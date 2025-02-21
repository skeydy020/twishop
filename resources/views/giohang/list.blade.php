@extends('main')


@section('content')

  @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $errors)
                <li>{{$errors}}</li>
            @endforeach
        </ul>

    </div>
@endif

    <form method="post" id="order-form">
         

        @if (count($sanphams) != 0)
            <div class="container py-5">
                <div class="row">
                    <div class="col-lg-8 mb-4">
                        <div class="table-responsive">
                            @php $total = 0;
                            $shippingFee = 30000; // Phí ship mặc định
                             @endphp
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="w-15">Sản phẩm</th>
                                        <th class="w-30"></th>
                                        <th class="w-15">Giá</th>
                                        <th class="w-15">Số lượng</th>
                                        <th class="w-15">Tổng tiền</th>
                                        <th class="w-10"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sanphams as $key => $sanpham)
                                        @php
                                            $Gia = $sanpham->GiamGia != 0 ? $sanpham->GiamGia : $sanpham->Gia;
                                            $priceEnd = $Gia * $GioHang[$sanpham->id];
                                            $total += $priceEnd;
                                        @endphp
                                        <tr>
                                            <td class="align-middle">
                                                <img src="{{ $sanpham->thumb }}" alt="IMG" class="img-fluid">
                                            </td>
                                            <td class="align-middle">{{ $sanpham->name }}</td>
                                            <td class="align-middle price">{{ number_format($Gia, 0, '', '.') }}</td>
                                            <!-- <td class="align-middle">
                                                <input class="form-control w-50" type="number" name="SoLuong[{{ $sanpham->id }}]" value="{{ $GioHang[$sanpham->id] }}">
                                            </td> -->

                                            <td class="align-middle quantity-control">
                                                <button class="btn btn-outline-secondary btn-sm decrement" type="button">-</button>
                                                <input class="form-control quantityDisplay" type="number" name="SoLuong[{{ $sanpham->id }}]" value="{{ $GioHang[$sanpham->id] }}">
                                                <button class="btn btn-outline-secondary btn-sm increment" type="button">+</button>
                                            </td>


                                            
                                            <td class="align-middle text-main price fw-500">{{ number_format($priceEnd, 0, '', '.') }}</td>
                                            <td class="align-middle">
                                                <a href="/carts/delete/{{ $sanpham->id }}" class="text-danger text-decoration-underline">Xóa</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> 
                        @php
                            // Miễn phí vận chuyển nếu tổng tiền >= 500.000
                            if ($total >= 500000) {
                                $shippingFee = 0;
                            }
                        @endphp
                        <div class="d-flex justify-content-end">
                            <input type="submit" value="Cập nhật giỏ hàng" formaction="/update-cart" class="btn btn-main-hover"></div><br>
                            <div class="d-flex justify-content-end">
                                <input class="form-control w-25 me-4" type="text" name="Code" placeholder="Mã giảm giá">
                                <input type="submit" value="Áp dụng mã giảm giá" formaction="/magiamgia" class="btn btn-main-hover">
                                <a class="ms-2 btn btn-secondary" href="/xoamagiamgia" >Xoá Mã Giảm Giá</a>
                            </div>
                        
                        @if(Session::get('coupon'))
                            @foreach(Session::get('coupon') as $key => $cou)
                            @if($cou['Loai'] == 0)
                                <?php
                                    $total_coupon = ($total * $cou['GiaTriGiamGia']) / 100;
                                ?>
                                @if($total_coupon > $cou['ToiDa'] )
                                    <?php $total_coupon = $cou['ToiDa'];?>
                                @endif
                                <div class="d-flex justify-content-end mt-5">
                                <span class="fw-500 me-3 h5">Tổng tiền Sản Phẩm: </span>
                                <span class="fw-600 text-main h5 price">{{number_format($total ,0,',','.')}}</span>
                                <input type="hidden" name="TongTien" value="{{ $total  }}">
                                </div>
                                <div class="d-flex justify-content-end  mt-3">
                                <span class="fw-500 me-3 h5">Phí vận chuyển: </span>
                                <span class="fw-600 text-main h5 price">{{ number_format($shippingFee, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-end  mt-3">
                                <span class="fw-500 me-3 h5">Mã giảm: </span>
                                <span class="fw-600 text-main h5 ">{{$cou['GiaTriGiamGia']}} %</span>   
                                </div>
                                <div class="d-flex justify-content-end  mt-3">
                                <span class="fw-500 me-3 h5">Tổng giảm: </span>
                                <span class="fw-600 text-main h5 price">-{{number_format($total_coupon,0,',','.')}}</span>   
                                </div>
                              
                                <div class="d-flex justify-content-end  mt-3">
                                <span class="fw-500 me-3 h4">Tổng tiền: </span>
                                <span class="fw-600 text-main h4 price">{{number_format($total - $total_coupon +$shippingFee,0,',','.')}}</span>
                                <input type="hidden" name="TongTien" value="{{ $total - $total_coupon+ $shippingFee}}">
                                </div>
                                
                            @elseif($cou['Loai'] == 1)
                            <div class="d-flex justify-content-end  mt-5">
                                <span class="fw-500 me-3 h5">Tổng tiền Sản Phẩm: </span>
                                <span class="fw-600 text-main h5 price">{{number_format($total ,0,',','.')}}</span>
                                <input type="hidden" name="TongTien" value="{{ $total  }}">
                        </div>
                        <div class="d-flex justify-content-end  mt-3">
                                <span class="fw-500 me-3 h5">Phí vận chuyển: </span>
                                <span class="fw-600 text-main h5 price">{{ number_format($shippingFee, 0, ',', '.') }}</span>
                            </div>
                                <div class="d-flex justify-content-end  mt-34">
                                <span class="fw-500 me-3 h5">Mã giảm: </span>
                                <span class="fw-600 text-main h5 price">-{{$cou['GiaTriGiamGia']}} </span>   
                                </div>
                                
                                <div class="d-flex justify-content-end  mt-3">
                                <span class="fw-500 me-3 h4">Tổng tiền: </span>
                                <span class="fw-600 text-main h4 price">{{number_format($total - $cou['GiaTriGiamGia'] + $shippingFee,0,',','.')}}</span>
                                <input type="hidden" name="TongTien" value="{{ $total - $cou['GiaTriGiamGia'] + $shippingFee }}">
                        </div>
                          
                          
                            @endif
                            <input type="hidden" name="CodeApDung" value="{{ $cou['Code'] }}">
                        @endforeach
                    @else
                    <div class="d-flex justify-content-end  mt-5">
                            <span class="fw-500 me-3 h5">Tổng tiền sản phẩm: </span>
                            <span class="fw-600 text-main h5 price">{{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-end  mt-3">
                            <span class="fw-500 me-3 h5">Phí vận chuyển: </span>
                            <span class="fw-600 text-main h5 price">{{ number_format($shippingFee, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-end  mt-3">
                            <span class="fw-500 me-3 h4">Tổng tiền: </span>
                            <span class="fw-600 text-main h4 price">{{ number_format($total + $shippingFee, 0, ',', '.') }}</span>
                            <input type="hidden" name="TongTien" value="{{ $total + $shippingFee }}">
                        </div>
                    @endif
                    <input type="hidden" name="PhiShip" value="{{ $shippingFee }}">
                        @csrf
                    </div>

                    <div class="col-lg-4">
                        <div class="border p-4 rounded">
                            <div class="">
                                <h4 class="mb-3 text-second">Thông Tin Khách Hàng</h4>
                                <div class="mb-3">
                                    <input class="form-control" id="name" type="text"  value="{{ old('TenKH', session('user.name', '')) }}"  name="TenKH" placeholder="Tên khách hàng" >
                                    <span class="error-message"></span>
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" id="tel" type="tel" value="{{ old('SDT', session('user.SDT', '')) }}" name="SDT" placeholder="Số điện thoại">
                                    <span class="error-message"></span>
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" id="address" type="text" value="{{ old('DiaChiNhanHang', session('user.DiaChi', '')) }}"  name="DiaChiNhanHang" placeholder="Địa chỉ giao hàng" >
                                    <span class="error-message"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-1 fw-500" for="pttt_id">Phương thức thanh toán</label>
                                    <select class="form-select" name="pttt_id" id="pttt_id">
                                        @foreach($thanhtoans as $thanhtoan)
                                            <option value="{{ $thanhtoan->id }}">{{ $thanhtoan->TenPt }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <textarea class="form-control" name="GhiChu" placeholder="Ghi chú"></textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-main-hover w-100">Đặt Hàng</button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center mt-5"><h2>Giỏ hàng trống, bấm vào <a class="text-main text-decoration-underline" href="/san-pham">đây để mua ngay!</a> </h2></div>
        @endif
    </form>
    
    <script src="/template/js/validator.js"></script>
    <script>
        Validator({
            form: '#order-form',
            rules: [
                Validator.isRequired('#name'),
                Validator.isTel('#tel'),
                Validator.minLength('#address', 10),
            ]
        });
    </script>
  
@endsection
