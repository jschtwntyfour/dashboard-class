<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>SMK Cinta Kasih Tzu Chi</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: Arial, sans-serif;
      background-color: #f0f4f8;
      color: #222;
    }

    /* ===== NAVBAR ===== */
    .navbar {
      position: absolute;
      top: 0; left: 0; right: 0;
      z-index: 10;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 40px;
      background-color: rgba(0, 0, 0, 0.45);
    }

    .navbar-kiri {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .navbar-kiri img {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #fff;
    }

    .navbar-kiri .nama-sekolah {
      color: #fff;
      font-size: 15px;
      font-weight: bold;
      line-height: 1.3;
    }

    .navbar-kiri .sub-sekolah {
      color: #ddd;
      font-size: 11px;
    }

    .tombol-login {
      background-color: #e94560;
      color: #fff;
      padding: 9px 22px;
      border-radius: 6px;
      text-decoration: none;
      font-size: 14px;
      font-weight: bold;
      border: 2px solid #fff;
      transition: background-color 0.2s;
    }

    .tombol-login:hover {
      background-color: #c73652;
    }

    /* ===== HERO ===== */
    .hero {
      position: relative;
      width: 100%;
      height: 100vh;
      background-color: #1a1a2e;
      overflow: hidden;
    }

    /* foto SMK sebagai background hero */
    .hero img.bg {
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0.45;
      position: absolute;
      top: 0; left: 0;
    }

    /* overlay gelap di atas foto */
    .hero-overlay {
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.7));
    }

    /* teks di tengah hero */
    .hero-teks {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      color: #fff;
      width: 90%;
    }

    .hero-teks h1 {
      font-size: 38px;
      font-weight: bold;
      margin-bottom: 12px;
      text-shadow: 2px 2px 8px rgba(0,0,0,0.6);
    }

    .hero-teks p {
      font-size: 16px;
      color: #ddd;
      margin-bottom: 28px;
      text-shadow: 1px 1px 4px rgba(0,0,0,0.5);
    }

    .hero-teks a {
      background-color: #e94560;
      color: #fff;
      padding: 12px 32px;
      border-radius: 8px;
      text-decoration: none;
      font-size: 15px;
      font-weight: bold;
    }

    .hero-teks a:hover {
      background-color: #c73652;
    }

    /* ===== SEKSI INFO ===== */
    .seksi-info {
      padding: 60px 40px;
      text-align: center;
      background-color: #fff;
    }

    .seksi-info h2 {
      font-size: 24px;
      color: #1a1a2e;
      margin-bottom: 10px;
    }

    .seksi-info p {
      color: #555;
      font-size: 14px;
      max-width: 600px;
      margin: 0 auto 40px;
      line-height: 1.7;
    }

    .kartu-grid {
      display: flex;
      justify-content: center;
      gap: 24px;
      flex-wrap: wrap;
    }

    .kartu {
      background-color: #f0f4f8;
      border-radius: 10px;
      padding: 28px 24px;
      width: 200px;
      text-align: center;
      border: 1px solid #dde3ea;
    }

    .kartu .ikon {
      font-size: 36px;
      margin-bottom: 12px;
    }

    .kartu h3 {
      font-size: 15px;
      color: #1a1a2e;
      margin-bottom: 6px;
    }

    .kartu p {
      font-size: 12px;
      color: #777;
      margin: 0;
    }

    /* ===== FOOTER ===== */
    .footer {
      background-color: #1a1a2e;
      color: #aaa;
      text-align: center;
      padding: 20px;
      font-size: 13px;
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
  <div class="navbar-kiri">
    <!-- ganti src dengan foto logo sekolah lo -->
    <img src="data:image/jpeg;base64,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" alt="Logo">
    <div>
      <div class="nama-sekolah">SMK Cinta Kasih Tzu Chi</div>
      <div class="sub-sekolah">Jakarta Barat</div>
    </div>
  </div>
  <a href="login.php" class="tombol-login">Login</a>
</div>

<!-- HERO — ganti src foto dengan foto gedung SMK lo -->
<div class="hero">
  <img class="bg"
      src="https://assets-a1.kompasiana.com/items/album/2022/10/14/lapangan-outdoor-6348c461d287dd47056fdda2.jpg?t=o&v=780"
      alt="Foto SMK">
  <!-- ↑ GANTI URL DI ATAS dengan foto gedung SMK Cinta Kasih Tzu Chi -->
  <!-- Contoh: src="foto_smk.jpg" kalau fotonya sudah lo simpan di folder yang sama -->

  <div class="hero-overlay"></div>
  <div class="hero-teks">
    <h1>SMK Cinta Kasih Tzu Chi</h1>
    <p>Sistem Informasi Sekolah - Kelola data siswa, nilai, absensi, dan jadwal dengan mudah</p>
    <a href="login.php">Masuk ke Sistem</a>
  </div>
</div>

<!-- SEKSI INFO -->
<div class="seksi-info">
  <h2>Fitur Sistem Informasi Sekolah</h2>
  <p>Platform digital SMK Cinta Kasih Tzu Chi untuk memudahkan guru dan siswa dalam kegiatan belajar mengajar.</p>
  <div class="kartu-grid">
    <div class="kartu">
      <div class="ikon">👤</div>
      <h3>Data Siswa</h3>
      <p>Kelola data siswa secara lengkap</p>
    </div>
    <div class="kartu">
      <div class="ikon">📊</div>
      <h3>Nilai Raport</h3>
      <p>Input dan pantau nilai per mapel</p>
    </div>
    <div class="kartu">
      <div class="ikon">📅</div>
      <h3>Absensi</h3>
      <p>Rekap kehadiran harian siswa</p>
    </div>
    <div class="kartu">
      <div class="ikon">📝</div>
      <h3>Tugas & Ujian</h3>
      <p>Info tugas, UH, dan agenda kelas</p>
    </div>
  </div>
</div>

<!-- FOOTER -->
<div class="footer">
  &copy; 2025 SMK Cinta Kasih Tzu Chi — Sistem Informasi Sekolah
</div>

</body>
</html>
