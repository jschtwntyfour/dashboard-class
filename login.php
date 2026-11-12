<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login — SISKO</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: Arial, sans-serif;
      background-color: #1a1a2e;
      color: #eaeaea;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .login-box {
      background-color: #16213e;
      border: 1px solid #0f3460;
      border-radius: 12px;
      padding: 36px 32px;
      width: 100%;
      max-width: 380px;
    }

    .login-box h2 {
      text-align: center;
      color: #e94560;
      font-size: 22px;
      margin-bottom: 4px;
    }

    .login-box p {
      text-align: center;
      color: #aaaaaa;
      font-size: 13px;
      margin-bottom: 24px;
    }

    /* pilihan role */
    .pilih-role {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }

    .pilih-role label {
      flex: 1;
      border: 2px solid #0f3460;
      border-radius: 8px;
      padding: 10px;
      text-align: center;
      cursor: pointer;
      font-size: 14px;
      font-weight: bold;
      color: #aaaaaa;
      transition: all 0.2s;
    }

    /* sembunyikan radio asli */
    .pilih-role input[type="radio"] {
      display: none;
    }

    /* kalau radio dipilih, label jadi merah */
    .pilih-role input[type="radio"]:checked + span {
      color: #e94560;
    }

    .pilih-role label:has(input:checked) {
      border-color: #e94560;
      background-color: rgba(233, 69, 96, 0.1);
      color: #e94560;
    }

    label.field-label {
      display: block;
      margin-bottom: 5px;
      color: #aaaaaa;
      font-size: 13px;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px 13px;
      margin-bottom: 16px;
      border: 1px solid #0f3460;
      border-radius: 7px;
      background-color: #1a1a2e;
      color: #eaeaea;
      font-size: 14px;
      box-sizing: border-box;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      outline: none;
      border-color: #e94560;
    }

    .tombol-masuk {
      width: 100%;
      padding: 11px;
      background-color: #e94560;
      color: #fff;
      border: none;
      border-radius: 7px;
      font-size: 15px;
      font-weight: bold;
      cursor: pointer;
    }

    .tombol-masuk:hover {
      background-color: #c73652;
    }

    .pesan-error {
      background-color: #3a1a1a;
      color: #e94560;
      border: 1px solid #e94560;
      padding: 10px 14px;
      border-radius: 6px;
      margin-bottom: 16px;
      font-size: 13px;
      text-align: center;
    }

    .kembali {
      display: block;
      text-align: center;
      margin-top: 16px;
      color: #aaaaaa;
      font-size: 13px;
      text-decoration: none;
    }

    .kembali:hover { color: #eaeaea; }

    .hint {
      margin-top: 20px;
      border-top: 1px solid #0f3460;
      padding-top: 16px;
      font-size: 12px;
      color: #555;
      text-align: center;
      line-height: 1.8;
    }
  </style>
</head>
<body>

<div class="login-box">
  <h2>Login SISKO</h2>
  <p>SMK Cinta Kasih Tzu Chi</p>

  <?php if (isset($_GET['error'])): ?>
    <div class="pesan-error">Username atau password salah!</div>
  <?php endif; ?>

  <form action="proses_login.php" method="POST">

    <!-- Pilih Role -->
    <div class="pilih-role">
      <label>
        <input type="radio" name="role" value="guru" required>
        <span>👨‍🏫 Guru</span>
      </label>
      <label>
        <input type="radio" name="role" value="siswa" required>
        <span>🎒 Siswa</span>
      </label>
    </div>

    <label class="field-label">Username</label>
    <input type="text" name="username" placeholder="Masukkan username" required>

    <label class="field-label">Password</label>
    <input type="password" name="password" placeholder="Masukkan password" required>

    <button type="submit" class="tombol-masuk">Masuk</button>
  </form>

  <a href="index.php" class="kembali">← Kembali ke halaman utama</a>

  <div class="hint">
    <b>Silahkan Login</b>
  </div>
</div>

</body>
</html>
