<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Invoices;
use App\Models\Sections;
use Illuminate\Http\Request;

class CustomersReportController extends Controller
{
    function __construct()
    {
    $this->middleware('permission:التقارير');
    $this->middleware('permission:تقرير العملاء', ['only' => ['index','Search_customers']]);
    }


    public function index()
    {
        $sections = Sections::all();
        return view('reports.customers_report', compact('sections'));
    }
    public function Search_customers(Request $request)
    {
        
// في حالة البحث بدون التاريخ
      
     if ($request->Section && $request->product && $request->start_at =='' && $request->end_at=='') {

       
        $invoices = Invoices::where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
        $sections = Sections::all();
         return view('reports.customers_report',compact('sections','invoices'));
  
      
       }
  
  
    // في حالة البحث بتاريخ
       
       else {
         
         $start_at = date($request->start_at);
         $end_at = date($request->end_at);
  
        $invoices = invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
         $sections = Sections::all();
         return view('reports.customers_report',compact('sections','invoices'));
  
        
       }
    }
}
