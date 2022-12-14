@extends('layouts.Backend.master')
@push('css')
<link href="{{ asset('public/assets/Backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
 <!-- Page Heading -->
          <a class="btn btn-success my-3" href="{{ route('invoice.add') }}"><i class="fa fa-plus-circle"></i>Add Invoice</a>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Invoice List</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>SL.</th>
                      <th>Customer Name</th>
                      <th>Invoice No.</th>
                      <th>Date</th> 
                      <th>Description</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                   @foreach($invoices as $key => $invoice)
                     <tr>
                       <td>{{ $key+1 }}</td>
                       <td>
                        {{ $invoice['payment']['customer']['name'] }}
                        ( {{ $invoice['payment']['customer']['mobile'] }} )
                       </td>
                       <td> Invoice No #{{ $invoice->invoice_no }}</td>
                       <td>{{ date('d-m-Y', strtotime($invoice->date)) }}</td>
                       <td>{{ $invoice->description }}</td>
                       <td>{{ $invoice->payment->total_amount }}</td>
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
