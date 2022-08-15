<?php

namespace App\Models;

use App\Models\User;
use App\Scopes\DeletedAdminScope;
use App\Traits\Taggable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

/**
 * App\Models\BlogPost
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $title
 * @property string $content
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\Image|null $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @property-read User $user
 * @method static \Database\Factories\BlogPostFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost latest()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost latestWithRelations()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost mostCommented()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost newQuery()
 * @method static \Illuminate\Database\Query\Builder|BlogPost onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost query()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogPost whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|BlogPost withTrashed()
 * @method static \Illuminate\Database\Query\Builder|BlogPost withoutTrashed()
 * @mixin \Eloquent
 */
class BlogPost extends Model
{
    use HasFactory;
    use SoftDeletes, Taggable;

    protected $fillable = ['title', 'content', 'user_id', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable')->latest();
    }

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $query)
    {
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public function scopeLatestWithRelations(Builder $query)
    {
        return $query->latest()
            ->withCount('comments')
            ->with('user')
            ->with('tags');
    }

    public static function boot()
    {
        static::addGlobalScope(new DeletedAdminScope);
        parent::boot();

        // ***Commented because an observer created for this Model

        // static::deleting(function (BlogPost $blogPost) {
        //     $blogPost->comments()->delete();
        //     Cache::tags(['blog-post'])->forget('blog-post-{$blogPost->id}');
        // });

        // static::updating(function (BlogPost $blogPost) {
        //     Cache::tags(['blog-post'])->forget('blog-post-{$blogPost->id}');
        // });

        // static::restoring(function (BlogPost $blogPost) {
        //     $blogPost->comments()->restore();
        // });
    }
}
