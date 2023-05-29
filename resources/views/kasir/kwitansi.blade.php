<!DOCTYPE html>
<html>

<head>
    <title>Kwitansi Toko The British</title>
    <style>
        @media print {
            body {
                width: 80mm;
            }
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            width: 80mm;
        }

        .container {
            width: 80mm;
            /* margin: 20px auto;
            padding: 10px 20px; */
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .line {
            border-bottom: 1px dashed #ccc;
            margin-bottom: 10px;
        }

        .details {
            margin-top: 20px;
            padding: 10px;
            background-color: #f8f8f8;
            border-radius: 5px;
        }

        .details table {
            width: 100%;
            border-collapse: collapse;
        }

        .details td {
            padding: 5px;
        }

        .details td:first-child {
            font-weight: bold;
            width: 50%;
        }

        .details td.text-right {
            text-align: right;
        }

        .details td:last-child {
            padding-top: 10px;
            border-top: 1px solid #ccc;
        }

        .details td:last-child span {
            float: right;
        }

        .details td:last-child strong {
            float: left;
        }

        .details td:last-child:before {
            content: '';
            display: table;
            clear: both;
        }


        .total {
            text-align: right;
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #888;
        }

        .footer p {
            margin: 0;
            line-height: 1.5;
        }
    </style>
</head>

<body>
    <div id="container" class="container">
        <div class="header">
            <p>Kwitansi Toko THE BRITISH</p>
            <p>Jl. Jend. Sudirman No. 123, Jakarta</p>
            <p>Telp. 021-123456</p>
        </div>

        <div class="line"></div>

        <div class="details">
            <table>

                <tr>
                    <td>Nomor Transaksi:</td>
                    <td>001</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td>Nama Barang</td>
                    <td class="text-right">Harga</td>
                </tr>
                <tr>
                    <td>Sabun Mandi</td>
                    <td class="text-right">Rp10.000</td>
                </tr>
                <tr>
                    <td>Jumlah:</td>
                    <td class="text-right">2</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td>Bayar:</td>
                    <td class="text-right">Rp20.000</td>
                </tr>
                <tr>
                    <td>Kembalian:</td>
                    <td class="text-right">Rp20.000</td>
                </tr>
                <tr>
                    <td>Total:</td>
                    <td class="text-right">Rp20.000</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr>
                    </td>
                </tr>
            </table>
        </div>


        <div class="line"></div>



        <div class="footer">
            <p>Terima kasih telah berbelanja di Toko Nenek.</p>
            <p>Silakan kembali lagi di lain waktu.</p>
        </div>
    </div>
</body>

</html>
