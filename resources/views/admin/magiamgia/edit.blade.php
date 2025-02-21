@extends('admin.main')

@section('content')
    <form action="" method="POST">
        <div class="card-body">
            <div class="row">
                <!-- Mã code -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Code">Mã code</label>
                        <input type="text" name="Code" value="{{ $magiamgia->Code }}" class="form-control" required>
                    </div>
                </div>

                <!-- Loại giảm giá -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="discount_type">Loại giảm giá</label>
                        <select name="discount_type" class="form-control" required>
                            <option value="0" {{ $magiamgia->LoaiGiamGia == '0' ? 'selected' : '' }}>Phần trăm</option>
                            <option value="1" {{ $magiamgia->LoaiGiamGia == '1' ? 'selected' : '' }}>Số tiền cố định</option>
                        </select>
                    </div>
                </div>
            </div>
        <!-- Mô tả -->
        <div class="form-group">
                <label for="description">Mô Tả</label>
                <textarea name="MoTa" class="form-control">{{ $magiamgia->MoTa }}</textarea>
            </div>
            <div class="row">
                <!-- Giá trị giảm giá -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="GiaTriGiamGia">Giá trị giảm giá</label>
                        <input type="number" name="GiaTriGiamGia" value="{{ $magiamgia->GiaTriGiamGia }}" step="1" class="form-control" required>
                    </div>
                </div>

                <!-- Giá trị đơn hàng tối thiểu -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="GiaTriToiThieu">Giá trị đơn hàng tối thiểu</label>
                        <input type="number" name="GiaTriToiThieu" value="{{ $magiamgia->GiaTriToiThieu }}" step="10000" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="GiamGiaToiDa">Giá trị đơn hàng tối thiểu</label>
                        <input type="number" name="GiamGiaToiDa" value="{{ $magiamgia->GiamGiaToiDa }}" step="10000" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Ngày bắt đầu -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="NgayBatDau">Ngày bắt đầu</label>
                        <input type="datetime-local" name="NgayBatDau" value="{{ $magiamgia->NgayBatDau }}" class="form-control">
                    </div>
                </div>

                <!-- Ngày kết thúc -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="NgayKetThuc">Ngày kết thúc</label>
                        <input type="datetime-local" name="NgayKetThuc" value="{{ $magiamgia->NgayKetThuc }}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Giới hạn số lần sử dụng -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="SLGioiHan">Giới hạn số lần sử dụng</label>
                        <input type="number" name="SLGioiHan" value="{{ $magiamgia->SLGioiHan }}" class="form-control">
                    </div>
                </div>

                <!-- Số lần đã sử dụng -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="SLSuDung">Số lần đã sử dụng</label>
                        <input type="number" name="SLSuDung" value="{{ $magiamgia->SLSuDung }}" class="form-control" readonly>
                    </div>
                </div>
            </div>

           

            <!-- Kích Hoạt -->
            <div class="form-group">
                <label for="is_active">Kích Hoạt</label>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="1" type="radio" id="active" name="is_active" {{ $magiamgia->is_active == 1 ? 'checked' : '' }}>
                    <label for="active" class="custom-control-label">Có</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="0" type="radio" id="no_active" name="is_active" {{ $magiamgia->is_active == 0 ? 'checked' : '' }}>
                    <label for="no_active" class="custom-control-label">Không</label>
                </div>
            </div>

         
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập Nhật mã giảm giá</button>
        </div>
        @csrf
    </form>
@endsection
