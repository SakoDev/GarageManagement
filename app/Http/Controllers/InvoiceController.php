<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('customer')->get();
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $customers = Customer::all();
        $vehicles = Vehicle::all();
        return view('invoices.create', compact(['customers', 'vehicles']));
    }

    public function store(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'invoice_date' => 'required|date',
            'vat_rate' => 'nullable|numeric|min:0',
            'item_description.*' => 'required|string|max:255',
            'quantity.*' => 'required|integer|min:1',
            'unit_amount.*' => 'required|numeric|min:0',
            'type.*' => 'required|string|in:Unit,Collection,Km,M,Litre,Piece',
        ]);

        // Generate a new invoice number
        $invoiceNumber = Invoice::generateInvoiceNumber();

        $invoice = Invoice::create([
            'invoice_id' => $invoiceNumber,
            'customer_id' => $request->customer_id,
            'vehicle_id' => $request->vehicle_id,
            'invoice_date' => $request->invoice_date,
            'vat_rate' => $request->vat_rate,
            'amount_paid' => 0, 
            'total_amount' => 0, 
            'balance_due' => 0, 
        ]);

        $totalAmount = 0;

        foreach ($request->item_description as $index => $description) {
            $quantity = $request->quantity[$index];
            $unitAmount = $request->unit_amount[$index];
            $itemTotal = $quantity * $unitAmount;
            $totalAmount += $itemTotal;

            // Create the invoice item
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'type' => $request->type[$index],
                'description' => $description,
                'quantity' => $quantity,
                'unit_amount' => $unitAmount,
            ]);
        }

        // Calculate VAT amount
        $vatAmount = ($totalAmount * $request->vat_rate) / 100;

        // Calculate total amount including VAT
        $totalWithVAT = $totalAmount + $vatAmount;

        // Update the invoice with total, VAT amount, and balance_due
        $invoice->update([
            'total_amount' => $totalWithVAT,
            'vat_amount' => $vatAmount,
            'balance_due' => $totalWithVAT, // Since no payments have been made yet
        ]);

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully!');
    }


    public function show(Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified invoice.
     */
    public function edit($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);
        $customers = Customer::all();
        $vehicles = Vehicle::all();
        return view('invoices.edit', compact('invoice', 'customers', 'vehicles'));
    }

    /**
     * Update the specified invoice in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the input fields
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'invoice_date' => 'required|date',
            'vat_rate' => 'nullable|numeric|min:0',
            'item_description.*' => 'required|string|max:255',
            'quantity.*' => 'required|integer|min:1',
            'unit_amount.*' => 'required|numeric|min:0',
            'type.*' => 'required|string|in:Unit,Collection,Km,M,Litre,Piece',
            'payment_amount' => 'nullable|numeric|min:0', // For partial payment
            'payment_method' => 'nullable|string', // Payment method field
        ]);

        // Find the invoice
        $invoice = Invoice::findOrFail($id);

        // Update the invoice record
        $invoice->update([
            'customer_id' => $request->customer_id,
            'vehicle_id' => $request->vehicle_id,
            'invoice_date' => $request->invoice_date,
            'vat_rate' => $request->vat_rate,
        ]);

        $totalAmount = 0;

        // Delete existing invoice items before updating with new data
        InvoiceItem::where('invoice_id', $invoice->id)->delete();

        // Loop through the updated invoice items
        foreach ($request->item_description as $index => $description) {
            $quantity = $request->quantity[$index];
            $unitAmount = $request->unit_amount[$index];
            $itemTotal = $quantity * $unitAmount;
            $totalAmount += $itemTotal;

            // Re-create the invoice item
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'type' => $request->type[$index],
                'description' => $description,
                'quantity' => $quantity,
                'unit_amount' => $unitAmount,
            ]);
        }

        // Calculate VAT amount
        $vatAmount = ($totalAmount * $request->vat_rate) / 100;

        // Calculate total amount including VAT
        $totalWithVAT = $totalAmount + $vatAmount;

        // Update the invoice with total and VAT amount
        $invoice->update([
            'total_amount' => $totalWithVAT,
            'vat_amount' => $vatAmount,
        ]);

        // Handle payment
        if ($request->payment_amount > 0 && $request->payment_method) {
            Payment::create([
                'invoice_id' => $invoice->id,
                'amount' => $request->payment_amount,
                'payment_date' => now(),
                'payment_method' => $request->payment_method,
            ]);

            // Update the invoice amount paid
            $invoice->amount_paid += $request->payment_amount;
        }

        // Calculate balance due
        $balanceDue = $totalWithVAT - $invoice->amount_paid;

        // Update the invoice balance_due and status
        $invoice->update([
            'balance_due' => $balanceDue,
            'status' => $balanceDue <= 0 ? 'paid' : ($invoice->amount_paid > 0 ? 'partially_paid' : 'unpaid'),
        ]);

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully!');
    }


    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }

    public function getVehicles($customerId)
    {
        // Fetch vehicles associated with the customer
        $vehicles = Vehicle::where('customer_id', $customerId)->get();

        // Return the vehicles as a JSON response
        return response()->json($vehicles);
    }
    public function print($id)
    {
        $invoice = Invoice::findOrFail($id);
        $user = User::where('id', 1)->first();

        return view('invoices.print', compact('invoice', 'user'));
    }
}
