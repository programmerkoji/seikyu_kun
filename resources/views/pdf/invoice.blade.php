<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="{{asset('css/invoice_pdf.css')}}">
</head>
<body>
    <div class="ly_header">
        <h1 class="bl_header_ttl">請求書</h1>
    </div>
    <div class="ly_address">
        <div class="bl_address_customer">
            <h2>{{ $invoice->company->name }}</h2>
        </div>
    </div>
</body>
</html>
