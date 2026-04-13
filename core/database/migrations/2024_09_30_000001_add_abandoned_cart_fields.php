<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAbandonedCartFields extends Migration
{
    public function up()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->string('customer_email')->nullable()->after('uniqueid');
            $table->string('customer_name')->nullable()->after('customer_email');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('abandoned_at')->nullable();
            $table->timestamp('recovery_email_sent_at')->nullable();
            $table->integer('recovery_attempts')->default(0);
            $table->boolean('recovered')->default(false);
            $table->string('status')->default('active'); // active, abandoned, recovered, converted
            $table->index('customer_email');
            $table->index('status');
            $table->index('abandoned_at');
        });
    }

    public function down()
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->dropColumn([
                'customer_email',
                'customer_name',
                'created_at',
                'updated_at',
                'abandoned_at',
                'recovery_email_sent_at',
                'recovery_attempts',
                'recovered',
                'status'
            ]);
        });
    }
}
