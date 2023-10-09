<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class InvoiceController extends Controller
{
    /**
     * Display a listing of invoices.
     */
    public function index(Request $request): Response
    {
        // Get logged in user and eager load their invoices
        $user = User::with('invoices.customer')->find(auth()->user()->id);
        return Inertia::render('Invoice/Index', [
            'invoices' => $user->invoices,
        ]);
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create(): Response
    {
        return Inertia::render('Invoice/Create', [
            'invoices' => auth()->user()->invoices,
        ]);
    }

    /**
     * Store a newly created invoice in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified invoice.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified invoice.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified invoice in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified invoice from storage.
     */
    public function destroy(Invoice $invoice): RedirectResponse
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('message', 'Invoice deleted.');
    }

    /**
     * Display the specified invoice.
     */
    public function print(Invoice $invoice): HttpResponse
    {
        $invoice->load(['user', 'invoiceItems', 'customer']);
        return $invoice->printPdf();
    }
}
