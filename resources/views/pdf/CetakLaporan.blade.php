<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan</title>
    <style>
        .garis1 {
            border-top: 3px solid black;
            height: 2px;
            border-bottom: 1px solid black;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ public_path('print/style.css') }}">
</head>

<body>
    {{-- <table style="border: none">
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
    </table> --}}

    <table style="border: none">
        <tr>
            <td style="width: 10%; border: none">
                <img class="logo" src="{{ public_path('print/logo.png') }}" alt="" style="width: 90px">
            </td>
            <td class="judul" style="border: none">
                <span class="h5">PT INIT SOLUSI DIGITAL</span><br />
                <span>
                    Jl. Ksatria Komplek PU No. 9 Kesambi, Kota Cirebon<br />
                    (0231) 231526<br />
                    E-Mail : connect@init.co.id
                </span>
            </td>
            <td style="width: 10%; border: none"></td>
        </tr>
    </table>

    <hr class="garis1" />

    <table>
        <tr>
            <th style="width: 90px">#INVOICE</th>
            <th style="width: 100PX">NAMA</th>
            <th style="width: auto">NO PHONE</th>
            <th>QNT</th>
            <th style="width: 100px">UNIT PRICE</th>
            <th style="width: 110px">TOTAL</th>
        </tr>
        @foreach ($transactions as $item)
            <tr>
                <td class="text-center">{{ $item->invoice_code }}</td>
                <td>{{ $item->user->name }}</td>
                <td class="text-center">{{ $item->user->phone }}</td>
                {{-- <td>{{ $item->service->name }} - {{ $item->service->categoryservices->name }}</td> --}}
                {{-- <td class="text-end">{{ $item->items->quantity }}</td> --}}
                @foreach ($item->items as $comment)
                    <td class="text-center">{{ $comment->quantity }}</td>
                    <td class="text-end">{{ $comment->price }}</td>
                @endforeach
                <td class="text-end">{{ $item->total }}</td>
            </tr>
        @endforeach
        {{-- <tr>
            <th colspan="3" class="text-end">Sub Total</th>
            <th class="text-end">{{ $transactions->total }}</th>
        </tr>
        <tr>
            <th colspan="3" class="text-end">Discount</th>
            <th class="text-end">0</th>
        </tr> --}}
        <tr>
            <th colspan="5" class="text-end">Total Uang Masuk</th>
            <th class="text-end">{{ $totalIncome }}</th>
        </tr>
    </table>

    <p class="text-center">PDF Generate on {{ $date }}</p>
</body>

</html>
