@extends('admin.main')

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th style="width: 50px">ID</th>
            <th>Người Dùng</th>
            <th>Mã Giảm Giá</th>
            <th>Ngày Sử Dụng</th>
            <th style="width: 100px">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($lichsus as $key => $lichsu)
            <tr>
                <td>{{ $lichsu->id }}</td>
                <td>{{ $lichsu->NguoiDung->name }}</td>
                <td>{{ $lichsu->MaGiamGia->Code }}</td>
              
                <td>{{ $lichsu->created_at }}</td>
               
                <td>
                   
                    <a href="#" class="btn btn-danger btn-sm"
                       onclick="removeRow('{{ $lichsu->id }}', '/admin/magiamgias/destroylichsu')">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $lichsus->links() !!}
@endsection


