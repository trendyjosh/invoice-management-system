<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
</head>

<body>
    <style>
        html {
            font-family: Arial, sans-serif;
            font-size: 14px;
            height: 100%;
        }

        h1 {
            font-weight: 400;
            font-size: 38px;
        }

        h2,
        h3 {
            margin: 0;
        }

        .totals {
            border-top: 10px solid #fcefe9;
            background-color: #fcefe9;
        }

        .invoice {
            margin-top: 50px;
            border-top: 2px solid #eb7c44;
            border-bottom: 2px solid #eb7c44;
        }

        .items {
            margin-top: 10px;
        }

        .items th {
            border-bottom: 2px solid #fcefe9;
            font-weight: normal;
        }

        .footer {
            position: absolute;
            bottom: 170px;
        }
    </style>
    <table width="100%" cellpadding="5" cellspacing="0">
        <tr>
            <td width="50%">
                <!-- <img src="https://placehold.co/100x100" width="80" height="80" alt=""> -->
            </td>
            <td width="50%">
                <h1>INVOICE</h1>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <h2>{{ Str::upper($invoice->user->company_name) }}</h2>
            </td>
            <td width="50%">
                <h3>Invoice to</h3>
            </td>
        </tr>
        <tr>
            <td width="50%">
                {{ $invoice->user->address_1 }}<br>
                @if($invoice->user->address_2){{ $invoice->user->address_2 }}<br>@endif
                {{ $invoice->user->city }}
                @if($invoice->user->county)<br>{{ $invoice->user->county }}@endif
                {{ $invoice->user->postcode }}<br>
            </td>
            <td>
                {{ $invoice->customer->name }}<br>
                {{ $invoice->customer->address_1 }}<br>
                @if($invoice->customer->address_2){{ $invoice->customer->address_2 }}<br>@endif
                {{ $invoice->customer->city }}
                @if($invoice->customer->county)<br>{{ $invoice->customer->county }}@endif
                {{ $invoice->customer->postcode }}<br>
            </td>
        </tr>
        <tr>
            <td>
                COMPANY NUMBER: {{ $invoice->user->company_number }}<br>
                PHONE: {{ $invoice->user->phone }}<br>
                EMAIL: {{ $invoice->user->email }}<br>
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">
                <table class="invoice" width="100%" cellpadding="5">
                    <tr>
                        <td width="25%" align="left">INVOICE NO.</td>
                        <td width="25%" align="right">{{ $invoice->invoice_number }}</td>
                        <td width="25%" align="left">CLIENT NUMBER</td>
                        <td width="25%" align="right">{{ $invoice->customer->id }}</td>
                    </tr>
                    <tr valign="top">
                        <td width="25%" align="left">DATE OF INVOICE</td>
                        <td width="25%" align="right">{{ $invoice->getDateString() }}</td>
                    </tr>
                    <tr valign="top">
                        <td width="25%" align="left">DUE DATE</td>
                        <td width="25%" align="right">{{ $invoice->getDueDateString() }}</td>
                    </tr>
                </table>
                <table class="items" width="100%" cellpadding="5" cellspacing="0">
                    <tr>
                        <th width="50%" align="left">DESCRIPTION</th>
                        <th width="15%" align="right">QUANTITY</th>
                        <th width="15%" align="right">UNIT PRICE</th>
                        <th width="20%" align="right">AMOUNT</th>
                    </tr>
                    @foreach($invoice->invoiceItems as $invoiceItem)
                    <tr>
                        <td align="left">{{ $invoiceItem->description }}</td>
                        <td align="right">{{ $invoiceItem->quantity }}</td>
                        <td align="right">{{ $invoiceItem->unit_price }}</td>
                        <td align="right"><b>{{ number_format($invoiceItem->getAmount(), 2) }}</b></td>
                    </tr>
                    @endforeach
                </table>
            </td>
        </tr>
    </table>
    <table class="footer" width="100%">
        <tr>
            <td>
                <table class="totals" width="100%" cellpadding="5" cellspacing="0">
                    <tr>
                        <td width="25%"></td>
                        <td width="25%"></td>
                        <td width="25%" align="left">AMOUNT</td>
                        <td width="25%" align="right"><b>£{{ $invoice->getTotal() }}</b></td>
                    </tr>
                    <tr bgcolor="#eb7c44" width="100%">
                        <td colspan="4" height="8"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" cellpadding="5">
                    <tr>
                        <td width="25%">
                            Bank account name:<br>
                            Account number:<br>
                            Sort code:<br>
                        </td>
                        <td width="25%">
                            {{ $invoice->user->bank_name }}<br>
                            {{ $invoice->user->bank_acc_no }}<br>
                            {{ $invoice->user->getSortCode() }}<br>
                        </td>
                        <td width="25%">
                            DUE DATE<br>
                            <b>{{ $invoice->getDueDateString() }}</b><br>
                        </td>
                        <td width="25%" align="right">
                            AMOUNT TO PAY<br>
                            <b>£{{ $invoice->getTotal() }}</b><br>
                        </td>
                    </tr>
                    <tr>
                        <td width="25%">PAYMENT REFERENCE</td>
                        <td width="25%">
                            {{ $invoice->invoice_number }}
                        </td>
                        <td colspan="2" align="right">
                            PAYMENT TERMS<br>
                            {{ $invoice->customer->getPaymentTermsString() }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>