<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NguoiDung_MaGiamGia extends Model
{
    use HasFactory;
    protected $fillable =[
        'NguoiDung_id',
        'MaGiamGia_id'
        ];
    public function NguoiDung()
    {
        return $this->hasOne(User::class, 'id', 'NguoiDung_id')
            ->withDefault(['name' => '']);
    }
    public function MaGiamGia()
    {
        return $this->hasOne(MaGiamGia::class, 'id', 'MaGiamGia_id')
            ->withDefault(['Code' => '']);
    }
}
