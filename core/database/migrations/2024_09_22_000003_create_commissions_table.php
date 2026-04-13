<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionsTable extends Migration
{
    public function up()
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Usuário que receberá a comissão
            $table->unsignedBigInteger('affiliate_id')->nullable(); // Afiliado responsável
            $table->string('transaction_id'); // ID da transação origem
            $table->string('commission_type'); // product, referral, tier1, tier2, etc.
            $table->decimal('transaction_amount', 15, 2); // Valor da transação
            $table->decimal('commission_percentage', 5, 2); // Percentual da comissão
            $table->decimal('commission_amount', 15, 2); // Valor da comissão
            $table->enum('status', ['pending', 'approved', 'paid', 'cancelled'])->default('pending');
            $table->date('due_date')->nullable(); // Data de vencimento
            $table->timestamp('paid_at')->nullable(); // Data do pagamento
            $table->string('payout_method')->nullable(); // Método de repasse
            $table->json('metadata')->nullable(); // Dados adicionais
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('affiliate_id')->references('id')->on('users')->onDelete('set null');
            $table->index(['user_id', 'status']);
            $table->index(['affiliate_id', 'status']);
            $table->index(['transaction_id']);
            $table->index(['commission_type', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('commissions');
    }
}