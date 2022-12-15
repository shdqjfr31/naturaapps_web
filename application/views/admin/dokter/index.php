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
          <li class="breadcrumb-item active">Master Data Dokter</li>
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
                      <th class="text-center">
                        <input type="checkbox" name="" id="centangSemua">
                      </th>
                      <th class="text-center">No.</th>
                      <th class="text-center">Kode</th>
                      <th class="text-center">Nama</th>
                      <th class="text-center">Spesialis</th>
                      <th class="text-center">Kode BPJS</th>
                      <th class="text-center">Nama BPJS</th>
                      <th class="text-center">Poli BPJS</th>
                      <th class="text-center">Aktif</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                  <tfoot>
                    <tr>
                      <th class="text-center">
                        <input type="checkbox" name="" id="">
                      </th>
                      <th class="text-center">No.</th>
                      <th class="text-center">Kode</th>
                      <th class="text-center">Nama</th>
                      <th class="text-center">Spesialis</th>
                      <th class="text-center">Kode BPJS</th>
                      <th class="text-center">Nama BPJS</th>
                      <th class="text-center">Poli BPJS</th>
                      <th class="text-center">Aktif</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </tfoot>
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
            "targets": 1, // your case first column
            "className": "text-center",
            "width": "5%",
            "orderable": false,
          },
          {
            "targets": 4,
            "className": "fw-bold",
          },
          {
            "targets": 8,
            "orderable": false,
            "className": "text-center"
          },
          {
            "targets": 9,
            "orderable": false,
            "className": "text-center"
          },
        ],
        ajax: {
          url: '<?= base_url('admin/dokter/get_ajax') ?>',
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

      $('#centangSemua').click(function(e) {
        if ($(this).is(':checked')) {
          $(".centangKode").prop("checked", true);
        } else {
          $(".centangKode").prop("checked", false);
        }
      })


      $('#tombolTambah').click(function(e) {
        $.ajax({
          url: "<?= base_url('admin/dokter/tambahDokter') ?>",
          dataType: "json",
          success: function(response) {
            if (response.sukses) {
              $('.viewmodal').html(response.sukses).show();
              $('#modalTambah').on('shown.bs.modal', function(e) {
                $('#KODE').focus();
              })
              $('#modalTambah').modal('show');
            }
          }
        });
      })

    });

    function edit(KODE) {
      $.ajax({
        type: "post",
        url: "<?= base_url('admin/dokter/edit') ?>",
        data: {
          KODE: KODE
        },
        dataType: "json",
        success: function(response) {
          if (response.sukses) {
            $('.viewmodal').html(response.sukses).show();
            $('#modalEdit').on('shown.bs.modal', function(e) {
              $('#NAMA').focus();
            })
            $('#modalEdit').modal('show');
          }
        }
      });
    }

    function hapus(KODE) {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success mx-1',
          cancelButton: 'btn btn-danger mx-1'
        },
        buttonsStyling: false
      })

      swalWithBootstrapButtons.fire({
        title: 'Hapus',
        text: `Yakin Menghapus Dokter dengan no kode = ${KODE} ?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "post",
            url: "<?= base_url('admin/dokter/delete') ?>",
            data: {
              KODE: KODE
            },
            dataType: "json",
            success: function(response) {
              if (response.sukses) {
                swalWithBootstrapButtons.fire(
                  'Terhapus!',
                  `Data dengan no kode = ${KODE} telah terhapus.`,
                  'success'
                )
                $('#myTable').DataTable().ajax.reload();
              }
            }
          });

        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons.fire(
            'Batal',
            'Hapus Dibatalkan',
            'error'
          )
        }
      })
    }

    $('.formHapus').submit(function(e) {
      e.preventDefault();
      let jmldata = $('.centangKode:checked')

      if (jmldata.length === 0) {
        Swal.fire({
          icon: 'warning',
          title: 'Perhatian',
          text: 'Maaf, tidak ada yang bisa dihapus, silahkan diceklis !',
          customClass: {
            confirmButton: 'btn btn-success mx-1',
          },
          buttonsStyling: false,
        })
      } else {
        Swal.fire({
          title: 'Hapus Data',
          text: `Ada ${jmldata.length} data dokter yang akan dihapus, yakin?`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, Hapus!',
          cancelButtonText: 'Tidak'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: "post",
              url: $(this).attr('action'),
              data: $(this).serialize(),
              dataType: "json",
              success: function(response) {
                if (response.sukses) {
                  Swal.fire(
                    'Terhapus!',
                    `${jmldata.length} data dokter telah terhapus`,
                    'success'
                  )
                  $('#myTable').DataTable().ajax.reload();
                }
              }
            });
          }
        })
      }

      // alert(jmldata.length)
      return false;
    })
  </script>
</body>

</html>