<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/login.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <section class="vh-100">
    <div class="container-fluid h-custom">
      <div class="row d-flex justify-content-center align-items-center h-100 bg-secondary text-dark" style="background: url(<?= base_url()?>assets/img/render.jpg) repeat !important;">
        <div class="col-sm-6 col-lg-6 col-xl-6 ">
          <img id="pepe" src="<?= base_url() ?>assets/img/nft.jpg"
            class="img-fluid" alt="Sample image">
        </div>
        <div class="col-sm-4 col-lg-4 col-xl-4 ">
          <form action="<?= base_url() ?>login/login" method="post">
            <!-- Username input -->
            <div data-mdb-input-init class="form-outline mb-4">
              <label class="form-label" for="form3Example3"><b>Usuario</b></label>
              <input name="username" type="text" id="form3Example3" class="form-control form-control-lg"
                placeholder="Nombre de usuario" required />
            </div>

            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-3">
              <label class="form-label" for="form3Example4"><b>Contraseña</b></label>
              <input name="password" type="password" id="form3Example4" class="form-control form-control-lg"
                placeholder="Contraseña" required />
            </div>
            <?php if (isset($data[0])) { ?>
              <div class="alert alert-danger">
                <?php
                if (isset($data[0])) {
                  echo $data[0];
                }
                ?>
              </div>
            <?php } ?>

            <div class="d-flex justify-content-between align-items-center">
              <!-- Checkbox -->
              <div class="form-check mb-0">
                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                <label class="form-check-label" for="form2Example3">
                  Recordarme
                </label>
              </div>
              <a href="#!" class="text-body">¿Olvidaste la contraseña?</a>
            </div>

            <div class="text-center text-lg-start mt-4 pt-2">
              <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-dark btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Acceder</button>
              <p class="small fw-bold mt-2 pt-1 mb-0">No tienes una cuenta? <a href="<?= base_url() ?>login/register"
                  class="link-danger">Regístrate!!!</a></p>
            </div>

          </form>
        </div>
      </div>
    </div>
    <div
      class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-dark text-white">
      <!-- Copyright -->
      <div class="text-white mb-3 mb-md-0">
        Copyright © 2020. All rights reserved.
      </div>
      <!-- Copyright -->

      <!-- Right -->
      <div>
        <a href="#!" class="text-white me-4">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="#!" class="text-white me-4">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="#!" class="text-white me-4">
          <i class="fab fa-google"></i>
        </a>
        <a href="#!" class="text-white">
          <i class="fab fa-linkedin-in"></i>
        </a>
      </div>
      <!-- Right -->
    </div>
  </section>
</body>

</html>