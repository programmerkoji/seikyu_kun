<?php

namespace App\Http\Controllers;

use App\Http\Services\ViewListInvoiceService;
use App\Models\Company;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * @var ViewListInvoiceService
     */
    protected $viewListInvoiceService;

    public function __construct()
    {
        $this->viewListInvoiceService = new ViewListInvoiceService();
    }

    public function index()
    {
        $invoices = $this->viewListInvoiceService->all()->paginate(config('constants.pagination'))->withQueryString();
        return view('invoice.index', compact('invoices'));
    }

    public function create()
    {
        $companies = Company::orderBy('id', 'desc')->get();
        return view('invoice.create', compact('companies'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show($invoice_id)
    {
        $invoice = Invoice::findOrFail($invoice_id);
        return view('invoice.detail', compact('invoice'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
