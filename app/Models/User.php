<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $api_token
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_admin
 * @property string $locale
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BlogPost[] $blogPosts
 * @property-read int|null $blog_posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $commentsOn
 * @property-read int|null $comments_on_count
 * @property-read \App\Models\Image|null $image
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User thatHasCommentedOnPost(\App\Models\BlogPost $post)
 * @method static Builder|User thatIsAnAdmin()
 * @method static Builder|User whereApiToken($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIsAdmin($value)
 * @method static Builder|User whereLocale($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User withMostBlogPosts()
 * @method static Builder|User withMostBlogPostsLastMonth()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const LOCALES = [
        'en' => 'English',
        'es' => 'Español',
        'de' => 'Deutsch'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email',
        'email_verified_at',
        'created_at',
        'updated_at',
        'is_admin',
        'locale',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function blogPosts()
    {
        return $this->hasMany('App\Models\BlogPost');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function commentsOn()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    public function scopeWithMostBlogPosts(Builder $query)
    {
        return $query->withCount('blogPosts')->orderBy('blog_posts_count', 'desc');
    }

    public function scopeWithMostBlogPostsLastMonth(Builder $query)
    {
        return $query->withCount(['blogPosts' => function (Builder $query) {
            $query->whereBetween(static::CREATED_AT, [now()->subMonths(1), now()]);
        }])->having('blog_posts_count', '>=', 2)
            ->orderBy('blog_posts_count', 'desc');
    }

    public function scopeThatHasCommentedOnPost(Builder $query, BlogPost $post)
    {
        return $query->whereHas('comments', function ($query) use($post) {
            return $query->where('commentable_id', '=', $post->id)
                ->where('commentable_type', '=', BlogPost::class);
        });
    }

    public function scopeThatIsAnAdmin(Builder $query)
    {
        return $query->where('is_admin', true);
    }
}
