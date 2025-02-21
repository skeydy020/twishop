<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    use HasFactory;
    protected $table = 'danh_gias';
    protected $fillable =[
        'chitietdonhang_id',
        'sanpham_id',
        'TenKH',
        'TenSP',
        'NoiDung',
        'Number',
    ];

    public function ChiTietDonHang()
    {
        return $this->hasOne(ChiTietDonHang::class, 'id', 'chitietdonhang_id')
            ->withDefault(['name' => 'Không có']);
    }
}