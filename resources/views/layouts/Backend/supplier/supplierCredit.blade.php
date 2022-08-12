@extends('layouts.Backend.master')
@push('css')
<link href="{{ asset('public/assets/Backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
 <!-- Page Heading -->
          <a target="_blank" class="btn btn-primary my-3" href="{{ route('supplier.credit.pdf') }}"><i class="fa fa-download"></i>Download PDF</a>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Supplier Credit List</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>SL.</th>
                      <th>Supplier Info</th>
                                          
                      <th>Credit Amount</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @php
                    $subTotal = '0';
                    @endphp
                    @foreach($suppliersCredit as $key => $payment)
                    <tr>
                      <td>{{ $key+1 }}</td>
                      <td>
                        {{ $payment->supplier->name }} -
                        {{ $payment->supplier->mobile }}
                      </td>
                      
                      
                      
                      <td>{{ $payment->due_amount }} TK.</td>
                      <td>
                        <a title="Edit" class="btn btn-info" href="{{ route('supplier.credit.edit', $payment->purchase_id) }}"><i class="fa fa-edit"></i></a>
                        <a target="_blank" title="Details" class="btn btn-success" href="{{ route('supplier.credit.summery', $payment->purchase_id) }}"><i class="fa fa-eye"></i></a>
                      </td>
                    </tr>
                    @php 
                    $subTotal += $payment->due_amount;
                    @endphp
                  @endforeach
                  </tbody>
                </table>
                <h3 style="text-align: center; color: green;"><strong>All Supplier Credit Amount:- <span style="color: red;">{{ $subTotal }} TK.<span></strong></h3>
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
