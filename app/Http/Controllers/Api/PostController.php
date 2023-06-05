<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Post\PostStoreRequest;
use App\Http\Requests\Api\Post\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Http\Services\PostService;
use App\Models\Post;
use Error;

class PostController extends Controller
{
    private PostService $service;

    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(PostResource::collection(Post::with('user')->active()->get()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        try {
            return response()->json($this->service->store($request->validated()));
        } catch (Error $error) {
            return response()->json(['error' => $error->getMessage()], $error->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json(new PostResource($post));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        try {
            return response()->json($this->service->update($request->validated(), $post));
        } catch (Error $error) {
            return response()->json(['error' => $error->getMessage()], $error->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        try {
            return response()->json($this->service->delete($post));
        } catch (Error $error) {
            return response()->json(['error' => $error->getMessage()], $error->getCode());
        }
    }
}
