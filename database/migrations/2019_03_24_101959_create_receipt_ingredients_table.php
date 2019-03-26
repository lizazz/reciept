<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptIngredientsTable extends Migration
{
    private $tableName = 'receipt_ingredients';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('receipt_id')->index();
            $table->unsignedInteger('ingredient_id')->index();
            $table->float('quantity')->default(0);
            $table->timestamps();
            $table->foreign('receipt_id')->references('id')->on('receipts')
                ->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('ingredient_id')->references('id')->on('ingredients')
                ->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::enableForeignKeyConstraints();
        Schema::dropIfExists($this->tableName);
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists($this->tableName);
    }
}
