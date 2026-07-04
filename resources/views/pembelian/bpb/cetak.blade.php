<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Bukti Pengajuan dan Penerimaan Barang</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 15mm;
        }

        body {
            font-family: "Segoe UI", Tahoma, Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
        }

        .container {
            width: 100%;
            border: 2px solid #2b5dab;
            padding: 12px;
            box-sizing: border-box;
        }

        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #2b5dab;
            margin-bottom: 12px;
        }

        .info-box {
            border: 1px solid #2b5dab;
            padding: 6px;
            margin-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #2b5dab;
            padding: 3px;
        }

        th {
            background: #eef3ff;
            text-align: center;
        }

        .info td {
            border: none;
            padding: 4px;
            vertical-align: top;
        }

        .info-label {
            width: 18%;
            font-weight: 600;
        }

        .info-sep {
            width: 2%;
        }

        .text-center {
            text-align: center;
        }

        .sign {
            margin-top: 40px;
            width: 100%;
        }

        .sign td {
            border: none;
            text-align: center;
            height: 100px;
        }

        .sign-title {
            margin-bottom: 70px;
            font-weight: 600;
        }

        @media print {
            body {
                margin: 0;
            }

            .container {
                border: 2px solid #2b5dab;
            }
        }
    </style>

</head>

<body>
    <div class="container">

        <div class="title">BUKTI PENGAJUAN BARANG</div>

        <div class="info-box">
            <table class="info">
                <tr>
                    <td class="info-label" style="width:15%">No. BPB</td>
                    <td class="info-sep" style="width:1%">:</td>
                    <td style="width:30%">{{ $bpb->no_bpb ?? '-' }}</td>

                    <td class="info-label">Eksternal Provider</td>
                    <td class="info-sep" style="width:1%">:</td>
                    <td>{{ $bpb->nama_supplier ?? '' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Tanggal Pengajuan</td>
                    <td class="info-sep" style="width:1%">:</td>
                    <td>{{ DateToIndo($bpb->tanggal) ?? '' }}</td>

                    <td class="info-label">No. PPB</td>
                    <td class="info-sep" style="width:1%">:</td>
                    <td>{{ $bpb->no_ref ?? '' }}</td>
                </tr>
            </table>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width:5%">No</th>
                    <th style="width:25%">Nama Barang</th>
                    <th style="width:5%">Satuan</th>
                    <th style="width:5%">Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i => $row)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ $row->nama_barang }}</td>
                        <td class="text-center">{{ $row->satuan }}</td>
                        <td class="text-center">{{ $row->jumlah }}</td>
                        <td>{{ $row->keterangan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Data tidak tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <table class="sign">
            <tr>
                <td class="sign-title">Mengetahui</td>
            </tr>
            <tr>
                <td><u>Manager</u></td>
            </tr>
        </table>

    </div>

</body>

</html>
