@extends('layouts.Backend.master')
@push('css')
<link href="{{ asset('public/assets/Backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
 <!-- Page Heading -->
          <a class="btn btn-success my-3" href="{{ route('customer.add') }}"><i class="fa fa-plus-circle"></i>Add Customer</a>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Customers List</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>SL.</th>
                      <th>Customer Name</th>
                      <th>Mobile</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($customers as $key => $customer)
                    <tr>
                      <td>{{ $key+1 }}</td>
                      <td>{{ $customer->name }}</td>
                      <td>{{ $customer->mobile }}</td>
                      <td>{{ $customer->email }}</td>
                      <td>{{ $customer->address }}</td>
                      <td>

                      	<a title="Edit" class="btn btn-success" href="{{ route('customer.edit', $customer->id) }}"><i class="fa fa-edit"></i></a>
                        @if(Auth::User()->userRole=='Admin')
                      	<a onclick="return confirm('are you suer to delete User')" title="Delete" class="btn btn-danger" href="{{ route('customer.delete', $customer->id) }}"><i class="fa fa-trash"></i></a>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
@endsection

@push('js')
<!-- Page level plugins -->
  <script src="{{ asset('public/assets/Backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('public/assets/Backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

  <!-- Page level custom scripts -->
  <script src="{{ asset('public/assets/Backend/js/demo/datatables-demo.js') }}"></script>
@endpush
