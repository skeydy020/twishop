@extends('main')
@section('content')
<!-- Login section -->
<section>
    <div class="container pt-5 mt-5">
        <h1 class="text-center text-second">Đăng ký</h1>
        @include('admin.alert')
        <form class="mt-4 w-50 mx-auto" id="signup-form" action="/admin/users/login/register/store" method="post">
            <div class="mb-4">
                <label for="name" class="form-label required fw-600">Họ và tên</label>
                <input type="text" id="name" class="form-control border-2" name="name" value="{{ old('name') }}"
                    aria-describedby="emailHelp" required>
                <span id="name-error" class="error-message"></span>
            </div>
            <div class="mb-4">
                <label for="tel" class="form-label required fw-600">Số điện thoại</label>
                <input type="tel" id="tel" class="form-control border-2" name="SDT" value="{{ old('SDT') }}" required>
                <span id="tel-error" class="error-message"></span>
            </div>
            <div class="mb-4">
                <label for="email" class="form-label required fw-600">Email</label>
                <input type="email" id="email" value="{{ old('email') }}" class="form-control border-2" name="email" required>
                <span class="error-message"></span>
            </div>
            <div class="mb-4">
                <div class="gender-selection d-flex align-items-center">
                    <label class="form-label required fw-600 m-0 me-3">Giới tính: </label>
                    <input class="me-1" type="radio" id="male" checked name="GioiTinh" value="Nam" required>
                    <label class="me-3" for="male">Nam </label>

                    <input class="me-1" type="radio" id="female" name="GioiTinh" value="Nữ" required>
                    <label class="me-3" for="female">Nữ </label>

                    <input class="me-1" type="radio" id="other" name="GioiTinh" value="Khác" required>
                    <label for="other">Khác </label>
                </div>
            </div>
            <div class="mb-4">
                <label for="name" class="form-label required fw-600">Địa chỉ</label>
                <input type="text" id="address" class="form-control border-2" name="DiaChi" value="{{ old('DiaChi') }}" required>
                <span id="address-error" class="error-message"></span>
            </div>
            <div class="row row-cols-2 mb-4">
                <div class="col">
                    <label for="password" class="form-label required fw-600">Mật khẩu</label>
                    <input type="password" id="password" class="form-control border-2" name="password" required minlength="8">
                    <span id="password-error" class="error-message"></span>
                </div>
                <div class="col">
                    <label for="confirm-password" class="form-label required fw-600">Nhập lại mật khẩu</label>
                    <input type="password" id="confirm-password" class="form-control border-2" name="confirm-password" required>
                    <span id="confirm-password-error" class="error-message"></span>
                </div>
            </div>
            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input border-1" type="checkbox" value="" id="" required />
                    <label class="form-check-label fs-6" for=""> Tôi đã đọc và đồng ý với <a class="text-second" href="">Điều khoản sử dụng và chính sách của TwiShop</a> </label>
                </div>

            </div>
            <button type="submit" class="btn btn-main-hover d-block mx-auto px-4">Đăng ký</button>

            @csrf
        </form>

    </div>
    <div class="mt-4">
        <p class="text-center">Đã có tài khoản? Bấm vào <a href="/admin/users/login" class="text-main text-decoration-underline fw-600">đây để đăng nhập</a></p>
    </div>
</section>

<script src="/template/js/validator.js"></script>
<script>
    Validator({
        form: '#signup-form',
        rules: [
            Validator.isRequired('#name'),
            Validator.isEmail('#email'),
            Validator.isTel('#tel'),
            Validator.minLength('#address', 10),
            Validator.minLength('#password', 8),
            Validator.isConfirmed('#confirm-password', function() {
                return document.querySelector('#signup-form #password').value;
            }),
        ]
    });
</script>


@endsection