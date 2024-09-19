<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ResponseController;

class PostController extends ResponseController
{
    public function index() : JsonResponse {
        try {
            $posts = Post::all();
            return $this->sendResponse($posts, 'Get data posts successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Not Found', ['error'=>'Data Not Found']);
        }
    }

    public function show($id) : JsonResponse {
        try {
            $post = Post::find($id);
            return $this->sendResponse($post, 'Get data post successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Not Found', ['error'=>'Post Not Found']);
        }
    }

    public function store(Request $request) : JsonResponse {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'title' => 'required',
                'content' => 'required',
                // 'c_password' => 'required|same:password',
            ]);

            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }

            $input = $request->all();
            $user = Post::create($input);
            $success['data'] =  $user;

            return $this->sendResponse($success, 'Data post added successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error', ['error'=> $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id) : JsonResponse {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'title' => 'required',
                'content' => 'required',
                // 'c_password' => 'required|same:password',
            ]);

            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }

            $post = Post::find($id);

            $post->update([
                'user_id' => $request->user_id,
                'title' => $request->title,
                'content' => $request->content
            ]);

            return $this->sendResponse($post, 'Data post updated successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error', ['error'=> $e->getMessage()], 500);
        }
    }

    public function destroy($id) : JsonResponse {
        try {
            $post = Post::find($id);
            $post->delete();

            return $this->sendResponse('', 'Data post deleted successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error', ['error'=> $e->getMessage()], 500);
        }
    }
}
