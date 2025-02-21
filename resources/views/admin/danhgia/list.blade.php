@extends('admin.main')

@section('content')
    <form action="/admin/danhgia/search" method="GET" class="m-3">
        <div class="row">
            <!-- Search by Product Name -->
            <div class="col-md-3">
                <label for="product_name">Tìm kiếm theo Tên sản phẩm:</label>
                <input type="text" name="product_name" id="product_name" value="{{ request('product_name') }}" class="form-control" placeholder="Nhập tên sản phẩm">
            </div>
    
            <!-- Search by Customer Name -->
            <div class="col-md-3">
                <label for="customer_name">Tìm kiếm theo Tên khách hàng:</label>
                <input type="text" name="customer_name" id="customer_name" value="{{ request('customer_name') }}" class="form-control" placeholder="Nhập tên khách hàng">
            </div>
    
            <!-- Filter by Rating -->
            <div class="col-md-3">
                <label for="rating">Lọc theo đánh giá sao:</label>
                <select name="rating" id="rating" class="form-control" onchange="this.form.submit()">
                    <option value="-1">Tất cả</option>
                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 sao</option>
                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 sao</option>
                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 sao</option>
                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 sao</option>
                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 sao</option>
                </select>
            </div>
    
            <!-- Search Button -->
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </div>
        </div>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th style="width: 50px">ID</th>
            <th>Tên khách hàng</th>
            <th>Tên sản phẩm</th>
            <th>Nội dung</th>
            <th>Rating</th>
            <th>Ngày tạo</th>
        </tr>
        </thead>
        <tbody>
        @foreach($danhgias as $key => $danhgia)
            <tr>
                <td>{{ $danhgia->id }}</td>
                <td>{{ $danhgia->ChiTietDonHang->DonHang->NguoiDung->name}}</td>
                <td>{{ $danhgia->ChiTietDonHang->SanPham->name}}</td>
                <td>{{ $danhgia->NoiDung }}</td>
                <td>{{ $danhgia->Number }}</td>
                <td>{{ $danhgia->created_at }}</td>
                {{-- <td>
                    <a href="#" class="btn btn-danger btn-sm"
                       onclick="removeRow('{{ $danhgia->id }}', '/admin/danhgia/destroy')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td> --}}
            </tr>
        @endforeach
        </tbody>
    </table>
    <div style="margin-top: 20px; text-align: center">{!! $danhgias->links('vendor.pagination.bootstrap-4') !!}</div>
@endsection
​
