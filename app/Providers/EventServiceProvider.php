<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * 框架自定义了各种事件，开发者先用自定义监听器与某一件绑定，再运行 $ php artisan event:generate 后，监听器将以文件形式生成 
     *
     * @var array
     */
    protected $listen = [
        // 监听《用户注册事件》
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // 监听《用户完成验证事件》
        Verified::class => [
            \App\Listeners\EmailVerified::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
