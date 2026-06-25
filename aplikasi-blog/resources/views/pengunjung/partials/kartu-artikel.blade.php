{{-- Kartu satu artikel (dipakai di halaman utama) --}}
<article class="card card-artikel mb-4">
    <img src="{{ $a->gambar_url }}" alt="{{ $a->judul }}" class="gambar">
    <div class="card-body p-4">
        <span class="badge-kategori">{{ $a->kategori->nama_kategori ?? '-' }}</span>

        <h2 class="h4 fw-bold mt-3 mb-2">
            <a href="{{ route('pengunjung.show', $a->id) }}" class="text-dark">{{ $a->judul }}</a>
        </h2>

        <div class="d-flex align-items-center gap-2 mb-3 text-muted small">
            <span class="avatar-inisial">{{ strtoupper(substr($a->penulis->nama_depan ?? '?', 0, 1)) }}</span>
            <span>{{ $a->penulis ? $a->penulis->nama_lengkap : 'Anonim' }}</span>
            <span>&middot;</span>
            <span>{{ $a->hari_tanggal }}</span>
        </div>

        <p class="text-secondary mb-3">{{ $a->ringkasan }}</p>

        <a href="{{ route('pengunjung.show', $a->id) }}" class="btn btn-baca">Baca Selengkapnya &rarr;</a>
    </div>
</article>
