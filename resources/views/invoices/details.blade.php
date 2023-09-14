@extends('layouts.master')

@section('title')
    تفاصيل فاتورة
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <a href="{{route('invoices.index')}}" class=" text-dark mb-0 my-auto">قائمة الفواتير</a><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تفاصيل الفاتورة</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    <!-- row opened -->
    <div class="row row-sm">

        <div class="col-xl-12">
            <!-- div -->
            <div class="card mg-b-20" id="tabs-style2">
                <div class="card-body">
                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-2">
                                <div class=" tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                            <li><a href="#tab4" class="nav-link active" data-toggle="tab">معلومات
                                                    الفاتورة</a></li>
                                            <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
                                            <li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border">
                                    <div class="tab-content">


                                        <div class="tab-pane active" id="tab4">
                                            <div class="table-responsive mt-15">

                                                <table class="table table-striped" style="text-align:center">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">تاريخ الاصدار</th>
                                                            <td class=" text-info">{{ $invoices->invoice_Date }}</td>
                                                            <th scope="row">تاريخ الاستحقاق</th>
                                                            <td class=" text-info">{{ $invoices->Due_date }}</td>
                                                            <th scope="row">القسم</th>
                                                            <td class=" text-info">{{ $invoices->sections->name }}</td>
                                                            <th scope="row">المنتج</th>
                                                            <td class=" text-info">{{ $invoices->product }}</td>
                                                        </tr>

                                                        <tr>
                                                           
                                                            <th scope="row">مبلغ التحصيل</th>
                                                            <td class=" text-info">{{ $invoices->Amount_collection }}</td>
                                                            <th scope="row">مبلغ العمولة</th>
                                                            <td class=" text-info">{{ $invoices->Amount_Commission }}</td>
                                                            <th scope="row">الخصم</th>
                                                            <td class=" text-info">{{ $invoices->Discount }}</td>
                                                            <th scope="row">نسبة الضريبة</th>
                                                            <td class=" text-info">{{ $invoices->Rate_VAT }}</td>
                                                        </tr>


                                                        <tr>
                                                            
                                                            <th scope="row">قيمة الضريبة</th>
                                                            <td class=" text-info">{{ $invoices->Value_VAT }}</td>
                                                            <th scope="row">الاجمالي مع الضريبة</th>
                                                            <td class=" text-info">{{ $invoices->Total }}</td>
                                                            <th scope="row">الحالة الحالية</th>

                                                            @if ($invoices->Value_Status == 1)
                                                                <td><span
                                                                        class="badge badge-pill badge-success">{{ $invoices->Status }}</span>
                                                                </td>
                                                            @elseif($invoices->Value_Status ==2)
                                                                <td><span
                                                                        class="badge badge-pill badge-danger">{{ $invoices->Status }}</span>
                                                                </td>
                                                            @else
                                                                <td><span
                                                                        class="badge badge-pill badge-warning">{{ $invoices->Status }}</span>
                                                                </td>
                                                            @endif
                                                        </tr>

                                                        <tr>
                                                            <th scope="row">ملاحظات</th>
                                                            <td class=" text-info">{{ $invoices->note }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab5">
                                            <div class="table-responsive mt-15">
                                                <table class="table center-aligned-table mb-0 table-hover"
                                                    style="text-align:center">
                                                    <thead>
                                                        <tr class="text-dark">
                                                            <th>نوع المنتج</th>
                                                            <th>القسم</th>
                                                            <th>حالة الدفع</th>
                                                            <th>تاريخ الاضافة </th>
                                                            <th>تاريخ الدفع </th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($details as $detail)
                                                        <tr>
                                                            <td>{{ $detail->invoices->product }}</td>
                                                            <td>{{ $detail->invoices->sections->name }}</td>
                                                            @if ($detail->Value_Status == 1)
                                                                <td><span
                                                                        class="badge badge-pill badge-success">{{ $detail->Status }}</span>
                                                                </td>
                                                            @elseif($detail->Value_Status ==2)
                                                                <td><span
                                                                        class="badge badge-pill badge-danger">{{ $detail->Status }}</span>
                                                                </td>
                                                            @else
                                                                <td><span
                                                                        class="badge badge-pill badge-warning">{{ $detail->Status }}</span>
                                                                </td>
                                                            @endif
                                                            <td>{{ date('d-m-Y', strtotime($detail->invoices->invoice_Date)) }}</td>
                                                            <td>{{$detail->Payment_Date != null ? $detail->Payment_Date : '--' }}</td>

                                                        </tr>
                                                        @endforeach
                                                           
                                                    </tbody>
                                                </table>


                                            </div>
                                        </div>


                                        <div class="tab-pane" id="tab6">
                                            <!--المرفقات-->
                                            <div class="card card-statistics">
                                                <div class="table-responsive mt-15">
                                                    <table class="table center-aligned-table mb-0 table table-hover"
                                                        style="text-align:center">
                                                        <thead>
                                                            <tr class="text-dark">
                                                                <th scope="col">#</th>
                                                                <th scope="col">اسم الملف</th>
                                                                <th scope="col">قام بالاضافة</th>
                                                                <th scope="col">تاريخ الاضافة</th>
                                                                <th scope="col">العمليات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($attachments as $attachment)
                                                                <tr>
                                                                    <td>{{ $attachment->id }}</td>
                                                                    <td>{{ $attachment->file_name }}</td>
                                                                    <td>{{ $attachment->Created_by }}</td>
                                                                    <td>{{ date('d-m-Y', strtotime($attachment->created_at)) }}</td>
                                                                    <td colspan="2">

                                                                        <a class="btn btn-outline-success btn-sm"
                                                                            href="{{ url('invoices/View_file') }}/{{ $attachment->id }}/{{ $attachment->file_name }}"
                                                                            role="button"><i class="fas fa-eye"></i>&nbsp;
                                                                            عرض</a>

                                                                        <a class="btn btn-outline-info btn-sm"
                                                                            href="{{ url('invoices/download') }}/{{ $attachment->id }}/{{ $attachment->file_name }}"
                                                                            role="button"><i
                                                                                class="fas fa-download"></i>&nbsp;
                                                                            تحميل</a>

                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /div -->
        </div>

    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

    </script>

@endsection