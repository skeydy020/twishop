<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\CreateFormRequest;
use Illuminate\Http\Request;
use App\Http\Services\Menu\MenuService;
use App\Http\Services\User\UserService;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{   
    protected $menuService;
    protected $userService;
    
    
    public function __construct(MenuService $menuService,UserService $userService)
    {
        $this->menuService = $menuService;
        $this->userService = $userService;
    
    }


    public function create(){
        if( $this->userService->CoQuyen()){
        return view('admin.menu.add',[
            'title'=>'Thêm danh mục'    ,
            'menus'=>$this->menuService->getParent()
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }
    public function store(CreateFormRequest $request){
        if( $this->userService->CoQuyen()){       
         $this->menuService->create($request);

         return redirect('/admin/menus/list');
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }

    public function index(){
        if( $this->userService->CoQuyen()){
        return view('admin.menu.list',[
            'title' => 'Danh sách các danh mục',
            'menus'=> $this->menuService->getAll()
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
        
    } 

    public function show(Menu $menu)
    {   
        if( $this->userService->CoQuyen()){
        return view('admin.menu.edit', [
            'title' => 'Chỉnh Sửa Danh Mục: ' . $menu->name,
            'menu' => $menu,
            'menus' => $this->menuService->getParent()
        ]);
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }

    public function update(Menu $menu, CreateFormRequest $request)
    {   
        if( $this->userService->CoQuyen()){
        $this->menuService->update($request, $menu);

        return redirect('/admin/menus/list');
        }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }

    public function destroy(Request $request): JsonResponse
    {   
        if( $this->userService->isAdmin()){
        $result = $this->menuService->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công danh mục'
            ]);
        }

        return response()->json([
            'error' => true
        ]);
    }
        else{
            return view('404',[
            'title'=>'Không tìm thấy trang'    
        ]);}
    }


}
