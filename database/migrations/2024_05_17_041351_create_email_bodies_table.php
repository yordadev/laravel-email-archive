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
        Schema::create('email_bodies', function (Blueprint $table) {
            $table->unsignedBigInteger('email_id')->primary()
                ->references('id')
                ->on('emails');

            $table->longText('content');
            $table->string('signature');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_bodies');
    }
};
