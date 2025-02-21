<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\DonHangService;
use App\Models\DonHang;

use App\Http\Services\User\UserService;
use Illuminate\Http\Request;

class DonHangController extends Controller
{
    protected $donhang;
    protected $userService;
    
    public function __construct(DonHangService $donhang,UserService $userService)
    {
        $this->donhang = $donhang;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
         if( $this->userService->CoQuyen()){
        // Fetch all DonHang with optional filtering
        $query = DonHang::query();

        if ($request->filled('TTDonHang')) {
            $query->where('TTDonHang', $request->TTDonHang);
        }
        // Add a special condition for status=processing
        if ($request->input('status') == 'processing') {
            $query->whereNotIn('TTDonHang', ['Đã giao hàng xong', 'Đơn hàng đã huỷ']);
        }


        // Search by ID
        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        // Search by Customer Name or Phone Number
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('TenKH', 'LIKE', "%$search%")
                ->orWhere('SDT', 'LIKE', "%$search%");
            });
        }
        $donhangs = $query->orderByDesc('id');
        $donhangs = $query->paginate(10); // Pagination for better performance

        return view('admin.donhang.list', [
            'title' => 'Danh Sách Đơn Đặt Hàng',
            'donhangs' => $donhangs,
        ]);
         }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }

    public function show(DonHang $donhang)
    {
         if( $this->userService->CoQuyen()){
        $Chitiets = $this->donhang->getProductForCart($donhang);

        return view('admin.donhang.detail', [
            'title' => 'Chi Tiết Đơn Hàng: ' . $donhang->name,
            'donhang' => $donhang,
            'Chitiets' => $Chitiets
        ]);
    }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }

    public function edit(DonHang $donhang)
    {     
         if( $this->userService->CoQuyen()){
        
        return view('admin.donhang.edit', [
            'title' => 'Chỉnh Sửa Trạng Thái Đơn Hàng: ' . $donhang->id
        ]);
         }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }

    public function update(Request $request, DonHang $donhang)
    {   
         if( $this->userService->CoQuyen()){
        
        if(($donhang->TTDonHang == 'Đơn hàng đã huỷ')|($donhang->TTDonHang == 'Đã giao hàng xong')){
            return redirect()->back()->with('message','Không thể thay đổi tình trạng!');
        }
        $result = $this->donhang->update($request, $donhang);
        if ($result) {
            return redirect('/admin/donhangs');
        }

        return redirect()->back();
         }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }

    public function destroy(Request $request)
    {
        if( $this->userService->isAdmin()){
        $result = $this->donhang->delete($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công đơn hàng'
            ]);
        }

        return response()->json(['error' => true]);
    }
        else{
            return redirect()->back()->with('error','Bạn không có quyền để thực hiện chức năng này');}
    }
}
