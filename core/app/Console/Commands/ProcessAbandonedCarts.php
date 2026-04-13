<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cart;
use App\Mail\AbandonedCartRecovery;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ProcessAbandonedCarts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carts:process-abandoned
                            {--hours=1 : Hours since last activity to consider cart abandoned}
                            {--max-attempts=3 : Maximum recovery email attempts}
                            {--dry-run : Run without sending emails}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process abandoned carts and send recovery emails';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $hoursThreshold = $this->option('hours');
        $maxAttempts = $this->option('max-attempts');
        $dryRun = $this->option('dry-run');

        $this->info("Processing abandoned carts...");
        $this->info("Hours threshold: {$hoursThreshold}");
        $this->info("Max attempts: {$maxAttempts}");

        // Step 1: Mark active carts as abandoned if inactive for X hours
        $this->markAbandonedCarts($hoursThreshold);

        // Step 2: Send recovery emails to abandoned carts
        $emailsSent = $this->sendRecoveryEmails($maxAttempts, $dryRun);

        $this->info("✓ Process completed. {$emailsSent} recovery emails sent.");

        return 0;
    }

    /**
     * Mark carts as abandoned based on inactivity
     */
    protected function markAbandonedCarts($hoursThreshold)
    {
        $cutoffTime = Carbon::now()->subHours($hoursThreshold);

        $carts = Cart::where('status', 'active')
            ->where('updated_at', '<=', $cutoffTime)
            ->whereNotNull('customer_email')
            ->get();

        $count = 0;
        foreach ($carts as $cart) {
            $cart->markAsAbandoned();
            $count++;
        }

        $this->info("✓ Marked {$count} carts as abandoned");
    }

    /**
     * Send recovery emails to abandoned carts
     */
    protected function sendRecoveryEmails($maxAttempts, $dryRun)
    {
        $carts = Cart::abandoned()
            ->notRecovered()
            ->recoveryAttemptsLessThan($maxAttempts)
            ->where(function ($query) {
                // Send first email after 1 hour
                $query->whereNull('recovery_email_sent_at')
                    ->where('abandoned_at', '<=', Carbon::now()->subHour());
            })
            ->orWhere(function ($query) {
                // Send follow-up emails 24 hours apart
                $query->whereNotNull('recovery_email_sent_at')
                    ->where('recovery_email_sent_at', '<=', Carbon::now()->subHours(24));
            })
            ->get();

        $emailsSent = 0;

        foreach ($carts as $cart) {
            if ($dryRun) {
                $this->line("Would send email to: {$cart->customer_email} (Cart ID: {$cart->id})");
            } else {
                try {
                    Mail::to($cart->customer_email)
                        ->send(new AbandonedCartRecovery($cart));

                    $cart->incrementRecoveryAttempts();
                    $emailsSent++;

                    $this->line("✓ Sent recovery email to: {$cart->customer_email}");
                } catch (\Exception $e) {
                    $this->error("✗ Failed to send email to {$cart->customer_email}: {$e->getMessage()}");
                }
            }
        }

        return $emailsSent;
    }
}
