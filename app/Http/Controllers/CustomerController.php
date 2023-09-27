<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     */
    public function index()
    {
        return Inertia::render('Customer/Index', [
            'customers' => auth()->user()->customers,
        ]);
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(Request $request)
    {
        //
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
