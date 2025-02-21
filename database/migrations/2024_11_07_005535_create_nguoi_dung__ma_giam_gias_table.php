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
        Schema::create('nguoi_dung__ma_giam_gias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('NguoiDung_id');  // Cột khóa phụ danh mục

            // Khóa phụ, tham chiếu tới bảng categories
            $table->foreign('NguoiDung_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade'); // Nếu danh mục bị xóa, sản phẩm cũng bị xóa
            
            $table->unsignedBigInteger('MaGiamGia_id');  // Cột khóa phụ danh mục

            // Khóa phụ, tham chiếu tới bảng categories
            $table->foreign('MaGiamGia_id')
                  ->references('id')
                  ->on('ma_giam_gias')
                  ->onDelete('cascade'); 
            $table->timestamps();
            
            $table->unique(['NguoiDung_id', 'MaGiamGia_id']);
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nguoi_dung__ma_giam_gias');
    }
};
