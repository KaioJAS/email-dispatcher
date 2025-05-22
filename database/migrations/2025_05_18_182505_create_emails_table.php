<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('remetente');
            $table->foreignId('remetente_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('destinatarios');
            $table->text('conteudo');
            $table->enum('status', ['pendente', 'enviado', 'erro'])->default('pendente');
            $table->timestamp('enviado_em')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};