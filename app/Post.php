<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\PostsController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'contents', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected $with = [
        'author',
    ];

    protected $appends = [
        'links', 'permissions',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished(Builder $query)
    {
        $query->whereNotNull('published_at');
    }

    public function scopeDraft(Builder $query)
    {
        $query->whereNull('published_at');
    }

    public function scopeStatus(Builder $query, string $status)
    {
        if ($status === 'published') {
            $query->whereNotNull('published_at');
        } else if ($status === 'draft') {
            $query->whereNull('published_at');
        } else if ($status === 'trashed') {
            $query->onlyTrashed();
        }
    }

    public function scopeSearch(Builder $query, string $search)
    {
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }
    }

    public function getLinksAttribute()
    {
        return [
            'edit' => action([PostsController::class, 'edit'], $this),
            'update' => action([PostsController::class, 'update'], $this),
            'destroy' => action([PostsController::class, 'destroy'], $this),
            'restore' => action([PostsController::class, 'restore'], $this),
        ];
    }

    public function getPermissionsAttribute()
    {
        return [
            'update' => Auth::user()->can('update', $this),
            'delete' => Auth::user()->can('delete', $this),
            'restore' => Auth::user()->can('restore', $this),
        ];
    }
}
