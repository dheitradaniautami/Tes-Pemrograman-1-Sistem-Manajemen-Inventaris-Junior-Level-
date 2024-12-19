<?php
include 'config.php';

// Tambahkan Barang
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $jumlah = $_POST['jumlah'];
    $harga_per_unit = $_POST['harga_per_unit'];
    $tanggal_masuk = $_POST['tanggal_masuk'];

    if ($nama_barang && $kategori && $jumlah > 0 && $harga_per_unit >= 100 && $tanggal_masuk <= date('Y-m-d')) {
        $stmt = $conn->prepare("INSERT INTO barang (nama_barang, kategori, jumlah, harga_per_unit, tanggal_masuk) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nama_barang, $kategori, $jumlah, $harga_per_unit, $tanggal_masuk]);
    }
}

// Ambil data barang
$barang = $conn->query("SELECT * FROM barang")->fetchAll(PDO::FETCH_ASSOC);
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
          <form method="POST">
            <h4>
              Form <span>Input Barang</span>
            </h4>
            <div class="form-row ">
              <div class="form-group col-lg-6">
                <label for="nama_barang">Nama Barang </label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
              </div>
              <div class="form-group col-lg-6">
                <label for="kategori">Kategori Barang</label>
                <select id="kategori" name="kategori" class="form-control wide" required>
                <option value="Elektronik">Elektronik</option>
                <option value="Pakaian">Pakaian</option>
                <option value="Makanan">Makanan</option>
                <option value="Lainnya">Lainnya</option>
                </select>
              </div>
            </div>
            <div class="form-row ">
              <div class="form-group col-lg-4">
                <label for="jumlah">Jumlah Barang</label>
                <input type="number" min="1" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah Minimal 1" required>
              </div>
              <div class="form-group col-lg-4">
                <label for="harga_per_unit">Harga Per Unit</label>
                <input type="number" class="form-control" id="harga_per_unit" name="harga_per_unit" min="100" placeholder="Min Rp.100" required>
              </div>
              <div class="form-group col-lg-4">
                <label for="tanggal_masuk">Choose Date </label>
                <div class="input-group date" id="tanggal_masuk" name="tanggal_masuk" data-date-format="mm-dd-yyyy">
                  <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" max="<?= date('Y-m-d') ?>" required>
                </div>
              </div>
            </div>
            <div class="btn-box">
              <button type="submit" class="btn ">Tambah Barang</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

    <!-- Tabel Daftar Barang -->
          <!-- Input untuk Pencarian -->
          <div class="container">

    <table class="table table-striped" border="1">
        <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Jumlah</th>
            <th>Harga Total</th>
            <th>Tanggal Masuk</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($barang as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['nama_barang']) ?></td>
                <td><?= htmlspecialchars($item['kategori']) ?></td>
                <td><?= $item['jumlah'] ?></td>
                <td>Rp<?= number_format($item['jumlah'] * $item['harga_per_unit'], 0, ',', '.') ?></td>
                <td><?= $item['tanggal_masuk'] ?></td>
                <td>
                    <a href="edit_barang.php?id=<?= $item['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?= $item['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus barang ini?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
  <!-- end book section -->

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
</script>
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