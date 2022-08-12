<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\supplier;
use App\purchase;
use App\purchaseDetail;
use App\supplierPayment;
use App\supplierPaymentDetail;
use App\User;
use App\Company;
use DB;
use Auth;
use PDF;


class supplierController extends Controller
{
    //---- Supplier View ----//
    public function view(){
    	$suppliers = supplier::select('id','name','mobile','email','address')->get();
    	return view('layouts.Backend.supplier.supplierView', compact('suppliers'));
    }
    //---- Supplier Add ----//
    public function add(){
    	return view('layouts.Backend.supplier.supplierAdd');
    }
    //---- Supplier Store ----//
    public function store(Request $request){
        // validation
        $validation = $request->validate([
        	'name'    => 'required',
        	'mobile'  => 'required',
        	'email'   => 'required|email'
        ]);
        // Insert Data
        $supplierInsert = new supplier;
        $supplierInsert->name       = $request->name;
        $supplierInsert->mobile     = $request->mobile;
        $supplierInsert->email      = $request->email;
        $supplierInsert->address    = $request->address;
        $supplierInsert->created_by = Auth::user()->id;
        $supplierInsert->save();
      // Redirect 
      return redirect()->route('supplier.view')->with('success', 'Supplier Added Successfully');
    }
    //---- Supplier Edit ----//
    public function edit($id){
        $supplierEdit = supplier::find($id);
        return view('layouts.Backend.supplier.supplierEdit', compact('supplierEdit'));
    }
    //---- Supplier Update ----//
    public function update($id, Request $request){
        // validation
        $validation = $request->validate([
            'name'    => 'required',
            'mobile'  => 'required',
            'email'   => 'required|email'
        ]);
        // Update
        $supplierUpdate = supplier::find($id);
        $supplierUpdate->name       = $request->name;
        $supplierUpdate->mobile     = $request->mobile;
        $supplierUpdate->email      = $request->email;
        $supplierUpdate->address    = $request->address;
        $supplierUpdate->updated_by = Auth::user()->id;
        $supplierUpdate->save();
        // Redirect 
      return redirect()->route('supplier.view')->with('success', 'Supplier Updated Successfully');
    }
     //---- Supplier Delete ----//
    public function delete($id){
        // Delete
        $supplierDelete = supplier::find($id);
        $supplierDelete->delete();
        // Redirect 
      return redirect()->route('supplier.view')->with('error', 'Supplier Deleted Successfully');
    }

