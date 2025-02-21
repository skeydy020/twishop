@extends('admin.main')

@section('content')
<form action="" method="GET" class="m-3">
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
                <option  value="Đơn hàng đã đặt" {{ request('TTDonHang') == 'Đơn hàng đã đặt' ? 'selected' : '' }}>Đơn hàng đã đặt</option>
                <option  value="Xác nhận đơn hàng" {{ request('TTDonHang') == 'Xác nhận đơn hàng' ? 'selected' : '' }}>Xác nhận đơn hàng</option>
                <option  value="Đang chờ vận chuyển" {{ request('TTDonHang') == 'Đang chờ vận chuyển' ? 'selected' : '' }}>Đang chờ vận chuyển</option>
                <option  value="Đang vận chuyển" {{ request('TTDonHang') == 'Đang vận chuyển' ? 'selected' : '' }}>Đang vận chuyển</option>
                <option  value="Đã giao hàng xong" {{ request('TTDonHang') == 'Đã giao hàng xong' ? 'selected' : '' }}>Đã giao hàng xong</option>
                <option  value="Đơn hàng đã huỷ" {{ request('TTDonHang') == 'Đơn hàng đã huỷ' ? 'selected' : '' }}>Đơn hàng đã huỷ</option>
            </select>
        </div>

        
    </div>
</form>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Tài khoản đặt hàng</th>
                <th>Tên Khách Hàng</th>
                <th>Số Điện Thoại</th>
                <th>Phương thức thanh toán</th>
                <th>Địa chỉ nhận</th>
                <th>Tình trạng đơn hàng</th>
                <th>Ngày Đặt hàng</th>
                <th style="width: 100px">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach($donhangs as $key => $donhang)
                <tr>
                    <td>{{ $donhang->id }}</td>
                    <td>{{ $donhang->NguoiDung->name }}</td>
                    <td>{{ $donhang->TenKH }}</td>
                    <td>{{ $donhang->SDT }}</td>
                    <td>{{ $donhang->PTTT->TenPt }}</td>
                    <td>{{ $donhang->DiaChiNhanHang }}</td>
                    <td>
                        <span class="fw-600 status
                            {{ $donhang->TTDonHang == 'Đơn hàng đã đặt' ? 'done' : '' }}
                            {{ $donhang->TTDonHang == 'Xác nhận đơn hàng' ? 'confirmed' : '' }}
                            {{ $donhang->TTDonHang == 'Đang chờ vận chuyển' ? 'pending' : '' }}
                            {{ $donhang->TTDonHang == 'Đang vận chuyển' ? 'shipping' : '' }}
                            {{ $donhang->TTDonHang == 'Đã giao hàng xong' ? 'shipped' : '' }}
                            {{ $donhang->TTDonHang == 'Đơn hàng đã huỷ' ? 'canceled' : '' }} 
                        ">
                            {{ $donhang->TTDonHang == '' ? 'Chưa cập nhật' : $donhang->TTDonHang }}
                        </span>
                    </td>
                    <td>{{ $donhang->created_at }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="/admin/donhangs/edit/{{ $donhang->id }}">
                            <i class="fas fa-edit"></i>
                        </a>
                         <a class="btn btn-primary btn-sm" href="/admin/donhangs/{{ $donhang->id }}">
                        <i class="fas fa-eye"></i>
                    </a>
                        <a href="#" class="btn btn-danger btn-sm"
                            onclick="removeRow('{{ $donhang->id }}', '/admin/donhangs/destroy')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        {!! $donhangs->links() !!}
    </div>
@endsection
