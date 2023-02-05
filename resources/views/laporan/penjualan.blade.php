<table>
    <thead>
    <tr>
        <th>Jenis</th>
        <th>Merek</th>
        <th>Brand</th>
        <th>Terjual</th>
        <th>Pendapatan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($kendaraans as $kendaraan)
        <tr>
            <td>{{ $kendaraan->jenis }}</td>
            <td>{{ $kendaraan->merek }}</td>
            <td>{{ $kendaraan->brand }}</td>
            <td>{{ count($kendaraan->penjualans) }}</td>
            <td>{{ "Rp " . number_format(count($kendaraan->penjualans) * $kendaraan->harga, 2, ',', '.') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
