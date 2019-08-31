<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', '');
        $search = $request->query('search', '');

        $posts = Post::query()
            ->status($status)
            ->search($search)
            ->latest('updated_at')
            ->get();

        $counts = function () {
            return [
                'all' => Post::count(),
                'published' => Post::published()->count(),
                'draft' => Post::draft()->count(),
                'trashed' => Post::onlyTrashed()->count(),
            ];
        };

        return inertia('Posts/Index', [
            'posts' => $posts,
            'status' => $status,
            'initialSearch' => $search,
            'counts' => $counts,
        ]);
    }

    public function create()
    {
        return inertia('Posts/Edit', [
            'post' => new Post(),
        ]);
    }

    public function store(PostRequest $request)
    {
        $post = $request->user()->posts()->create([
            'title' => $request->title,
            'contents' => $request->contents,
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        return redirect()
            ->action([PostsController::class, 'edit'], $post)
            ->with('success', 'The post was created.');
    }

    public function edit(Post $post)
    {
        return inertia('Posts/Edit', [
            'post' => $post,
        ]);
    }

    public function update(PostRequest $request, Post $post)
    {
        $publishedAt = $post->published_at;

        if ($post->published_at && $request->status === 'draft') {
            $post->published_at = null;
        }

        if (!$post->published_at && $request->status === 'published') {
            $post->published_at = now();
        }

        $post->title = $request->title;
        $post->contents = $request->contents;

        $post->save();

        return redirect()
            ->action([PostsController::class, 'edit'], $post)
            ->with('success', 'The post was updated.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()
            ->action([PostsController::class, 'index'])
            ->with('success', 'The post was deleted.');
    }

    public function restore(Post $post)
    {
        $post->restore();

        return redirect()
            ->action([PostsController::class, 'edit'], $post)
            ->with('success', 'The post was restored.');
    }
}
