<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\SimpleExcel\SimpleExcelWriter;

class CompanyController extends Controller
{
    /**
     * Display a listing of the companies.
     */
    public function index(Request $request): Response
    {
        // Check authorisation
        if ($request->user()->cannot('viewAny', Company::class)) {
            abort(403);
        }

        // Get logged in user
        $user = User::with('companies.invoices')->find(auth()->user()->id);
        // Get all active companies
        $companies = $user->companies()->where('status', 1)->with('invoices')->paginate($this->paginate());
        return Inertia::render('Company/Index', [
            'companies' => $companies,
        ]);
    }

    /**
     * Show the form for creating a new company.
     */
    public function create(Request $request): Response
    {
        // Check authorisation
        if ($request->user()->cannot('create', Company::class)) {
            abort(403);
        }

        return Inertia::render('Company/Create');
    }

    /**
     * Store a newly created company in storage.
     */
    public function store(CompanyRequest $request): RedirectResponse
    {
        // Check authorisation
        if ($request->user()->cannot('create', Company::class)) {
            abort(403);
        }

        // Validate input
        $formFields = $request->validated();

        // Insert new company
        $user = User::find(auth()->user()->id);
        $user->companies()->create($formFields);

        return redirect()->route('companies.index')->with('message', 'Company created.');
    }

    /**
     * Display the specified company.
     */
    public function show(Request $request, Company $company): Response
    {
        // Check authorisation
        if ($request->user()->cannot('view', $company)) {
            abort(403);
        }

        $company->load('invoices.company');
        return Inertia::render('Company/Show', [
            'company' => $company,
        ]);
    }

    /**
     * Show the form for editing the specified company.
     */
    public function edit(Request $request, Company $company): Response
    {
        // Check authorisation
        if ($request->user()->cannot('update', $company)) {
            abort(403);
        }

        return Inertia::render('Company/Edit', [
            'company' => $company,
        ]);
    }

    /**
     * Update the specified company in storage.
     */
    public function update(CompanyRequest $request, Company $company): RedirectResponse
    {
        // Check authorisation
        if ($request->user()->cannot('update', $company)) {
            abort(403);
        }

        // Validate input
        $formFields = $request->validated();

        // Update basic company details
        $company->update($formFields);

        return redirect()->route('companies.index')->with('message', 'Company updated.');
    }

    /**
     * Remove the specified company from storage.
     */
    public function destroy(Request $request, Company $company): RedirectResponse
    {
        // Check authorisation
        if ($request->user()->cannot('delete', $company)) {
            abort(403);
        }

        $company->delete();
        return redirect()->route('companies.index')->with('message', 'Company deleted.');
    }

    /**
     * Archive the specified company.
     */
    public function archive(Request $request, Company $company): RedirectResponse
    {
        // Check authorisation
        if ($request->user()->cannot('delete', $company)) {
            abort(403);
        }

        // Update company status
        $company->status = 0;
        $company->save();

        return redirect()->route('companies.index')->with('message', 'Company archived.');
    }

    /**
     * Download csv of companies.
     */
    public function export(Request $request)
    {
        // Check authorisation
        if ($request->user()->cannot('viewAny', Company::class)) {
            abort(403);
        }

        // Get logged in user
        $user = User::with('companies')->find(auth()->user()->id);

        // Get all user's companies
        $companies = $user->companies()->get();

        // Create CSV of companies and stream to browser
        $csv = SimpleExcelWriter::streamDownload('companies.csv');
        foreach ($companies as $company) {
            $csv->addRow($company->attributesToArray());
        }

        return $csv->toBrowser();
    }
}
