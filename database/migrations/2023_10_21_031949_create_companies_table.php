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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('企業名');
            $table->string('post_code', 12)->comment('郵便番号');
            $table->string('address')->comment('住所');
            $table->string('tel', 40)->comment('電話番号');
            $table->string('ceo_name', 40)->comment('代表者名');
            $table->string('responsible_person_name', 40)->comment('担当者名');
            $table->text('note')->comment('備考')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
