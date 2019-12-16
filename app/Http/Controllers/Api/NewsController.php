<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function get(Request $request)
    {
        if (empty($request->get('id'))) {
            return News::with('likes')->orderBy('updated_at','desc')->paginate(10);
        }

        return News::with('likes')->find($request->get('id'));
    }

    public function delete(Request $request)
    {
        if ( ! $request->user()) {
            return response()->json(['error' => 'You should authorize']);
        }

        try {
            News::destroy($request->post('id'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

        return response()->json([
            'success' => true,
        ]);
    }

    public function update(Request $request)
    {
        try {
            News::find($request->post('id'))->update($request->all(['title', 'content']));

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            $data['author_id'] = $request->user()->id;
            News::create($data);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
