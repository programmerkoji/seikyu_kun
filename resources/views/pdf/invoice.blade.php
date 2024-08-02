<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <style>
        body {
            line-height: 1.58;
        }
        .bg_blue {
            background: #0067c0;
        }
        .text_white {
            color: #FCFCFC;
        }
        .price_text {
            text-align: right;
        }
        .header_ttl {
            text-align: center;
            margin-bottom: 24px;
        }
        .ly_address {
            margin-bottom: 24px;
        }

        .bl_address_customer {
            width: 40%;
            float: left;
            font-weight: bold;
            font-size: 18px;
            border-bottom: 1px solid #333333;
        }

        .bl_address_own {
            text-align: right;
        }
        .ly_invoiceHead {
            margin-bottom: 24px;
        }
        .bl_invoiceHead_left {
            float: left;
            width: 65%;
        }
        .bl_invoiceHead_left table {
            width: 80%;
        }
        .bl_invoiceList_table {
            margin-bottom: 24px;
        }
        table {
            border-collapse: collapse;
        }
        td, th {
            border: 1px solid #999999;
            padding: 8px;
            font-size: 11px;
        }
        th {
            background: #0067c0;
            color: #FCFCFC;
        }
        .bl_detail_topTable {
            width: 100%;
        }
        .bl_detail_bottomTable {
            width: 100%;
        }
        .bl_detail_bottomTable td {
            text-align: right;
        }
        .bl_detail_bottomTable_wrapper {
            float: right;
            width: 30%;
            margin-top: 4px;
        }
        .ly_other {
            margin-top: 24px;
            clear: both;
            width: 100%;
        }
        .bl_other_table {
            width: 100%;
        }
    </style>
</head>
<body>
    <h1 class="header_ttl bg_blue text_white">請求書</h1>
    <div class="ly_address">
        <div class="bl_address_customer">
            <div>{{ $invoice->company->name }} 御中</div>
        </div>
        <div class="bl_address_own">
            <div>No. {{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div>請求日　{{ $data['endOfMonth'] }}</div>
        </div>
    </div>
    <div class="ly_invoiceHead">
        <div class="bl_invoiceHead_left">
            <div style="margin-bottom: 4px">下記のとおり、御請求申し上げます。</div>
            <table class="bl_invoiceList_table">
                <tr>
                    <th>件名</th>
                    <td>テスト</td>
                </tr>
                <tr>
                    <th>支払期限</th>
                    <td>2024/07/31</td>
                </tr>
                <tr>
                    <th>振込先</th>
                    <td>サンプル銀行 本店<br>普通1234567 株式会社サンプル</td>
                </tr>
            </table>
            <table>
                <tr>
                    <th>ご請求金額（税込）</th>
                    <td class="price_text">¥{{ $data['formattedTotalPriceIncludingTax'] }}</td>
                </tr>
            </table>
        </div>
        <div class="bl_invoiceHead_right">
            <div>サンプル株式会社</div>
            <div>
                〒123-5678<br>
                住所：茨城県つくば市松代2丁目3-10<br>
                電話：090-1234-4325<br>
                メール：utautaouka@gmail.com
            </div>
        </div>
    </div>
    <div class="ly_detail">
        <table class="bl_detail_topTable">
            <tr>
                <th>プラン</th>
                <th>掲載内容</th>
                <th>掲載開始</th>
                <th>掲載期間</th>
                <th>数量</th>
                <th>単価</th>
                <th>金額</th>
            </tr>
            @foreach ($invoice->postings as $posting)
            <tr>
                <td>{{ $posting->product->name }}</td>
                <td>{{ $posting->content }}</td>
                <td>{{ \Carbon\Carbon::parse($posting->posting_start)->format('Y/m/d') }}</td>
                <td>{{ $posting->posting_term }}週間</td>
                <td>{{ $posting->quantity }}部</td>
                <td class="price_text">{{ number_format($posting->price) }}円</td>
                <td class="price_text">{{ number_format($posting->price * $posting->quantity) }}円</td>
            </tr>
            @endforeach
            @for ($i = 0; $i < 15 - count($invoice->postings); $i++)
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            @endfor
        </table>
        <div class="bl_detail_bottomTable_wrapper">
            <table class="bl_detail_bottomTable">
                <tr>
                    <th>小計</th>
                    <td class="price_text">{{ $data['formattedTotalPrice'] }}円</td>
                </tr>
                <tr>
                    <th>消費税</th>
                    <td class="price_text">{{ $data['formattedTaxAmount'] }}円</td>
                </tr>
                <tr>
                    <th>合計</th>
                    <td class="price_text">{{ $data['formattedTotalPriceIncludingTax'] }}円</td>
                </tr>
            </table>
        </div>
        <div class="ly_other">
            <table class="bl_other_table">
                <tr>
                    <th>備考</th>
                </tr>
                <tr>
                    <td>@if ($invoice->note) {{ $invoice->note }} @else &nbsp; @endif</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
