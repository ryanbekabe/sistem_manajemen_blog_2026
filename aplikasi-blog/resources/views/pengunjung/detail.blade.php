@extends('layouts.pengunjung')

@section('title', $artikel->judul . ' — Blog Kami')

@section('content')

{{-- Breadcrumb: Beranda / Kategori / Judul --}}
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb small">
        <li class="breadcrumb-item">
            <a href="{{ route('pengunjung.index') }}" style="color: var(--green)">Beranda</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('pengunjung.index', ['kategori' => $artikel->id_kategori]) }}" style="color: var(--green)">
                {{ $artikel->kategori->nama_kategori ?? '-' }}
            </a>
        </li>
        <li class="breadcrumb-item active text-muted" aria-current="page">
            {{ \Illuminate\Support\Str::limit($artikel->judul, 40) }}
        </li>
    </ol>
</nav>

<div class="row g-4">

    {{-- Kolom kiri: isi artikel --}}
    <div class="col-lg-8">
        <article class="card card-artikel">
            <img src="{{ $artikel->gambar_url }}" alt="{{ $artikel->judul }}" class="gambar">
            <div class="card-body p-4 p-md-5">
                <span class="badge-kategori">{{ $artikel->kategori->nama_kategori ?? '-' }}</span>

                <h1 class="h3 fw-bold mt-3 mb-3">{{ $artikel->judul }}</h1>

                <div class="d-flex align-items-center gap-2 mb-4">
                    <span class="avatar-inisial">{{ strtoupper(substr($artikel->penulis->nama_depan ?? '?', 0, 1)) }}</span>
                    <div class="small">
                        <div class="fw-semibold text-dark">{{ $artikel->penulis ? $artikel->penulis->nama_lengkap : 'Anonim' }}</div>
                        <div class="text-muted">{{ $artikel->hari_tanggal }}</div>
                    </div>
                </div>

                <div class="fs-6 lh-lg text-secondary">
                    {!! nl2br(e($artikel->isi)) !!}
                </div>

                <hr class="my-4">
                <a href="{{ route('pengunjung.index') }}" class="btn btn-baca">&larr; Kembali ke Beranda</a>
            </div>
        </article>
    </div>

    {{-- Kolom kanan: artikel terkait sekategori --}}
    <div class="col-lg-4">
        <div class="card widget p-3">
            <h2 class="h5 fw-bold mb-3 px-2">Artikel Terkait</h2>

            @forelse ($terkait as $t)
                <a href="{{ route('pengunjung.show', $t->id) }}"
                   class="d-flex gap-3 align-items-center p-2 rounded text-dark terkait-item">
                    <img src="{{ $t->gambar_url }}" alt=""
                         style="width:64px;height:48px;object-fit:cover;border-radius:8px;background:#dfe6ec;flex-shrink:0;">
                    <div>
                        <div class="fw-semibold small lh-sm">{{ \Illuminate\Support\Str::limit($t->judul, 50) }}</div>
                        <div class="text-muted" style="font-size:.75rem">{{ $t->hari_tanggal }}</div>
                    </div>
                </a>
            @empty
                <p class="text-muted small px-2 mb-0">Belum ada artikel terkait.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection
