<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Invoices;
use App\Models\InvoicesAttachments;
use Illuminate\Http\Request;

class InvoicesArchiveController extends Controller
{
    function __construct()
    {
    $this->middleware('permission:ارشيف الفواتير', ['only' => ['invoicesArchive']]);
    $this->middleware('permission:ارشفة الفاتورة', ['only' => ['archive']]);
    $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
    $this->middleware('permission:الغاء ارشفة الفاتورة', ['only' => ['update']]);

    }
    public function invoicesArchive()
    {
        $invoices = Invoices::onlyTrashed()->get();
        return view('invoices.invoicesArchive', compact('invoices'));
    }
    public function archive($id)
    {
        $invoices = Invoices::find($id);
        $invoices->delete();
        return Redirect()->route('invoices.index')->with('status', 'تم نقل الفاتوره الى الارشيف');
    }
    public function update($id)
    {
        $flight = Invoices::withTrashed()->where('id', $id)->restore();
        return Redirect()->route('invoices.index')->with('status', 'تم الغاء الفاتوره من الارشيف');
    }
    public function destroy($id)
    {
         $invoices = invoices::withTrashed()->where('id',$id)->first();
         $inv_attachments = InvoicesAttachments::find($id);
        $path = public_path('./files/') . $inv_attachments->file_name;
        unlink($path);
         $invoices->forceDelete();
         return Redirect()->route('invoices.index')->with('status', 'تم حذف الفاتوره بنجاح ');
    
    }
}
