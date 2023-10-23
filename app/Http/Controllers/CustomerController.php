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

class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     */
    public function index(): Response
    {
        // Get logged in user
        $user = User::with('customers.invoices')->find(auth()->user()->id);
        // Get all active customers
        $customers = $user->customers()->where('status', 1)->with('invoices')->get();
        return Inertia::render('Customer/Index', [
            'customers' => $customers,
        ]);
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create(): Response
    {
        return Inertia::render('Customer/Create');
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(CustomerRequest $request): RedirectResponse
    {
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
    public function show(Customer $customer): Response
    {
        $customer->load('invoices.customer');
        return Inertia::render('Customer/Show', [
            'customer' => $customer,
        ]);
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(Customer $customer): Response
    {
        return Inertia::render('Customer/Edit', [
            'customer' => $customer,
        ]);
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(CustomerRequest $request, Customer $customer): RedirectResponse
    {
        // Validate input
        $formFields = $request->validated();

        // Update basic customer details
        $customer->update($formFields);

        return redirect()->route('customers.index')->with('message', 'Customer updated.');
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('message', 'Customer deleted.');
    }

    /**
     * Archive the specified customer.
     */
    public function archive(Customer $customer): RedirectResponse
    {
        // Update customer status
        $customer->status = 0;
        $customer->save();

        return redirect()->route('customers.index')->with('message', 'Customer archived.');
    }
}
