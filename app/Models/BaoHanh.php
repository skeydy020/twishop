<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaoHanh extends Model
{
    use HasFactory;
    protected $fillable =[
        'chitietdonhang_id',
        'LyDoBaoHanh',
        'MoTa',
        'TrangThai'];
    public function ChiTietDonHang()
    {
        return $this->hasOne(ChiTietDonHang::class, 'id', 'chitietdonhang_id')
            ->withDefault(['name' => 'Không có']);
    }
}
