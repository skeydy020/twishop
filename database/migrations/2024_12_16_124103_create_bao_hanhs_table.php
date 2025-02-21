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
        Schema::create('bao_hanhs', function (Blueprint $table) {
            $table->id(); // ID tự tăng
            $table->unsignedBigInteger('chitietdonhang_id'); // ID chi tiết đơn hàng
            $table->string('LyDoBaoHanh'); // Lý do bảo hành
            $table->text('MoTa')->nullable(); // Mô tả lỗi sản phẩm
            $table->text('TrangThai'); // Trạng thái bảo hành
            $table->timestamps(); // Thời gian tạo và cập nhật

            // Liên kết khóa ngoại
            $table->foreign('chitietdonhang_id')->references('id')->on('chi_tiet_don_hangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bao_hanh');
    }
};