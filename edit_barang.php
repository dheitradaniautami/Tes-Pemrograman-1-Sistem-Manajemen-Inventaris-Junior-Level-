<?php
include 'config.php';

// Ambil data barang berdasarkan ID
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM barang WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    echo "Data tidak ditemukan!";
    exit();
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $jumlah = $_POST['jumlah'];
    $harga_per_unit = $_POST['harga_per_unit'];
    $tanggal_masuk = $_POST['tanggal_masuk'];

    // Validasi input
    if ($nama_barang && $kategori && $jumlah > 0 && $harga_per_unit >= 100 && $tanggal_masuk <= date('Y-m-d')) {
        $update = $conn->prepare("UPDATE barang SET nama_barang = ?, kategori = ?, jumlah = ?, harga_per_unit = ?, tanggal_masuk = ? WHERE id = ?");
        $update->execute([$nama_barang, $kategori, $jumlah, $harga_per_unit, $tanggal_masuk, $id]);

        header("Location: index.php");
        exit();
    } else {
        $error = "Pastikan semua input valid dan sesuai ketentuan.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Inventory</title>


  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <!-- nice select -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha256-mLBIhmBvigTFWPSCtvdu6a76T+3Xyt+K571hupeFLg4=" crossorigin="anonymous" />
  <!-- datepicker -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css">
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />

</head>

<body>

  <div class="hero_area">

  <!-- book section -->

  <section class="book_section layout_padding">
    <div class="container">
      <div class="row">
        <div class="col">
        <h2 class="text-center mb-4">Edit Barang</h2>
            <a href="index.php" class="btn btn-secondary mb-4">Kembali</a>

            <!-- Form Edit Barang -->
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
          <form method="POST">
            <h4>
              Form <span>Edit Barang</span>
            </h4>
            <div class="form-row ">
              <div class="form-group col-lg-6">
                <label for="nama_barang">Nama Barang </label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= htmlspecialchars($data['nama_barang']) ?>" required>
              </div>
              <div class="form-group col-lg-6">
                <label for="kategori">Kategori Barang</label>
                <select  id="kategori" name="kategori" class="form-control wide" required>
                <option value="Elektronik" <?= $data['kategori'] === 'Elektronik' ? 'selected' : '' ?>>Elektronik</option>
                <option value="Pakaian" <?= $data['kategori'] === 'Pakaian' ? 'selected' : '' ?>>Pakaian</option>
                <option value="Makanan" <?= $data['kategori'] === 'Makanan' ? 'selected' : '' ?>>Makanan</option>
                <option value="Lainnya" <?= $data['kategori'] === 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                </select>
              </div>
            </div>
            <div class="form-row ">
              <div class="form-group col-lg-4">
                <label for="jumlah">Jumlah Barang</label>
                <input type="number" min="1" class="form-control" id="jumlah" name="jumlah" value="<?= htmlspecialchars($data['jumlah']) ?>" required>
              </div>
              <div class="form-group col-lg-4">
                <label for="harga_per_unit">Harga Per Unit</label>
                <input type="number" class="form-control" id="harga_per_unit" name="harga_per_unit" min="100" value="<?= htmlspecialchars($data['harga_per_unit']) ?>" required>
              </div>
              <div class="form-group col-lg-4">
                <label for="tanggal_masuk">Choose Date </label>
                <div class="input-group date" id="tanggal_masuk" name="tanggal_masuk" data-date-format="mm-dd-yyyy">
                  <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" value="<?= $data['tanggal_masuk'] ?>" max="<?= date('Y-m-d') ?>" required>
                </div>
              </div>
            </div>
            <div class="btn-box">
              <button type="submit" class="btn ">Simpan Perubahan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>


<br><br><br><hr>
  <!-- footer section -->
  <footer class="footer_section">
    <div class="container">
      <p>
        &copy; <span id="displayYear"></span> All Rights Reserved By
        <a href="https://www.instagram.com/dheitradaniautami/">Dheitra Dania Utami</a>
      </p>
    </div>
  </footer>
  <!-- footer section -->

  <!-- jQery -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.js"></script>
  <!-- nice select -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js" integrity="sha256-Zr3vByTlMGQhvMfgkQ5BtWRSKBGa2QlspKYJnkjZTmo=" crossorigin="anonymous"></script>
  <!-- owl slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <!-- datepicker -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>


</body>

</html>