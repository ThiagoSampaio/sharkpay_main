<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // Subscription Events
        \App\Events\SubscriptionCreated::class => [
            \App\Listeners\TriggerSubscriptionWebhook::class . '@handleCreated',
        ],
        \App\Events\SubscriptionCancelled::class => [
            \App\Listeners\TriggerSubscriptionWebhook::class . '@handleCancelled',
        ],
        \App\Events\SubscriptionRenewed::class => [
            \App\Listeners\TriggerSubscriptionWebhook::class . '@handleRenewed',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
