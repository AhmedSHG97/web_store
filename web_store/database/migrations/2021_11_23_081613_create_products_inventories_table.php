<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_inventories', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained()->onDelete("cascade");
            $table->foreignId('inventory_id')->constrained()->onDelete("cascade");
            $table->primary(["product_id","inventory_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_inventories');
    }
}
