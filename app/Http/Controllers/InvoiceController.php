<?php

namespace App\Http\Controllers;

use App\Http\Repositories\InvoiceRepository;
use App\Http\Requests\InvoiceRequest;
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

    public function index(Request $request)
    {
        $years = $this->viewListInvoiceService->getDistinctYears();
        $months = $this->viewListInvoiceService->getDistinctMonths();
        $input = $request->input();
        $searchYear = 0;
        $searchMonth = 0;
        if (!empty($input)) {
            $searchYear = (int)$input['searchYear'];
            $searchMonth = (int)$input['searchMonth'];
            $query = $this->viewListInvoiceService->search($input);
        } else {
            $query = $this->viewListInvoiceService->all();
        }
        $invoices = $query->paginate(config('constants.pagination'))->withQueryString();
        return view('invoice.index', compact('invoices', 'years', 'months', 'searchYear', 'searchMonth'));
    }

    public function show($invoice_id)
    {
        $invoice = $this->viewListInvoiceService->findByOne($invoice_id);
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
        $this->invoiceRepository->destroy($id, []);
        return redirect()
        ->route('invoice.index')
        ->with('message', '請求を削除しました');
    }

    public function downloadPDF(int $invoice_id)
    {
        $invoice = $this->viewListInvoiceService->findByOne($invoice_id);
        $data['endOfMonth'] = $this->invoiceDownloadPDFService->getEndOfMonth($invoice);
        $data += $this->invoiceDownloadPDFService->getTotalPriceWithTax($invoice);
        $fileName = $this->invoiceDownloadPDFService->generateFilename($invoice);
        $pdf = PDF::loadView('pdf.invoice', compact('invoice', 'data'));
        return $pdf->stream($fileName);
    }
}
