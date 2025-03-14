<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('change_history', function (Blueprint $table) {
            $table->id();
            $table->string('entity_type'); // 'document' atau 'agunan'
            $table->string('no_dokumen');
            $table->unsignedBigInteger('user_id'); // User yang mengedit
            $table->json('changes'); // Data perubahan dalam JSON
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('change_history');
    }
};
