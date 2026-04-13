<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLowStockThresholdToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('low_stock_threshold')->default(10)->after('quantity');
            $table->boolean('low_stock_alert_enabled')->default(true)->after('low_stock_threshold');
            $table->timestamp('last_low_stock_alert_at')->nullable()->after('low_stock_alert_enabled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['low_stock_threshold', 'low_stock_alert_enabled', 'last_low_stock_alert_at']);
        });
    }
}
