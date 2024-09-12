<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'required|string|max:15',
            'company_name' => 'nullable|string|max:255',
            'ice' => 'nullable|string|max:20',
            'patente' => 'nullable|string|max:20',
            'id_fiscale' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer added successfully!');
    }

    public function show($id)
    {
        $customer = Customer::with(['vehicles', 'invoices.payments'])->findOrFail($id);

        // Calculate total balance due from all invoices
        $totalBalanceDue = $customer->invoices->sum('balance_due');

        // Collect payment history from all invoices
        $paymentHistory = collect();
        foreach ($customer->invoices as $invoice) {
            foreach ($invoice->payments as $payment) {
                $paymentHistory->push($payment);
            }
        }

        return view('customers.show', compact('customer', 'totalBalanceDue', 'paymentHistory'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'required|string|max:15',
            'company_name' => 'required|string|max:255',
            'ice' => 'nullable|string|max:20',
            'patente' => 'nullable|string|max:20',
            'id_fiscale' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully!');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
