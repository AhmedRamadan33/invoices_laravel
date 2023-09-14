@extends('layouts.master')
@section('title')
لوحه التحكم - برنامج الفواتير
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm mt-3">
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-primary-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">اجمالى الفواتير</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">
												{{ number_format(App\Models\Invoices::sum('Total'))}}
											</h4>
											<p class="mb-0 tx-12 text-white op-7">{{App\Models\Invoices::count()}}</p>
										</div>
										<span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-up text-white"></i>
											<span class="text-white op-7">100%</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-danger-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">الفواتير الغير مدفوعه</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">
												{{ number_format(App\Models\Invoices::where('Value_Status','2')->sum('Total'))}}

											</h4>
											<p class="mb-0 tx-12 text-white op-7">{{App\Models\Invoices::where('Value_Status','2')->count()}}</p>
										</div>
										<span class="float-right my-auto mr-auto">
											@if ($unPaidPercent >= 50)
											<i class="fas fa-arrow-circle-up text-white"></i>
											@else
											<i class="fas fa-arrow-circle-down text-white"></i>
											@endif
											<span class="text-white op-7">{{$unPaidPercent}}%</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-success-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">الفواتير المدفوعه</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">
												{{ number_format(App\Models\Invoices::where('Value_Status','1')->sum('Total'))}}

											</h4>
											<p class="mb-0 tx-12 text-white op-7">{{App\Models\Invoices::where('Value_Status','1')->count()}}</p>
										</div>
										<span class="float-right my-auto mr-auto">
											@if ($paidPercent >= 50)
											<i class="fas fa-arrow-circle-up text-white"></i>
											@else
											<i class="fas fa-arrow-circle-down text-white"></i>
											@endif
											<span class="text-white op-7">{{$paidPercent}}%</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-warning-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">الفواتير المدفوعه جزئيا</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">
												{{ number_format(App\Models\Invoices::where('Value_Status','3')->sum('Total'))}}

											</h4>
											<p class="mb-0 tx-12 text-white op-7">{{App\Models\Invoices::where('Value_Status','3')->count()}}</p>
										</div>
										<span class="float-right my-auto mr-auto">
											@if ($partialPercent >= 50)
											<i class="fas fa-arrow-circle-up text-white"></i>
											@else
											<i class="fas fa-arrow-circle-down text-white"></i>
											@endif
											<span class="text-white op-7">{{$partialPercent}}%</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
						</div>
					</div>
				</div>
				<!-- row closed -->

				<!-- row opened -->
				<div class="row row-sm">
					<div class="col-md-12 col-lg-12 col-xl-7">
						<div class="card">
							<div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mb-0">نسبة احصائية الفواتير</h4>
								</div>
							</div>
							<div class="card-body">
								{!! $chartjs->render() !!}

							</div>
						</div>
					</div>
					<div class="col-lg-12 col-xl-5">
						<div class="card card-dashboard-map-one">
							<label class="main-content-label">نسبة احصائية الفواتير</label>
							<div class="">
								{!! $chartjs_2->render() !!}
							</div>
						</div>
					</div>
				</div>
				<!-- row closed -->

		</div>
		<!-- Container closed -->
@endsection