    public function supplierCredit(){
        //$suppliersCredit = supplierPayment::whereIn('paid_status', ['full_due','partical_paid'])->get();
        $suppliersCredit = supplierPayment::whereIn('paid_status', ['full_due', 'partical_paid'])->get();
        // dd($suppliersCredit->toArray());
        return view('layouts.Backend.supplier.supplierCredit',compact('suppliersCredit'));
    }
    //---- supplier Credit PDF ----//
    public function supplierCreditPdf(){
        $data['suppliersCredit'] = supplierPayment::whereIn('paid_status', ['full_due', 'partical_paid'])->get();
        $data['company'] = company::first();
        $pdf = PDF::loadView('layouts.Backend.pdf.supplierCredit', $data);
        //$pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }
    //---- supplier Credit Edit ----//
    public function supplierCreditEdit($purchase_id){
        $data['payment'] = supplierPayment::where('purchase_id', $purchase_id)->first();
        $data['invoice_details'] = purchaseDetail::where('purchase_id', $purchase_id)->get();
          //dd($data->toArray());
       return view('layouts.Backend.supplier.supplierCreditEdit', $data);
    }
    //---- supplier Credit Update ----//
    public function supplierCreditUpdate(Request $request, $purchase_id){
       //validation 
        $validation = $request->validate([
            'paid_status' => 'required',
            'date' => 'required'
        ]);
        // partials paid validation
        if($request->new_paid_amount < $request->paid_amount) {
            return redirect()->back()->with('error','Error! Please Paid Exact Amount');
        } else{
            $supplierPayment = supplierPayment::where('purchase_id', $purchase_id)->first();
            $supplierPaymentDetail = new supplierPaymentDetail();
            $supplierPayment->paid_status = $request->paid_status;
            if($request->paid_status == 'full_paid') {
                $supplierPayment->paid_amount = supplierPayment::where('purchase_id', $purchase_id)->first()->paid_amount + $request->new_paid_amount;
                $supplierPayment->due_amount = '0';
                $supplierPaymentDetail->current_paid_amount = $request->new_paid_amount;
            } elseif($request->paid_status == 'Partical_paid'){
                $supplierPayment->paid_amount = supplierPayment::where('purchase_id', $purchase_id)->first()->paid_amount + $request->paid_amount;
                $supplierPayment->due_amount = $request->new_paid_amount - $request->paid_amount;
                $supplierPaymentDetail->current_paid_amount = $request->paid_amount;
            }
            $supplierPayment->save();
            $supplierPaymentDetail->purchase_id = $purchase_id;
            $supplierPaymentDetail->date = date('Y-m-d', strtotime($request->date));
            $supplierPaymentDetail->updated_by = Auth::user()->id;
            $supplierPaymentDetail->save();
            // Redirect
             return redirect()->route('supplier.credit')->with('success', 'Supplier Credit Edit Successfully');
        }
    }
    //---- Indivisual supplier Credit Summery ----//
    public function supplierCreditSummery($purchase_id){
        $data['payment'] = supplierPayment::where('purchase_id', $purchase_id)->first();
        $data['invoice_details'] = purchaseDetail::where('purchase_id', $purchase_id)->get();
        $data['payment_details'] = supplierPaymentDetail::where('purchase_id', $purchase_id)->get();
        $data['company'] = company::first();
        $pdf = PDF::loadView('layouts.Backend.pdf.supplierCreditSummery', $data);
        //$pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }
    //---- Paid supplier List ----//
    public function supplierPaidList(){
        $suppliersCredit = supplierPayment::whereIn('paid_status', ['full_paid', 'partical_paid'])->get();
        //$suppliersCredit = payment::where('paid_status', '!=', 'full_due')->get();
        //dd($data->toArray());
        return view('layouts.Backend.supplier.supplierPaidList', compact('suppliersCredit'));
    }
   
    //---- Paid supplier List PDF ----//
    public function supplierPaidListPdf(){
        $data['payments'] = supplierPayment::where('paid_status', '!=', 'full_due')->get();
        $data['company'] = company::first();
        $pdf = PDF::loadView('layouts.Backend.pdf.supplierPaidPdf', $data);
        //$pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }
    //---- supplier Wais Report ---//
    public function supplierWaisReport(){
        $data['suppliers'] = supplier::all();
        return view('layouts.Backend.supplier.supplierWaisReport', $data);
    }
    //---- supplier Credit Wais PDF ----//
    public function supplierCreditWaisPdf(Request $request){
        $supplier_id = $request->supplier_id;
        $data['creditsupplier'] = supplierPayment::whereIn('paid_status',['full_due', 'partical_paid'])->where('supplier_id', $supplier_id)->get();
        $data['company'] = company::first();
        $pdf = PDF::loadView('layouts.Backend.pdf.singlesupplierCreditPdf', $data);
        //$pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }
    //---- supplier Paid wais PDF ----//
    public function supplierPaidWaisPdf(Request $request){
        $supplier_id = $request->supplier_id;
        $data['paidsupplier'] = supplierPayment::whereIn('paid_status',['full_paid', 'partical_paid'])->where('supplier_id', $supplier_id)->get();
        $data['company'] = company::first();
        $pdf = PDF::loadView('layouts.Backend.pdf.singleSupplierPaidPdf', $data);
        //$pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }
    
}
