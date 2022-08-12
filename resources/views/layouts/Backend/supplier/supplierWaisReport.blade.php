@extends('layouts.Backend.master')
@push('ajax')
<script type="text/javascript">
  $(document).ready(function(){
     $(document).on('change', '.serch_value', function(){
        var value = $(this).val();
        // credit supplier
        if(value == 'credit_supplier') {
          $('#credit_supplier').show();
        } else{
          $('#credit_supplier').hide();
        } 
       // paid supplier
       if(value == 'paid_supplier'){
        $('#paid_supplier').show();
       } else{
        $('#paid_supplier').hide();
       }
     });
  });
</script>
@endpush
@section('content')
<div class="row">
    <div class="col-lg-12">
       <div class="card">
            <div class="card-body">
                  <h4 class="py-2 mb-4 text-primary text-center">Search supplier Credit Or Paid Wais Report!
                  </h4>
                  <!--- Radio Button --->
                  <div class="row">
                    <div class="col-lg-8 offset-lg-4">
                      <label>
                        <strong>Credit Supplier Report</strong>
                      </label>
                      <input type="radio" name="supplier_wais_report" value="credit_supplier" class="serch_value">
                      &nbsp; &nbsp;

                      <label>
                        <strong>Paid supplier Report</strong>
                      </label>
                      <input type="radio" name="supplier_wais_report" value="paid_supplier" class="serch_value">
                    </div>
                  </div>
              <!---- Credit supplier wais Report start ---->
                <div id="credit_supplier" style="margin-top: 25px; display: none;">
                  <form method="GET" action="{{ route('supplier.credit.wais.pdf') }}" target="_blank">
                    <div class="form-row">
                      <div class="col-lg-7 offset-lg-2">
                        <div class="form-group">
                            <label>Credit supplier</label>
                            <select name="supplier_id" class="form-control">
                              <option value="">
                              *Select Credit supplier*
                              </option>
                              @foreach($suppliers as $supplier)
                              <option value="{{ $supplier->id }}">
                                {{ $supplier->name }} :-
                                {{ $supplier->mobile }}
                              </option>
                              @endforeach
                           </select>
                             @error('supplier_id')
                             <strong class="alert alert-danger">{{ $message }}
                             </strong>
                             @enderror
                        </div> 
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <input style="padding-top: 10px;" type="submit" name="submit" class="btn btn-primary mt-4" value="Search">
                        </div> 
                      </div>
                    </div>
                  </form>
                </div>
              <!---- Credit supplier wais Report End ---->

              <!---- paid supplier report start ---->
               <div id="paid_supplier" style="margin-top: 25px; display: none;">
                  <form method="GET" action="{{ route('supplier.paid.wais.pdf') }}" target="_blank">
                    <div class="form-row">
                      <div class="col-lg-7 offset-lg-2">
                        <div class="form-group">
                            <label>Paid supplier</label>
                            <select name="supplier_id" class="form-control" id="supplier_id">
                              <option value="">
                              *Select Paid supplier*
                              </option>
                              @foreach($suppliers as $supplier)
                              <option value="{{ $supplier->id }}">
                                {{ $supplier->name }} :-
                                {{ $supplier->mobile }}
                              </option>
                              @endforeach
                           </select>
                             @error('supplier_id')
                             <strong class="alert alert-danger">{{ $message }}
                             </strong>
                             @enderror
                        </div> 
                      </div>

                      <div class="col-lg-3">
                        <div class="form-group">
                          <input style="padding-top: 10px;" type="submit" name="submit" class="btn btn-primary mt-4" value="Search">
                        </div> 
                      </div>
                    </div>
                  </form>
                </div>
              <!---- paid supplier wais report end   ---->
            </div><!-- card body -->
       </div>        
    </div>
</div>
@endsection
