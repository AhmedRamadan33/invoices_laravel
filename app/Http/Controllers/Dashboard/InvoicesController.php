<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Sections;
use App\Models\Invoices;
use App\Models\InvoicesAttachments;
use App\Models\InvoicesDetails;
use App\Models\User;
use App\Notifications\AddInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class InvoicesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:الفواتير');
        $this->middleware('permission:قائمة الفواتير', ['only' => ['index']]);
        $this->middleware('permission:الفواتير المدفوعة', ['only' => ['invoicesPaid']]);
        $this->middleware('permission:الفواتير الغير مدفوعة', ['only' => ['invoicesUnpaid']]);
        $this->middleware('permission:الفواتير المدفوعة جزئيا', ['only' => ['invoicesPartial']]);

        $this->middleware('permission:اضافة فاتورة', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل الفاتورة', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
        $this->middleware('permission:طباعةالفاتورة', ['only' => ['Print_invoice']]);
        $this->middleware('permission:تغير حالة الدفع', ['only' => ['Status_edit']]);
        $this->middleware('permission:تفاصيل فاتورة', ['only' => ['invoicesDetails']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoices::all();
        return view('invoices.index', compact('invoices'));
    }
    public function invoicesPaid()
    {
        $invoices = Invoices::where('Value_Status', 1)->get();
        return view('invoices.invoicesPaid', compact('invoices'));
    }
    public function invoicesUnpaid()
    {
        $invoices = Invoices::where('Value_Status', 2)->get();
        return view('invoices.invoicesUnpaid', compact('invoices'));
    }
    public function invoicesPartial()
    {
        $invoices = Invoices::where('Value_Status', 3)->get();
        return view('invoices.invoicesPartial', compact('invoices'));
    }
    public function Print_invoice($id)
    {
        $invoices = Invoices::find($id);
        return view('invoices.Print_invoice', compact('invoices'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Sections::all();
        return view('invoices.add', compact('sections'));
    }

    // display prod By Sec
    public function prodBySec($id)
    {
        $prodBySec = DB::table('products')->where('section_id', $id)->pluck('name', 'id');
        return json_encode($prodBySec);
    }
    // invoicesDetails
    public function invoicesDetails($id)
    {

        $invoices = invoices::where('id', $id)->first();
        $details  = InvoicesDetails::where('id_Invoice', $id)->get();
        $attachments  = InvoicesAttachments::where('invoice_id', $id)->get();
        
        return view('invoices.details', compact('invoices', 'attachments', 'details'));
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
            'invoice_Date' => 'required|date',
            'Due_date' => 'required|date',
            'product' => 'required|string',
            'Section' => 'required',
            'Amount_collection' => 'required|string',
            'Amount_Commission' => 'required|string',
            'Rate_VAT' => 'required|string',
            'pic' => 'required|mimes:jpeg,png,jpg,gif,pdf'

        ]);
        $invoices = new Invoices();
        $invoices->invoice_Date = $request->invoice_Date;
        $invoices->Due_date = $request->Due_date;
        $invoices->product = $request->product;
        $invoices->section_id = $request->Section;
        $invoices->Amount_collection = $request->Amount_collection;
        $invoices->Amount_Commission = $request->Amount_Commission;
        $invoices->Discount = $request->Discount;
        $invoices->Value_VAT = $request->Value_VAT;
        $invoices->Rate_VAT = $request->Rate_VAT;
        $invoices->Total = $request->Total;
        $invoices->note = $request->note;

        $invoices->save();

        InvoicesDetails::create([
            'id_Invoice' => $invoices->id,
        ]);

        //start upload file code
        $file = $request->file('pic');
        $fileName = time() . $file->getClientOriginalName();
        $location = public_path('./files/');
        $file->move($location, $fileName);
        //End upload file code

        // store in invoices attachments database
        $inv_attachments = new InvoicesAttachments();
        $inv_attachments->invoice_id = $invoices->id;
        $inv_attachments->file_name = $fileName;
        $inv_attachments->Created_by = Auth::user()->name;
        $inv_attachments->save();


        if (Auth::user()->roles_name != 'owner') {
            $user = User::where('roles_name', '=', 'owner')->get();
            $InvoiceNoti = Invoices::latest()->first();
            Notification::send($user, new AddInvoice($InvoiceNoti));
        }

        return redirect()->route('invoices.create')->with('status', 'تم اضافه الفاتوره بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices = Invoices::find($id);
        $sectionId = $invoices->section_id;
        $sections = Sections::where('id', '!=', $sectionId)->get();

        $inv_attachments = InvoicesAttachments::find($id);
        return view('invoices.edit', compact('invoices', 'sections', 'inv_attachments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'invoice_Date' => 'required|date',
            'Due_date' => 'required|date',
            'product' => 'required|string',
            'Section' => 'required',
            'Amount_collection' => 'required|string',
            'Amount_Commission' => 'required|string',
            'Rate_VAT' => 'required|string',

        ]);
        $invoices = Invoices::find($id);
        $invoices->invoice_Date = $request->invoice_Date;
        $invoices->Due_date = $request->Due_date;
        $invoices->product = $request->product;
        $invoices->section_id = $request->Section;
        $invoices->Amount_collection = $request->Amount_collection;
        $invoices->Amount_Commission = $request->Amount_Commission;
        $invoices->Discount = $request->Discount;
        $invoices->Value_VAT = $request->Value_VAT;
        $invoices->Rate_VAT = $request->Rate_VAT;
        $invoices->Total = $request->Total;
        $invoices->note = $request->note;
        $invoices->save();


        $inv_attachments = InvoicesAttachments::find($invoices->id);

        //start upload file code
        $file = $request->file('pic');
        if ($file != null) {
            $fileName = time() . $file->getClientOriginalName();
            $location = public_path('./files/');
            $file->move($location, $fileName);
            $path = public_path('./files/') . $inv_attachments->file_name;
            unlink($path);
        } else {
            $fileName = $inv_attachments->file_name;
        }

        //End upload file code
        $invoices_id = $invoices->id;
        // store in invoices attachments database
        $inv_attachments->invoice_id = $invoices_id;
        $inv_attachments->file_name = $fileName;
        $inv_attachments->Created_by = Auth::user()->name;
        $inv_attachments->save();
        return redirect()->route('invoices.index')->with('status', 'تم تحديث الفاتوره بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $inv_attachments = InvoicesAttachments::find($request->invoice_id);
        $invoices = Invoices::find($request->invoice_id);
        $path = public_path('./files/') . $inv_attachments->file_name;
        unlink($path);
        $invoices->forceDelete();
        return redirect()->route('invoices.index')->with('status', 'تم حذف الفاتوره بنجاح');
    }

    public function Status_edit($id)
    {
        $invoices = Invoices::find($id);
        return view('invoices.status', compact('invoices'));
    }
    public function Status_Update($id, Request $request)
    {
        $invoices = Invoices::find($id);

        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            InvoicesDetails::create([
                'id_Invoice' => $invoices->id,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'Payment_Date' => $request->Payment_Date,
            ]);
        } else {
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            InvoicesDetails::create([
                'id_Invoice' => $invoices->id,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'Payment_Date' => $request->Payment_Date,
            ]);
        }
        return redirect()->route('invoices.index')->with('status', 'تم تحديث حاله الفاتوره بنجاح');
    }


    public function MarkAsRead_all()
    {
        $userUnreadNotification = auth()->user()->unreadNotifications;

        if ($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return redirect()->back();
        }
    }
}
