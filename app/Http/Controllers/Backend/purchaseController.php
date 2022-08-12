<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\product;
use App\supplier;
use App\unit;
use App\category;
use App\purchase;
use App\purchaseDetail;
use App\supplierPayment;
use App\supplierPaymentDetail;
use App\Company;
use PDF;
use DB;
use Auth;


class purchaseController extends Controller
{
    //---- Purchase View ----//
    public function view(){
        $prachases = purchase::orderBy('date','desc')->orderBy('id','desc')->get();
    	return view('layouts.Backend.purchase.purchaseView', compact('prachases'));
    }
    //---- Purchase Add ----//
    public function add(){
    	$data['suppliers']  = supplier::get();
        $purchase_no = purchase::orderBy('id','desc')->first();
        $data['date'] = date('Y-m-d');
        if($purchase_no == null){
            $firstPurchase = '0';
            $data['purchaseData']  =  $firstPurchase+1;
        } else{
            $purchaseCheck = purchase::orderBy('id','desc')->first()->purchase_no;
            $data['purchaseData'] = $purchaseCheck+1;
        }
        $data['units']      = unit::select('id','name')->get();
        $data['categories'] = category::select('id','name')->get();
    	return view('layouts.Backend.purchase.purchaseAdd',$data);
    }
    // Purchase Store //
    public function store(Request $request){
        if($request->category_id == null) {
           return redirect()->back()->with('error', 'Sorry! You do not select any product');
        } else{
            if($request->estimated_amount < $request->paid_amount) {
                return redirect()->back()->with('error', 'Sorry! Your Have to pay wright Amount');
            } else{
              // Multipale Data Insert start //
                $purchase = new purchase();
                $purchase->purchase_no  = $request->purchase_no;
                $purchase->date        = date('Y-m-d', strtotime($request->date));
                $purchase->description = $request->description;
                $purchase->status      = '0';
                $purchase->created_by  = Auth::user()->id;
                DB::transaction(function() use($request,$purchase) {
                   if($purchase->save()) {
                    // Invoice Details Insert Start //
                    $category_id = count($request->category_id);
                    for ($i=0; $i < $category_id; $i++) { 
                        $purchaseDetail = new purchaseDetail();
                        $purchaseDetail->date          = date('Y-m-d', strtotime($request->date));
                        $purchaseDetail->purchase_id    = $purchase->id;
                        $purchaseDetail->category_id   = $request->category_id[$i];
                        $purchaseDetail->product_id    = $request->product_id[$i];
                        $purchaseDetail->buying_qty   = $request->buying_qty[$i];
                        $purchaseDetail->unit_price    = $request->unit_price[$i];
                        $purchaseDetail->buying_price = $request->buying_price[$i];
                        $purchaseDetail->status        = '0';
                        $purchaseDetail->save();
                    }
                    // Invoice Details Insert End //
                    // supplier Data Insert Start //
                    if($request->supplier == '0') {
                        $supplier = new supplier();
                        $supplier->name    = $request->name;
                        $supplier->mobile  = $request->mobile;
                        $supplier->email   = $request->email;
                        $supplier->address = $request->address;
                        $supplier->save();
                        $supplier_id = $supplier->id;
                    } else{
                        $supplier_id = $request->supplier;
                    }
                    
                    // Customer Data Insert End //
                    // Payment Data Insert Start //
                    $supplierPayment  = new supplierPayment();
                     $supplierPaymentDetail = new supplierPaymentDetail();
                     $supplierPayment->purchase_id      = $purchase->id;
                     $supplierPayment->supplier_id     = $supplier_id;
                     $supplierPayment->paid_status     = $request->paid_status;
                     $supplierPayment->total_amount    = $request->estimated_amount;
                     if($request->paid_status == 'full_paid'){
                        $supplierPayment->paid_amount = $request->estimated_amount;
                        $supplierPayment->due_amount  = '0';
                        $supplierPaymentDetail->current_paid_amount = $request->estimated_amount;
                     } elseif($request->paid_status == 'full_due'){
                        $supplierPayment->paid_amount = '0';
                        $supplierPayment->due_amount  = $request->estimated_amount;
                        $supplierPaymentDetail->current_paid_amount = '0';
                     } elseif($request->paid_status == 'Partical_paid'){
                        $supplierPayment->paid_amount = $request->paid_amount;
                        $supplierPayment->due_amount  = $request->estimated_amount - $request->paid_amount;
                        $supplierPaymentDetail->current_paid_amount = $request->paid_amount;
                     }
                     $supplierPayment->save();
                     $supplierPaymentDetail->purchase_id = $purchase->id;
                     $supplierPaymentDetail->date       = date('Y-m-d', strtotime($request->date));
                     $supplierPaymentDetail->save();

                 }
                    // Payment Data Insert End //
                });
            }

            }

              // Multipale Data Insert End //
            // Redirect 
            return redirect()->route('purchase.view')->with('success', 'Purchase Added Successfully');
        }

