<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Support\Facades\Auth;

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
    
    // 重写 notify 方法，此处与教程不同，参照的是教程对应章节下面的一个同学回复
    public function topicNotify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        $this->notify($instance);
    }

    // 当用户阅读通知后，清除通知计数信息
    // unreadNotification 为 notifiable 中的方法
    public function markAsRead ()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
}
