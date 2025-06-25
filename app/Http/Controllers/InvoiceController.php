<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceStoreRequest;
use App\Http\Requests\InvoiceUpdateRequest;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\SimpleExcel\SimpleExcelWriter;

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
    public function create(Request $request): Response
    {
        // Get logged in user and eager load their customers
        $user = User::with('customers')->find(auth()->user()->id);
        // Get all active customers
        $customers = $user->customers()->where('status', 1)->get();
        return Inertia::render('Invoice/Create', [
            'customers' => $customers,
            'selected' => $user->customers()->find($request->customer) // optionally selected customer
        ]);
    }

    /**
     * Store a newly created invoice in storage.
     */
    public function store(InvoiceStoreRequest $request): RedirectResponse
    {
        // Validate input
        $formFields = $request->validated();

        // Include current user
        $user = User::find(auth()->user()->id);
        $formFields['user_id'] = $user->id;

        // Increment previous invoice number
        $previousInvoiceNumber = $user->invoices()->latest('invoice_number')?->value('invoice_number');
        $formFields['invoice_number'] = ++$previousInvoiceNumber ?? 1;

        // Get customer
        $customer = Customer::find($formFields['customer']);

        // Calculate due date from customer payment terms
        $date = Carbon::now();
        $due_date = Carbon::now()->addDays($customer->payment_terms);
        $formFields['date'] = $date->toDateString();
        $formFields['due_date'] = $due_date->toDateString();

        // Create invoice for the selected customer
        $invoice = $customer->invoices()->create($formFields);
        // Create all invoice items for the invoice
        $invoice->invoiceItems()->createMany($formFields['invoiceItems']);

        return redirect()->route('invoices.index')->with('message', 'Invoice created.');
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
    public function edit(Invoice $invoice): Response
    {
        // Eager load relationships
        $invoice->load(['invoiceItems', 'customer']);
        // Get logged in user and eager load their customers
        $user = User::with('customers')->find(auth()->user()->id);
        // Get all active customers
        $customers = $user->customers()->where('status', 1)->get();
        return Inertia::render('Invoice/Edit', [
            'customers' => $customers,
            'invoice' => $invoice,
        ]);
    }

    /**
     * Update the specified invoice in storage.
     */
    public function update(InvoiceUpdateRequest $request, Invoice $invoice): RedirectResponse
    {
        // Validate input
        $formFields = $request->validated();

        // Update basic invoice details
        $invoice->update($formFields);
        // Update all invoice items for the invoice
        $invoice->invoiceItems()->delete();
        $invoice->invoiceItems()->createMany($formFields['invoiceItems']);

        return redirect()->route('invoices.index')->with('message', 'Invoice updated.');
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

    /**
     * Download csv of invoices.
     */
    public function export()
    {
        // Get logged in user
        $user = User::with([
            'invoices' => ['invoiceItems', 'customer'],
        ])->find(auth()->user()->id);

        // Create CSV of invoices and stream to browser
        $csv = SimpleExcelWriter::streamDownload('invoices.csv');
        foreach ($user->invoices as $invoice) {
            foreach ($invoice->invoiceItems as $invoiceItem) {
                $csv->addRow([
                    ...$invoice->attributesToArray(),
                    'customer' => $invoice->customer->name,
                    'description' => $invoiceItem->description,
                    'quantity' => $invoiceItem->quantity,
                    'unit_price' => $invoiceItem->unit_price,
                ]);
            }
        }

        return $csv->toBrowser();
    }
}
