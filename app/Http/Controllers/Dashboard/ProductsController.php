<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    function __construct()
    {
    
    $this->middleware('permission:المنتجات', ['only' => ['index']]);
    $this->middleware('permission:اضافة منتج', ['only' => ['create','store']]);
    $this->middleware('permission:تعديل منتج', ['only' => ['edit','update']]);
    $this->middleware('permission:حذف منتج', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::all();
        $sections = Sections::all();
        return view('products.index',compact('products','sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required|unique:products,name',
            'section_id' =>'required|exists:sections,id',
        ]);
        $products = new Products;
        $products->name = $request->name;
        $products->description = $request->description;
        $products->section_id = $request->section_id;
        $products->save();
        return redirect()->route('products.index')->with('status' ,'تم اضافه المنتج بنجاح');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = request()->id;
        $request->validate([
            'name' =>'required|unique:sections,name,'.$id,
            'section_name' =>'required',

        ]);

        $section_id = Sections::where('name',$request->section_name)->first();
        $product = Products::find($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->section_id = $section_id->id;
        $product->save();
        return redirect()->route('products.index')->with('status' ,'تم تحديث المنتج بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $id = request()->id;
        $product = Products::find($id);
        $product->delete();
        return redirect()->route('products.index')->with('status','تم حذف المنتج بنجاح');
    }
}
