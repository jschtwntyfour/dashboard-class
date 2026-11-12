<?php
session_start();
include 'koneksi.php';

// cek apakah sudah login sebagai siswa
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'siswa') {
    header("Location: login.php");
    exit;
}

// tentukan halaman aktif
$halaman = isset($_GET['hal']) ? $_GET['hal'] : 'nilai';

// ambil id_siswa berdasarkan username yang login
// (asumsi: username siswa1 = siswa id 1, siswa2 = id 2, dst)
// cara sederhana: cari siswa berdasarkan urutan username
$usernameLogin = $_SESSION['username'];
// ambil angka di belakang "siswa"
$nomorSiswa = (int) str_replace('siswa', '', $usernameLogin);
$resultCariSiswa = mysqli_query($koneksi, "SELECT * FROM siswa LIMIT 1 OFFSET " . ($nomorSiswa - 1));
$dataSiswaLogin  = mysqli_fetch_assoc($resultCariSiswa);

// ============================================================
// DATA NILAI SISWA
// ============================================================
if ($halaman == 'nilai' && $dataSiswaLogin) {
    $idSiswa     = $dataSiswaLogin['id'];
    $resultNilai = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_siswa='$idSiswa'");
}

// ============================================================
// DATA TUGAS (filter per mapel kalau ada)
// ============================================================
if ($halaman == 'tugas') {
    $filterMapel = isset($_GET['mapel']) ? $_GET['mapel'] : '';

    if ($filterMapel != '') {
        $resultTugas = mysqli_query($koneksi, "SELECT * FROM tugas WHERE mapel='$filterMapel' ORDER BY tanggal DESC");
    } else {
        $resultTugas = mysqli_query($koneksi, "SELECT * FROM tugas ORDER BY tanggal DESC");
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Siswa</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: Arial, sans-serif; background-color: #1a1a2e; color: #eaeaea; min-height: 100vh; }

    /* NAVBAR */
    .navbar {
      background-color: #16213e;
      border-bottom: 3px solid #3fb950;
      padding: 0 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 58px;
    }
    .navbar-kiri span  { font-size: 16px; font-weight: bold; color: #3fb950; }
    .navbar-kiri small { font-size: 11px; color: #aaa; margin-left: 10px; }
    .navbar-kanan      { display: flex; align-items: center; gap: 14px; font-size: 13px; color: #aaa; }
    .navbar-kanan a    { color: #e94560; text-decoration: none; font-weight: bold; font-size: 13px; }
    .navbar-kanan a:hover { color: #c73652; }

    /* MENU */
    .menu {
      background-color: #16213e;
      display: flex;
      gap: 4px;
      padding: 10px 30px;
      border-bottom: 1px solid #0f3460;
    }
    .menu a {
      padding: 8px 18px;
      border-radius: 6px;
      text-decoration: none;
      font-size: 13px;
      font-weight: bold;
      color: #aaa;
    }
    .menu a:hover { background-color: rgba(63,185,80,0.1); color: #eaeaea; }
    .menu a.aktif { background-color: #3fb950; color: #1a1a2e; }

    /* KONTEN */
    .konten { padding: 28px 30px; }
    h2 { color: #3fb950; margin-bottom: 20px; font-size: 20px; }

    /* KARTU INFO SISWA */
    .kartu-siswa {
      background-color: #16213e;
      border: 1px solid #0f3460;
      border-left: 4px solid #3fb950;
      border-radius: 10px;
      padding: 16px 20px;
      margin-bottom: 24px;
      max-width: 420px;
      font-size: 13px;
    }
    .kartu-siswa h3  { color: #eaeaea; font-size: 15px; margin-bottom: 6px; }
    .kartu-siswa span { color: #aaa; }

    /* TABEL */
    table { width: 100%; border-collapse: collapse; background-color: #16213e; border-radius: 10px; overflow: hidden; margin-bottom: 20px; }
    th { background-color: #0f3460; padding: 11px 16px; text-align: left; font-size: 12px; color: #aaa; }
    td { padding: 11px 16px; font-size: 13px; border-bottom: 1px solid #0f3460; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background-color: #1e2a4a; }

    .nilai-angka { font-weight: bold; font-size: 15px; }
    .hijau  { color: #3fb950; }
    .kuning { color: #d29922; }
    .merah  { color: #e94560; }

    /* RATA-RATA */
    .kotak-rata {
      background-color: #0f3460;
      border-radius: 8px;
      padding: 14px 20px;
      display: inline-block;
      margin-top: 6px;
      font-size: 14px;
    }
    .kotak-rata b { font-size: 22px; }

    /* FILTER MAPEL */
    .filter-mapel {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
      margin-bottom: 20px;
    }
    .filter-mapel a {
      padding: 7px 14px;
      border-radius: 6px;
      text-decoration: none;
      font-size: 12px;
      font-weight: bold;
      color: #aaa;
      border: 1px solid #0f3460;
      background-color: #16213e;
    }
    .filter-mapel a:hover { border-color: #3fb950; color: #eaeaea; }
    .filter-mapel a.aktif { background-color: #3fb950; color: #1a1a2e; border-color: #3fb950; }

    /* BADGE */
    .badge { display: inline-block; padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: bold; }
    .b-tugas  { background-color: rgba(88,166,255,0.15);  color: #58a6ff; }
    .b-uh     { background-color: rgba(233,69,96,0.15);   color: #e94560; }
    .b-agenda { background-color: rgba(63,185,80,0.15);   color: #3fb950; }

    .isi-tugas { font-size: 12px; color: #aaa; margin-top: 3px; }
  </style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
  <div class="navbar-kiri">
    <span>SISKO</span>
    <small>SMK Cinta Kasih Tzu Chi</small>
  </div>
  <div class="navbar-kanan">
    🎒 <?php echo $_SESSION['username']; ?> &nbsp;|&nbsp;
    <a href="logout.php">Logout</a>
  </div>
</div>

<!-- MENU -->
<div class="menu">
  <a href="dashboard_siswa.php?hal=nilai" class="<?php echo $halaman=='nilai' ? 'aktif' : ''; ?>">📊 Nilai Saya</a>
  <a href="dashboard_siswa.php?hal=tugas" class="<?php echo $halaman=='tugas' ? 'aktif' : ''; ?>">📝 Tugas & Ujian</a>
</div>

<div class="konten">

<!-- ======== HALAMAN NILAI ======== -->
<?php if ($halaman == 'nilai'): ?>
  <h2>Nilai Raport Saya</h2>

  <!-- Info siswa -->
  <?php if ($dataSiswaLogin): ?>
    <div class="kartu-siswa">
      <h3><?php echo $dataSiswaLogin['nama']; ?></h3>
      <span>NISN: <?php echo $dataSiswaLogin['nisn']; ?></span> &nbsp;·&nbsp;
      <span>Kelas: <?php echo $dataSiswaLogin['kelas']; ?></span>
    </div>

    <!-- Tabel Nilai -->
    <table>
      <thead>
        <tr><th>No</th><th>Mata Pelajaran</th><th>Nilai</th><th>Keterangan</th></tr>
      </thead>
      <tbody>
        <?php
          $no    = 1;
          $total = 0;
          $jml   = 0;
          while ($n = mysqli_fetch_assoc($resultNilai)):
            $total += $n['nilai'];
            $jml++;
            // tentukan warna dan keterangan nilai
            if ($n['nilai'] >= 90)      { $warna = 'hijau';  $ket = 'Sangat Baik'; }
            elseif ($n['nilai'] >= 75)  { $warna = 'hijau';  $ket = 'Baik'; }
            elseif ($n['nilai'] >= 60)  { $warna = 'kuning'; $ket = 'Cukup'; }
            else                        { $warna = 'merah';  $ket = 'Kurang'; }
        ?>
        <tr>
          <td><?php echo $no++; ?></td>
          <td><?php echo $n['mapel']; ?></td>
          <td><span class="nilai-angka <?php echo $warna; ?>"><?php echo $n['nilai']; ?></span></td>
          <td><?php echo $ket; ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <?php if ($jml > 0):
      $rata = $total / $jml;
      if ($rata >= 90)     { $ketRata = 'Sangat Baik'; $wRata = 'hijau'; }
      elseif ($rata >= 75) { $ketRata = 'Baik';        $wRata = 'hijau'; }
      elseif ($rata >= 60) { $ketRata = 'Cukup';       $wRata = 'kuning'; }
      else                 { $ketRata = 'Kurang';       $wRata = 'merah'; }
    ?>
      <div class="kotak-rata">
        Rata-rata: <b class="<?php echo $wRata; ?>"><?php echo number_format($rata, 1); ?></b>
        &nbsp;—&nbsp; <?php echo $ketRata; ?>
      </div>
    <?php endif; ?>

  <?php else: ?>
    <p style="color:#aaa;">Data siswa tidak ditemukan.</p>
  <?php endif; ?>

<!-- ======== HALAMAN TUGAS ======== -->
<?php elseif ($halaman == 'tugas'): ?>
  <h2>Tugas, Ujian Harian & Agenda</h2>

  <!-- Filter per Mapel -->
  <div class="filter-mapel">
    <a href="dashboard_siswa.php?hal=tugas" class="<?php echo $filterMapel=='' ? 'aktif' : ''; ?>">Semua</a>
    <?php
      $mapelList = ['Matematika','Bahasa Indonesia','Bahasa Inggris','Pemrograman Web','Basis Data'];
      foreach ($mapelList as $m) {
        $aktif = ($filterMapel == $m) ? 'aktif' : '';
        echo "<a href='dashboard_siswa.php?hal=tugas&mapel=$m' class='$aktif'>$m</a>";
      }
    ?>
  </div>

  <!-- Tabel Tugas -->
  <table>
    <thead>
      <tr><th>No</th><th>Mapel</th><th>Judul</th><th>Keterangan</th><th>Jenis</th><th>Tanggal</th></tr>
    </thead>
    <tbody>
      <?php $no = 1; while ($t = mysqli_fetch_assoc($resultTugas)): ?>
      <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo $t['mapel']; ?></td>
        <td>
          <?php echo $t['judul']; ?>
          <div class="isi-tugas"><?php echo $t['isi']; ?></div>
        </td>
        <td><?php echo $t['isi']; ?></td>
        <td>
          <?php
            if ($t['jenis'] == 'Tugas')        echo "<span class='badge b-tugas'>Tugas</span>";
            if ($t['jenis'] == 'Ujian Harian')  echo "<span class='badge b-uh'>Ujian Harian</span>";
            if ($t['jenis'] == 'Agenda')        echo "<span class='badge b-agenda'>Agenda</span>";
          ?>
        </td>
        <td><?php echo $t['tanggal']; ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

<?php endif; ?>

</div>
</body>
</html>
