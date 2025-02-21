@extends('admin.main')

@section('content')
{{-- <form action="" method="GET" class="m-3">
    <div class="row">
        <!-- Search by ID -->
        <div class="col-md-3">
            <label for="id">Tìm kiếm theo ID:</label>
            <input type="text" name="id" id="id" value="{{ request('id') }}" class="form-control" placeholder="Nhập ID">
        </div>

        <!-- Search by Name or Phone -->
        <div class="col-md-3">
            <label for="search">Tìm kiếm theo Tên/SDT:</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                   class="form-control" placeholder="Nhập tên khách hàng hoặc số điện thoại">
        </div>

        <!-- Search Button -->
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </div>
        
        <!-- Filter by TTDonHang -->
        <div class="col-md-3">
            <label for="TTDonHang">Lọc theo tình trạng đơn hàng:</label>
            <select name="TTDonHang" id="TTDonHang" class="form-control" onchange="this.form.submit()">
                <option value="">Tất cả</option>
                <option value="Đơn hàng đã đặt" {{ request('TTDonHang') == 'Đơn hàng đã đặt' ? 'selected' : '' }}>Đơn hàng đã đặt</option>
                <option value="Xác nhận đơn hàng" {{ request('TTDonHang') == 'Xác nhận đơn hàng' ? 'selected' : '' }}>Xác nhận đơn hàng</option>
                <option value="Đang chờ vận chuyển" {{ request('TTDonHang') == 'Đang chờ vận chuyển' ? 'selected' : '' }}>Đang chờ vận chuyển</option>
                <option value="Đang vận chuyển" {{ request('TTDonHang') == 'Đang vận chuyển' ? 'selected' : '' }}>Đang vận chuyển</option>
                <option value="Đã giao hàng xong" {{ request('TTDonHang') == 'Đã giao hàng xong' ? 'selected' : '' }}>Đã giao hàng xong</option>
                <option value="" {{ request('TTDonHang') === '' ? 'selected' : '' }}>Chưa cập nhật</option>
            </select>
        </div>

        
    </div>
</form> --}}

    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Tên khách hàng</th>
                <th>Tên sản phẩm</th>
                <th>Lý do bảo hành</th>
                <th>Mô tả</th>
                <th>Trạng thái xử lý</th>
                <th style="width: 100px">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach($baohanhs as $key => $baohanh)
                <tr>
                    <td>{{ $baohanh->id }}</td>
                    <td>{{ $baohanh->ChiTietDonHang->DonHang->NguoiDung->name }}</td>
                    <td>{{ $baohanh->ChiTietDonHang->SanPham->name }}</td>
                    <td>{{ $baohanh->LyDoBaoHanh }}</td>
                    <td>{{ $baohanh->MoTa }}</td>
                    <td>{{ $baohanh->TrangThai }}</td>
                    <td>{{ $baohanh->created_at }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="/admin/baohanhs/edit/{{ $baohanh->id }}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-danger btn-sm"
                            onclick="removeRow('{{ $baohanh->id }}', '/admin/baohanhs/destroy')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        {!! $baohanhs->links() !!}
    </div>
@endsection
