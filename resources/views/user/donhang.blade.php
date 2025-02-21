@extends('main')

@section('css')
<link rel="stylesheet" href="{{asset('static/css/rating.css') }}">
@endsection

@section('content')

<div class="container py-5">
    <h1 class="text-second text-center capitalize">Chi tiết đơn hàng</h1>

    <div class="row row-cols-2 mt-5">

        <!-- Sidebar -->
        <div class="w-25 side-bar-box p-0 mx-4">
            <h5 class="bg-main side-bar-heading py-3 text-center">Tài khoản của bạn</h5>
            <ul class="p-3 m-0">
                <li class="mb-3 px-3 py-2 d-block fw-500 side-bar-item rounded-3">
                    <a href="/tai-khoan" class="nav-link">
                        Thông tin tài khoản
                    </a>
                </li>
                <li class="mb-3 px-3 py-2 d-block fw-500 side-bar-item rounded-3 active">
                    <a href="/tai-khoan/lich-su-mua-hang" class="nav-link">
                        Lịch sử đơn hàng
                    </a>
                </li>
                <li class="mb-3 px-3 py-2 d-block fw-500 side-bar-item rounded-3 ">
                    <a href="/tai-khoan/doi-mat-khau" class="nav-link">
                        Đổi mật khẩu
                    </a>
                </li>
                <li class="mb-3 px-3 py-2 d-block fw-500 side-bar-item rounded-3">
                    <a href="/dang-xuat" class="nav-link">
                        Đăng xuất
                    </a>
                </li>
            </ul>
        </div>
        <!-- Content -->
        <div class="col-md-8 py-4 px-4 border box-rounded box-content active">
            <h6 class="text-second fw-600 mb-4 capitalize">thông tin đơn hàng</h6>
            <div class="customer mt-3">
                <ul class="p-0">
                    <li class="my-1">Tên khách hàng: <strong>{{ $donhang->TenKH }}</strong></li>
                    <li class="my-1">Số điện thoại: <strong>{{ $donhang->SDT }}</strong></li>
                    <li class="my-1">Địa chỉ nhận hàng: <strong>{{ $donhang->DiaChiNhanHang }}</strong></li>
                    <li class="my-1">Phương thức thanh toán: <strong>{{ $donhang->PTTT->TenPt }}</strong></li>
                    <span class="">Trạng thái:
                        <span class=" fw-bold status
                    {{ $donhang->TTDonHang == 'Đơn hàng đã đặt' ? 'done' : '' }}
                    {{ $donhang->TTDonHang == 'Xác nhận đơn hàng' ? 'confirmed' : '' }}
                    {{ $donhang->TTDonHang == 'Đang chờ vận chuyển' ? 'pending' : '' }}
                    {{ $donhang->TTDonHang == 'Đang vận chuyển' ? 'shipping' : '' }}
                    {{ $donhang->TTDonHang == 'Đã giao hàng xong' ? 'shipped' : '' }}
                ">
                            {{ $donhang->TTDonHang == '' ? 'Chưa cập nhật' : $donhang->TTDonHang }}
                        </span>
                    </span>

                    <li class="my-1">Ghi chú: <strong>{{ $donhang->GhiChu }}</strong></li>
                    <li class="my-1">Ngày đặt hàng : <strong>{{ $donhang->created_at }}</strong></li>
                </ul>
            </div>

            <div class="carts">
                @php $TongTien = 0; @endphp
                <table class="table align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 15%;">Hình ảnh</th>
                            <th scope="col" style="width: 20%;">Tên sản phẩm</th>
                            <th scope="col" style="width: 15%;">Giá</th>
                            <th scope="col" style="width: 15%;">Số lượng</th>
                            <th scope="col" style="width: 15%;">Tổng tiền</th>
                            <th scope="col" style="width: 20%;">Đánh giá</th>
                            <th scope="col" style="width: 15%;">Yêu cầu bảo hành</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($Chitiets as $key => $Chitiet)
                        @php
                        $GiaThoiDiem = $Chitiet->Gia * $Chitiet->SoLuong;
                        $TongTien += $GiaThoiDiem;
                        @endphp
                        <tr>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <img src="{{ $Chitiet->SanPham->thumb }}" alt="IMG" style="width: 100px; height: auto; object-fit: cover;">
                                </div>
                            </td>
                            <td class="text-start text-truncate" style="max-width: 150px;">{{ $Chitiet->SanPham->name }}</td>
                            <td class="price">{{ number_format($Chitiet->Gia, 0, '', '.') }}</td>
                            <td>{{ $Chitiet->SoLuong }}</td>
                            <td class="price text-main">{{ number_format($GiaThoiDiem, 0, '', '.') }}</td>
                            <td class="">
                                @if($donhang->TTDonHang == 'Đã giao hàng xong' && !App\Http\Services\SanPham\SanPhamWebService::isdanhgia($Chitiet->id))
                                <!-- Nút Gửi Đánh Giá -->
                                <div class="js_rating_action" data-id="{{ $Chitiet->id }}" style=" padding-top: 0px;text-align: center">
                                    <a style="width: 400px;background: #FC4100; padding: 10px;color: white;border-radius: 5px" href="">Đánh giá</a>
                                </div>

                                <div class="form_rating form_rating_{{ $Chitiet->id }} d-none ">
                                    <form class="rateForm px-3 rounded" action="/san-pham/danh-gia" method="post">
                                        @csrf
                                        <div style="display: flex;margin-top: 15px; font-size: 15px">
                                            <p class="text-center">Chọn đánh giá của bạn</p>
                                            <span style="margin: 0 15px" class="list_start">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa fa-star fa-star-{{$Chitiet->id}}" data-key="{{ $i }}"></i>
                                                    @endfor
                                            </span>
                                            <span class="list_text" style=" padding-bottom: 0px; height: 24px;"></span>
                                        </div>
                                        <div>
                                            <textarea name="NoiDung" class="form-control" id="" cols="30" rows="3"></textarea>
                                        </div>
                                        <input type="hidden" name="chitietdonhang_id" value="{{ $Chitiet->id }}">
                                        <input id="ratingNumber" type="hidden" name="Number" value="0">

                                        <div style="margin-top: 15px">
                                            <button class="btn btn-main-hover"
                                                href="">
                                                Gửi đánh giá
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                @endif
                            </td>
                            
                            <td class="">
                                @if($donhang->TTDonHang == 'Đã giao hàng xong')
                                    <div class="js_baohanh_action" data-id="{{ $Chitiet->id }}" style="text-align: center">
                                        <!-- Nút mở modal -->
                                        <?php $baohanh = $getBaoHanh($Chitiet->id); ?>
                                        
                                        @if(is_null($baohanh))
                                            <button 
                                                type="button" 
                                                class="btn btn-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalBaoHanh{{ $Chitiet->id }}" 
                                                style="width: 100px;background: #FC4100; padding: 10px;color: white;border-radius: 5px; border: #FC4100 ">
                                                Yêu cầu bảo hành
                                            </button>
                                        @elseif($baohanh->TrangThai == "Chờ xử lý")
                                            <button 
                                                type="button" 
                                                class="btn btn-primary" 
                                                style="width: 100px;background: #FC4100; padding: 10px;color: white;border-radius: 5px; border: #FC4100 ">
                                                Chờ xử lý
                                            </button>
                                        @elseif($baohanh->TrangThai == "Đang xử lý")
                                            
                                        <button 
                                            type="button" 
                                            class="btn btn-primary" 
                                            style="width: 100px;background: #FC4100; padding: 10px;color: white;border-radius: 5px; border: #FC4100 ">
                                            Đang xử lý
                                        </button>
                                        
                                        @elseif($baohanh->TrangThai == "Hoàn thành")
                                        <button 
                                            type="button" 
                                            class="btn btn-primary" 
                                            style="width: 100px;background: #FC4100; padding: 10px;color: white;border-radius: 5px; border: #FC4100 ">
                                            Hoàn Thành
                                        </button>

                                        @else

                                        <button 
                                            type="button" 
                                            class="btn btn-primary" 
                                            style="width: 100px;background: #FC4100; padding: 10px;color: white;border-radius: 5px; border: #FC4100 ">
                                            {{ $baohanh->TrangThai }}
                                        </button>

                                        @endif
                                    </div>
                                @endif
                            
                                <!-- Modal Bảo hành -->
                                <div class="modal fade" id="modalBaoHanh{{ $Chitiet->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $Chitiet->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form class="baohanh" action="/bao-hanh/store" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalLabel{{ $Chitiet->id }}">Thông tin bảo hành</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="productName" class="form-label">Tên sản phẩm</label>
                                                        <input type="text" class="form-control" id="productName" value="{{ $Chitiet->SanPham->name }}" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="orderCode" class="form-label">Mã đơn hàng</label>
                                                        <input type="text" class="form-control" id="orderCode" value="{{ $donhang->id }}" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="warrantyReason" class="form-label">Lý do bảo hành</label>
                                                        <select class="form-select" id="warrantyReason" name="LyDoBaoHanh" required>
                                                            <option value="" disabled selected>Chọn lý do bảo hành</option>
                                                            <option value="Sản phẩm bị lỗi kỹ thuật">Sản phẩm bị lỗi kỹ thuật</option>
                                                            <option value="Sản phẩm không hoạt động đúng chức năng">Sản phẩm không hoạt động đúng chức năng</option>
                                                            <option value="Lỗi do quá trình vận chuyển">Lỗi do quá trình vận chuyển</option>
                                                            <option value="Lý do khác">Lý do khác</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label for="description" class="form-label">Mô tả lỗi sản phẩm</label>
                                                        <textarea class="form-control" id="description" name="MoTa" rows="3" required></textarea>
                                                    </div>
                                                    <!-- Truyền thêm thông tin ẩn -->
                                                    <input type="hidden" name="chitietdonhang_id" value="{{ $Chitiet->id }}">
                                                    <input type="hidden" name="TrangThai" value="Chờ xử lý">
                                                    <input type="hidden" name="donhang_id" value="{{ $donhang->id }}">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                    <button type="submit" class="btn btn-primary">Gửi yêu cầu bảo hành</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        <tr class="table-secondary">
                            <td colspan="6" class="text-end fw-bold">Tổng Tiền Đơn Hàng</td>
                            <td class="fw-bold price text-main text-end">{{ number_format($TongTien, 0, '', '.') }}</td>
                        </tr>
                        <tr class="table-secondary">
                            <td colspan="6" class="text-end fw-bold">Số Tiền Giảm</td>
                            <td class="fw-bold price text-main text-end">{{ number_format($TongTien - $donhang->TongTien, 0, '', '.') }}</td>
                        </tr>
                        <tr class="table-secondary">
                            <td colspan="6" class="text-end fw-bold">Số Tiền Thanh Toán</td>
                            <td class="fw-bold price text-main text-end">{{ number_format($donhang->TongTien, 0, '', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-end mt-4">
                <a href="/tai-khoan/huy-don-hang/{{ $donhang->id }}" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng?');">Hủy Đơn Hàng</a>
            </div>
        </div>
    </div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="{{asset('static/js/rating.js')}}"></script>

@endsection