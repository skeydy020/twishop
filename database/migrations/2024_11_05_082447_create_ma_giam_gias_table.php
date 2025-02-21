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
        Schema::create('ma_giam_gias', function (Blueprint $table) {
            $table->id();
            $table->string('Code',255);
            $table->text('MoTa');
            $table->integer('LoaiGiamGia');
            $table->double('GiaTriGiamGia');
            $table->double('GiaTriToiThieu', 10, 2)->nullable(); 
            $table->double('GiamGiaToiDa', 10, 2)->nullable(); 
            $table->dateTime('NgayBatDau')->nullable(); 
            $table->dateTime('NgayKetThuc')->nullable();
            $table->integer('SLGioiHan')->nullable(); 
            $table->integer('SLSuDung')->default(0);
            $table->integer('KichHoat'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ma_giam_gias');
    }
};
