<?php

namespace App\Http\Services;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostService
{
    public function store(array $data): PostResource
    {
        $data['slug'] = Str::slug($data['title']);

        $this->uploadFile($data);

        if (!$post = Auth::user()->posts()->create($data))
            throw new Error('Ошибка при сохранении', 500);

        return new PostResource($post->load('user'));
    }

    public function update(array $data, Post $post): PostResource
    {
        if (!empty($data['title']))
            $data['slug'] = Str::slug($data['title']);

        $this->uploadFile($data);

        if (!$post->update($data))
            throw new Error('Ошибка при обновлении', 500);

        return new PostResource($post->load('user'));
    }

    public function delete(Post $post)
    {
        if (!$post->delete())
            throw new Error('Ошибка при удалении', 500);

        return [
            'message' => 'Успешно'
        ];
    }

    private function uploadFile(array &$data): void
    {
        if (!empty($data['preview_image']))
            $data['preview_image'] = 'storage/' . Storage::disk('public')->put('posts', $data['preview_image']);

        if (!empty($data['detail_image']))
            $data['detail_image'] = 'storage/' . Storage::disk('public')->put('posts', $data['detail_image']);
    }
}
