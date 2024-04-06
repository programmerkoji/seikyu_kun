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
        Schema::create('postings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('posting_term')->comment('掲載期間');
            $table->date('posting_start')->comment('掲載開始日');
            $table->date('posting_end')->comment('掲載終了日');
            $table->integer('quantity')->default(0)->comment('掲載数');
            $table->integer('price')->default(0)->comment('掲載金額');
            $table->boolean('is_special_price')->default(0)->comment('特別価格有無');
            $table->boolean('special_price')->nullable()->comment('特別価格');
            $table->text('note')->nullable()->comment('その他');
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
        Schema::dropIfExists('postings');
    }
};
