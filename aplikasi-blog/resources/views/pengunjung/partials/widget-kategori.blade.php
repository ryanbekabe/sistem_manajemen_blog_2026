{{-- Widget daftar kategori + jumlah artikel (penyaring) --}}
<div class="card widget p-3">
    <h2 class="h5 fw-bold mb-3 px-2">Kategori Artikel</h2>

    <div class="list-group list-group-flush">
        <a href="{{ route('pengunjung.index') }}"
           class="list-group-item {{ ! $idKategori ? 'active' : '' }}">
            Semua Artikel <span class="badge">{{ $totalArtikel }}</span>
        </a>

        @foreach ($kategori as $k)
            <a href="{{ route('pengunjung.index', ['kategori' => $k->id]) }}"
               class="list-group-item {{ (int) $idKategori === $k->id ? 'active' : '' }}">
                {{ $k->nama_kategori }} <span class="badge">{{ $k->artikel_count }}</span>
            </a>
        @endforeach
    </div>
</div>
