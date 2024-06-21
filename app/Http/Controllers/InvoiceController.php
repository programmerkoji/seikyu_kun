<?php

namespace App\Http\Controllers;

use App\Http\Repositories\InvoiceRepository;
use App\Http\Services\InvoiceDownloadPDFService;
use App\Http\Services\ViewListInvoiceService;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class InvoiceController extends Controller
{
    /**
     * @var ViewListInvoiceService
     */
    protected $viewListInvoiceService;

    /**
     * @var $invoiceDownloadPDFService
     */
    protected $invoiceDownloadPDFService;

    /**
     * @var InvoiceRepository
     */
    protected $invoiceRepository;

    public function __construct()
    {
        $this->viewListInvoiceService = new ViewListInvoiceService();
        $this->invoiceDownloadPDFService = new InvoiceDownloadPDFService();
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
        $data = $this->getInvoiceAndPostings($invoice_id);
        return view('invoice.detail', $data);
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

    public function downloadPDF(int $invoice_id)
    {
        $data = $this->getInvoiceAndPostings($invoice_id);
        $data['endOfMonth'] = $this->invoiceDownloadPDFService->getEndOfMonth($data['invoice']);
        $data += $this->invoiceDownloadPDFService->getTotalPriceWithTax($data['postings']);
        $fileName = $this->invoiceDownloadPDFService->generateFilename($data['invoice']);
        $pdf = PDF::loadView('pdf.invoice', $data);
        return $pdf->stream($fileName);
    }

    private function getInvoiceAndPostings($invoice_id)
    {
        $invoice = $this->viewListInvoiceService->findByOne($invoice_id);
        $postings = $this->viewListInvoiceService->getPosting($invoice);
        return compact('invoice', 'postings');
    }
}
