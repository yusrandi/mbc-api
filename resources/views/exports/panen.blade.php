<table class="table table-bordered mb-0 text-nowrap">
    <thead>
        <tr>
            <td colspan="8" style="text-align: center; border:none;"><b>DATA PANEN</b></td>

        </tr>
        <tr>
            <th>#</th>
            <th>Waktu Panen</th>
            <th>Sapi</th>
            <th>Panen Ke -</th>
            <th>Keterangan Panen</th>
            <th>Peternak</th>
            <th>Pendamping</th>
            <th>TSR</th>

        </tr>
    </thead>
    <tbody>

        @foreach ($datas as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->tgl_panen }}</td>
                <td>{{ 'MBC-' . $item->sapi->generasi . '.' . $item->sapi->anak_ke . '-' . $item->sapi->eartag_induk . '-' . $item->sapi->eartag }}
                </td>
                <td>{{ $item->frek_panen }}</td>
                <td>{{ $item->ket_panen }}</td>

                <td>{{ $item->peternak->nama_peternak }}</td>
                <td>{{ $item->pendamping->user->name }}
                </td>
                <td>{{ $item->tsr->user->name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
