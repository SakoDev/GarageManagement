<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .invoice-container {
            width: 100%;
            height: 100vh;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
            box-sizing: border-box;
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 2rem;
        }

        .header .invoice-id {
            background-color: #f5f5f5;
            padding: 10px;
            font-size: 1.25rem;
        }

        .details,
        .client-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .table th,
        .table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .table th {
            background-color: #f5f5f5;
        }

        .table td {
            text-align: right;
        }

        .total {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .total .label {
            margin-right: 20px;
            font-weight: bold;
        }

        .terms {
            font-size: 0.9rem;
        }

        .signature {
            margin-top: 40px;
            text-align: right;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            width: 200px;
            margin-top: 10px;
        }

        /* Footer at the bottom */
        .footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
        }

        @media print {
            @page {
                size: A5;
            }

            .invoice-container {
                page-break-inside: avoid;
                height: auto;
                min-height: 100vh;
            }

            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</head>

<body>

    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div>
                <h1>DEVIS</h1>
                <div class="invoice-id">Devis n° : {{ $invoice->invoice_id }}</div>
            </div>
            <div>
                <!-- Empty for any potential logo -->
                <div class="details">
                    <div>Date : {{ $invoice->invoice_date }}</div>
                </div>
            </div>
        </div>

        <!-- Client Info -->
        <div class="client-info">
            <div>
                <p><strong>{{ $user->company_name }}</strong></p>
                <p>{{ $user->phone_number }}</p>
                <p>{{ $user->ice }}</p>
            </div>
            <div>
                <p><strong>{{ $invoice->customer->company_name }}</strong></p>
                <p>{{ $invoice->customer->phone_number }}</p>
                <p>{{ $invoice->customer->ice }}</p>
            </div>
        </div>

        <!-- Invoice Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Unit</th>
                    <th>Designation</th>
                    <th>Prix</th>
                    <th>Qté</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                    <tr>
                        <td style="text-align: left">{{ $item->type }}</td>
                        <td style="text-align: left">{{ $item->description }}</td>
                        <td style="text-align: left">{{ number_format($item->unit_amount, 2) }} DH</td>
                        <td style="text-align: left">{{ str_pad($item->quantity, 2, '0', STR_PAD_LEFT) }}</td>
                        <td style="text-align: right">{{ number_format($item->quantity * $item->unit_amount, 2) }} DH</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="total">
            <div class="label">Sous total :</div>
            <div>{{ number_format($invoice->total_amount, 2) }} DH</div>
        </div>
        @if ($invoice->vat_rate != 0)
            <div class="total">
                <div class="label">TVA ({{ $invoice->vat_rate }}%) :</div>
                <div>{{ number_format($invoice->vat_amount, 2) }} DH</div>
            </div>
        @endif
        <div class="total">
            <div class="label">TOTAL :</div>
            <div><strong>{{ number_format($invoice->total_amount + $invoice->vat_amount, 2) }} DH</strong></div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="text-align:center;">MERCI DE VOTRE CONFIANCE</p>
        </div>
    </div>

</body>

</html>
