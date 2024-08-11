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
use ZipArchive;

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
        $searchYear = $request->input('searchYear');
        $searchMonth = $request->input('searchMonth');
        $keyword = $request->input('keyword');
        if ($searchYear || $searchMonth || $keyword) {
            $query = $this->viewListInvoiceService->search($searchYear, $searchMonth, $keyword);
        } else {
            $query = $this->viewListInvoiceService->all();
        }
        $totalInvoiceIds = $query->pluck('id');
        $invoices = $query->paginate(config('constants.pagination'))->withQueryString();
        return view('invoice.index', compact('invoices', 'years', 'months', 'searchYear', 'searchMonth', 'totalInvoiceIds'));
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

    public function downloadMultiplePDFs(Request $request)
    {
        $invoiceIds = $request->input('invoice_ids');
        $zip = new ZipArchive;
        $zipFileName = 'invoice.zip';

        if (empty($invoiceIds)) {
            return redirect()
                ->route('invoice.index')
                ->with('message', 'ダウンロードできる請求がありません');
        }
        if ($zip->open(storage_path($zipFileName), ZipArchive::CREATE) === TRUE) {
            foreach ($invoiceIds as $invoice_id) {
                $invoice = $this->viewListInvoiceService->findByOne($invoice_id);
                $data['endOfMonth'] = $this->invoiceDownloadPDFService->getEndOfMonth($invoice);
                $data += $this->invoiceDownloadPDFService->getTotalPriceWithTax($invoice);
                $fileName = $this->invoiceDownloadPDFService->generateFilename($invoice);
                $pdf = PDF::loadView('pdf.invoice', compact('invoice', 'data'));

                // 一時ファイルにPDFを保存
                $tempPath = storage_path('app/temp/' . $fileName);
                $pdf->save($tempPath);

                // ZIPファイルに追加
                $zip->addFile($tempPath, $fileName);
            }
            $zip->close();
        }

        return response()->download(storage_path($zipFileName))->deleteFileAfterSend(true);
    }
}
