<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\User;
use App\Mail\LowStockAlert;
use App\Events\LowStockDetected;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CheckLowStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:check-low';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for products with low stock and send alerts to merchants';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Checking for low stock products...');

        // Get products with low stock that have alerts enabled
        $lowStockProducts = Product::where('low_stock_alert_enabled', true)
            ->whereColumn('quantity', '<=', 'low_stock_threshold')
            ->where('quantity_status', 0) // Only check products with inventory tracking enabled
            ->with('user')
            ->get();

        $alertsSent = 0;
        $productsChecked = $lowStockProducts->count();

        foreach ($lowStockProducts as $product) {
            // Check if we already sent an alert in the last 24 hours
            if ($product->last_low_stock_alert_at &&
                $product->last_low_stock_alert_at->gt(Carbon::now()->subHours(24))) {
                continue;
            }

            // Send email alert to merchant
            if ($product->user && $product->user->email) {
                try {
                    Mail::to($product->user->email)->send(new LowStockAlert($product));

                    // Update last alert timestamp
                    $product->last_low_stock_alert_at = Carbon::now();
                    $product->save();

                    // Fire event for real-time notifications
                    event(new LowStockDetected($product));

                    $alertsSent++;
                    $this->info("Alert sent for product: {$product->name} (ID: {$product->id})");
                } catch (\Exception $e) {
                    $this->error("Failed to send alert for product {$product->id}: {$e->getMessage()}");
                }
            }
        }

        $this->info("Process completed. Checked {$productsChecked} products, sent {$alertsSent} alerts.");

        return 0;
    }
}
