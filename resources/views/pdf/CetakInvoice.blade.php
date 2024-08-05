<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="{{ public_path('print/style.css') }}">
</head>

<body>
    <table style="border: none">
        <tr>
            <td style="width: 50%; border: none">
                <img class="logo" src="{{ public_path('print/logo.png') }}" alt="">
            </td>
            <td class="judul" style="width: 50%; border: none">
                <span class="h5">INVOICE</span>
                <table style="border: none; margin-top: 10px;">
                    <tr>
                        <td style="width: 50%; border: none">Nama :</td>
                        <td class="text-end" style="width: 50%; border: none;">
                            {{ $transactions->user->name }}</td>
                    </tr>
                    <tr>
                        <td style="width: 50%; border: none">No Handphone :</td>
                        <td class="text-end" style="width: 50%; border: none;">
                            {{ $transactions->user->phone }}</td>
                    </tr>
                    <tr>
                        <td style="width: 50%; border: none">Email :</td>
                        <td class="text-end" style="width: 50%; border: none;">
                            {{ $transactions->user->email }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <p style="margin-top: 30px">
        INVOICE #{{ $transactions->invoice_code }} <br />
        DATE {{ $date }}
    </p>

    <table>
        <tr>
            <th style="width: 90px">QUANTITY</th>
            <th style="width: auto">DESCRIPTION</th>
            <th style="width: 120px">UNIT PRICE</th>
            <th style="width: 130px">TOTAL</th>
        </tr>
        @foreach ($transactions->items as $item)
            <tr>
                <td class="text-center">{{ $item->quantity }}</td>
                <td>{{ $item->service->name }} - {{ $item->service->categoryservices->name }}</td>
                <td class="text-end">{{ $item->service->price }}</td>
                <td class="text-end">{{ $item->price }}</td>
            </tr>
        @endforeach
        <tr>
            <td style="height: 14px"></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="height: 14px"></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="height: 14px"></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <th colspan="3" class="text-end">Sub Total</th>
            <th class="text-end">{{ $transactions->total }}</th>
        </tr>
        <tr>
            <th colspan="3" class="text-end">Discount</th>
            <th class="text-end">0</th>
        </tr>
        <tr>
            <th colspan="3" class="text-end">Total</th>
            <th class="text-end">{{ $transactions->total }}</th>
        </tr>
    </table>

    <p class="text-center">PDF Generate on {{ $date }}</p>
</body>

</html>
