@extends('layouts.Backend.master')
@push('css')
<link href="{{ asset('assets/Backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Manage Password</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Password</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-md-12">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3> Edit Password
               </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <form method="post" action="{{ route('profile.password.update') }}" id="myForm">
                  @csrf
                  <div class="row">                
                        <!---- From Two Colum Start ---->
					<div class="col-lg-12">
						<div class="form-group">
							<label for="password">Current Password</label>
							<input type="password" name="current_password" id="current_password" class="form-control @error('current_password') Invalid @enderror">
							@error('current_password')
							<strong class="alert alert-danger">{{ $message }}
							</strong>
							@enderror
						</div> 
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="password">New Password</label>
							<input type="password" name="password" id="password" class="form-control @error('password') Invalid @enderror">
							@error('password')
							<strong class="alert alert-danger">{{ $message }}
							</strong>
							@enderror
						</div> 
					</div>
					<!---- From Two Colum Start ---->

					<!---- From Two Colum Start ---->
					<div class="col-lg-6">
						<div class="form-group">
							<label for="password">Again New Password</label>
							<input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') Invalid @enderror">
							@error('password_confirmation')
							<strong class="alert alert-danger">{{ $message }}
							</strong>
							@enderror
						</div> 
					</div>
					<!---- From Two Colum Start ---->
					</div><!--End row -->
					<!-- Submit Button start -->
					<div class="form-group">
					<input type="submit" name="submit" value="Change" class="form-control btn btn-primary btn-block">
					</div>
            </form>

                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
    $(document).ready(function () {
      $('#myForm').validate({
        rules: {
          current_password: {
            required: true,
          },
          password: {
            required: true,
            minlength: 5
          },
          password_confirmation: {
            required: true,
            equalTo: '#password'
          },
        },
        messages: {
          current_password: {
            required: "Please provide current password",
          },
          password: {
            required: "Please provide a new password",
            minlength: "Your password must be at least 5 characters long"
          },

          password_confirmation: {
            required: "Please provide confirm new password",
            equalTo: "Confirm new password does not match"
          },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
    });
  </script>
@endsection

@push('js')
<!-- Page level plugins -->
  <script src="{{ asset('assets/Backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/Backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

  <!-- Page level custom scripts -->
  <script src="{{ asset('assets/Backend/js/demo/datatables-demo.js') }}"></script>
@endpush
