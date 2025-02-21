<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaGiamGia extends Model
{
    use HasFactory;
    protected $fillable =[
        'Code',
        'MoTa',
        'LoaiGiamGia',
        'GiaTriGiamGia',
        'GiaTriToiThieu',
        'GiamGiaToiDa',
        'NgayBatDau',
        'NgayKetThuc',
        'SLGioiHan',
        'SLSuDung',
        'KichHoat'];
       
}
