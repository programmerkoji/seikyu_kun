<?php

namespace App\Http\Controllers;

use App\Http\Repositories\InvoiceRepository;
use App\Http\Services\ViewListInvoiceService;
use App\Models\Company;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * @var ViewListInvoiceService
     */
    protected $viewListInvoiceService;
    /**
     * @var InvoiceRepository
     */
    protected $invoiceRepository;

    public function __construct()
    {
        $this->viewListInvoiceService = new ViewListInvoiceService();
        $this->invoiceRepository = new InvoiceRepository();
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
        $this->invoiceRepository->create($request->toArray());
        return redirect()
        ->route('invoice.index')
        ->with('message', '請求を登録しました');
    }

    public function show($invoice_id)
    {
        $invoice = $this->viewListInvoiceService->findByOne($invoice_id);
        $postings = $this->viewListInvoiceService->getPosting($invoice_id);
        return view('invoice.detail', compact('invoice', 'postings'));
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
