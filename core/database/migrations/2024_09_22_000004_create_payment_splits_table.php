<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentSplitsTable extends Migration
{
    public function up()
    {
        Schema::create('payment_splits', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id'); // ID da transação
            $table->unsignedBigInteger('recipient_id'); // Beneficiário do split
            $table->string('recipient_type')->default('user'); // user, merchant, affiliate
            $table->decimal('original_amount', 15, 2); // Valor original da transação
            $table->decimal('split_percentage', 5, 2); // Percentual do split
            $table->decimal('split_amount', 15, 2); // Valor do split
            $table->decimal('fee_amount', 15, 2)->default(0); // Taxa deduzida
            $table->decimal('net_amount', 15, 2); // Valor líquido a receber
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->string('split_rule_id')->nullable(); // ID da regra de split aplicada
            $table->json('split_config')->nullable(); // Configuração do split
            $table->timestamp('scheduled_at')->nullable(); // Agendamento do repasse
            $table->timestamp('processed_at')->nullable(); // Data do processamento
            $table->string('external_id')->nullable(); // ID externo no provider
            $table->text('failure_reason')->nullable(); // Motivo de falha
            $table->timestamps();

            $table->foreign('recipient_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['transaction_id', 'status']);
            $table->index(['recipient_id', 'status']);
            $table->index(['status', 'scheduled_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_splits');
    }
}