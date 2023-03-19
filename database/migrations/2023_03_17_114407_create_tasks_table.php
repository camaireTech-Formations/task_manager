<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()      
    {
        Schema::create('tasks', function (Blueprint $table){
            $table->id();
            $table->string('task_name');
            $table->longText('details');
            $table->enum('statut', [1,2,3]);
            $table->enum('favoris', [0,1])->default(0);
            $table->enum('statut_corbeille', [0,1])->default(0);
            $table->integer('parent_id')->default(0);
            $table->foreignId('tasks_list_id')->references('id')->on('tasks_lists')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
