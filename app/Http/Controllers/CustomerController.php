<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\SimpleExcel\SimpleExcelWriter;

class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     */
    public function index(Request $request): Response
    {
        // Check authorisation
        if ($request->user()->cannot('viewAny', Customer::class)) {
            abort(403);
        }

        // Get logged in user
        $user = User::with('customers.invoices')->find(auth()->user()->id);
        // Get all active customers
        $customers = $user->customers()->where('status', 1)->with('invoices')->paginate($this->paginate());
        return Inertia::render('Customer/Index', [
            'customers' => $customers,
        ]);
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create(Request $request): Response
    {
        // Check authorisation
        if ($request->user()->cannot('create', Customer::class)) {
            abort(403);
        }

        return Inertia::render('Customer/Create');
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(CustomerRequest $request): RedirectResponse
    {
        // Check authorisation
        if ($request->user()->cannot('create', Customer::class)) {
            abort(403);
        }

        // Validate input
        $formFields = $request->validated();

        // Get previous customer number
        $user = User::find(auth()->user()->id);
        $previousCustomerNumber = $user->customers()->latest('customer_number')?->value('customer_number');

        // Insert new customer with incremented customer number
        $formFields['customer_number'] = ++$previousCustomerNumber ?? 1;
        $user->customers()->create($formFields);

        return redirect()->route('customers.index')->with('message', 'Customer created.');
    }

    /**
     * Display the specified customer.
     */
    public function show(Request $request, Customer $customer): Response
    {
        // Check authorisation
        if ($request->user()->cannot('view', $customer)) {
            abort(403);
        }

        $customer->load('invoices.customer');
        return Inertia::render('Customer/Show', [
            'customer' => $customer,
        ]);
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(Request $request, Customer $customer): Response
    {
        // Check authorisation
        if ($request->user()->cannot('update', $customer)) {
            abort(403);
        }

        return Inertia::render('Customer/Edit', [
            'customer' => $customer,
        ]);
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(CustomerRequest $request, Customer $customer): RedirectResponse
    {
        // Check authorisation
        if ($request->user()->cannot('update', $customer)) {
            abort(403);
        }

        // Validate input
        $formFields = $request->validated();

        // Update basic customer details
        $customer->update($formFields);

        return redirect()->route('customers.index')->with('message', 'Customer updated.');
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(Request $request, Customer $customer): RedirectResponse
    {
        // Check authorisation
        if ($request->user()->cannot('delete', $customer)) {
            abort(403);
        }

        $customer->delete();
        return redirect()->route('customers.index')->with('message', 'Customer deleted.');
    }

    /**
     * Archive the specified customer.
     */
    public function archive(Request $request, Customer $customer): RedirectResponse
    {
        // Check authorisation
        if ($request->user()->cannot('delete', $customer)) {
            abort(403);
        }

        // Update customer status
        $customer->status = 0;
        $customer->save();

        return redirect()->route('customers.index')->with('message', 'Customer archived.');
    }

    /**
     * Download csv of customers.
     */
    public function export(Request $request)
    {
        // Check authorisation
        if ($request->user()->cannot('viewAny', Customer::class)) {
            abort(403);
        }

        // Get logged in user
        $user = User::with('customers')->find(auth()->user()->id);

        // Get all user's customers
        $customers = $user->customers()->get();

        // Create CSV of customers and stream to browser
        $csv = SimpleExcelWriter::streamDownload('customers.csv');
        foreach ($customers as $customer) {
            $csv->addRow($customer->attributesToArray());
        }

        return $csv->toBrowser();
    }
}