     // Purchase Delte //
        public function delete($id){
            $purchaseDelete = purchase::find($id);
            $purchaseDelete->delete();
            // Redirect 
            return redirect()->route('purchase.view')->with('error', 'Purchase Deleted Successfully');
        }
    // Purchase Pending List //
      public function pendingList(){
         $prachases = purchase::orderBy('date','desc')->orderBy('id','desc')->where('status','0')->get();
        return view('layouts.Backend.purchase.purchasePendingList', compact('prachases'));
      }
    // Purchase Approved //
    public function approve($id){
        $data['purchase'] = purchase::with('purchaseDetails')->find($id);
        return view('layouts.Backend.purchase.purchaseApproved', $data);
        // Purchase Approved Processess //
      }
    public function approveprocesses(Request $request, $id){
        
        
        $purchase  = purchase::find($id);
        $purchase->status = '1';
        $purchase->updated_by = Auth::user()->id;
        DB::transaction(function() use($request,$purchase,$id) {
           foreach($request->buying_qty as $key => $val){
              $purchaseDetail = purchaseDetail::where('id', $key)->first();
              $purchaseDetail->status = '1';
              $purchaseDetail->save();
              $product = product::where('id', $purchaseDetail->product_id)->first();
              $product->quantity = ((float)($purchaseDetail->buying_qty)) + ((float)($product->quantity));
              $product->save(); 
           }
           $purchase->save();
        });
        // Redirect 
        return redirect()->route('purchase.pending.list')->with('success', 'Purchase approved successfullly');
    }
      public function approveprocessess($id){
        $purchase = purchase::find($id);
        $product  = product::where('id', $purchase->product_id)->first();
        $buyingQty = ((float)($purchase->buying_qty)) + ((float)($product->quantity));
        $product->quantity = $buyingQty;
        if($product->save()){
            DB::table('purchases')
                ->where('id', $id)
                ->update(['status' => 1]);
        }
        // Redirect 
        return redirect()->route('purchase.pending.list')->with('success', 'Purchase Approved Successfully');
      }
      // Purchase Report //
      public function purchaseReport(){
         return view('layouts.Backend.purchase.purchaseReport');
      }
      // purchase Report PDF //
      public function purchaseReportpdf(Request $request){
         // validation 
        $validation =  $request->validate([
            'start_date' => 'required',
            'end_date'   => 'required'
        ]);
        // Purchase report
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date   = date('Y-m-d', strtotime($request->end_date));
        $data['purchases'] = purchase::whereBetween('date',[$start_date,$end_date])->where('status', '1')->get();
        $data['sdate'] = date('Y-m-d', strtotime($request->start_date));
        $data['edate']   = date('Y-m-d', strtotime($request->end_date));
        $data['company'] = company::first();
        $pdf = PDF::loadView('layouts.Backend.pdf.purchaseReport', $data);
        //$pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
      }
}
