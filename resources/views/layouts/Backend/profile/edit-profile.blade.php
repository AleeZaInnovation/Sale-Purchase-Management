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
            <h1 class="m-0">Manage Profile</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
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
                <h3> Edit Profile
                <a class="btn btn-success my-3 float-sm-right" href="{{route('profile.view')}}"><i class="fa fa-list"></i> Your Profile </a>
               </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <form method="post" action="{{ route('profile.update') }}" id="myForm" enctype="multipart/form-data">
                  @csrf
                  <div class="form-row">
	                  <div class="form-group col-md-6">
	                        <label>Name</label>
	                        <input type="text" name="name" class="form-control" value="{{ $edits->name }}">
	                        <font style="color: red;">{{($errors->has('name'))?($errors->first('name')):''}}</font>
	                  </div>
	                  <div class="form-group col-md-6">
	                        <label for="email">Email</label>
	                        <input type="email" name="email" id="email" class="form-control" value="{{ $edits->email }}">

	                        <font style="color: red;">
	                          {{($errors->has('email'))?($errors->first('email')):''}}</font>

	                  </div>
	                   <div class="form-group col-md-6">
	                        <label>Number</label>
	                        <input type="mobile" name="mobile" class="form-control @error('mobile') Invalid @enderror" value="{{ $edits->mobile }}">
	                        @error('mobile ')
	                        <strong class="alert alert-danger">{{ $message }}</strong>
	                        @enderror
	                  </div>
	                  
	                  <div class="form-group col-md-6">
	                        <label>Designation</label>
	                        <input type="designation" name="designation" class="form-control @error('designation') Invalid @enderror" value="{{ $edits->designation }}">
	                        @error('designation ')
	                        <strong class="alert alert-danger">{{ $message }}</strong>
	                        @enderror
	                  </div> 

	                  <div class="form-group col-md-6">
	                        <label>Address</label>
	                        <input type="text" name="address" class="form-control @error('address') Invalid @enderror" value="{{ $edits->address }}">
	                        @error('address ')
	                        <strong class="alert alert-danger">{{ $message }}</strong>
	                        @enderror
	                  </div>
	                

	                  <div class="form-group col-md-6">
	                        <label>Gender</label>
	                        <input type="text" name="gender" class="form-control @error('gender') Invalid @enderror" value="{{ $edits->gender }}">
	                        @error('gender ')
	                        <strong class="alert alert-danger">{{ $message }}</strong>
	                        @enderror
	                  </div>
	                  <div class="form-group col-md-6">
	                        <label for="image">Image</label>
	                        <input type="file" name="image" class="form-control" id="image">
	                  </div>
	                  <div class="form-group col-md-6">
	                        <img id="showImage" src="{{(!empty($edits->image))?url('public/assets/backend/images/'.$edits->image):url('public/assets/backend/no_image.jpg')}}" style="width: 150px; height: 160px; border:1px; solid:#000;">
	                  </div>

                  </div>

                  <div class="form-group col-md-12">
                        <input type="submit" value="Update" class="form-control btn btn-primary btn-block">
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
          usertype: {
            required: true,
          },
          email: {
            required: true,
            email: true,
          },
          password: {
            required: true,
            minlength: 5
          },
        },
        messages: {
          usertype: {
            required: "Please select usertype"
          },
          email: {
            required: "Please enter a email address",
            email: "Please enter a vaild email address"
          },
          password: {
            required: "Please provide a password",
            minlength: "Your password must be at least 5 characters long"
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
