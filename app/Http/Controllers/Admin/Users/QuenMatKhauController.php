<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Services\GioHangService;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class QuenMatKhauController extends Controller
{   
    protected $giohang;
    public function __construct(GioHangService $giohang)
    {
        $this->giohang = $giohang;
    }
    public function index(){
        return view('admin.users.quenmatkhau',['title'=>   'Quên Mật Khẩu',
        'sanphamgiohangs' => $this->giohang->getSanPham()]);
    
       }
       public function datmatkhaumoi(Request $request)
       {
           if ((string) $request->input('password') != (string) $request->input('confirm-password')) {
               Session::flash('error', 'Password nhập lại không trùng khớp');
               return redirect()->back();
           }
       
           $token_random = Str::random();
       
           $customer = User::where('email', '=', $request->input('email'))
                           ->where('remember_token', '=', $request->input('token'))
                           ->first();
       
           if ($customer) {
               // Gán giá trị mới cho thuộc tính
               $customer->password = bcrypt($request->input('password'));
               $customer->remember_token = $token_random;
               $customer->save();
       
               return redirect()->route('login')->with('success', 'Mật khẩu đã cập nhật mới. Quay lại trang đăng nhập');
           } else {
               return redirect()->route('quenmk')->with('error', 'Vui lòng nhập lại email vì link đã quá hạn');
           }
       }
       
    public function matkhaumoi(Request $request)
    {
       
            return view('admin.users.matkhaumoi',['title'=>   'Đặt Mật Khẩu Mới',
            'sanphamgiohangs' => $this->giohang->getSanPham()]);
        
        
    }
    public function guimail(Request $request)
{
    // Tạo một mảng chứa tiêu đề email và thời gian hiện tại
    $data = array();
    $title_mail = "Lấy lại mật khẩu khách hàng - TwiShop " . Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
    $data['email'] = $request->email_account;

    // Tìm kiếm khách hàng theo địa chỉ email mà người dùng nhập vào
    $customer = User::where('email', $data['email'])->get();
    foreach ($customer as $key => $value) {
        $customer_id = $value->id;
    }

    // Kiểm tra xem email có tồn tại trong hệ thống không
    if ($customer) {
        $count_customer = $customer->count();
        
        // Nếu không tìm thấy khách hàng, hiển thị thông báo lỗi
        if ($count_customer == 0) {
            return redirect()->back()->with('error', 'Email chưa được đăng ký để khôi phục mật khẩu');
        } else {
            // Tạo một token ngẫu nhiên để đặt lại mật khẩu
            $token_random = Str::random();
            
            // Cập nhật token cho khách hàng để xác minh
            $customer = User::find($customer_id);
            $customer->remember_token = $token_random;
            $customer->save();

            // Gửi email chứa link đặt lại mật khẩu
            $to_email = $data['email'];
            $link_reset_pass = url('/admin/users/login/matkhaumoi?email=' . $to_email . '&token=' . $token_random);
            
            // Chuẩn bị dữ liệu cho email
            
            $datamail = [
                "name" => $title_mail,
                "body" => $link_reset_pass, // Link reset password
                "email" => $to_email
            ];
            
            // Gửi email
            Mail::send('mail.quenmatkhau', $datamail, function ($message) use ($title_mail, $to_email) {
                $message->to($to_email)->subject($title_mail); // Đặt tiêu đề cho email
                $message->from('toan89471@st.vimaru.edu.vn', $title_mail); // Đặt email người gửi
            });

            // Chuyển hướng và thông báo rằng email đã được gửi thành công
            return redirect()->back()->with('message', 'Gửi mail thành công, vui lòng vào email để reset password');
        }
    }
}

    
    

}
