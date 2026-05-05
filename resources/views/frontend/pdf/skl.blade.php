<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page { margin: 0.8cm 1.2cm; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10.5pt;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }
        .header-container {
            width: 100%;
            margin-bottom: 5px;
            text-align: center;
        }
        .kop-surat {
            width: 100%;
            max-height: 110px;
        }
        .content {
            padding: 0 20px;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            text-decoration: underline;
            margin-bottom: 1px;
        }
        .subtitle {
            text-align: center;
            margin-bottom: 10px;
            font-size: 10.5pt;
        }
        .table-data {
            width: 100%;
            margin-bottom: 8px;
        }
        .table-data td {
            padding: 1px 0;
            vertical-align: top;
        }
        .status-box {
            text-align: center;
            font-weight: bold;
            font-size: 13pt;
            margin: 8px 0;
            padding: 5px;
            border: 1.5px solid #000;
            text-transform: uppercase;
        }
        .table-nilai {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .table-nilai th, .table-nilai td {
            border: 1px solid #000;
            padding: 3px 6px;
            text-align: center;
        }
        .table-nilai th {
            background-color: #f2f2f2;
        }
        .signature-container {
            float: right;
            width: 220px;
            margin-top: 10px;
            text-align: left;
            position: relative;
        }
        .qr-code {
            width: 75px;
            height: 75px;
            margin: 3px 0;
        }
        .manual-signature {
            width: 150px;
            height: auto;
            margin: 5px 0;
            display: block;
        }
        .stamp-img {
            position: absolute;
            width: 90px;
            left: -30px;
            top: 10px;
            opacity: 0.8;
            z-index: -1;
        }
        .clear {
            clear: both;
        }
        p { margin: 3px 0; }
    </style>
</head>
<body>
    <div class="header-container">
        @if($kop_base64)
            <img src="{{ $kop_base64 }}" class="kop-surat">
        @else
            <h2 style="margin:0; text-transform: uppercase; font-size: 14pt;">{{ $setting->school_name }}</h2>
            <hr style="border: 1px solid #000; margin-top: 3px;">
        @endif
    </div>

    <div class="content">
        <div class="title">SURAT KETERANGAN LULUS</div>
        <div class="subtitle">Nomor: {{ $skl_number }}</div>

        <p style="text-align: justify;">{{ $setting->skl_template ?? 'Berdasarkan hasil rapat pleno dewan guru dan mengacu pada kriteria kenaikan kelas yang telah ditetapkan, siswa yang bersangkutan dinyatakan:' }}</p>

        <table class="table-data">
            <tr>
                <td width="25%">Nama Lengkap</td>
                <td width="3%">:</td>
                <td><strong>{{ $student->nama_lengkap }}</strong></td>
            </tr>
            <tr>
                <td>NISN</td>
                <td>:</td>
                <td>{{ $student->nisn }}</td>
            </tr>
            <tr>
                <td>NIS</td>
                <td>:</td>
                <td>{{ $student->nomor_peserta }}</td>
            </tr>
        </table>

        <div class="status-box">
            {{ str_replace('_', ' ', $student->status_kelulusan) }}
        </div>

        <p>Dengan rincian nilai sebagai berikut:</p>

        <table class="table-nilai">
            <thead>
                <tr>
                    <th width="8%">No</th>
                    <th>Mata Pelajaran</th>
                    <th width="18%">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach($subjects as $s)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td style="text-align: left;">{{ $s->nama }}</td>
                    <td>{{ $student->nilai_ujian[$s->kode] ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="font-weight: bold;">
                    <td colspan="2">TOTAL NILAI (TTL)</td>
                    <td>{{ $student->nilai_ujian['TTL'] ?? '-' }}</td>
                </tr>
            </tfoot>
        </table>

        <p>{{ $setting->skl_closing ?? 'Demikian surat keterangan ini diberikan agar dapat dipergunakan sebagaimana mestinya.' }}</p>

        <div class="signature-container">
            <div>{{ $setting->school_address_city ?? 'Kota' }}, {{ $skl_date }}</div>
            <div>Kepala Sekolah,</div>
            
            <div style="height: 85px; position: relative;">
                @if($setting->signature_type == 'qr')
                    <img src="{{ $qrcode_base64 }}" class="qr-code">
                @else
                    @if($stamp_base64)
                        <img src="{{ $stamp_base64 }}" class="stamp-img">
                    @endif
                    @if($signature_base64)
                        <img src="{{ $signature_base64 }}" class="manual-signature">
                    @endif
                @endif
            </div>

            <div><strong>{{ $setting->principal_name }}</strong></div>
            <div>NIP. {{ $setting->principal_nip ?? '-' }}</div>
        </div>
        <div class="clear"></div>
        
        <div style="margin-top: 15px; font-size: 7.5pt; color: #444; font-style: italic; border-top: 0.5px solid #ccc; padding-top: 3px; text-align: center;">
            {{ $setting->skl_footer ?? '* Dokumen ini diterbitkan secara elektronik. Verifikasi keaslian dapat dilakukan dengan memindai kode QR di atas.' }}
        </div>
    </div>
</body>
</html>
