<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckoutBuildersTable extends Migration
{
    public function up()
    {
        Schema::create('checkout_builders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Configuração do funil
            $table->json('funnel_config');
            $table->json('upsell_products')->nullable();
            $table->json('downsell_products')->nullable();
            $table->json('abandoned_cart_config')->nullable();

            // Configurações de aparência
            $table->json('theme_config')->nullable();
            $table->string('logo_url')->nullable();
            $table->text('custom_css')->nullable();

            // Configurações de pagamento
            $table->json('payment_methods')->nullable();
            $table->json('installment_config')->nullable();

            // Status e métricas
            $table->enum('status', ['draft', 'active', 'inactive', 'archived'])->default('draft');
            $table->integer('conversion_rate')->default(0);
            $table->decimal('total_revenue', 15, 2)->default(0);
            $table->integer('total_orders')->default(0);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'status']);
            $table->index('slug');
        });
    }

    public function down()
    {
        Schema::dropIfExists('checkout_builders');
    }
}