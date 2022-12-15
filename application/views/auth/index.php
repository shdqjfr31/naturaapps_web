<!DOCTYPE html>
<html lang="en">
<!-- head start -->
<?php $this->load->view('layouts/login/head'); ?>
<!-- head end -->

<body>
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="<?php echo config_item('templates'); ?>assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">JafarScript</span>
                </a>
              </div>
              <!-- End Logo -->
              <div class="card mb-3">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <?= $this->session->flashdata('message'); ?>
                    <h5 class="card-title text-left pb-0 fs-4">Login</h5>
                    <!-- <p class="text-center small">Enter your username & password to login</p> -->
                  </div>
                  <form method="POST" class="row g-3 needs-validation" action="<?php echo site_url('Auth'); ?>" novalidate>
                    <div class="col-12">
                      <label for="username" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="username" class="form-control" id="username" required>
                        <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>
                        <div class="invalid-feedback">Masukkan username.</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="password" required>
                      <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                      <div class="invalid-feedback">Masukkan password!</div>
                    </div>
                    <!-- <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div> -->
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <!-- <div class="col-12">
                      <p class="small mb-0">Don't have account? <a href="pages-register.html">Create an account</a></p>
                    </div> -->
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- footer start -->
        <?php $this->load->view('layouts/login/footer'); ?>
        <!-- footer end -->
      </section>
    </div>
  </main>
  <!-- End #main -->
  <!-- script start -->
  <?php $this->load->view('layouts/login/script'); ?>
  <!-- script end -->
</body>

</html>