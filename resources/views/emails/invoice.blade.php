<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>[MOBIL] Invoice Mobil {{ $sale->car_name }}</title>
</head>
<body>
    <h3>INVOICE MOBIL</h3>
    <p>Terima kasih telah membeli mobil di dealer kami. Berikut adalah detail pembelian Anda.</p>
    
    <table>
        <tr>
            <td>Tanggal Pembelian</td>
            <td>{{ toDate($sale->date) }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>{{ $sale->customer_name }}</td>
        </tr>
        <tr>
            <td>No. Telepon</td>
            <td>{{ $sale->customer_phone }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $sale->customer_email }}</td>
        </tr>
        <tr>
            <td colspan="2">
                <hr />
            </td>
        </tr>
        <tr>
            <td>Mobil</td>
            <td>{{ $sale->car_name }}</td>
        </tr>
        <tr>
            <td>Harga</td>
            <td>Rp. {{ toNumber($sale->car_price) }},-</td>
        </tr>
    </table>
</body>
</html>