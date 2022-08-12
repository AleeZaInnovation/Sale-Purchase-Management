@extends('layouts.Backend.master')
@push('css')
<link href="{{ asset('assets/Backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h4 class="m-0 font-weight-bold text-dark"> Purchase No: {{ $purchase->purchase_no }} ({{ date('d-m-Y', strtotime($purchase->date)) }}) </h4>
            </div>
            <div class="card-body">
              <form method="post" action="{{ route('purchase.approve.process', $purchase->id) }}">
                @csrf
              <!--- Customer Info start ---->
              <table width="100%" class="table" style="color: black;">
                <tbody>
                  <tr>
                    <td><strong>Supplier Information</strong></td>
                    <td><strong>Supplier Name: </strong>
                      {{ $purchase->supplierPayment->supplier->name }}
                    </td>
                    <td><strong>Supplier Mobile: </strong>
                      {{ $purchase->supplierPayment->supplier->mobile }}
                    </td>
                    <td><strong>Supplier Email: </strong>
                      {{ $purchase->supplierPayment->supplier->email }}
                    </td>
                    <td><strong>Supplier Adddress: </strong>
                      {{ $purchase->supplierPayment->supplier->address }}
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Description</strong></td>
                    <td colspan="3">{{ $purchase->description }}</td>
                  </tr>
                </tbody>
              </table>
              <!--- Customer Info End ---->
              <!---- Selling info Start -->
              <table class="table borderd" style="background: #e2e2e2;  color: black;" width="100%">
                <thead style="background:#cdced2;">
                 <tr class="text-center">
                  <th>SL NO.</th>
                  <th>Category Name</th>
                  <th>Product Name</th>
                  <th>Current Quantity</th>
                  <th>Quantity</th>
                  <th>Unit Price</th>
                  <th>Total Price</th>
                 </tr>
                </thead>
                <tbody>
                  @php 
                  $subTotal = '0';
                  @endphp
                  @foreach($purchase['purchaseDetails'] as $key => $purchases)

                  <input type="hidden" name="category_id[]" value="purchases->category_id">

                  <input type="hidden" name="product_id[]" value="purchases->product_id">

                  <input type="hidden" name="buying_qty[{{ $purchases->id }}]" value="purchases->buying_qty">
                  <tr class="text-center">

                    <td>{{ $key+1 }}</td>
                    <td>{{ $purchases->category->name }}</td>
                    <td>{{ $purchases->product->name }}</td>
                    <td>{{ $purchases->product->quantity }}</td>
                    <td>{{ $purchases->buying_qty }}</td>
                    <td>{{ $purchases->unit_price }}</td>
                    <td>{{ $purchases->buying_price }}</td>
                  </tr>
                  @php
                  $subTotal += $purchases->buying_price;
                  @endphp
                @endforeach
                <tr class="text-center">
                  <td colspan="6" class="text-right"><strong>Sub Total:</strong></td>
                  <td><strong>{{ $subTotal }}</strong></td>
                </tr>
                <tr class="text-center">
                  <td colspan="6" class="text-right"><strong>Discount:</strong></td>
                  <td><strong>{{ $purchase->supplierPayment->discount_amount }}</strong></td>
                </tr>
                <tr class="text-center">
                  <td colspan="6" class="text-right"><strong>Paid Amount:</strong></td>
                  <td><strong>{{ $purchase->supplierPayment->paid_amount }}</strong></td>
                </tr>
                <tr class="text-center">
                  <td colspan="6" class="text-right"><strong>Due Amount:</strong></td>
                  <td><strong>{{ $purchase->supplierPayment->due_amount }}</strong></td>
                </tr>
                <tr class="text-center">
                  <td colspan="6" class="text-right"><strong>Grant Total:</strong></td>
                  <td><strong>{{ $purchase->supplierPayment->total_amount }}</strong></td>
                </tr>
                </tbody>
              </table>
              <!---- Selling info End -->
              <input type="submit" name="submit" value="Purchase Approved" class="btn btn-primary">
              </form>
            </div>
          </div>
@endsection

@push('js')
<!-- Page level plugins -->
  <script src="{{ asset('assets/Backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/Backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

  <!-- Page level custom scripts -->
  <script src="{{ asset('assets/Backend/js/demo/datatables-demo.js') }}"></script>
@endpush
