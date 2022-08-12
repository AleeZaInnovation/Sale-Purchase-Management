<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\invoice;
use App\invoiceDetail;
use App\purchase;
use App\purchaseDetail;
use App\product;
use App\category;
use App\supplier;
use App\customer;
use App\unit;
use App\payment;
use App\supplierPayment;
use App\supplierPaymentDetail;
use App\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
         

        // Earning Report========
        $date = date('Y-m-d');
        $todayInvoice = invoiceDetail::where('date', $date)->where('status', 1)->sum('selling_price');
        $todayInvoiceCount = invoice::where('status', 1)->whereDate('created_at', today())->count();
        $todayPurchase = purchaseDetail::where('date', $date)->where('status', 1)->sum('buying_price');
        $todayPurchaseCount = purchase::where('date', $date)->where('status', 1)->count();
        // Others===============
        $category = category::all()->count();
        $supplier = supplier::all()->count();
        $products = product::all()->count();
        $users    = User::all()->count();
        $customer = customer::all()->count();
        $unit     = unit::all()->count();
        $totalPurchase = purchase::all()->count();
        $totalInvoice = invoice::all()->count();
        $pending_invoice = invoice::where('status', 0)->get()->count();
        $due_amount = payment::sum('due_amount');

        return view('layouts.Backend.index', compact('todayInvoice', 'todayInvoiceCount', 'todayPurchase', 'todayPurchaseCount', 'category', 'supplier', 'products', 'users', 'customer', 'unit', 'totalPurchase', 'totalInvoice', 'pending_invoice', 'due_amount'));
    }
}
