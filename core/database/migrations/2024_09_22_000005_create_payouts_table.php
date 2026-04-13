<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoutsTable extends Migration
{
    public function up()
    {
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('payout_id')->unique(); // ID único do repasse
            $table->decimal('amount', 15, 2); // Valor do repasse
            $table->decimal('fee_amount', 10, 2)->default(0); // Taxa do repasse
            $table->decimal('net_amount', 15, 2); // Valor líquido
            $table->enum('payout_method', ['pix', 'bank_transfer', 'wallet']); // Método de repasse
            $table->json('recipient_data'); // Dados do destinatário (conta, etc)
            $table->enum('status', ['scheduled', 'processing', 'completed', 'failed', 'cancelled'])->default('scheduled');
            $table->date('scheduled_date'); // Data agendada
            $table->timestamp('processed_at')->nullable(); // Data do processamento
            $table->string('external_id')->nullable(); // ID no provider
            $table->text('description')->nullable(); // Descrição
            $table->text('failure_reason')->nullable(); // Motivo de falha
            $table->json('metadata')->nullable(); // Dados adicionais
            $table->boolean('automatic')->default(false); // Repasse automático
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'status']);
            $table->index(['status', 'scheduled_date']);
            $table->index(['payout_method', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('payouts');
    }
}