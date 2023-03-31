<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div style="margin: 50px;">
        <div class="logo" style="margin-top: -10px; text-align: justify;">
            <!-- <img src="{{asset('Daebak.png')}}" alt=""> -->
            <div style="margin-center;">
                <h1>ATMA KOREAN BBQ</h1>
                <p style="color: #C00000; margin-top: -20px; text-align: center;">FUN PLACE TO GRILL!</p>
                <p style="text-align: center; margin-top: -20px; font-family: Calibri, sans-serif;">Jl. Babarsari No. 43 Yogyakarta 552181
                    <br>
                    Telp. (0274) 487711 | http://www.atmakoreanbbq.com
                </p>
            </div>
        </div>
        <table width="90%" style=" border-top: 2px dashed; border-collapse: collapse;" cellpadding="12">
            <tbody>
                <tr>
                    <th style="text-align: center;">LAPORAN STOK BAHAN</th>
                </tr>
            </tbody>
        </table>
        <div>
            ITEM MENU : ALL
        </div>
        <div>
            BULAN : CUSTOM ({{ $start }} s/d {{ $end }})
        </div>
        <table style="margin-top: 20px;  border-collapse: collapse" cellpadding="5" width=90%>
            <thead style=" border-top: 1px solid; background-color: #F2F2F2; ">
                <tr><th style="text-align: left;" colspan="7">MAKANAN</th></tr>
            </thead>
            <thead style=" border-top-style: double; border-bottom-style: double;">
                <tr>
                <th>No.</th>
                <th style="text-align: left;">Item Menu</th>
                <th style="text-align: right;">Unit</th>
                <th style="text-align: right;">Incoming Stock</th>
                <th style="text-align: right;">Remaining Stock</th>
                <th style="text-align: right;">Waste Stock</th>
                </tr>
            </thead>
            <tbody style="margin-top: 5px ; border-bottom-style: double;">
                <!-- Data -->
                @for($i = 0; $i < count($dataStok); $i++)
                    @if($dataStok[$i]->KATEGORI_MENU=='Utama')
                    <tr style="padding-bottom: 5px ; border: 1pt; border-bottom-style: dotted;">
                    <td style="text-align: left;"> {{ $i + 1 }}</td>
                    <td style="text-align: left;"> {{ $dataStok[$i]->NAMA_BAHAN}} </td>
                    <td style="text-align: left;">{{ $dataStok[$i]->UNIT}}</td>
                    <td style="text-align: right;">{{ $dataStok[$i]->REMAINING_STOK}}</td>
                    <td style="text-align: right;">{{ $dataStok[$i]->INCOMING_STOK }}</td>
                    <td style="text-align: right;">{{ $dataStok[$i]->WASTE_STOK }}</td>
                    </tr>
                    @endif
                @endfor
            </tbody>
        </table>

        <table style="margin-top: 20px;  border-collapse: collapse" cellpadding="5" width=90%>
            <thead style=" border-top: 1px solid; background-color: #F2F2F2; ">
                <tr><th style="text-align: left;" colspan="7">SIDE DISH</th></tr>
            </thead>
            <thead style=" border-top-style: double; border-bottom-style: double;">
                <tr>
                <th>No.</th>
                <th style="text-align: left;">Item Menu</th>
                <th style="text-align: right;">Unit</th>
                <th style="text-align: right;">Incoming Stock</th>
                <th style="text-align: right;">Remaining Stock</th>
                <th style="text-align: right;">Waste Stock</th>
                </tr>
            </thead>
            <tbody style="margin-top: 5px ; border-bottom-style: double;">
                <!-- Data -->
                @for($i = 0; $i < count($dataStok); $i++)
                    @if($dataStok[$i]->KATEGORI_MENU=='Side Dish')
                    <tr style="padding-bottom: 5px ; border: 1pt; border-bottom-style: dotted;">
                    <td style="text-align: left;"> {{ $i + 1 }}</td>
                    <td style="text-align: left;"> {{ $dataStok[$i]->NAMA_BAHAN}} </td>
                    <td style="text-align: left;">{{ $dataStok[$i]->UNIT}}</td>
                    <td style="text-align: right;">{{ $dataStok[$i]->REMAINING_STOK}}</td>
                    <td style="text-align: right;">{{ $dataStok[$i]->INCOMING_STOK }}</td>
                    <td style="text-align: right;">{{ $dataStok[$i]->WASTE_STOK }}</td>
                    </tr>
                    @endif
                @endfor
            </tbody>
        </table>

        <table style="margin-top: 20px;  border-collapse: collapse" cellpadding="5" width=90%>
            <thead style=" border-top: 1px solid; background-color: #F2F2F2; ">
                <tr><th style="text-align: left;" colspan="7">MINUMAN</th></tr>
            </thead>
            <thead style=" border-top-style: double; border-bottom-style: double;">
                <tr>
                <th>No.</th>
                <th style="text-align: left;">Item Menu</th>
                <th style="text-align: right;">Unit</th>
                <th style="text-align: right;">Incoming Stock</th>
                <th style="text-align: right;">Remaining Stock</th>
                <th style="text-align: right;">Waste Stock</th>
                </tr>
            </thead>
            <tbody style="margin-top: 5px ; border-bottom-style: double;">
                <!-- Data -->
                @for($i = 0; $i < count($dataStok); $i++)
                    @if($dataStok[$i]->KATEGORI_MENU=='Minuman')
                    <tr style="padding-bottom: 5px ; border: 1pt; border-bottom-style: dotted;">
                    <td style="text-align: left;"> {{ $i + 1 }}</td>
                    <td style="text-align: left;"> {{ $dataStok[$i]->NAMA_BAHAN}} </td>
                    <td style="text-align: left;">{{ $dataStok[$i]->UNIT}}</td>
                    <td style="text-align: right;">{{ $dataStok[$i]->REMAINING_STOK}}</td>
                    <td style="text-align: right;">{{ $dataStok[$i]->INCOMING_STOK }}</td>
                    <td style="text-align: right;">{{ $dataStok[$i]->WASTE_STOK }}</td>
                    </tr>
                    @endif
                @endfor
            </tbody>
        </table>

       
        <div style="text-align: center; margin-top: 50px ">
            <span>Printed <?= @date('M d, Y H:i:s A') ?></span><br>
        </div>
    </div>
