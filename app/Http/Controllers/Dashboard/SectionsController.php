<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    function __construct()
    {
    
    $this->middleware('permission:الاقسام', ['only' => ['index']]);
    $this->middleware('permission:اضافة قسم', ['only' => ['create','store']]);
    $this->middleware('permission:تعديل قسم', ['only' => ['edit','update']]);
    $this->middleware('permission:حذف قسم', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Sections::all();
        return view('sections.index',compact('sections'));
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
            'name' =>'required|unique:sections,name',
        ]);
        $section = new Sections();
        $section->name = $request->name;
        $section->description = $request->description;
        $section->created_by = Auth::user()->name;
        $section->save();
        return redirect()->route('sections.index')->with('status' ,'تم اضافه القسم بنجاح');
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
        ]);
        $section = Sections::find($id);
        $section->name = $request->name;
        $section->description = $request->description;
        $section->save();
        return redirect()->route('sections.index')->with('status' ,'تم تحديث القسم بنجاح');
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
        $section = Sections::find($id);
        $section->delete();
        return redirect()->route('sections.index')->with('status','تم حذف القسم بنجاح');
    }
}
