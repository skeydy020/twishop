<?php

namespace App\Http\Services\Menu;

use App\Models\Menu;
use App\Models\SanPham;
use App\Models\songs;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\FuncCall;

class MenuService{
    public function getParent(){
        return Menu::where('parent_id',0)->get();
    }
     public function danhmuc(){
        $menus =  Menu::select('id', 'name')->withCount('products')
        ->where('parent_id','0')->where('active','1')->get();
        foreach ($menus as $menu) {
            $count = 0;
            $childs = Menu::withCount('products')->where('parent_id',$menu['id'])->get();
            foreach ($childs as $child) {
                $count += $child['products_count'];
            }
            $menu['products_count'] += $count;
        }
        return $menus;
    }
    public function danhmuccon($id){
        $menus =  Menu::select('id', 'name')->withCount('products')
        ->where('parent_id',$id)->where('active','1')->get();
        return $menus;
    }
   
    public function getAll(){
        return Menu::orderbyDesc('id')->paginate(20);   
    }
    public function create($request){
        try{
            Menu::create([
                'name' => (string)$request->input('name'),
                'thumb' => (string)$request->input('thumb'),
                'parent_id' => (int)$request->input('parent_id'),
                'description' => (string)$request->input('description'),
                'content' => (string)$request->input('content'),
                'active' => (string)$request->input('active'),
                'slug'=> Str::slug($request->input('name'),'-')
            ]);
            
            Session::flash('Success','Tạo danh mục thành công');

        }catch(\Exception $err){
            Session::flash('Error',$err->getMessage());
            return false;
        }
        return true;
    }

    public function update($request, $menu): bool
    {
        if ($request->input('parent_id') != $menu->id) {
            $menu->parent_id = (int)$request->input('parent_id');
        }

        $menu->name = (string)$request->input('name');
        $menu->thumb = (string)$request->input('thumb');
        $menu->description = (string)$request->input('description');
        $menu->content = (string)$request->input('content');
        $menu->active = (string)$request->input('active');
        $menu->save();

        
        Session::flash('success', 'Cập nhật thành công Danh mục');
        return true;
    }

    public function destroy($request)
    {
        $id = (int)$request->input('id');
        $menu = Menu::where('id', $id)->first();
        if ($menu) {
            return Menu::where('id', $id)->orWhere('parent_id', $id)->delete();
        }

        return false;
    }
    public function maingetall()
    {
        
            return Menu::
            orderByDesc('id')->paginate(16);
    }
    public function show()
    {
        return Menu::select('name', 'id')
        ->where('parent_id', 0)
        ->orderbyDesc('id')
        ->get();
    }
    public function show4()
    {
        return Menu::whereIn('id', [13, 9, 4, 3])->get();
    }
    

    public function more($id)
    {
        return Menu::
            where('active', 1)
            ->where('id', '!=', $id)
            ->orderByDesc('id')
            ->limit(8)
            ->get();
    }

    public function getId($id)
    {
        return Menu::where('id', $id)->where('active', 1)->firstOrFail();
    }

    public function getProduct($menu, $request)
    {
        $query = $menu->products()
            ->select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1);

        if ($request->input('price')) {
            $query->orderBy('price', $request->input('price'));
        }

        return $query
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();
    }
}