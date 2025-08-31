<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'email_verified_at',
        'role',
        'status', // thêm trạng thái tài khoản
    ];

    // Các quan hệ
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'user_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'followed_id');
    }

    // Helper check role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Helper check trạng thái
    public function isActive()
    {
        return $this->status === 'active';
    }
}
