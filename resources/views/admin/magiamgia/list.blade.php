@extends('admin.main')

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th style="width: 50px">ID</th>
            <th>Code</th>
            <th>Loại</th>
            <th>Mô tả</th>
            <th>Giá trị giảm</th>
            <th>Giá trị tối thiểu</th>
            <th>Giảm tối đa</th>
            <th>Giới hạn</th>
            <th>Đã sử dụng</th>
            <th>Ngàu bắt đầu</th>
            <th>Ngày kết thúc</th>
            <th>Trạng Thái</th>
            <th style="width: 100px">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($magiamgias as $key => $magiamgia)
            <tr>
                <td>{{ $magiamgia->id }}</td>
                <td>{{ $magiamgia->Code }}</td>
                <td>{{ $magiamgia->LoaiGiamGia }}</td>
                <td>{{ $magiamgia->MoTa }}
                </td>
                <td>{{ $magiamgia->GiaTriGiamGia }}</td>
                <td>{{ $magiamgia->GiaTriToiThieu }}</td>
                <td>{{ $magiamgia->GiamGiaToiDa }}</td>
                <td>{{ $magiamgia->SLGioiHan }}</td>
                <td>{{ $magiamgia->SLSuDung }}</td>
                <td>{{ $magiamgia->NgayBatDau }}</td>
                <td>{{ $magiamgia->NgayKetThuc }}</td>
                <td>{!! \App\Helper\Helper::active( $magiamgia->KichHoat ) !!}</td>
                <td>
                    <a class="btn btn-primary btn-sm" href="/admin/magiamgias/edit/{{ $magiamgia->id }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="#" class="btn btn-danger btn-sm"
                       onclick="removeRow('{{ $magiamgia->id }}', '/admin/magiamgias/destroy')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <a href="/admin/magiamgias/add" class="button">Thêm mã giảm giá</a>
    {!! $magiamgias->links() !!}
@endsection


