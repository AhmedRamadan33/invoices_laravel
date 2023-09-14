<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;

use App\Models\InvoicesAttachments;
use Illuminate\Http\Request;

class InvoicesAttachmentsController extends Controller
{
    function __construct()
    {
    $this->middleware('permission:عرض المرفق', ['only' => ['open_file']]);
    $this->middleware('permission:تحميل المرفق', ['only' => ['get_file']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoicesAttachments  $invoicesAttachments
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoicesAttachments  $invoicesAttachments
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoicesAttachments  $invoicesAttachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoicesAttachments  $invoicesAttachments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function open_file($id,$file_name)
    {
        $contents = public_path('./files/') . $file_name;
        return response()->file($contents);
    }
    public function get_file($id,$file_name)
    {
        $contents = public_path('./files/') . $file_name;
        return response()->download( $contents);
    }

    
}
