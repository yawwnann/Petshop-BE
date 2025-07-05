<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Detail Pesanan {{ $pesanan->id }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Detail Pesanan #{{ $pesanan->id }}</h1>

    <p>
        <strong>Nama Pelanggan:</strong> {{ $pesanan->nama_pelanggan }}<br>
        <strong>Nomor WhatsApp:</strong> {{ $pesanan->nomor_whatsapp ?? '-' }}<br>
        <strong>Tanggal Pesan:</strong>
        {{ $pesanan->tanggal_pesan ? $pesanan->tanggal_pesan->format('d M Y') : '-' }}<br>
        <strong>Status:</strong> {{ $pesanan->status }} <br>
        <strong>Alamat:</strong> {{ $pesanan->alamat_pengiriman ?? '-' }}<br>
    </p>

    <h2>Item Dipesan:</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Ikan</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesanan->items ?? [] as $item)
                <tr>
                    <td>{{ $item->nama_ikan }}</td>
                    <td>{{ $item->pivot->jumlah }}</td>
                    <td>Rp {{ number_format($item->pivot->harga_saat_pesan ?? 0, 0, ',', '.') }}</td>
                    <td>Rp
                        {{ number_format(($item->pivot->jumlah ?? 0) * ($item->pivot->harga_saat_pesan ?? 0), 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Tidak ada item.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Total Keseluruhan</td>
                <td class="total">Rp {{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    @if($pesanan->catatan)
        <h2>Catatan:</h2>
        <p>{{ $pesanan->catatan }}</p>
    @endif

</body>

</html>