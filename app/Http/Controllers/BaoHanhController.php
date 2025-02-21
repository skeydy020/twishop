<?php

namespace App\Http\Controllers;

use App\Http\Services\BaoHanh\BaoHanhService;
use App\Http\Services\User\UserService;
use App\Models\BaoHanh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

use function PHPUnit\Framework\isNull;

class BaoHanhController extends Controller
{
    protected $baohanhservice;

    public function __construct(BaoHanhService $baohanhservice)
    {
        $this->baohanhservice = $baohanhservice;
    }
    
    public function store(Request $request)
    {
        $this->baohanhservice->insert($request);
        return redirect()->back();
    }

    public function index()
    {      
        return view('admin.baohanh.list', [
            'title' => 'Danh Sách bảo hành',
            'baohanhs' => $this->baohanhservice->getAll(),
        ]);
    }

    public function show(BaoHanh $baohanh)
    {     

        return view('admin.baohanh.edit', [
            'title' => 'Chỉnh Sửa Bảo Hành',
            'baohanh' => $baohanh,
        ]);
       
    }

    public function update(Request $request, BaoHanh $baohanh)
    {     

        $this->baohanhservice->update($request, $baohanh); 

        return redirect('/admin/baohanhs/list');

    }

    public function destroy(Request $request)
    {
        $result = $this->baohanhservice->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công tin tức'
            ]);
        }

        return response()->json([ 'error' => true ]);
    }
}
