<?php

namespace App\Http\Controllers\Api;

use App\Photos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhotosController extends Controller
{
    public function get(Request $request)
    {
        if ( ! empty($request->get('id'))) {
            return Photos::find($request->get('id'))->with('likes');
        }

        return Photos::with('likes')->orderBy('created_at', 'desc')->get();
    }

    public function create(Request $request)
    {

        if ( ! $request->hasFile('file')) {
            return response()->json(['error' => 'Empty file']);
        }

        $file = $request->file('file');

        if ( ! $file->isValid()) {
            return response()->json(['error' => 'Invalid file']);
        }

        try {
            $path = public_path('images');
            $file->move($path, $file->getClientOriginalName());
            Photos::create([
                'file_name' => $file->getClientOriginalName(),
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

    }

    public function delete(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer|required',
        ]);

        try {
            /** @var Photos $image */
            $image = Photos::findOrFail($request->post('id'));
            $file  = public_path('images') . DIRECTORY_SEPARATOR . $image->file_name;
            if ( ! unlink($file)) {
                throw new \Exception('Can`t remove file ' . $file);
            }
            $image->delete();

            return response()->json(['success' => true]);


        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

    }
}
