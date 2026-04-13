<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeStructuresTable extends Migration
{
    public function up()
    {
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // NULL = taxa global
            $table->string('payment_method'); // pix, credit_card, boleto, bank_transfer
            $table->enum('fee_type', ['fixed', 'percentage', 'mixed'])->default('percentage');
            $table->decimal('fee_value', 10, 4)->default(0); // Valor da taxa
            $table->decimal('fixed_fee', 10, 2)->default(0); // Taxa fixa adicional (para tipo mixed)
            $table->decimal('min_amount', 10, 2)->default(0); // Valor mínimo para aplicar essa taxa
            $table->decimal('max_amount', 10, 2)->nullable(); // Valor máximo para aplicar essa taxa
            $table->integer('min_installments')->default(1); // Parcelamento mínimo
            $table->integer('max_installments')->nullable(); // Parcelamento máximo
            $table->json('conditions')->nullable(); // Condições adicionais (JSON)
            $table->boolean('active')->default(true);
            $table->integer('priority')->default(0); // Prioridade de aplicação
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'payment_method', 'active']);
            $table->index(['payment_method', 'active', 'priority']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('fee_structures');
    }
}