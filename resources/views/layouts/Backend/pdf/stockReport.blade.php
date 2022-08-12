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
	  <strong>All Product stock List</strong>
	</h3>
	<table border="1" width="100%" style="text-align: center;">
		<thead>
			<tr>
               <th>SL.</th>
               <th>Supplier Name</th>
               <th>Product Category</th>
               <th>Product Name</th>
               <th>In (Stock)</th>
               <th >Pruchase Price</th>
               <th>Out (Stock)</th>
               <th>Current (Stock)</th>
            </tr>
		</thead>
	    <tbody>
            @foreach($stocks as $key => $stock)
            @php 
            $price = App\purchaseDetail::where('category_id', $stock->category_id)->where('product_id',$stock->id)->where('status', '1')->sum('buying_price');
            $purchase_stock = App\purchaseDetail::where('category_id', $stock->category_id)->where('product_id',$stock->id)->where('status', '1')->sum('buying_qty');
            $selling_stock  = App\invoiceDetail::where('category_id',$stock->category_id)->where('product_id', $stock->id)->where('status', '1')->sum('selling_qty');
            @endphp
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $stock['supplier']['name'] }}</td>
                <td>{{ $stock->category->name }}</td>
                <td>{{ $stock->name }}</td>
                <td>
                	{{ $purchase_stock }}
                	{{ $stock['unit']['name'] }}
                </td>
                <td style="text-align: right" >
                        {{ $price }}
                       Tk
                </td>
                <td>
                	{{ $selling_stock }}
                	{{ $stock['unit']['name'] }}
                </td>
                <td>
                {{ $stock->quantity }}
                {{ $stock['unit']['name'] }}
                </td>
            </tr>
            @endforeach
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