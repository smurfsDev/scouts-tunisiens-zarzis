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
        Schema::create('request_documents', function (Blueprint $table) {
            $table->id();
			$table->string("title");
			$table->string("to");
			$table->date("date");
			$table->string("location");
			$table->string("subject");
			$table->longText("body");
			$table->foreignId("user_id");
			$table->foreign("user_id")->references("id")->on("users");
			$table->foreignId("admin_id")->nullable();
			$table->foreign("admin_id")->references("id")->on("users");
			$table->integer("status")->default(0);
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
        Schema::dropIfExists('request_documents');
    }
};
