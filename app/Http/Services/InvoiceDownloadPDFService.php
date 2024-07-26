<?php

namespace App\Http\Services;

use App\Http\Repositories\InvoiceRepository;
use Carbon\Carbon;

class InvoiceDownloadPDFService
{
    /**
     * @var InvoiceRepository
     */
    protected $invoiceRepository;

    public function __construct() {
        $this->invoiceRepository = new InvoiceRepository();
    }

    public function getEndOfMonth(object $invoice)
    {
        $billingYear = $invoice->billing_year;
        $billingMonth = $invoice->billing_month;
        return Carbon::createFromDate($billingYear, $billingMonth, 1)->endOfMonth()->format('Y/m/d');
    }

    public function getTotalPriceWithTax(array $postings)
    {
        $totalPrice = array_reduce($postings, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
        $taxRate = config('constants.taxRate');
        $taxAmount = (int)round($totalPrice * $taxRate);
        $totalPriceIncludingTax = $taxAmount + $totalPrice;
        $formattedTotalPrice = number_format($totalPrice);
        $formattedTaxAmount = number_format($taxAmount);
        $formattedTotalPriceIncludingTax = number_format($totalPriceIncludingTax);
        return compact('formattedTotalPrice', 'formattedTaxAmount', 'formattedTotalPriceIncludingTax');
    }

    public function generateFilename(object $invoice)
    {
        $companyName = $invoice->company->name;
        $billingYear = $invoice->billing_year;
        $billingMonth = $invoice->billing_month;
        return $companyName.'_'.$billingYear.'年'.$billingMonth.'月請求書'.'.pdf';
    }
}
