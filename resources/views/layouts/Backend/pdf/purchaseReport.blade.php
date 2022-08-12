<!DOCTYPE html>
<html>
<head>
	<style type ="text/css" >
   .footer{ 
       position: fixed;         
       bottom: 100px; 
       width: 100%;
   }  
</style>
	<title>Invoice</title>
</head>
<body>
<h2 style="text-align:center; color: #4e73df; padding-bottom: 5px; margin-left: 20px;" class="text-primary"><strong>{{$company->name}}</strong></h2>
  <h5 style="text-align: center; color: black; padding-bottom: 0">
    <strong>Mobile:- {{$company->mobile}}</strong>
  </h5>
  <h5 style="text-align: center; color: black; padding-bottom: 0">
    <strong>{{$company->address}} -- {{$company->email}}</strong>
  </h5>
    <hr style="padding-bottom: 0px;">
    <h4 style="color: black; padding-bottom: 0">
	  <strong>Daily Invoice Report:-
	   ( {{ date('d-m-Y', strtotime($sdate)) }} - {{ date('d-m-Y', strtotime($edate)) }} ) 
	</strong>
	</h4>
<table border="1" width="100%" >
	<thead>
		<tr>
			<td>SL No</td>
			<td>Supplier Name</td>
			<td >Purchase No</td>
			<td >Purchase Date</td>
			<td>Description</td>
			<td> Amount</td>
		</tr>
	</thead>
	<tbody>
		@php
		$subTotal = '0';
		@endphp
		@foreach($purchases  as $key => $purchase )		
		<tr>
			,<td> {{$key + 1}}</td>
			<td>{{ $purchase->supplierPayment->supplier->name }}</td>
			<td style="text-align: center;">{{ $purchase->purchase_no}}</td>
			<td style="text-align: center;">{{ $purchase->date }}</td>
			<td>{{ $purchase->description }}</td>
			<td style="text-align: right;">{{ $purchase->supplierPayment->total_amount }}</td>			
		</tr>
		@php
		$subTotal += $purchase->supplierPayment->total_amount;
		@endphp
		@endforeach		
		<tr>
			<td style="text-align: right; color:green;" colspan="5">Sub Total:-</td>
			<td style="color:green; text-align: right;">{{ $subTotal }}</td>
		</tr>
	</tbody>
</table>
<div class="footer">
<hr>
<table width="100%">
	<br>
	<br>
	<tbody>
		<tr>
			<td style="text-align: left;">Shop Signature</td>
			<td style="text-align: right;">Owner Signature</td>
		</tr>
	</tbody>
</table>
@php 
$date = new DateTime('now', new DateTimezone('Asia/Dhaka'));
@endphp
<br>
<strong>
	Printing Time:- {{ $date->format('F j, Y, g:i a') }}
</strong>
</div>

</body>
</html>