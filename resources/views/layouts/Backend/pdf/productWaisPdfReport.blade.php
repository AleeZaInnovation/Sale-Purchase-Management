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
    <h3 style="color: black; padding-bottom: 0">
	  <strong>Product name:- {{ $product['name'] }} </strong>
	</h3>
	<table border="1" width="100%" style="text-align: center;">
		<thead>
			<tr>
               <th>Product Category</th>
               <th>Product Name</th>
               <th>Product Stock</th>
            </tr>
		</thead>
	    <tbody>
            <tr>
                <td>{{ $product['category']['name'] }}</td>
                <td>{{ $product->name }}</td>
                <td>
                {{ $product->quantity }}
                {{ $product['unit']['name'] }}
                </td>
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