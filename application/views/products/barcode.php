<!DOCTYPE html>
<html lang="en">
<!-- head start -->
<?php $this->load->view('layouts/dashboard/head'); ?>
<!-- head end -->

<body>


  <!-- header start -->
  <?php $this->load->view('layouts/dashboard/header'); ?>
  <!-- header end -->


  <!-- sidebar start -->
  <?php $this->load->view('layouts/dashboard/sidebar'); ?>
  <!-- sidebar end -->

  <main id="main" class="main">
    <!-- Start Page Title -->
    <div class="pagetitle">
      <h1>Master Data</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url('Admin/Dashboard') ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">Master Data Products</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->

    <!-- Start Section -->
    <section class="section">
      <!--Start Content  -->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body py-4">
              <button type="button" class="btn btn-primary mx-1" id="tombolTambah"><i class="bi bi-person-plus"></i> Tambah</button>
              <button type="submit" class="btn btn-danger mx-1" id="tombolHapusSemua"><i class="bi bi-trash"></i> Hapus Semua</button>
              <h1><?= $products->product_name ?></h1>

              <div class="box-body">

                <?php $generator = new Picqer\Barcode\BarcodeGeneratorJPG();
                file_put_contents('assets/upload/bar-code/product-' . $products->product_kode . '.png', $generator->getBarcode($products->product_kode, $generator::TYPE_CODABAR));
                echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($products->product_kode, $generator::TYPE_CODABAR)) . '">';
                ?>





                <br>
                <?= $products->product_kode ?>

              </div>
              <!-- End Default Table Example -->
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body py-4">
              <h1><?= $products->product_name ?></h1>

              <div class="box-body">
                <?php
                $qrCode = new Endroid\QrCode\QrCode($products->product_kode);
                $qrCode->writeFile('assets/upload/qr-code/product-' . $products->product_kode . '.png');
                ?>
                <br>
                <img style="width: 200px;" src="<?= config_item('assets') ?>upload/qr-code/product-<?= $products->product_kode ?>.png" alt="">
                <br>
                <br>
                <br>
                <?php
                $qrCode2 = new Endroid\QrCode\QrCode($products->product_kode);
                $qrCode2->setSize(300);
                $qrCode2->setMargin(10);
                // var_dump(base_url('assets/fonts/noto_sans.otf'));

                // Set advanced options
                $qrCode2->setWriterByName('png');
                $qrCode2->setEncoding('UTF-8');
                $qrCode2->setErrorCorrectionLevel(Endroid\QrCode\ErrorCorrectionLevel::HIGH());
                $qrCode2->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
                $qrCode2->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
                $qrCode2->setLabel('Scan the code', 16, 'assets/fonts/noto_sans.otf', Endroid\QrCode\LabelAlignment::CENTER());
                $qrCode2->setLogoPath('assets/images/j.png');
                $qrCode2->setLogoSize(150, 200);
                $qrCode2->setValidateResult(false);

                $qrCode2->setRoundBlockSize(true, Endroid\QrCode\QrCode::ROUND_BLOCK_SIZE_MODE_MARGIN); // The size of the qr code is shrinked, if necessary, but the size of the final image remains unchanged due to additional margin being added (default)
                $qrCode2->setRoundBlockSize(true, Endroid\QrCode\QrCode::ROUND_BLOCK_SIZE_MODE_ENLARGE); // The size of the qr code and the final image is enlarged, if necessary
                $qrCode2->setRoundBlockSize(true, Endroid\QrCode\QrCode::ROUND_BLOCK_SIZE_MODE_SHRINK); // The size of the qr code and the final image is shrinked, if necessary

                // Set additional writer options (SvgWriter example)
                $qrCode2->setWriterOptions(['exclude_xml_declaration' => true]);

                $qrCode2->writeFile('assets/upload/qr-code2/product-' . $products->product_kode . '.png');

                // $dataUri = $qrCode2->writeDataUri();
                ?>
                <img style="width: 200px;" src="<?= config_item('assets') ?>upload/qr-code2/product-<?= $products->product_kode ?>.png" alt="">
                <br>
                <?= $products->product_kode ?>
              </div>
              <!-- End Default Table Example -->
            </div>
          </div>
        </div>
      </div>
      <!-- <button type="submit" class="btn btn-danger ye"> tes</button> -->
      <!--End Content  -->
      <!-- End Section -->
    </section>

  </main>
  <!-- End #main -->


  <!-- footer start -->
  <?php $this->load->view('layouts/dashboard/footer'); ?>
  <!-- footer end -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


  <div class="viewmodal" style="display: none;"></div>
  <!-- script start -->
  <?php $this->load->view('layouts/dashboard/scriptDataTables'); ?>

</body>

</html>