</body>
<style>
    body {
        margin: auto;
        width: 210mm;
        height: 240mm;
        padding-bottom: 50px;
        font-family: Calibri, Segoe, "Segoe UI", Optima, Arial, sans-serif;
        font-size: 12pt;
    }
    h1 {
        font-family: Candara, Calibri, Segoe, "Segoe UI", Optima, Arial, sans-serif;
        font-size: 30pt;
        font-style: normal;
        font-variant: normal;
        color: #44546A;
        font-weight: 700;
        text-align: center;
        line-height: 23px;
    }
    span {
        font-size: 8pt;
    }
    /* Create two equal columns that floats next to each other */
    .column {
        float: left;
        width: 50%;
        padding: 10px;
        height: 30px;
        /* Should be removed. Only for demonstration */
    }
    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }
    h3 {
        font-family: Candara, Calibri, Segoe, "Segoe UI", Optima, Arial, sans-serif;
        font-size: 17px;
        font-style: normal;
        font-variant: normal;
        font-weight: 700;
        line-height: 23px;
    }
    p {
        font-family: Candara, Calibri, Segoe, "Segoe UI", Optima, Arial, sans-serif;
        font-size: 14pt;
        font-style: normal;
        font-variant: normal;
        font-weight: 400;
        line-height: 23px;
    }
    blockquote {
        font-family: Candara, Calibri, Segoe, "Segoe UI", Optima, Arial, sans-serif;
        font-size: 17px;
        font-style: normal;
        font-variant: normal;
        font-weight: 400;
        line-height: 23px;
    }
    pre {
        font-family: Candara, Calibri, Segoe, "Segoe UI", Optima, Arial, sans-serif;
        font-size: 11px;
        font-style: normal;
        font-variant: normal;
        font-weight: 400;
        line-height: 23px;
    }
    img {
        height: 1.37in;
        width: 1.46in;
        margin-top: 15px;
    }
    .my-box {
        width: 100px;
        padding: 20px;
        border: 5px solid black;
        border-radius: 25px;
        margin: auto;
    }
    .logo {
        margin: 10px;
        display: flex;
        justify-content: center;
    }
    .text {
        text-align: center;
    }
</style>
<script>
    window.onload = window.print();
</script>

</html>