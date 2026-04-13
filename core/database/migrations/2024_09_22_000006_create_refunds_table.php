<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundsTable extends Migration
{
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->string('refund_id')->unique(); // ID único do reembolso
            $table->string('original_transaction_id'); // ID da transação original
            $table->unsignedBigInteger('user_id'); // Usuário solicitante
            $table->unsignedBigInteger('requested_by')->nullable(); // Quem solicitou (admin, user)
            $table->decimal('original_amount', 15, 2); // Valor original da transação
            $table->decimal('refund_amount', 15, 2); // Valor a ser reembolsado
            $table->decimal('fee_amount', 10, 2)->default(0); // Taxa do reembolso
            $table->enum('refund_type', ['full', 'partial']); // Tipo de reembolso
            $table->text('reason'); // Motivo do reembolso
            $table->enum('status', ['requested', 'approved', 'processing', 'completed', 'rejected', 'failed'])->default('requested');
            $table->timestamp('requested_at'); // Data da solicitação
            $table->timestamp('approved_at')->nullable(); // Data da aprovação
            $table->timestamp('processed_at')->nullable(); // Data do processamento
            $table->unsignedBigInteger('approved_by')->nullable(); // Quem aprovou
            $table->string('external_id')->nullable(); // ID no provider
            $table->text('rejection_reason')->nullable(); // Motivo da rejeição
            $table->text('failure_reason')->nullable(); // Motivo de falha
            $table->json('metadata')->nullable(); // Dados adicionais
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('requested_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->index(['user_id', 'status']);
            $table->index(['original_transaction_id']);
            $table->index(['status', 'requested_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('refunds');
    }
}