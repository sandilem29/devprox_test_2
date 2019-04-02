<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserDetails extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('csv_imports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->text('surname');
            $table->string('initials', 2);
            $table->integer('age');
            $table->date('date_of_birth');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('csv_imports');
    }
}
