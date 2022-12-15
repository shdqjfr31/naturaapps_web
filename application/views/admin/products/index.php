<!DOCTYPE html>
<html lang="en">
<!-- head start -->
<?php $this->load->view('layouts/dashboard/headDataTables'); ?>
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
      <?= form_open('admin/dokter/deletemultiple', ['class' => 'formHapus']) ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body py-4">
              <button type="button" class="btn btn-primary mx-1" id="tombolTambah"><i class="bi bi-person-plus"></i> Tambah</button>
              <button type="submit" class="btn btn-danger mx-1" id="tombolHapusSemua"><i class="bi bi-trash"></i> Hapus Semua</button>
              <div class="mt-3 table-responsive">
                <table id="myTable" class="table table-striped table-bordered table-hover display " style="width:100%">
                  <thead>
                    <tr>
                      <th class="text-center">No.</th>
                      <th class="text-center">Kode</th>
                      <th class="text-center">Nama</th>
                      <th class="text-center">Harga</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
              <!-- End Default Table Example -->
            </div>
          </div>
        </div>
      </div>
      <?= form_close() ?>
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
  <!-- <script>
    $(document).ready(function() {
      $(".ye").submit(function() {
        alert("Submitted");
        console.log("ye");
      });
    });
  </script> -->
  <!-- script end -->
  <script>
    // $(document).ready(function() {
    //   $('#myTable').DataTable();
    // });
    function tampilDataDokter() {
      table = $('#myTable').DataTable({
        serverSide: true,
        responsive: true,
        processing: true,
        order: [],
        columnDefs: [{
            "targets": 0, // your case first column
            "className": "text-center",
            "width": "5%",
            "orderable": false,
          },
          {
            "targets": 4, // your case first column
            "className": "text-center",
            "width": "10%",
            "orderable": false,
          },

        ],
        ajax: {
          url: '<?= base_url('admin/products/get_ajax') ?>',
          type: 'POST'
        }
      });
      // setInterval(function() {
      //   table.ajax.reload();
      //   console.log('Tes');
      // }, 1000);
    }


    $(document).ready(function() {
      tampilDataDokter();


    });
  </script>
</body>

</html>