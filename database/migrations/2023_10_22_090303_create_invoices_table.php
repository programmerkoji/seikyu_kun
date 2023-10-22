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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('billing_date')->comment('請求日');
            $table->date('posting_start')->comment('掲載日');
            $table->date('posting_end')->comment('掲載日');
            $table->string('detail')->comment('請求内容');
            $table->integer('quantity')->comment('請求数');
            $table->integer('price')->comment('請求金額');
            $table->text('note')->nullable()->comment('備考');
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
        Schema::dropIfExists('invoices');
    }
};
