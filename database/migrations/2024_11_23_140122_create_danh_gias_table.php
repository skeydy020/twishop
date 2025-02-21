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
        Schema::create('danh_gias', function (Blueprint $table) {
           $table->id();
            // $table->integer('sampham_id')->index()->default(0);
            // $table->integer('user_id')->index()->default(0);
            $table->integer('chitietdonhang_id')->index()->default(0);
            $table->string('NoiDung')->nullable();
            $table->string('Number')->nullable();
            $table->timestamps();

            $table->foreign('chitietdonhang_id')
                ->references('id')->on('chi_tiet_don_hangs') // Liên kết đến bảng san_phams
                ->onDelete('cascade');            // Xóa đánh giá khi sản phẩm bị xóa

            // $table->foreign('sampham_id')
            // ->references('id')->on('san_phams') // Liên kết đến bảng san_phams
            // ->onDelete('cascade');            // Xóa đánh giá khi sản phẩm bị xóa

            // $table->foreign('user_id')
            //     ->references('id')->on('users')   // Liên kết đến bảng users
            //     ->onDelete('cascade');           // Xóa đánh giá khi user bị xóa
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danh_gias');
    }
};
