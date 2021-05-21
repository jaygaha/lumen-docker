<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * display current user's posts
     *
     * @return void
     */
    public function index()
    {
        $user = auth()->user();
        $posts = $user->posts()->with('category')->get();
        
        return response()->json(['posts' =>  $posts], 200);
    }

    /**
     * show specified post
     *
     * @param [type] $id
     * @return void
     */
    public function show($id)
    {
        $post = Post::with('category')->find($id);
        return response()->json(['response' => $post], 200);
    }

    /**
     * Store new resource
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'category_id' => 'required',
            'name' => 'required|string',
            'description' => 'required',
            'status' => 'required',
        ]);
        
        try {
            $user = auth()->user();

            $request->request->add(['user_id' => $user->id]);
            $post = Post::create($request->all());

             //return success message
             return response()->json(
                [
                    'response' => [
                        'created' => true,
                        'postId' => $post->id
                    ]
                ], 201
            );

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'An error occured while saving.'], 409);
        }
    }

    /**
     * Update a resource by ID
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //validate incoming request 
        $this->validate($request, [
            'category_id' => 'required',
            'name' => 'required|string',
            'description' => 'required',
        ]);

        try {
            $post = Post::findOrFail($id);
            $post->update($request->all());

            return response()->json(['response' => $post], 200);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'An error occured while saving.'], 409);
        }
    }

    /**
     * Delete a specific player
     */
    /**
     * Delete a specific post
     *
     * @param [type] $id
     * @return void
     */
    public function destroy($id) 
    {
        Post::findOrFail($id)->delete();
   
        return response()->json('Deleted successfully.', 200);
    }
}