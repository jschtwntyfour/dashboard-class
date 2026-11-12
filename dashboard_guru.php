<?php
session_start();
include 'koneksi.php';

// cek apakah sudah login sebagai guru
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'guru') {
    header("Location: login.php");
    exit;
}

// tentukan halaman aktif (default: siswa)
$halaman = isset($_GET['hal']) ? $_GET['hal'] : 'siswa';

// ============================================================
// PROSES CRUD SISWA
// ============================================================
if ($halaman == 'siswa') {

    // TAMBAH SISWA
    if (isset($_POST['aksi']) && $_POST['aksi'] == 'tambah') {
        $nama  = $_POST['nama'];
        $nisn  = $_POST['nisn'];
        $kelas = $_POST['kelas'];
        $jk    = $_POST['jk'];
        $q = "INSERT INTO siswa (nama, nisn, kelas, jk) VALUES ('$nama','$nisn','$kelas','$jk')";
        mysqli_query($koneksi, $q);
        header("Location: dashboard_guru.php?hal=siswa&pesan=tambah");
        exit;
    }

    // EDIT SISWA
    if (isset($_POST['aksi']) && $_POST['aksi'] == 'edit') {
        $id    = $_POST['id'];
        $nama  = $_POST['nama'];
        $nisn  = $_POST['nisn'];
        $kelas = $_POST['kelas'];
        $jk    = $_POST['jk'];
        $q = "UPDATE siswa SET nama='$nama', nisn='$nisn', kelas='$kelas', jk='$jk' WHERE id='$id'";
        mysqli_query($koneksi, $q);
        header("Location: dashboard_guru.php?hal=siswa&pesan=edit");
        exit;
    }

    // HAPUS SISWA
    if (isset($_GET['hapus'])) {
        $id = $_GET['hapus'];
        mysqli_query($koneksi, "DELETE FROM siswa WHERE id='$id'");
        header("Location: dashboard_guru.php?hal=siswa&pesan=hapus");
        exit;
    }

    // ambil semua siswa
    $resultSiswa = mysqli_query($koneksi, "SELECT * FROM siswa");

    // ambil data siswa yang mau diedit
    $editSiswa = null;
    if (isset($_GET['edit'])) {
        $idEdit    = $_GET['edit'];
        $rEdit     = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id='$idEdit'");
        $editSiswa = mysqli_fetch_assoc($rEdit);
    }
}

// ============================================================
// PROSES CRUD NILAI
// ============================================================
if ($halaman == 'nilai') {

    // SIMPAN NILAI
    if (isset($_POST['aksi']) && $_POST['aksi'] == 'simpan_nilai') {
        $id_siswa = $_POST['id_siswa'];
        $mapel    = ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'Pemrograman Web', 'Basis Data'];
        $keys     = ['mtk', 'bind', 'bing', 'web', 'bd'];

        mysqli_query($koneksi, "DELETE FROM nilai WHERE id_siswa='$id_siswa'");

        for ($i = 0; $i < count($mapel); $i++) {
            $n = $_POST[$keys[$i]];
            mysqli_query($koneksi, "INSERT INTO nilai (id_siswa, mapel, nilai) VALUES ('$id_siswa','$mapel[$i]','$n')");
        }
        header("Location: dashboard_guru.php?hal=nilai&pesan=nilai");
        exit;
    }

    $resultSiswa = mysqli_query($koneksi, "SELECT * FROM siswa");
    $resultNilai = null;
    $siswaDipilih = null;

    if (isset($_GET['id_siswa'])) {
        $idS          = $_GET['id_siswa'];
        $rS           = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id='$idS'");
        $siswaDipilih = mysqli_fetch_assoc($rS);
        $resultNilai  = mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_siswa='$idS'");
    }
}

