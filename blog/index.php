<?php
// index.php — Halaman utama Sistem Manajemen Blog (CMS).
declare(strict_types=1);
date_default_timezone_set('Asia/Jakarta');
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sistem Manajemen Blog (CMS)</title>
<style>
    :root {
        --primary: #2563eb;
        --primary-dark: #1d4ed8;
        --danger: #dc2626;
        --danger-dark: #b91c1c;
        --success: #16a34a;
        --bg: #f1f5f9;
        --surface: #ffffff;
        --border: #e2e8f0;
        --text: #1e293b;
        --muted: #64748b;
        --sidebar: #0f172a;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
        font-family: "Segoe UI", system-ui, -apple-system, sans-serif;
        background: var(--bg);
        color: var(--text);
        font-size: 14px;
    }
    /* Header */
    header {
        background: var(--sidebar);
        color: #fff;
        padding: 16px 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        position: sticky;
        top: 0;
        z-index: 50;
        box-shadow: 0 1px 4px rgba(0,0,0,.15);
    }
    header .logo { font-size: 22px; }
    header h1 { font-size: 18px; font-weight: 600; letter-spacing: .3px; }
    header span.sub { color: #94a3b8; font-size: 12px; margin-left: 4px; }
    /* Layout */
    .layout { display: flex; min-height: calc(100vh - 56px); }
    nav {
        width: 240px;
        background: var(--surface);
        border-right: 1px solid var(--border);
        padding: 16px 12px;
        flex-shrink: 0;
    }
    nav .menu-item {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 14px;
        border-radius: 8px;
        cursor: pointer;
        color: var(--muted);
        font-weight: 500;
        margin-bottom: 4px;
        transition: all .15s;
        user-select: none;
    }
    nav .menu-item:hover { background: #f8fafc; color: var(--text); }
    nav .menu-item.active { background: var(--primary); color: #fff; }
    main { flex: 1; padding: 24px; overflow-x: auto; }
    .panel-head {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 18px; flex-wrap: wrap; gap: 12px;
    }
    .panel-head h2 { font-size: 20px; }
    /* Buttons */
    .btn {
        border: none; border-radius: 8px; padding: 9px 16px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        display: inline-flex; align-items: center; gap: 6px;
        transition: background .15s; font-family: inherit;
    }
    .btn-primary { background: var(--primary); color: #fff; }
    .btn-primary:hover { background: var(--primary-dark); }
    .btn-danger { background: var(--danger); color: #fff; }
    .btn-danger:hover { background: var(--danger-dark); }
    .btn-ghost { background: #e2e8f0; color: var(--text); }
    .btn-ghost:hover { background: #cbd5e1; }
    .btn-sm { padding: 6px 10px; font-size: 12px; }
    /* Table */
    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
    }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 12px 14px; text-align: left; border-bottom: 1px solid var(--border); vertical-align: middle; }
    th { background: #f8fafc; font-size: 12px; text-transform: uppercase; letter-spacing: .4px; color: var(--muted); }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover { background: #f8fafc; }
    td.aksi { white-space: nowrap; }
    .avatar { width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border); background:#e2e8f0; }
    .thumb { width: 64px; height: 44px; border-radius: 6px; object-fit: cover; border: 1px solid var(--border); background:#e2e8f0; }
    .badge { background: #e0e7ff; color: #3730a3; padding: 3px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; }
    .muted { color: var(--muted); font-size: 12px; }
    .hash { font-family: "Consolas", "Courier New", monospace; font-size: 12px; color: var(--muted); letter-spacing: .3px; }
    .kosong { text-align: center; padding: 40px; color: var(--muted); }
    .text-clip { max-width: 320px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    /* Modal */
    .modal-overlay {
        position: fixed; inset: 0; background: rgba(15,23,42,.55);
        display: none; align-items: flex-start; justify-content: center;
        padding: 40px 16px; z-index: 100; overflow-y: auto;
    }
    .modal-overlay.show { display: flex; }
    .modal {
        background: var(--surface); border-radius: 14px; width: 100%; max-width: 520px;
        box-shadow: 0 20px 50px rgba(0,0,0,.3); animation: pop .15s ease;
    }
    @keyframes pop { from { transform: translateY(-12px); opacity: 0; } to { transform: none; opacity: 1; } }
    .modal-header { padding: 18px 22px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
    .modal-header h3 { font-size: 17px; }
    .modal-close { background: none; border: none; font-size: 22px; cursor: pointer; color: var(--muted); line-height: 1; }
    .modal-body { padding: 22px; }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 6px; font-size: 13px; }
    .form-group input, .form-group textarea, .form-group select {
        width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px;
        font-size: 14px; font-family: inherit; background: #fff;
    }
    .form-group input:focus, .form-group textarea:focus, .form-group select:focus {
        outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,.15);
    }
    .form-group textarea { resize: vertical; min-height: 90px; }
    .form-row { display: flex; gap: 14px; }
    .form-row .form-group { flex: 1; }
    .preview-foto { width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border); margin-top: 8px; }
    .modal-footer { padding: 16px 22px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; }
    /* Modal konfirmasi hapus */
    .konfirmasi-box { max-width: 380px; text-align: center; padding: 32px 28px 26px; }
    .konfirmasi-ikon {
        width: 72px; height: 72px; border-radius: 50%; background: #fee2e2;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 18px; font-size: 30px; animation: pop .15s ease;
    }
    .konfirmasi-box h3 { font-size: 18px; margin-bottom: 8px; color: var(--text); }
    .konfirmasi-box p { color: var(--muted); font-size: 13px; margin-bottom: 24px; }
    .konfirmasi-aksi { display: flex; gap: 12px; justify-content: center; }
    .konfirmasi-aksi .btn { min-width: 110px; justify-content: center; padding: 11px 18px; }
    /* Toast */
    #toast-wrap { position: fixed; top: 20px; right: 20px; z-index: 200; display: flex; flex-direction: column; gap: 10px; }
    .toast {
        padding: 13px 18px; border-radius: 10px; color: #fff; font-weight: 500; font-size: 13px;
        box-shadow: 0 8px 24px rgba(0,0,0,.2); min-width: 240px; animation: slideIn .2s ease;
    }
    .toast.ok { background: var(--success); }
    .toast.err { background: var(--danger); }
    @keyframes slideIn { from { transform: translateX(40px); opacity: 0; } to { transform: none; opacity: 1; } }
    .spinner { text-align: center; padding: 40px; color: var(--muted); }
    .hint { font-size: 12px; color: var(--muted); margin-top: 4px; }
</style>
</head>
<body>

<header>
    <span class="logo">📝</span>
    <h1>Sistem Manajemen Blog <span class="sub">— CMS</span></h1>
</header>

<div class="layout">
    <nav>
        <div class="menu-item active" data-menu="penulis">👤 Kelola Penulis</div>
        <div class="menu-item" data-menu="artikel">📰 Kelola Artikel</div>
        <div class="menu-item" data-menu="kategori">🏷️ Kelola Kategori Artikel</div>
    </nav>

    <main id="konten">
        <div class="spinner">Memuat…</div>
    </main>
</div>

<!-- Modal generik -->
<div class="modal-overlay" id="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <h3 id="modal-title">Form</h3>
            <button class="modal-close" type="button" onclick="App.tutupModal()">&times;</button>
        </div>
        <form id="modal-form" enctype="multipart/form-data">
            <div class="modal-body" id="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="App.tutupModal()">Batal</button>
                <button type="submit" class="btn btn-primary" id="modal-submit">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal konfirmasi hapus -->
<div class="modal-overlay" id="konfirmasi-overlay">
    <div class="modal konfirmasi-box">
        <div class="konfirmasi-ikon"><span>🗑️</span></div>
        <h3 id="konfirmasi-judul">Hapus data ini?</h3>
        <p id="konfirmasi-teks">Data yang dihapus tidak dapat dikembalikan.</p>
        <div class="konfirmasi-aksi">
            <button type="button" class="btn btn-ghost" id="konfirmasi-batal">Batal</button>
            <button type="button" class="btn btn-danger" id="konfirmasi-ya">Ya, Hapus</button>
        </div>
    </div>
</div>

<div id="toast-wrap"></div>

<script>
const App = (() => {
    "use strict";

    const konten  = document.getElementById('konten');
    const overlay = document.getElementById('modal-overlay');
    const form    = document.getElementById('modal-form');
    let menuAktif = 'penulis';

    // ---------- Util ----------
    function toast(pesan, ok = true) {
        const el = document.createElement('div');
        el.className = 'toast ' + (ok ? 'ok' : 'err');
        el.textContent = pesan;
        document.getElementById('toast-wrap').appendChild(el);
        setTimeout(() => el.remove(), 3200);
    }

    async function ambilJSON(url) {
        const r = await fetch(url);
        return r.json();
    }

    async function kirim(url, formData) {
        const r = await fetch(url, { method: 'POST', body: formData });
        return r.json();
    }

    function bukaModal(judul) {
        document.getElementById('modal-title').textContent = judul;
        overlay.classList.add('show');
    }
    function tutupModal() {
        overlay.classList.remove('show');
        form.reset();
        form.onsubmit = null;
        document.getElementById('modal-body').innerHTML = '';
    }
    overlay.addEventListener('click', e => { if (e.target === overlay) tutupModal(); });

    // Modal konfirmasi hapus — mengembalikan Promise<boolean>.
    const kOverlay = document.getElementById('konfirmasi-overlay');
    const kBatal   = document.getElementById('konfirmasi-batal');
    const kYa      = document.getElementById('konfirmasi-ya');
    function konfirmasi(teks, labelYa = 'Ya, Hapus') {
        document.getElementById('konfirmasi-teks').textContent = teks;
        kYa.textContent = labelYa;
        kOverlay.classList.add('show');
        return new Promise(resolve => {
            function selesai(hasil) {
                kOverlay.classList.remove('show');
                kBatal.onclick = kYa.onclick = null;
                kOverlay.onclick = null;
                resolve(hasil);
            }
            kBatal.onclick = () => selesai(false);
            kYa.onclick    = () => selesai(true);
            kOverlay.onclick = e => { if (e.target === kOverlay) selesai(false); };
        });
    }

    // ================= NAVIGASI =================
    document.querySelectorAll('.menu-item').forEach(item => {
        item.addEventListener('click', () => {
            document.querySelectorAll('.menu-item').forEach(m => m.classList.remove('active'));
            item.classList.add('active');
            menuAktif = item.dataset.menu;
            render();
        });
    });

    function render() {
        if (menuAktif === 'penulis')  return renderPenulis();
        if (menuAktif === 'artikel')  return renderArtikel();
        if (menuAktif === 'kategori') return renderKategori();
    }

    // ================= PENULIS =================
    async function renderPenulis() {
        konten.innerHTML = `
            <div class="panel-head">
                <h2> Data Penulis</h2>
                <button class="btn btn-primary" onclick="App.formPenulis()">+ Tambah Penulis</button>
            </div>
            <div class="card"><div class="spinner">Memuat data…</div></div>`;
        const res = await ambilJSON('ambil_penulis.php');
        const data = res.data || [];
        let baris = data.map(p => `
            <tr>
                <td><img class="avatar" src="${p.foto_url}" alt="foto" onerror="this.src='uploads_penulis/default.png'"></td>
                <td><strong>${p.nama}</strong></td>
                <td>${p.user_name}</td>
                <td><code class="hash">${p.password_preview}</code></td>
                <td class="aksi">
                    <button class="btn btn-ghost btn-sm" onclick="App.formPenulis(${p.id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="App.hapusPenulis(${p.id})">Hapus</button>
                </td>
            </tr>`).join('');
        if (!data.length) baris = `<tr><td colspan="5" class="kosong">Belum ada data penulis.</td></tr>`;
        konten.querySelector('.card').innerHTML = `
            <table>
                <thead><tr><th>Foto</th><th>Nama</th><th>Username</th><th>Password</th><th>Aksi</th></tr></thead>
                <tbody>${baris}</tbody>
            </table>`;
    }

    async function formPenulis(id = null) {
        let d = { nama_depan: '', nama_belakang: '', user_name: '', foto_url: 'uploads_penulis/default.png' };
        if (id) {
            const res = await ambilJSON('ambil_satu_penulis.php?id=' + id);
            if (!res.sukses) return toast(res.pesan, false);
            d = res.data;
        }
        document.getElementById('modal-body').innerHTML = `
            <input type="hidden" name="id" value="${id || ''}">
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Depan</label>
                    <input type="text" name="nama_depan" value="${esc(d.nama_depan)}" required>
                </div>
                <div class="form-group">
                    <label>Nama Belakang</label>
                    <input type="text" name="nama_belakang" value="${esc(d.nama_belakang)}" required>
                </div>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="user_name" value="${esc(d.user_name)}" required>
            </div>
            <div class="form-group">
                <label>Password ${id ? '<span class="muted">(kosongkan bila tidak diubah)</span>' : ''}</label>
                <input type="password" name="password" ${id ? '' : 'required'}>
            </div>
            <div class="form-group">
                <label>Foto Profil <span class="muted">(opsional, maks 2 MB)</span></label>
                <input type="file" name="foto" accept="image/*">
                <img class="preview-foto" src="${d.foto_url}" onerror="this.src='uploads_penulis/default.png'">
            </div>`;
        bukaModal(id ? 'Edit Penulis' : 'Tambah Penulis');
        form.onsubmit = async (e) => {
            e.preventDefault();
            kunci(true);
            const res = await kirim(id ? 'update_penulis.php' : 'simpan_penulis.php', new FormData(form));
            kunci(false);
            toast(res.pesan, res.sukses);
            if (res.sukses) { tutupModal(); renderPenulis(); }
        };
    }

    async function hapusPenulis(id) {
        if (!await konfirmasi('Data penulis yang dihapus tidak dapat dikembalikan.')) return;
        const fd = new FormData(); fd.append('id', id);
        const res = await kirim('hapus_penulis.php', fd);
        toast(res.pesan, res.sukses);
        if (res.sukses) renderPenulis();
    }

    // ================= KATEGORI =================
    async function renderKategori() {
        konten.innerHTML = `
            <div class="panel-head">
                <h2> Data Kategori Artikel</h2>
                <button class="btn btn-primary" onclick="App.formKategori()">+ Tambah Kategori</button>
            </div>
            <div class="card"><div class="spinner">Memuat data…</div></div>`;
        const res = await ambilJSON('ambil_kategori.php');
        const data = res.data || [];
        let baris = data.map(k => `
            <tr>
                <td><strong>${k.nama_kategori}</strong></td>
                <td class="muted">${k.keterangan || '<em>—</em>'}</td>
                <td class="aksi">
                    <button class="btn btn-ghost btn-sm" onclick="App.formKategori(${k.id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="App.hapusKategori(${k.id})">Hapus</button>
                </td>
            </tr>`).join('');
        if (!data.length) baris = `<tr><td colspan="3" class="kosong">Belum ada data kategori.</td></tr>`;
        konten.querySelector('.card').innerHTML = `
            <table>
                <thead><tr><th>Nama Kategori</th><th>Keterangan</th><th>Aksi</th></tr></thead>
                <tbody>${baris}</tbody>
            </table>`;
    }

    async function formKategori(id = null) {
        let d = { nama_kategori: '', keterangan: '' };
        if (id) {
            const res = await ambilJSON('ambil_satu_kategori.php?id=' + id);
            if (!res.sukses) return toast(res.pesan, false);
            d = res.data;
        }
        document.getElementById('modal-body').innerHTML = `
            <input type="hidden" name="id" value="${id || ''}">
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama_kategori" value="${esc(d.nama_kategori)}" required>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan">${esc(d.keterangan)}</textarea>
            </div>`;
        bukaModal(id ? 'Edit Kategori' : 'Tambah Kategori');
        form.onsubmit = async (e) => {
            e.preventDefault();
            kunci(true);
            const res = await kirim(id ? 'update_kategori.php' : 'simpan_kategori.php', new FormData(form));
            kunci(false);
            toast(res.pesan, res.sukses);
            if (res.sukses) { tutupModal(); renderKategori(); }
        };
    }

    async function hapusKategori(id) {
        if (!await konfirmasi('Data kategori yang dihapus tidak dapat dikembalikan.')) return;
        const fd = new FormData(); fd.append('id', id);
        const res = await kirim('hapus_kategori.php', fd);
        toast(res.pesan, res.sukses);
        if (res.sukses) renderKategori();
    }

    // ================= ARTIKEL =================
    async function renderArtikel() {
        konten.innerHTML = `
            <div class="panel-head">
                <h2> Data Artikel</h2>
                <button class="btn btn-primary" onclick="App.formArtikel()">+ Tambah Artikel</button>
            </div>
            <div class="card"><div class="spinner">Memuat data…</div></div>`;
        const res = await ambilJSON('ambil_artikel.php');
        const data = res.data || [];
        let baris = data.map(a => `
            <tr>
                <td><img class="thumb" src="${a.gambar_url}" alt="gambar" onerror="this.style.visibility='hidden'"></td>
                <td><strong>${a.judul}</strong><div class="muted text-clip">${a.isi}</div></td>
                <td><span class="badge">${a.nama_kategori}</span></td>
                <td>${a.nama_penulis}</td>
                <td class="muted">${a.hari_tanggal}</td>
                <td class="aksi">
                    <button class="btn btn-ghost btn-sm" onclick="App.formArtikel(${a.id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="App.hapusArtikel(${a.id})">Hapus</button>
                </td>
            </tr>`).join('');
        if (!data.length) baris = `<tr><td colspan="6" class="kosong">Belum ada data artikel.</td></tr>`;
        konten.querySelector('.card').innerHTML = `
            <table>
                <thead><tr><th>Gambar</th><th>Judul</th><th>Kategori</th><th>Penulis</th><th>Tanggal</th><th>Aksi</th></tr></thead>
                <tbody>${baris}</tbody>
            </table>`;
    }

    async function formArtikel(id = null) {
        // Muat dropdown penulis & kategori secara paralel.
        const [rp, rk] = await Promise.all([
            ambilJSON('ambil_penulis.php'),
            ambilJSON('ambil_kategori.php'),
        ]);
        const penulis  = rp.data || [];
        const kategori = rk.data || [];

        if (!penulis.length || !kategori.length) {
            return toast('Tambahkan minimal 1 penulis dan 1 kategori terlebih dahulu.', false);
        }

        let d = { id_penulis: '', id_kategori: '', judul: '', isi: '', gambar_url: '' };
        if (id) {
            const res = await ambilJSON('ambil_satu_artikel.php?id=' + id);
            if (!res.sukses) return toast(res.pesan, false);
            d = res.data;
        }

        const optP = penulis.map(p => `<option value="${p.id}" ${p.id == d.id_penulis ? 'selected' : ''}>${p.nama}</option>`).join('');
        const optK = kategori.map(k => `<option value="${k.id}" ${k.id == d.id_kategori ? 'selected' : ''}>${k.nama_kategori}</option>`).join('');

        document.getElementById('modal-body').innerHTML = `
            <input type="hidden" name="id" value="${id || ''}">
            <div class="form-group">
                <label>Judul</label>
                <input type="text" name="judul" value="${esc(d.judul)}" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Penulis</label>
                    <select name="id_penulis" required><option value="">-- pilih --</option>${optP}</select>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="id_kategori" required><option value="">-- pilih --</option>${optK}</select>
                </div>
            </div>
            <div class="form-group">
                <label>Isi Artikel</label>
                <textarea name="isi" required>${esc(d.isi)}</textarea>
            </div>
            <div class="form-group">
                <label>Gambar Artikel ${id ? '<span class="muted">(kosongkan bila tidak diubah)</span>' : '<span class="muted">(wajib, maks 2 MB)</span>'}</label>
                <input type="file" name="gambar" accept="image/*" ${id ? '' : 'required'}>
                ${id && d.gambar_url ? `<img class="thumb" style="margin-top:8px;width:120px;height:80px" src="${d.gambar_url}" onerror="this.style.display='none'">` : ''}
            </div>
            <p class="hint">Tanggal akan diisi otomatis oleh server (Asia/Jakarta).</p>`;
        bukaModal(id ? 'Edit Artikel' : 'Tambah Artikel');
        form.onsubmit = async (e) => {
            e.preventDefault();
            kunci(true);
            const res = await kirim(id ? 'update_artikel.php' : 'simpan_artikel.php', new FormData(form));
            kunci(false);
            toast(res.pesan, res.sukses);
            if (res.sukses) { tutupModal(); renderArtikel(); }
        };
    }

    async function hapusArtikel(id) {
        if (!await konfirmasi('Artikel beserta gambarnya akan dihapus dan tidak dapat dikembalikan.')) return;
        const fd = new FormData(); fd.append('id', id);
        const res = await kirim('hapus_artikel.php', fd);
        toast(res.pesan, res.sukses);
        if (res.sukses) renderArtikel();
    }

    // ---------- helper kecil ----------
    function esc(s) {
        return String(s ?? '').replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }
    function kunci(on) {
        const b = document.getElementById('modal-submit');
        b.disabled = on;
        b.textContent = on ? 'Menyimpan…' : 'Simpan';
    }

    // ---------- init ----------
    render();

    return { formPenulis, hapusPenulis, formKategori, hapusKategori, formArtikel, hapusArtikel, tutupModal };
})();
</script>
</body>
</html>
