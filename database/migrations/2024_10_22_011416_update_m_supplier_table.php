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
        Schema::table('m_supplier', function (Blueprint $table) {
            $table->string('supplier_kode', 10);
            $table->string('supplier_nama', 100);
            $table->string('supplier_alamat', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_supplier', function (Blueprint $table) {
            //
        });
    }
};