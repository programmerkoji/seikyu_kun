<?php

namespace App\Http\Controllers;

use App\Repositories\InvoiceRepository;
use App\Repositories\PaymentCategoryRepository;
use App\Http\Requests\InvoiceRequest;
use App\Services\InvoiceDownloadPDFService;
use App\Services\PostingInvoiceService;
use App\Services\ViewListInvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use PDF;
use ZipArchive;

class InvoiceController extends Controller
{
    /**
     * @var ViewListInvoiceService
     */
    protected $viewListInvoiceService;

    /**
     * @var InvoiceDownloadPDFService
     */
    protected $invoiceDownloadPDFService;

    /**
     * @var InvoiceRepository
     */
    protected $invoiceRepository;

    /**
     * @var PostingInvoiceService
     */
    protected $postingInvoiceService;

    /**
     * @var PaymentCategoryRepository
     */
    protected $paymentCategoryRepository;

    public function __construct()
    {
        $this->viewListInvoiceService = new ViewListInvoiceService();
        $this->invoiceDownloadPDFService = new InvoiceDownloadPDFService();
        $this->invoiceRepository = new InvoiceRepository();
        $this->postingInvoiceService = new PostingInvoiceService();
        $this->paymentCategoryRepository = new PaymentCategoryRepository();
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

        $statusBgColors = $this->viewListInvoiceService->getStatusBgColors($invoices);
        return view('invoice.index', compact('invoices', 'years', 'months', 'searchYear', 'searchMonth', 'totalInvoiceIds', 'statusBgColors'));
    }

    public function show($invoice_id)
    {
        $invoice = $this->viewListInvoiceService->findByOne($invoice_id, ['company:id,name', 'postings', 'postings.product']);
        return view('invoice.detail', compact('invoice'));
    }

    public function create()
    {
        $postingData = session('postingData');
        $companyId = $postingData['company_id'] ?? null;
        if (!$postingData) {
            return redirect()
                ->route('posting.create')
                ->with('error', '掲載データがありません。');
        }
        if ($companyId) {
            $companyData = $this->viewListInvoiceService->getCompanyInfoByPosting($companyId);
            $invoiceDatas = $this->viewListInvoiceService->findByCompanyId($companyId)->get();
        }
        return view('invoice.create', compact('companyData', 'invoiceDatas'));
    }

    public function store(InvoiceRequest $request)
    {
        try {
            $this->postingInvoiceService->createPostingWithInvoice($request->all());
            return redirect()->route('posting.index')->with('message', '登録が完了しました。');
        } catch (\Exception $e) {
            Log::channel('daily')->error('エラーメッセージ', [
                'exception' => $e,
            ]);
            return back()->with('error', '請求データ、または掲載データの登録に失敗しました。')->withInput();
        }
    }

    public function edit($invoiceId)
    {
        $invoice = $this->viewListInvoiceService->findByOne($invoiceId, []);
        return view('invoice.edit', compact('invoice'));
    }

    public function update(InvoiceRequest $request, $invoiceId)
    {
        try {
            $this->invoiceRepository->update($request->toArray(), $invoiceId, []);
            return redirect()->route('invoice.index')->with('message', '編集が完了しました。');
        } catch (\Exception $e) {
            Log::channel('daily')->error('エラーメッセージ', [
                'exception' => $e,
            ]);
            return back()->with('error', '請求データ、または掲載データの登録に失敗しました。')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->invoiceRepository->destroy($id, []);
            return redirect()
                ->route('invoice.index')
                ->with('message', '請求を削除しました');
        } catch (\Exception $e) {
            Log::channel('daily')->error('エラーメッセージ', [
                'exception' => $e,
            ]);
            return back()->with('error', '請求データ、または掲載データの削除に失敗しました。');
        }
    }

    public function downloadMultiplePDFs(Request $request)
    {
        $startTotal = microtime(true);
        $invoiceIds = $request->input('invoice_ids');
        $zip = new ZipArchive;
        $zipFileName = 'invoice.zip';
        // $tempDir = storage_path('app/temp/');
        $tempZipPath = storage_path($zipFileName);

        if (empty($invoiceIds)) {
            return redirect()
                ->route('invoice.index')
                ->with('message', 'ダウンロードできる請求がありません');
        }
        // if (!File::exists($tempDir)) {
        //     File::makeDirectory($tempDir, 0755, true);
        // }

        $startFetch = microtime(true);
        $invoices = $this->viewListInvoiceService->findByIds($invoiceIds)->get();
        $endFetch = microtime(true);
        Log::info("🔸請求書データ取得時間: " . round($endFetch - $startFetch, 3) . "秒");

        $startZip = microtime(true);
        if ($zip->open(storage_path($zipFileName), ZipArchive::CREATE) === TRUE) {
            foreach ($invoices as $invoice) {
                $startLoop = microtime(true);

                $data['endOfMonth'] = $this->invoiceDownloadPDFService->getEndOfMonth($invoice);
                $data += $this->invoiceDownloadPDFService->getTotalPriceWithTax($invoice);
                $fileName = $this->invoiceDownloadPDFService->generateFilename($invoice);

                $startPDF = microtime(true);
                $pdf = PDF::loadView('pdf.invoice', compact('invoice', 'data'));
                $pdfContent = $pdf->output(); // バイナリデータ
                $zip->addFromString($fileName, $pdfContent);
                $endPDF = microtime(true);
                Log::info("PDF生成時間（{$fileName}）: " . round($endPDF - $startPDF, 3) . "秒");

                $endLoop = microtime(true);
                Log::info("🔁ループ全体時間（{$fileName}）: " . round($endLoop - $startLoop, 3) . "秒");
            }
            $zip->close();
        }
        $endZip = microtime(true);
        Log::info("🗜 ZIP生成時間: " . round($endZip - $startZip, 3) . "秒");


        $endTotal = microtime(true);
        Log::info("トータル処理時間: " . round($endTotal - $startTotal, 3) . "秒");

        return response()->download(storage_path($zipFileName))->deleteFileAfterSend(true);
    }

    /**
     * @param int $invoiceId
     * @return void
     */
    public function paymentDetails($invoiceId)
    {
        $invoice = $this->viewListInvoiceService->findByOne($invoiceId, ['paymentDetails', 'paymentDetails.paymentCategory']);
        $paymentDetails = $invoice->paymentDetails;
        $amountArray = $paymentDetails->pluck('amount');
        $paymentCategories = $invoice->paymentDetails->pluck('paymentCategory')->toArray();
        $paymentCategoryNames = array_column($paymentCategories, 'name');
        $totalPriceData = $this->invoiceDownloadPDFService->getTotalPriceWithTax($invoice);
        return view('invoice.payment-detail', compact('invoice', 'paymentDetails', 'paymentCategoryNames', 'totalPriceData'));
    }

    public function paymentDetailCreate($invoiceId)
    {
        $invoice = $this->viewListInvoiceService->findByOne($invoiceId, ['paymentDetails']);
        $paymentCategories = $this->paymentCategoryRepository->getAll();
        $totalPriceData = $this->invoiceDownloadPDFService->getTotalPriceWithTax($invoice);
        return view('invoice.payment-detail-create', compact('invoice', 'paymentCategories', 'totalPriceData'));
    }
}
