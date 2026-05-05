<table>
    <tr>
        <td colspan="4"><b>SEKOLAH</b></td>
        <td colspan="{{ $subjects->count() + 10 }}"><b>: (Isi Nama Sekolah)</b></td>
    </tr>
    <tr>
        <td colspan="4"><b>Kelas</b></td>
        <td colspan="{{ $subjects->count() + 10 }}"><b>: (Isi Kelas)</b></td>
    </tr>
    <tr>
        <th rowspan="2" align="center" valign="center" style="background-color: #4472c4; color: #ffffff; font-weight: bold; border: 1px solid #000000;">NO</th>
        <th rowspan="2" align="center" valign="center" style="background-color: #4472c4; color: #ffffff; font-weight: bold; border: 1px solid #000000;">NAMA SISWA</th>
        <th rowspan="2" align="center" valign="center" style="background-color: #4472c4; color: #ffffff; font-weight: bold; border: 1px solid #000000;">NISN</th>
        <th rowspan="2" align="center" valign="center" style="background-color: #4472c4; color: #ffffff; font-weight: bold; border: 1px solid #000000;">NIS</th>
        @if($subjects->count())
        <th colspan="{{ $subjects->count() }}" align="center" style="background-color: #4472c4; color: #ffffff; font-weight: bold; border: 1px solid #000000;">MATA PELAJARAN</th>
        @endif
        <th rowspan="2" align="center" valign="center" style="background-color: #4472c4; color: #ffffff; font-weight: bold; border: 1px solid #000000;">TTL</th>
        <th colspan="3" align="center" style="background-color: #4472c4; color: #ffffff; font-weight: bold; border: 1px solid #000000;">Ketidakhadiran</th>
        <th rowspan="2" align="center" valign="center" style="background-color: #4472c4; color: #ffffff; font-weight: bold; border: 1px solid #000000;">Ekstr Pramuka</th>
        <th rowspan="2" align="center" valign="center" style="background-color: #4472c4; color: #ffffff; font-weight: bold; border: 1px solid #000000;">Status Kelulusan (lulus/tidak_lulus)</th>
    </tr>
    <tr>
        @foreach($subjects as $s)
        <th align="center" style="background-color: #4472c4; color: #ffffff; font-weight: bold; border: 1px solid #000000;">{{ $s->kode }}</th>
        @endforeach
        <th align="center" style="background-color: #4472c4; color: #ffffff; font-weight: bold; border: 1px solid #000000;">Sakit</th>
        <th align="center" style="background-color: #4472c4; color: #ffffff; font-weight: bold; border: 1px solid #000000;">Izin</th>
        <th align="center" style="background-color: #4472c4; color: #ffffff; font-weight: bold; border: 1px solid #000000;">Alpa</th>
    </tr>
    <!-- Baris contoh -->
    <tr>
        <td align="center" style="border: 1px solid #000000;">1</td>
        <td style="border: 1px solid #000000;">CONTOH NAMA SISWA</td>
        <td style="border: 1px solid #000000;">0012345678</td>
        <td style="border: 1px solid #000000;">240001</td>
        @foreach($subjects as $s)
        <td align="center" style="border: 1px solid #000000;">85</td>
        @endforeach
        <td align="center" style="border: 1px solid #000000;"></td>
        <td align="center" style="border: 1px solid #000000;">0</td>
        <td align="center" style="border: 1px solid #000000;">0</td>
        <td align="center" style="border: 1px solid #000000;">0</td>
        <td align="center" style="border: 1px solid #000000;">B</td>
        <td align="center" style="border: 1px solid #000000;">lulus</td>
    </tr>
</table>

@if($subjects->count())
<table>
    <tr><td><b>KETERANGAN MAPEL :</b></td></tr>
    @foreach($subjects as $s)
    <tr><td>{{ $s->kode }} : {{ $s->nama }}</td></tr>
    @endforeach
</table>
@endif
