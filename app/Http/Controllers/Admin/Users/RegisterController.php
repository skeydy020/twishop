<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Services\GioHangService;
use App\Models\User;
use App\Models\XacThucEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\BinaryOp\Equal;
use Illuminate\Support\Str;

class RegisterController extends Controller
{   
    protected $giohang;
    public function __construct(GioHangService $giohang)
    {
        $this->giohang = $giohang;
    }
   public function index(){
    return view('admin.users.register',['title'=>   'Đăng ký tài khoản',
    'sanphamgiohangs' => $this->giohang->getSanPham()]);

   }
   public function store(Request $request){
    if(((String)$request->input('password')) != ((String)$request->input('confirm-password')))
    {   Session::flash('error','Password nhập lại không trùng khớp');
        return redirect()->back();
    }   
        $user = User::where('email',$request->input('email'))->first();
        if($user){
            if(is_null($user->email_verified_at)){
                $user->name = $request->input('name');
                $user->SDT = $request->input('SDT');
                $user->GioiTinh = $request->input('GioiTinh');
                $user->DiaChi = $request->input('DiaChi');
                $user->password = bcrypt($request->input('password'));
                $user->save();
                $this->guimail($request);
               
            }
            else{
                return redirect()->back()->with('error', 'Tài khoản Email đã được đăng kí');
            }
        }
        else{
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->SDT = $request->input('SDT');
        $user->DiaChi = $request->input('DiaChi');
        $user->GioiTinh = $request->input('GioiTinh');
        $user->password = bcrypt($request->input('password'));
        
        $user->save();
        $this->guimail($request);
    }
        return redirect()->route('login');
    
   }
   public function guimail(Request $request)
{
    // Tạo một mảng chứa tiêu đề email và thời gian hiện tại
    $data = array();
    $title_mail = "Xác thực tài khoản khách hàng - TwiShop " . Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
    $data['email'] = $request->email;

    // Tìm kiếm khách hàng theo địa chỉ email mà người dùng nhập vào
    $customer = User::where('email', $data['email'])->get();
    foreach ($customer as $key => $value) {
        $customer_id = $value->id;
    }   

    // Kiểm tra xem email có tồn tại trong hệ thống không
    
            // Tạo một token ngẫu nhiên để đặt lại mật khẩu
            $token_random = Str::random(6);
            
            // Cập nhật token cho khách hàng để xác minh
            $customer = User::find($customer_id);
            $customer->xacthuc = $token_random;
            $customer->save();

            // Gửi email chứa link đặt lại mật khẩu
            $to_email = $data['email'];
            $link_xacthuc = url('/admin/users/login/register/xacthuc?email=' . $to_email . '&xacthuc=' . $token_random);
            
            // Chuẩn bị dữ liệu cho email
            
            $datamail = [
                "name" => $title_mail,
                "body" => $link_xacthuc, // Link reset password
                "email" => $to_email
            ];
            
            // Gửi email
            Mail::send('mail.xacthuc', $datamail, function ($message) use ($title_mail, $to_email) {
                $message->to($to_email)->subject($title_mail); // Đặt tiêu đề cho email
                $message->from('toan89471@st.vimaru.edu.vn', $title_mail); // Đặt email người gửi
            });

            // Chuyển hướng và thông báo rằng email đã được gửi thành công
            return redirect()->back()->with('message', 'Gửi mail thành công, vui lòng vào email để xác thực tài khoản');
        
    
}
public function xacthuc(Request $request)
       {
           
       
           $token_random = Str::random(6);
       
           $customer = User::where('email', '=', $request->input('email'))
                           ->where('xacthuc', '=', $request->input('xacthuc'))
                           ->first();
       
           if ($customer) {
               // Gán giá trị mới cho thuộc tính
               $customer->xacthuc = $token_random;
               $customer->email_verified_at = date('Y-m-d');
               $customer->save();
       
               return redirect()->route('login')->with('success', 'Xác thực email thành công! Quay lại trang đăng nhập');
           } else {
               return redirect()->route('login')->with('error', 'Link đã quá hạn');
           }
       }

}
