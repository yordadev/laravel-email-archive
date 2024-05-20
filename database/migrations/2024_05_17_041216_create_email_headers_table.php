<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('email_headers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('email_id')
                ->references('id')
                ->on('emails');

            $table->string('key');
            $table->text('value');
            $table->timestamps();
            $table->softDeletes();

            $table->index('email_id');
            $table->index(['email_id', 'key']);

            $table->unique(['email_id', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_headers');
    }
};
