<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Services\GioHangService;
use App\Models\GioiTinh;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Response;

class LoginController extends Controller
{   
    protected $giohang;
    public function __construct(GioHangService $giohang)
    {
        $this->giohang = $giohang;
    }
   public function index(){
    return view('admin.users.login',['title'=>   'Đăng nhập hệ thống',
    'sanphamgiohangs' => $this->giohang->getSanPham()
]);

   }
   public function store(Request $request){
        $this->validate($request,[
            'email'=> 'required|email:filter',  
            'password'=>'required'
        ]);
        if(Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ], $request->input('remember')
        ))
        { 
            $user = Auth::user();
            
            // Kiểm tra xem email đã được xác thực chưa
            if (is_null($user->email_verified_at)) {
                Auth::logout(); // Đăng xuất ngay lập tức nếu email chưa được xác thực
                Session::flash('error', 'Email này chưa được xác thực!.');
                return redirect()->back(); // Trở về trang đăng nhập với thông báo lỗi
            }
            
          if($user->role_id == 1) $quyen = 'Người quản lý';
            else $quyen = 'Nhân viên';

            Session::put('user', [
                'name' => $user->name,
                'thumb' => $user->thumb,
                'quyen' => $quyen, 
                   'SDT' =>  $user->SDT, 
                'DiaChi' =>  $user->DiaChi, 
            ]);
        // Kiểm tra xem người dùng có phải là admin không
        if ($user->role_id == 3) {
            return redirect()->route('home'); // Chuyển hướng đến trang chính cho người dùng thường
        } 
        else {
            return redirect()->route('admin'); // Chuyển hướng đến trang tác vụ
            }
          
           
        }
    Session::flash('error','Email hoặc Password không chính xác');
    return redirect()->back();
   }
   public function redirect($provider)
{
    return Socialite::driver($provider)->redirect();
}
 
public function callback($provider)
{
           
    $getInfo = Socialite::driver($provider)->user();
     
    $user = $this->createUser($getInfo,$provider);
    if($user->role_id == 1) $quyen = 'Người quản lý';
    else $quyen = 'Nhân viên';

    Session::put('user', [
        'name' => $user->name,
        'thumb' => $user->thumb,
        'quyen' => $quyen, 
    ]);
    auth()->login($user);
 
    return redirect()->route('home'); 
 
}
function createUser($getInfo,$provider){
 
 $user = User::where('provider_id', $getInfo->id)->first();
 
 if (!$user) {
     $existingUser = User::where('email', $getInfo->email)->first();

        if ($existingUser) {
            // Nếu email đã tồn tại, cập nhật provider_id
            $existingUser->provider = $provider;
            $existingUser->provider_id = $getInfo->id;
            $existingUser->save();

            return $existingUser;
        }
    $email = $getInfo->email ?? $getInfo->id . '@' . $provider . '.local';

     $user = User::create([
        'name'     => $getInfo->name,
        'email'    => $email,
        'provider' => $provider,
        'provider_id' => $getInfo->id
    ]);
  }
  return $user;
}

}
