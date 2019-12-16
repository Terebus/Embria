<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Likes;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function like(Request $request)
    {
        $this->validate($request, [
            'id'   => 'int|required',
            'type' => 'string|required',
        ]);
        $user = $request->user();
        $type = $request->post('type');
        $id   = $request->post('id');

        /** @var Likes $like */
        $like = Likes::where('user_id', $user->id)->where('type', $type)->where('object_id', $id)->first();

        if ( ! is_null($like) && $like->exists()) {
            $like->delete();

            return response()->json([
                'success' => true,
                'action'  => 'removed',
            ]);
        }
        try {
            Likes::create([
                'object_id' => $id,
                'user_id'   => $user->id,
                'type'      => $type,
            ]);

            return response()->json([
                'success' => true,
                'action'  => 'added',
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
