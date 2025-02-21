@extends('main')
@section('content')
  <!-- quên mật khâu section -->
<section id="form">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-sm-offset-1">
                <div class="login-form">
                <h1 class="text-center text-second">Điền email tài khoản để lấy lại mật khẩu</h1>
                  
                    <form class="mt-4 w-35 mx-auto"  action="/admin/users/login/guiemail" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="form-label required fw-600">Email</label>
                            <input type="email" class="form-control border-2" placeholder="Nhập email..." name="email_account"
                                aria-describedby="emailHelp" required>
                        </div>
                        <button type="submit" class="btn btn-main-hover d-block mx-auto px-3">Gửi mail</button>
                    </form>
                </div> <!-- /.login-form -->
            </div>
        </div>
    </div>
</section> 

@endsection