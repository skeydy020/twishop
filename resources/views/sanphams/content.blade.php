@extends('main')

@section('css')
    <link rel="stylesheet" href="{{asset('static/css/rating.css') }}">
@endsection

@section('content')
<div class="container py-5">
        <div class="row row-cols-1">
        <div class="col-md-7">
                <div class="main-image">
                    <img class="img-fluid" id="mainImage" src="{{ $sanpham->thumb }}" alt="Main Product Image">
                    <div id="magnifier"></div>
                </div>
                <div class="row preview-images ">
                    <button class="col img-btn shadow p-3 mb-5 bg-body rounded mx-2" onclick="changeImage(this)"><img class="img-fluid" src="{{ $sanpham->thumb }}" alt=""></button>
                    @foreach($anhs as $key => $anh)
                    <button class="col img-btn shadow p-3 mb-5 bg-body rounded mx-2" onclick="changeImage(this)"><img class="img-fluid" src="{{ $anh->thumb }}" alt=""></button>
                    @endforeach
                </div>
            </div>
            <div class="col-md-5">
                <h4 class="text-second">{{ $sanpham->name }}</h4>

                <div class="d-flex pt-4">
                    <p class="me-3">Thương hiệu</p>
                    <div class=" flex-fill"><a class="text-primary text-decoration-underline"             href="/thuong-hieu/{{ $sanpham->thuonghieu_id }}-{{ Str::slug($sanpham->ThuongHieu->name, '-') }}">{{ $sanpham->ThuongHieu->name }}</a></div>
                    <p class="id align-self-end">{{ $sanpham->Code }}</p>
                </div>
                <div class="prices d-flex align-items-center pb-4">
                    <p class="m-0 me-4">Giá bán</p>
                    <div class="d-flex align-items-center flex-fill">
                        @if ($sanpham->GiamGia  >0)
                            <span class="price-regular me-2"> {{ number_format($sanpham->Gia, 0, '', '.') }}</span>
                            <span class="price-onsale fs-5"> {{ number_format($sanpham->GiamGia, 0, '', '.') }}</span>
                        @php
                            $phanTramGiam = round((($sanpham->Gia -$sanpham->GiamGia) / $sanpham->Gia) * 100);
                        @endphp
                    </div>
                    <span class="float-end text-muted small me-4">Đã bán: {{ $sanpham->DaBan }}</span>
                    <div class="">
                        <span class="discount-badge-inline float-end">-{{ $phanTramGiam }}%</span>
                            @elseif($sanpham->GiamGia  < 1 )
                                <span class="price-onsale fs-5"> {{ number_format($sanpham->Gia, 0, '', '.') }}</span>
                            @endif
                    </div>
                    
                </div>
                
                <div class="">
                    <li class="py-2 d-flex align-items-center"><i class="fa-solid fa-check me-3 fs-5"></i><span
                            class="fs-6">Hàng chính hãng</span></li>
                    <li class="py-2 d-flex align-items-center"><i class="fa-solid fa-check me-3 fs-5"></i><span
                            class="fs-6">Miễn phí giao hàng toàn quốc đơn trên 500k</span></li>
                    <li class="py-2 d-flex align-items-center"><i class="fa-solid fa-check me-3 fs-5"></i><span
                            class="fs-6">Giao hàng hỏa tốc 4 tiếng</span></li>
                </div>

                
                <form action="/add-cart" method="post">
                    @if ($sanpham->Gia !== NULL)
                        <label for="SoLuong" class="py-4 h5 fw-600">Số lượng ({{ $sanpham->SoLuong }} có sẵn)</label>
                        
                        <div class="d-flex">
                            <div class="d-flex align-items-center bg-light-gray rounded me-5 p-0">
                                <button class="btn-custom px-4 decrement fs-3" type="button">-</button>
                                <input class="text-center fw-500 quantityDisplay num-product rounded border" style="width:100px;" type="number" name="SoLuong" value="1">
                                <button class="btn-custom px-4 increment fs-3" type="button">+</button>
                            </div>

                            <button type="submit"
                                class="btn btn-main-hover add-to-cart-btn capitalize flex-fill">
                                Thêm vào giỏ hàng
                            </button>
                        </div>
                        <input type="hidden" name="sanpham_id" value="{{ $sanpham->id }}">
                    @endif
                    @csrf
                </form>
                                
                <div class="infor mt-5">
                    <h5 class="mb-4">Thông tin sản phẩm</h5>
                    <div class="item row mb-3">
                        <div class="col title">Xuất xứ</div>
                        <div class="col content">{{ $sanpham->XuatXu->name }}</div>
                    </div>
                    <div class="item row mb-3">
                        <div class="col title">Giới tính</div>
                        <div class="col content">{{ $sanpham->GioiTinh->name }}</div>
                    </div>
                    <div class="item row mb-3">
                        <div class="col title">Độ tuổi</div>
                        <div class="col content">{{ $sanpham->DoTuoi->name }}</div>
                    </div>
                    <div class="item row mb-3">
                        <div class="col title">Thương hiệu</div>
                        <div class="col content">{{ $sanpham->ThuongHieu->name }}</div>
                    </div>
                </div>
            </div>
            <div class="col-full">
                <h4 class="my-3">Mô tả sản phẩm</h4>
                <h5>{!! $sanpham->description !!}</h5>
                <div class="desc text-justify mt-3">
                {!! $sanpham->content !!}
                </div>
            </div>

            <div class="component_rating" style="margin-bottom: 20px; margin-top: 40px">
                <h4 style="padding-bottom: 20px">Đánh giá sản phẩm</h4>
                <div class="row" style="border-radius: 5px;margin-left: 0px; margin-right: 0px ;border: 1px solid #dedede">
                    <div class="col-sm-2 component_rating_content" style="display: flex;align-items: center;">
                            <div class="rating_item" style="height: 100%;margin-left: 50%;width: 20%; position: relative; text-align: center">
                                {{-- <span class="fa fa-star" style="font-size: 100px;display: block;color: #ff9705; margin-left: 40px ; text-align: center;"></span> --}}
                                {{-- <b style="position: absolute;top: 50%;left:50%;transform: translate(200%, -50%);color: white;font-size: 20px">2.5</b> --}}
                                <a class="fa fa-star" href="{{ route('chitietsanpham', ['id' => $id, 'slug' => $slug]) }}" 
                                    style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);font-size: 100px;color: #ff9705;cursor: pointer;">
                                </a>
                                <b style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);color: white;font-size: 20px">{{ $tbdanhgia }}</b>
                            </div>    
                    </div> 

                    <div class="col-sm-7 list_rating" style="width: 60%;padding: 20px">
                        @for($i=1; $i <=5; $i++)
                            <div class="item_rating" style="display: flex; align-items: center">
                                <div style="width: 10%; font-size: 14px">
                                    {{ $i }}<span class="fa fa-star" style="padding-left: 5px"></span>
                                </div>
                                <div style="width: 70%; margin: 0 20px">
                                    <span style="width: 100%; height: 8px;display: block; border: 1px solid #dedede; border-radius: 5px; background-color: #dedede">
                                        <b style="width: {{ $gettongluotdanhgia($sanpham) != 0 ? ($getluotdanhgia($sanpham, $i) / $gettongluotdanhgia($sanpham) * 100) : 0 }}%; background-color: #f25800; display: block; border-radius: 5px; height: 100%;"></b>                                            </span>                          
                                </div>
                                <div style="width: 20%">
                                    <a href="{{ route('chitietsanpham', ['id' => $id, 'slug' => $slug]) . '/' . $i }}"> {{ $getluotdanhgia($sanpham, $i) }} đánh giá </a>                   
                                </div>
                            </div>
                        @endfor
                    </div>

                    <div class="col-sm-2 d-flex justify-content-center align-items-center">
                        <a href="{{ route('chitietsanpham', ['id' => $id, 'slug' => $slug]) }}" >
                            <button class="btn btn-primary" style="width: 110%; background-color: #ff9705; border: none;">
                                Tất cả {{ $comments->count() }} đánh giá
                            </button>
                        </a>
                    </div>
                </div>

                <div class="comment-section" style="max-height: 400px; 
                overflow-y: auto; border: 1px solid #ddd; padding: 15px; border-radius: 8px;">
                    <div class="comments" style="margin-top: 15px">
                        <?php
                            foreach ($comments as $comment) {
                                echo '<div class="comment">';
                                echo '<div class="comment-author">' . $comment->ChiTietDonHang->DonHang->NguoiDung->name . '</div>';
                                if (isset($comment->Number)) { //tồn tại
                                    echo '<div>';
                                    for ($i = 1; $i <= $comment->Number; $i++) {
                                        echo '<span class="star">&#9733;</span>'; // Biểu tượng ngôi sao Unicode
                                    }
                                    for ($j = $comment->Number + 1; $j <= 5; $j++) {
                                        echo '<span class="star empty">&#9734;</span>'; // Biểu tượng ngôi sao rỗng Unicode
                                    }
                                    echo '</div>';
                                }
                        
                                echo e($comment->created_at); 
                            
                                echo '<div class="comment-text">' . $comment->NoiDung . '</div>';
                                echo '</div>';
                            }
                        ?>
                    </div>
                </div>
            </div>   

        </div>
    </div>
    <section class="py-md-4 py-2">
        <div class="container position-relative mt-md-5 mt-5">
            <div class="b-md-5 mb-5">
                <h1 class="capitalize text-second fs-3 fs-md-1 text-center">Sản phẩm tương tự</h1>
            </div>
            <div class="row row-cols-2 row-cols-md-4 g-4">
                @foreach($splienquans as $key => $splienquan)
                <div class="col">
                    <a href="/san-pham/{{ $splienquan->id }}-{{ Str::slug($splienquan->name, '-') }}">
                        <div class="card h-100">
                            <img src="{{ $splienquan->thumb }}" class="card-img-top" alt="Toy 1">
                            <div class="card-body">
                                <h5 class="card-title two-line-text-overflow "> {{ $splienquan->name }}</h5>
                                <div class="mb-2 mt-3 text-start">
                                   
                                    @if ($splienquan->GiamGia  >0)
                                    <span class=" price-regular">  {{ number_format($splienquan->Gia, 0, '', '.') }}</span>
                                    <span class=" price-onsale fs-5">  {{ number_format($splienquan->GiamGia, 0, '', '.') }}</span>
                                    @elseif($splienquan->GiamGia  <1 )
                                    <span class="price-onsale fs-5"> {{ number_format($splienquan->Gia, 0, '', '.') }}</span>
                                    @endif
                                </div>
                                <!-- <div class="d-flex align-items-center">
                                    <a href="/add-cart/{{ $splienquan->id }}" class="btn btn-main-hover add-to-cart-btn capitalize flex-fill">Thêm vào
                                        giỏ hàng</a>
                                    <button class="btn btn-favorite"><i
                                            class="fa-regular fa-heart text-main fs-3"></i></button>
                                </div> -->
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="d-flex"><a href="/san-pham" class="btn text-main mt-4 px-4 mx-auto fs-5 fw-bold btn-border">Xem thêm</a></div>
        </div>
    </section>
</div>
</div>

@endsection
