@extends('layouts.pengunjung')

@section('title', 'Beranda — Blog Kami')

@section('content')
<div class="row g-4">

    {{-- Kolom kiri: daftar artikel terbaru --}}
    <div class="col-lg-8">
        @forelse ($artikel as $a)
            @include('pengunjung.partials.kartu-artikel', ['a' => $a])
        @empty
            <div class="card card-artikel p-5 text-center text-muted">
                Belum ada artikel{{ $kategoriAktif ? ' pada kategori "' . $kategoriAktif->nama_kategori . '"' : '' }}.
            </div>
        @endforelse
    </div>

    {{-- Kolom kanan: widget kategori --}}
    <div class="col-lg-4" id="kategori">
        @include('pengunjung.partials.widget-kategori')
    </div>

</div>
@endsection
