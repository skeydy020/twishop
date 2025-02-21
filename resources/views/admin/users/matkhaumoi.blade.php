@extends('main')
@section('content')

<section id="form">
    <!-- form -->
    <div class="container">
      
        <div class="login-form">
            <!-- login form -->
            <?php
                $token = $_GET['token'];
                $email = $_GET['email'];
            ?>
             <h1 class="text-center text-second">Điền mật khẩu mới</h1>
            
            <form action="/admin/users/login/datmatkhaumoi" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}"/>
                <input type="hidden" name="token" value="{{ $token }}"/>
           
                    <div class="col">
                        <label for="password" class="form-label required fw-600">Mật khẩu</label>
                        <input type="password" class="form-control border-2" name="password" required>
                    </div>
                    <div class="col">
                        <label for="confirm-password" class="form-label required fw-600">Nhập lại mật khẩu</label>
                        <input type="password" class="form-control border-2" name="confirm-password" required>
                    </div>
             
                <button type="submit" class="btn btn-main-hover d-block mx-auto px-4">Đặt lại mật khẩu</button>
       
            </form>
        </div>
        <!--/login form-->
    </div>
</section>
<!--/form-->
@endsection