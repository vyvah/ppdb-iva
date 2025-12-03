@extends('layouts.dashboard')
@section('title', 'Pengumuman')

@section('content')

    <div class="container-modern" style="padding:20px">

        <div class="header-modern" style="padding:20px;margin-bottom:20px">
            <h2>Pengumuman</h2>
            <p class="text-muted mb-0">Daftar pengumuman resmi. Lihat hasil seleksi Anda di bagian "Hasil Saya".</p>
        </div>

        {{-- Hasil Pengumuman untuk User --}}
        @if(isset($userPengumuman) && $userPengumuman)
            <div class="card-modern" style="margin-bottom:20px; padding:18px; border:1px solid #ececec;">
                <h4>Hasil Saya</h4>
                <p><strong>Nama:</strong> {{ $userPengumuman->nama_peserta ?? '-' }}</p>
                <p><strong>Nomor Pendaftaran:</strong> {{ $userPengumuman->nomor_pendaftaran ?? '-' }}</p>
                <p><strong>Status:</strong>
                    @if($userPengumuman->status_hasil === 'diterima')
                        <span class="badge bg-success">Diterima</span>
                    @elseif($userPengumuman->status_hasil === 'cadangan')
                        <span class="badge bg-warning">Cadangan</span>
                    @else
                        <span class="badge bg-danger">Tidak Diterima</span>
                    @endif
                </p>
                @if($userPengumuman->nilai_akhir)
                    <p><strong>Nilai Akhir:</strong> {{ $userPengumuman->nilai_akhir }}</p>
                @endif
                @if($userPengumuman->pesan_pengumuman)
                    <p><strong>Pesan:</strong> {!! nl2br(e($userPengumuman->pesan_pengumuman)) !!}</p>
                @endif
                <p class="text-muted"><small>Dipublikasikan: {{ optional($userPengumuman->tanggal_pengumuman)->format('d M Y H:i') ?? '-' }}</small></p>
            </div>
        @else
            <div class="alert alert-info">Belum ada pengumuman khusus untuk Anda.</div>
        @endif

        {{-- Daftar Pengumuman Publik --}}
        <div class="card-modern" style="padding:18px; border:1px solid #ececec;">
            <h4>Pengumuman Publik</h4>

            @forelse($pengumans as $p)
                <div style="border-bottom:1px dashed #eee; padding:12px 0">
                    <h5 style="margin:0">{{ $p->nama_peserta ?? ($p->nomor_pendaftaran ?? 'Pengumuman') }}</h5>
                    <p style="margin:4px 0; color:#6b7280">{{ optional($p->tanggal_pengumuman)->format('d M Y') }}</p>
                    @if($p->pesan_pengumuman)
                        <p style="margin:6px 0">{{ Str::limit($p->pesan_pengumuman, 240) }}</p>
                    @endif
                    <p style="margin:6px 0"><strong>Status:</strong>
                        @if($p->status_hasil === 'diterima')
                            <span class="badge bg-success">Diterima</span>
                        @elseif($p->status_hasil === 'cadangan')
                            <span class="badge bg-warning">Cadangan</span>
                        @else
                            <span class="badge bg-danger">Tidak Diterima</span>
                        @endif
                    </p>
                </div>
            @empty
                <p>Tidak ada pengumuman dipublikasikan saat ini.</p>
            @endforelse

            <div style="margin-top:12px">
                {{ $pengumans->links() }}
            </div>
        </div>

    </div>

@endsection
