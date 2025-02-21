<?php

namespace App\Http\Requests\DonHang;

use Illuminate\Foundation\Http\FormRequest;

class DonHangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'TenKH' => 'required',
            'SDT' => 'required',
            'DiaChiNhanHang' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'TenKH.required' => 'Vui lòng nhập tên khách nhận hàng',
            'SDT.required' => 'Số điện thoại không được trống',
            'DiaChiNhanHang.required' => 'Địa chỉ nhận hàng không được trống'
        ];
    }
}
