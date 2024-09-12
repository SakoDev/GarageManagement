<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Total number of invoices
        $totalInvoices = Invoice::count();

        // Total unpaid invoices
        $unpaidInvoices = Invoice::where('status', 'unpaid')->count();

        // Total balance due across all unpaid invoices
        $totalBalanceDue = Invoice::where('status', '!=', 'paid')->sum('balance_due');

        // Get random customers with balance due
        $customersWithBalance = Customer::whereHas('invoices', function ($query) {
            $query->where('balance_due', '>', 0);
        })->inRandomOrder()->limit(5)->get();

        // Get a list of unpaid invoices
        $unpaidInvoicesList = Invoice::with('customer')
            ->where('status', 'unpaid')
            ->orderBy('invoice_date', 'desc')
            ->limit(5)
            ->get();

        // Calculate total payments made this month
        $totalPaymentsThisMonth = Payment::whereMonth('payment_date', Carbon::now()->month)
            ->whereYear('payment_date', Carbon::now()->year)
            ->sum('amount');

        return view('dashboard.index', compact(
            'totalInvoices', 
            'unpaidInvoices', 
            'totalBalanceDue', 
            'customersWithBalance', 
            'unpaidInvoicesList', 
            'totalPaymentsThisMonth'
        ));
    }
}