// ============================================================
// PROSES CRUD TUGAS
// ============================================================
if ($halaman == 'tugas') {

    // TAMBAH TUGAS
    if (isset($_POST['aksi']) && $_POST['aksi'] == 'tambah_tugas') {
        $mapel   = $_POST['mapel'];
        $judul   = $_POST['judul'];
        $isi     = $_POST['isi'];
        $jenis   = $_POST['jenis'];
        $tanggal = $_POST['tanggal'];
        mysqli_query($koneksi, "INSERT INTO tugas (mapel, judul, isi, jenis, tanggal) VALUES ('$mapel','$judul','$isi','$jenis','$tanggal')");
        header("Location: dashboard_guru.php?hal=tugas&pesan=tugas");
        exit;
    }

    // HAPUS TUGAS
    if (isset($_GET['hapus_tugas'])) {
        $id = $_GET['hapus_tugas'];
        mysqli_query($koneksi, "DELETE FROM tugas WHERE id='$id'");
        header("Location: dashboard_guru.php?hal=tugas");
        exit;
    }

    $resultTugas = mysqli_query($koneksi, "SELECT * FROM tugas ORDER BY tanggal DESC");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Guru</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #faf7f2; color: #3d3d3d; min-height: 100vh; }

    /* NAVBAR */
    .navbar {
      background-color: #e8dcc8;
      border-bottom: 3px solid #8b7355;
      padding: 0 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 58px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .navbar-kiri { display: flex; align-items: center; gap: 10px; }
    .navbar-kiri span { font-size: 16px; font-weight: bold; color: #8b7355; }
    .navbar-kiri small { font-size: 11px; color: #a9967f; }
    .navbar-kanan { display: flex; align-items: center; gap: 14px; font-size: 13px; color: #a9967f; }
    .navbar-kanan a { color: #8b7355; text-decoration: none; font-weight: bold; font-size: 13px; }
    .navbar-kanan a:hover { color: #6b5645; }

    /* MENU */
    .menu {
      background-color: #f5ede0;
      display: flex;
      gap: 4px;
      padding: 10px 30px;
      border-bottom: 1px solid #e0d4c4;
    }
    .menu a {
      padding: 8px 18px;
      border-radius: 6px;
      text-decoration: none;
      font-size: 13px;
      font-weight: bold;
      color: #a9967f;
      background-color: transparent;
      transition: all 0.2s ease;
    }
    .menu a:hover { background-color: #e8dcc8; color: #6b5645; }
    .menu a.aktif { background-color: #d4a574; color: #fff; }

    /* KONTEN */
    .konten { padding: 28px 30px; }
    h2 { color: #8b7355; margin-bottom: 20px; font-size: 20px; }

    /* PESAN */
    .pesan-sukses { background-color: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; padding: 11px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 13px; }

    /* FORM */
    .form-box { background-color: #f5ede0; padding: 22px; border-radius: 10px; max-width: 520px; margin-bottom: 28px; border: 1px solid #e0d4c4; box-shadow: 0 2px 6px rgba(0,0,0,0.05); }
    .form-box h3 { margin: 0 0 14px; color: #5d4a3a; font-size: 14px; font-weight: 600; }
    .form-box label { display: block; margin-bottom: 4px; color: #8b7355; font-size: 12px; font-weight: 500; }
    .form-box input,
    .form-box select,
    .form-box textarea { width: 100%; padding: 9px 12px; margin-bottom: 12px; border: 1px solid #e0d4c4; border-radius: 6px; background-color: #fffbf7; color: #3d3d3d; font-size: 13px; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; transition: border-color 0.2s ease; }
    .form-box textarea { min-height: 80px; resize: vertical; }
    .form-box input:focus, .form-box select:focus, .form-box textarea:focus { outline: none; border-color: #d4a574; background-color: #fff; }

    .tombol-simpan { background-color: #d4a574; color: #fff; border: none; padding: 9px 22px; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: bold; margin-right: 8px; transition: background-color 0.2s ease; }
    .tombol-simpan:hover { background-color: #c4956c; }
    .tombol-batal { background-color: transparent; color: #8b7355; border: 1px solid #c4a586; padding: 9px 22px; border-radius: 6px; cursor: pointer; font-size: 13px; text-decoration: none; transition: all 0.2s ease; }
    .tombol-batal:hover { color: #5d4a3a; border-color: #8b7355; }

    /* TABEL */
    table { width: 100%; border-collapse: collapse; background-color: #fffbf7; border-radius: 10px; overflow: hidden; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); }
    th { background-color: #e8dcc8; padding: 11px 16px; text-align: left; font-size: 12px; color: #8b7355; font-weight: 600; }
    td { padding: 11px 16px; font-size: 13px; border-bottom: 1px solid #f5ede0; color: #3d3d3d; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background-color: #faf7f2; }

    .t-edit  { background-color: transparent; color: #6b8e23; border: 1px solid #a4ac86; padding: 4px 11px; border-radius: 5px; cursor: pointer; font-size: 12px; text-decoration: none; margin-right: 4px; transition: all 0.2s ease; }
    .t-edit:hover  { background-color: #a4ac86; color: #fff; }
    .t-hapus { background-color: transparent; color: #a0522d; border: 1px solid #cd853f; padding: 4px 11px; border-radius: 5px; cursor: pointer; font-size: 12px; text-decoration: none; transition: all 0.2s ease; }
    .t-hapus:hover { background-color: #cd853f; color: #fff; }
    .t-lihat { background-color: transparent; color: #8b7355; border: 1px solid #c4a586; padding: 4px 11px; border-radius: 5px; cursor: pointer; font-size: 12px; text-decoration: none; transition: all 0.2s ease; }
    .t-lihat:hover { background-color: #c4a586; color: #fff; }

    .badge { display: inline-block; padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: bold; }
    .b-tugas  { background-color: #d4e4f7; color: #5a7fa0; }
    .b-uh     { background-color: #fce4ec; color: #a0522d; }
    .b-agenda { background-color: #e8f5e9; color: #6b8e23; }
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
    👨‍🏫 <?php echo $_SESSION['username']; ?> &nbsp;|&nbsp;
    <a href="logout.php">Logout</a>
  </div>
</div>

<!-- MENU -->
<div class="menu">
  <a href="dashboard_guru.php?hal=siswa" class="<?php echo $halaman=='siswa' ? 'aktif' : ''; ?>">👤 Data Siswa</a>
  <a href="dashboard_guru.php?hal=nilai" class="<?php echo $halaman=='nilai' ? 'aktif' : ''; ?>">📊 Nilai</a>
  <a href="dashboard_guru.php?hal=tugas" class="<?php echo $halaman=='tugas' ? 'aktif' : ''; ?>">📝 Tugas & Ujian</a>
</div>

<div class="konten">

<?php if (isset($_GET['pesan'])): ?>
  <div class="pesan-sukses">
    <?php
      $p = $_GET['pesan'];
      if ($p == 'tambah') echo 'Siswa berhasil ditambahkan!';
      if ($p == 'edit')   echo 'Data siswa berhasil diubah!';
      if ($p == 'hapus')  echo 'Siswa berhasil dihapus!';
      if ($p == 'nilai')  echo 'Nilai berhasil disimpan!';
      if ($p == 'tugas')  echo 'Tugas/ujian berhasil ditambahkan!';
    ?>
  </div>
<?php endif; ?>

<!-- ======== HALAMAN SISWA ======== -->
<?php if ($halaman == 'siswa'): ?>
  <h2>Data Siswa</h2>

  <!-- Form Tambah / Edit -->
  <div class="form-box">
    <h3><?php echo $editSiswa ? 'Edit Data Siswa' : 'Tambah Siswa Baru'; ?></h3>
    <form action="dashboard_guru.php?hal=siswa" method="POST">
      <input type="hidden" name="aksi" value="<?php echo $editSiswa ? 'edit' : 'tambah'; ?>">
      <?php if ($editSiswa): ?>
        <input type="hidden" name="id" value="<?php echo $editSiswa['id']; ?>">
      <?php endif; ?>

      <label>Nama Lengkap</label>
      <input type="text" name="nama" value="<?php echo $editSiswa ? $editSiswa['nama'] : ''; ?>" required>

      <label>NISN</label>
      <input type="text" name="nisn" maxlength="10" value="<?php echo $editSiswa ? $editSiswa['nisn'] : ''; ?>" required>

      <label>Kelas</label>
      <select name="kelas" required>
        <option value="">-- Pilih --</option>
        <?php
          $kelasOptions = ['10 RPL 1','10 RPL 2','10 TKJ 1','11 RPL 1','11 TKJ 1','12 RPL 1'];
          foreach ($kelasOptions as $k) {
            $sel = ($editSiswa && $editSiswa['kelas'] == $k) ? 'selected' : '';
            echo "<option $sel>$k</option>";
          }
        ?>
      </select>

      <label>Jenis Kelamin</label>
      <select name="jk" required>
        <option value="">-- Pilih --</option>
        <option <?php echo ($editSiswa && $editSiswa['jk']=='Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
        <option <?php echo ($editSiswa && $editSiswa['jk']=='Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
      </select>

      <button type="submit" class="tombol-simpan"><?php echo $editSiswa ? 'Simpan Perubahan' : 'Simpan'; ?></button>
      <?php if ($editSiswa): ?>
        <a href="dashboard_guru.php?hal=siswa" class="tombol-batal">Batal</a>
      <?php endif; ?>
    </form>
  </div>

  <!-- Tabel Siswa -->
  <table>
    <thead>
      <tr><th>No</th><th>Nama</th><th>NISN</th><th>Kelas</th><th>J/K</th><th>Aksi</th></tr>
    </thead>
    <tbody>
      <?php $no = 1; while ($s = mysqli_fetch_assoc($resultSiswa)): ?>
      <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo $s['nama']; ?></td>
        <td><?php echo $s['nisn']; ?></td>
        <td><?php echo $s['kelas']; ?></td>
        <td><?php echo $s['jk']; ?></td>
        <td>
          <a href="dashboard_guru.php?hal=siswa&edit=<?php echo $s['id']; ?>" class="t-edit">Edit</a>
          <a href="dashboard_guru.php?hal=siswa&hapus=<?php echo $s['id']; ?>" class="t-hapus"
             onclick="return confirm('Yakin hapus siswa ini?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

<!-- ======== HALAMAN NILAI ======== -->
<?php elseif ($halaman == 'nilai'): ?>
  <h2>Input Nilai Siswa</h2>

  <!-- Pilih Siswa -->
  <div class="form-box" style="max-width:280px;">
    <h3>Pilih Siswa</h3>
    <form action="dashboard_guru.php" method="GET">
      <input type="hidden" name="hal" value="nilai">
      <label>Nama Siswa</label>
      <select name="id_siswa" required>
        <option value="">-- Pilih Siswa --</option>
        <?php while ($s = mysqli_fetch_assoc($resultSiswa)): ?>
          <option value="<?php echo $s['id']; ?>"
            <?php echo (isset($_GET['id_siswa']) && $_GET['id_siswa'] == $s['id']) ? 'selected' : ''; ?>>
            <?php echo $s['nama']; ?>
          </option>
        <?php endwhile; ?>
      </select>
      <button type="submit" class="tombol-simpan">Tampilkan</button>
    </form>
  </div>

  <!-- Form Input Nilai -->
  <?php if ($siswaDipilih): ?>
    <div class="form-box">
      <h3>Input Nilai: <?php echo $siswaDipilih['nama']; ?></h3>
      <?php
        // siapkan nilai yang sudah ada
        $nilaiLama = [];
        if ($resultNilai) {
          while ($n = mysqli_fetch_assoc($resultNilai)) {
            $nilaiLama[$n['mapel']] = $n['nilai'];
          }
        }
      ?>
      <form action="dashboard_guru.php?hal=nilai&id_siswa=<?php echo $siswaDipilih['id']; ?>" method="POST">
        <input type="hidden" name="aksi" value="simpan_nilai">
        <input type="hidden" name="id_siswa" value="<?php echo $siswaDipilih['id']; ?>">

        <label>Matematika</label>
        <input type="number" name="mtk" min="0" max="100" value="<?php echo $nilaiLama['Matematika'] ?? ''; ?>" required>

        <label>Bahasa Indonesia</label>
        <input type="number" name="bind" min="0" max="100" value="<?php echo $nilaiLama['Bahasa Indonesia'] ?? ''; ?>" required>

        <label>Bahasa Inggris</label>
        <input type="number" name="bing" min="0" max="100" value="<?php echo $nilaiLama['Bahasa Inggris'] ?? ''; ?>" required>

        <label>Pemrograman Web</label>
        <input type="number" name="web" min="0" max="100" value="<?php echo $nilaiLama['Pemrograman Web'] ?? ''; ?>" required>

        <label>Basis Data</label>
        <input type="number" name="bd" min="0" max="100" value="<?php echo $nilaiLama['Basis Data'] ?? ''; ?>" required>

        <button type="submit" class="tombol-simpan">Simpan Nilai</button>
      </form>
    </div>
  <?php endif; ?>

<!-- ======== HALAMAN TUGAS ======== -->
<?php elseif ($halaman == 'tugas'): ?>
  <h2>Tugas, Ujian Harian & Agenda</h2>

  <!-- Form Tambah Tugas -->
  <div class="form-box">
    <h3>Tambah Baru</h3>
    <form action="dashboard_guru.php?hal=tugas" method="POST">
      <input type="hidden" name="aksi" value="tambah_tugas">

      <label>Mata Pelajaran</label>
      <select name="mapel" required>
        <option value="">-- Pilih --</option>
        <option>Matematika</option>
        <option>Bahasa Indonesia</option>
        <option>Bahasa Inggris</option>
        <option>Pemrograman Web</option>
        <option>Basis Data</option>
      </select>

      <label>Judul</label>
      <input type="text" name="judul" placeholder="Contoh: Buat Form Login" required>

      <label>Keterangan / Isi</label>
      <textarea name="isi" placeholder="Jelaskan detail tugas/ujian/agenda..."></textarea>

      <label>Jenis</label>
      <select name="jenis" required>
        <option value="">-- Pilih Jenis --</option>
        <option>Tugas</option>
        <option>Ujian Harian</option>
        <option>Agenda</option>
      </select>

      <label>Tanggal</label>
      <input type="date" name="tanggal" required>

      <button type="submit" class="tombol-simpan">Simpan</button>
    </form>
  </div>

  <!-- Tabel Tugas -->
  <table>
    <thead>
      <tr><th>No</th><th>Mapel</th><th>Judul</th><th>Jenis</th><th>Tanggal</th><th>Aksi</th></tr>
    </thead>
    <tbody>
      <?php $no = 1; while ($t = mysqli_fetch_assoc($resultTugas)): ?>
      <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo $t['mapel']; ?></td>
        <td><?php echo $t['judul']; ?></td>
        <td>
          <?php
            if ($t['jenis'] == 'Tugas')        echo "<span class='badge b-tugas'>Tugas</span>";
            if ($t['jenis'] == 'Ujian Harian')  echo "<span class='badge b-uh'>Ujian Harian</span>";
            if ($t['jenis'] == 'Agenda')        echo "<span class='badge b-agenda'>Agenda</span>";
          ?>
        </td>
        <td><?php echo $t['tanggal']; ?></td>
        <td>
          <a href="dashboard_guru.php?hal=tugas&hapus_tugas=<?php echo $t['id']; ?>" class="t-hapus"
             onclick="return confirm('Yakin hapus?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

<?php endif; ?>

</div>
</body>
</html>