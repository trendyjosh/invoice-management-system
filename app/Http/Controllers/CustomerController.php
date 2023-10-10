<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     */
    public function index(): Response
    {
        $user = User::with('customers.invoices')->find(auth()->user()->id);
        return Inertia::render('Customer/Index', [
            'customers' => $user->customers,
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
    public function store(Request $request)
    {
        // Validate input
        $formFields = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'address_1' => ['required', 'string'],
            'address_2' => ['nullable', 'string'],
            'city' => ['required', 'string'],
            'county' => ['nullable', 'string'],
            'postcode' => ['required', 'string'],
        ]);

        $user = User::find(auth()->user()->id);
        $user->customers()->create($formFields);

        return redirect()->route('customers.index')->with('message', 'Customer created.');
    }

    /**
     * Display the specified customer.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
