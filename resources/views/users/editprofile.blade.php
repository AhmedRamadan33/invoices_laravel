@extends('layouts.master')

@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Pages</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Edit-Profile</span>
						</div>
					</div>
				
				</div>
				<!-- breadcrumb -->
				            {{-- Start message Validation Errors --}}

							@if ($errors->any())
							<div class="alert alert-danger ">
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
						{{-- End message Validation Errors --}}
@endsection
@section('content')
<form method="POST" action="{{route('profile.update')}}" enctype="multipart/form-data">
	@csrf
				<!-- row -->
				<div class="row row-sm">
					<!-- Col -->
					<div class="col-lg-4">
						
						<div class="card mg-b-20">
							<div class="card-body">
								<div class="pl-0">
									<div class="main-profile-overview">
										<div class="main-img-user upload">
											<img alt="" src="{{URL::asset('files/'.Auth::user()->image)}}" >
											<div class="round">
												<input name="profile_pic" type="file">
												<i class="fas fa-camera" style="color: #fff"></i>
											</div>
										</div>
										<div class="d-flex justify-content-between mg-b-20">
											<div>
												<h5 class="main-profile-name">{{Auth::user()->name}}</h5>
												<p class="main-profile-name-text">{{Auth::user()->roles_name}}</p>
											</div>
										</div>
										<h6>Bio</h6>
										<div class="main-profile-bio">
											{{Auth::user()->roles_name}}
										</div><!-- main-profile-bio -->
									
										<hr class="mg-y-30">
										<label class="main-content-label tx-13 mg-b-20">Social</label>
										<div class="main-profile-social-list">
											<div class="media">
												<div class="media-icon bg-primary-transparent text-primary">
													<i class="icon ion-logo-github"></i>
												</div>
												<div class="media-body">
													<span>Github</span> <a href="">{{Auth::user()->Github}}</a>
												</div>
											</div>
											<div class="media">
												<div class="media-icon bg-success-transparent text-success">
													<i class="icon ion-logo-twitter"></i>
												</div>
												<div class="media-body">
													<span>Twitter</span> <a href="">{{Auth::user()->Twitter}}</a>
												</div>
											</div>
											<div class="media">
												<div class="media-icon bg-info-transparent text-info">
													<i class="icon ion-logo-linkedin"></i>
												</div>
												<div class="media-body">
													<span>Linkedin</span> <a href="">{{Auth::user()->Linkedin}}</a>
												</div>
											</div>
											<div class="media">
												<div class="media-icon bg-danger-transparent text-danger">
													<i class="icon ion-md-link"></i>
												</div>
												<div class="media-body">
													<span>My Portfolio</span> <a href="">{{Auth::user()->Google}}</a>
												</div>
											</div>
										</div>									
									</div><!-- main-profile-overview -->
								</div>
							</div>
						</div>
						<div class="card mg-b-20">
							<div class="card-body">
								<div class="main-content-label tx-13 mg-b-25">
									Conatct
								</div>
								<div class="main-profile-contact-list">
									<div class="media">
										<div class="media-icon bg-primary-transparent text-primary">
											<i class="icon ion-md-phone-portrait"></i>
										</div>
										<div class="media-body">
											<span>Mobile</span>
											<div>
												{{Auth::user()->phone}}
											</div>
										</div>
									</div>
									<div class="media">
										<div class="media-icon bg-success-transparent text-success">
											<i class="icon ion-logo-slack"></i>
										</div>
										<div class="media-body">
											<span>Country</span>
											<div>
												{{Auth::user()->country}}
											</div>
										</div>
									</div>
									<div class="media">
										<div class="media-icon bg-info-transparent text-info">
											<i class="icon ion-md-locate"></i>
										</div>
										<div class="media-body">
											<span>Current Address</span>
											<div>
												{{Auth::user()->address}}
											</div>
										</div>
									</div>
								</div><!-- main-profile-contact-list -->
							</div>
						</div>
					</div>

					<!-- Col -->
					<div class="col-lg-8">
						<div class="card">
							<div class="card-body">
								<div class="mb-4 main-content-label">Personal Information</div>
								<form class="">
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">User Name</label>
											</div>
											<div class="col-md-9">
												<input type="text" name="name" class="form-control" placeholder="name" value="{{Auth::user()->name}}">
											</div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Roles</label>
											</div>
											<div class="col-md-9">
												<input disabled type="text" class="form-control"  placeholder="Roles" value="{{Auth::user()->roles_name}}">
											</div>
										</div>
									</div>
									<div class="mb-4 main-content-label">Contact Info</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Email</label>
											</div>
											<div class="col-md-9">
												<input type="text" disabled  class="form-control"  placeholder="Email" value="{{Auth::user()->email}}">
											</div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Phone</label>
											</div>
											<div class="col-md-9">
												<input type="text" name="phone" class="form-control"  placeholder="phone number" value="{{Auth::user()->phone}}">
											</div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Country</label>
											</div>
											<div class="col-md-9">
												<input type="text" name="country" class="form-control" placeholder="country" value="{{Auth::user()->country}}">
											</div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Address</label>
											</div>
											<div class="col-md-9">
												<textarea class="form-control" name="address" rows="2"  placeholder="Address">{{Auth::user()->address}}</textarea>
											</div>
										</div>
									</div>
									<div class="mb-4 main-content-label">Social Info</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Twitter</label>
											</div>
											<div class="col-md-9">
												<input type="text" name="Twitter"  class="form-control"  placeholder="twitter" value="{{Auth::user()->Twitter}}">
											</div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Facebook</label>
											</div>
											<div class="col-md-9">
												<input type="text" name="Facebook" class="form-control"  placeholder="facebook" value="{{Auth::user()->Facebook}}">
											</div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Google+</label>
											</div>
											<div class="col-md-9">
												<input type="text" name="Google" class="form-control"  placeholder="google" value="{{Auth::user()->Google}}">
											</div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Linked in</label>
											</div>
											<div class="col-md-9">
												<input type="text" name="Linkedin" class="form-control"  placeholder="linkedin" value="{{Auth::user()->Linkedin}}">
											</div>
										</div>
									</div>
									<div class="form-group ">
										<div class="row">
											<div class="col-md-3">
												<label class="form-label">Github</label>
											</div>
											<div class="col-md-9">
												<input type="text" name="Github" class="form-control" placeholder="github" value="{{Auth::user()->Github}}">
											</div>
										</div>
									</div>

							</div>
							<div class="card-footer text-left">
								<button type="submit" class="btn btn-primary waves-effect waves-light">Update Profile</button>
							</div>

						</div>
					</div>
					<!-- /Col -->
				</div>
				<!-- row closed -->
			</form>

			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')

@endsection