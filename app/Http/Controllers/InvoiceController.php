<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceActionRequest;
use App\Http\Requests\InvoiceSortRequest;
use App\Http\Requests\InvoiceStoreRequest;
use App\Http\Requests\InvoiceUpdateRequest;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\SimpleExcel\SimpleExcelWriter;

class InvoiceController extends Controller
{
    /**
     * Display a listing of invoices.
     */
    public function index(InvoiceSortRequest $request): Response
    {
        // Check authorisation
        if ($request->user()->cannot('viewAny', Invoice::class)) {
            abort(403);
        }

        // Validate input
        $formFields = $request->validated();

        // Get logged in user and eager load their invoices
        $user = User::with('invoices.customer')->find(auth()->user()->id);

        [
            $invoices,
            $orderKey,
            $orderDir,
        ] = $user->getSortedInvoices($formFields, $this->paginate());

        return Inertia::render('Invoice/Index', [
            'invoices' => $invoices,
            'orderKey' => $orderKey,
            'orderDir' => $orderDir,
        ]);
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create(Request $request): Response
    {
        // Check authorisation
        if ($request->user()->cannot('create', Invoice::class)) {
            abort(403);
        }

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
        // Check authorisation
        if ($request->user()->cannot('create', Invoice::class)) {
            abort(403);
        }

        // Validate input
        $formFields = $request->validated();

        // Include current user
        $user = User::find(auth()->user()->id);
        $formFields['user_id'] = $user->id;

        // Get customer
        $customer = Customer::find($formFields['customer']);

        // Increment previous invoice number
        $previousInvoiceNumber = DB::table('invoices')
            ->where('customer_id', $customer->id)
            ->where('user_id', $user->id)
            ->max('invoice_number');
        $formFields['invoice_number'] = ++$previousInvoiceNumber ?? 1;

        // Calculate due date from customer payment terms
        $date = new Carbon($formFields['date']);
        $dueDate = Invoice::calculateDueDate($formFields['date'], $customer);
        $formFields['date'] = $date->toDateString();
        $formFields['due_date'] = $dueDate->toDateString();

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
    public function edit(Request $request, Invoice $invoice): Response
    {
        // Check authorisation
        if ($request->user()->cannot('update', $invoice)) {
            abort(403);
        }

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
        // Check authorisation
        if ($request->user()->cannot('update', $invoice)) {
            abort(403);
        }

        // Validate input
        $formFields = $request->validated();

        // Re-calculate due date from customer payment terms
        $date = new Carbon($formFields['date']);
        $dueDate = Invoice::calculateDueDate($formFields['date'], $invoice->customer);
        $formFields['date'] = $date->toDateString();
        $formFields['due_date'] = $dueDate->toDateString();

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
    public function destroy(Request $request, Invoice $invoice): RedirectResponse
    {
        // Check authorisation
        if ($request->user()->cannot('delete', $invoice)) {
            abort(403);
        }

        $invoice->delete();
        return redirect()->route('invoices.index')->with('message', 'Invoice deleted.');
    }

    /**
     * Display the specified invoice.
     */
    public function print(Request $request, Invoice $invoice): HttpResponse
    {
        // Check authorisation
        if ($request->user()->cannot('view', $invoice)) {
            abort(403);
        }

        $invoice->load(['user', 'invoiceItems', 'customer']);
        return $invoice->printPdf();
    }

    /**
     * Download csv of invoices.
     */
    public function export(Request $request)
    {
        // Check authorisation
        if ($request->user()->cannot('viewAny', Invoice::class)) {
            abort(403);
        }

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

    /**
     * Update invoices with specified action.
     */
    public function action(InvoiceActionRequest $request): RedirectResponse
    {
        // Check authorisation
        if ($request->user()->cannot('action', Invoice::class)) {
            abort(403);
        }

        // Validate input
        $formFields = $request->validated();

        // Include current user
        $user = User::find(auth()->user()->id);

        // Increment previous invoice number
        foreach ($formFields['invoices'] as $invoiceId) {
            $invoice = $user->invoices()->find($invoiceId);
            switch ($formFields['action']) {
                case 'paid':
                    $invoice->paid = true;
                    break;
                case 'outstanding':
                    $invoice->paid = false;
                    break;
            }
            $invoice->save();
        }

        return redirect()->route('invoices.index')->with('message', 'Invoices updated.');
    }
}
