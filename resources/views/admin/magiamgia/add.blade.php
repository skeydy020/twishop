@extends('admin.main')

@section('content')
    <form action="" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Mã code</label>
                        <input type="text" name="Code" value="{{ old('Code') }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    <label for="LoaiGiamGia">Loại giảm giá</label>
                    <select name="LoaiGiamGia" class="form-control" required>
                        <option value="0" {{ old('LoaiGiamGia') == 'percentage' ? 'selected' : '' }}>Phần trăm</option>
                        <option value="1" {{ old('LoaiGiamGia') == 'fixed_amount' ? 'selected' : '' }}>Số tiền cố định</option>
                    </select>
                </div>
            </div>

            </div>


            <div class="form-group">
                        <label >Mô tả</label>
                        <textarea name="MoTa" class="form-control"></textarea>
                    </div>
                    
                    <div class="row">
            <!-- Giá trị giảm giá -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="GiaTriGiamGia">Giá trị giảm giá</label>
                    <input type="number" name="GiaTriGiamGia" value="{{ old('GiaTriGiamGia') }}" step="1" class="form-control" required>
                </div>
            </div>

            <!-- Giá trị đơn hàng tối thiểu -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="GiaTriToiThieu">Giá trị đơn hàng tối thiểu</label>
                    <input type="number" name="GiaTriToiThieu" value="{{ old('GiaTriToiThieu') }}" step="10000" class="form-control">
                </div>
            </div>
            <!-- Giảm giá tối đa -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="GiamGiaToiDa">Giảm giá tối đa</label>
                    <input type="number" name="GiamGiaToiDa" value="{{ old('GiamGiaToiDa') }}" step="10000" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Ngày bắt đầu -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="NgayBatDau">Ngày bắt đầu</label>
                    <input type="datetime-local" name="NgayBatDau" value="{{ old('NgayBatDau') }}" class="form-control">
                </div>
            </div>

            <!-- Ngày kết thúc -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="NgayKetThuc">Ngày kết thúc</label>
                    <input type="datetime-local" name="NgayKetThuc" value="{{ old('NgayKetThuc') }}" class="form-control">
                </div>
            </div>
        </div>
                    <div class="row">
            <!-- Giới hạn số lần sử dụng -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="SLGioiHan">Giới hạn số lần sử dụng</label>
                    <input type="number" name="SLGioiHan" value="{{ old('SLGioiHan') }}" class="form-control">
                </div>
            </div>

            <!-- Số lần đã sử dụng -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="SLSuDung">Số lần đã sử dụng</label>
                    <input type="number" name="SLSuDung" value="{{ old('SLSuDung', 0) }}" class="form-control" readonly>
                </div>
            </div>
        </div>


            <div class="form-group">
                <label>Kích Hoạt</label>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="1" type="radio" id="active" name="KichHoat" checked="">
                    <label for="active" class="custom-control-label">Có</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="0" type="radio" id="no_active" name="KichHoat" >
                    <label for="no_active" class="custom-control-label">Không</label>
                </div>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thêm mã giảm giá</button>
        </div>
        @csrf
    </form>
@endsection

