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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("slug")->unique();
            $table->string("description");
            $table->decimal("price", 10, 7);
            $table->foreignId("currency_id")->constrained()->cascadeOnDelete();
            $table->decimal("purchase_price", 10, 7);
            $table->integer("stock_quantity")->default(0);
            $table->string("product_type");
            $table->boolean("is_downloadable")->default(false);
            $table->boolean("available_market")->default(false);
            $table->boolean("status")->default(true);
            $table->foreignId("shop_id")->nullable(true)->constrained()->cascadeOnDelete();
            $table->boolean("is_downloaddable")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
