<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use Notifiable, MustVerifyEmailTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    // 关联《话题》数据库，一个用户拥有多条话题
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    // 用户模型与回复模型的关系
    public function replies()
    {
        // 一个用户拥用多条回复
        return $this->hasMany(Reply::class);
    }

    // 授权策略接口方法
    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }
}
