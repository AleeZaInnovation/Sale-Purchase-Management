@extends('layouts.Backend.master')
@push('css')
<link href="{{ asset('public/assets/Backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
 <!-- Page Heading -->
          <a class="btn btn-success my-3" href="{{ route('purchase.add') }}"><i class="fa fa-plus-circle"></i>Add Purchase</a>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Purchase List</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>SL.</th>
                      <th>Supplier Name</th>
                      <th>Purchase No.</th>
                      <th>Date</th>
                      <th>Description</th>
                      <th>Total Price</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($prachases as $key => $prachase)
                     <tr>
                       <td>{{ $key+1 }}</td>
                       <td>{{ $prachase->supplierPayment->supplier->name }}</td>
                       <td>Purchase No #{{ $prachase->purchase_no }}</td>
                       <td>{{ date('m-d-Y', strtotime($prachase->date)) }}</td>
                       <td>{{ $prachase->description }}</td>
                       <td>{{ $prachase->supplierPayment->total_amount }}</td>
                       <td>
                         @if($prachase->status == '0')
                         <span class="btn btn-danger">Pending</span>
                         @elseif($prachase->status == '1')
                         <span class="btn btn-success">Approved</span>
                         @endif
                       </td>
                       <td>
                        @if($prachase->status == '0')
                        <a onclick="return confirm('are you suer to delete User')" title="Delete" class="btn btn-danger" href="{{ route('purchase.delete', $prachase->id) }}"><i class="fa fa-trash"></i></a>
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
