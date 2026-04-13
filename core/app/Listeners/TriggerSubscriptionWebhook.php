<?php

namespace App\Listeners;

use App\Http\Controllers\Webhooks\SubscriptionWebhookController;
use Illuminate\Contracts\Queue\ShouldQueue;

class TriggerSubscriptionWebhook implements ShouldQueue
{
    /**
     * Handle subscription created event
     */
    public function handleCreated($event)
    {
        SubscriptionWebhookController::trigger('subscription.created', $event->subscription);
    }

    /**
     * Handle subscription cancelled event
     */
    public function handleCancelled($event)
    {
        SubscriptionWebhookController::trigger('subscription.cancelled', $event->subscription);
    }

    /**
     * Handle subscription renewed event
     */
    public function handleRenewed($event)
    {
        SubscriptionWebhookController::trigger('subscription.renewed', $event->subscription);
    }

    /**
     * Handle subscription updated event
     */
    public function handleUpdated($event)
    {
        SubscriptionWebhookController::trigger('subscription.updated', $event->subscription);
    }
}
