@extends('admin.main')

@section('head')
@endsection

@section('content')
    <form action="" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                        <label>Tình trạng bảo hành</label>
                        <select class="form-control" name="TrangThai">
                            <option value="Chờ xử lý">Chờ xử lý</option>
                            <option value="1 đổi 1 trong 3 ngày">1 đổi 1 trong 3 ngày</option>
                            <option value="Sửa chữa 7 ngày">Sửa chữa 7 ngày</option>
                            <option value="Bảo hành hoàn thành">Bảo hành hoàn thành</option>
                            <option value=""></option>
                        </select>
                    </div>
             </div>
            </div>       

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập Nhật Trạng Thái Bảo Hành</button>
        </div>
        @csrf
    </form>
@endsection

@section('footer')
@endsection
