<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Invoices;
use Illuminate\Http\Request;

class InvoicesReportController extends Controller
{
    function __construct()
    {
    $this->middleware('permission:التقارير');
    $this->middleware('permission:تقرير الفواتير', ['only' => ['index','Search_invoices']]);
    }
    
    public function index()
    {
        return view('reports.invoices_report');
    }
    public function Search_invoices(Request $request)
    {
        $rdio = $request->rdio;

        // فى حاله البحث بنوع الفاتوره
        if ($rdio == 1) {
            // فى حاله عدم تحديد تاريخ
            if ($request->type && $request->start_at == '' && $request->end_at =='') {
                $type = $request->type;
                $invoices = Invoices::where('Status', '=', $type)->get();

                return view('reports.invoices_report',compact('invoices','type'));
            }
            // فى حاله تحديد تاريخ
            else{
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;

                $invoices = Invoices::whereBetween('invoice_Date', [$start_at,$end_at])->where('Status', '=', $type)->get();
                return view('reports.invoices_report',compact('invoices','type','start_at','end_at'));
                // return $start_at ;
            }

            // ==========================================================
            // فى حاله البحث برقم الفاتوره
        } else {
            $id = $request->invoice_number;
            $invoices = Invoices::where('id', '=', $id)->get();
            return view('reports.invoices_report',compact('invoices'));
        }
    }
}
