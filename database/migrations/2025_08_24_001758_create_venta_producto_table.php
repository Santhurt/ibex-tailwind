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
        Schema::create('venta_producto', function (Blueprint $table) {
            $table->foreignId("id_venta")->constrained("ventas");
            $table->foreignId("id_producto")->constrained("productos");
            $table->integer("cantidad");
            $table->integer("subtotal");
            $table->primary(["id_venta", "id_producto"]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_producto');
    }
};
