<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="./favicon/favicon.ico" />

  <!-- Core Css -->
  <link rel="stylesheet" href="./assets/css/styles.css" />

  <title>Sign-In INVOICE</title>
</head>

<body>
  <!-- Preloader -->
  <div class="preloader">
    <img src="./assets/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid" />
  </div>

  <div id="main-wrapper" class="auth-customizer-none">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3 auth-card">
            <div class="card mb-0">
              <div class="card-body">
                <a href="" class="text-nowrap logo-img text-center d-block mb-5 w-100">
                  <h1>INVOICE NEKO Demo</h1>
                  
                  <img src="./img/neko.png" class="dark-logo w-30" alt="Logo-Dark" />
                  <img src="./img/neko.png" class="light-logo w-30" alt="Logo-light" />
                </a>
                <div class="row">
                  <div class="col-6 mb-2 mb-sm-0 w-100">
                  
                    <?php
                    require_once './config.php';

                    if (isset($_SESSION['google_data'])) {
                      header("Location:  ");
                    } else {
                      echo ' <a class="btn btn-rounded btn-light text-dark border fw-normal d-flex align-items-center justify-content-center rounded-2 py-8" href="' . $client->createAuthUrl() . '" role="button">
                      <img src="./assets/images/svgs/google-icon.svg" alt="modernize-img" class="img-fluid me-2" width="18" height="18">
                      <span class="flex-shrink-0">Sign-in with Google</span>
                    </a>';
                    }
                    ?>
                  

                  </div>
                  <!-- <div class="col-6">
                    <a class="btn text-dark border fw-normal d-flex align-items-center justify-content-center rounded-2 py-8" href="javascript:void(0)" role="button">
                      <img src="./assets/images/svgs/facebook-icon.svg" alt="modernize-img" class="img-fluid me-2" width="18" height="18">
                      <span class="flex-shrink-0">with FB</span>
                    </a>
                  </div> -->
                </div>
                <!-- <div class="position-relative text-center my-4">
                  <p class="mb-0 fs-4 px-3 d-inline-block bg-body text-dark z-index-5 position-relative">or sign in with
                  </p>
                  <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                </div> -->
                <!-- <form>
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1">
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                      <label class="form-check-label text-dark" for="flexCheckChecked">
                        Remeber this Device
                      </label>
                    </div>
                    <a class="text-primary fw-medium" href="./main/authentication-forgot-password.html">Forgot
                      Password ?</a>
                  </div>
                  <a href="./main/index.html" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Sign In</a>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-medium">New to Modernize?</p>
                    <a class="text-primary fw-medium ms-2" href="./main/authentication-register.html">Create an
                      account</a>
                  </div>
                </form> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
   
   
  </div>
  <div class="dark-transparent sidebartoggler"></div>
  <!-- Import Js Files -->



  <script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/libs/simplebar/dist/simplebar.min.js"></script>
  <script src="./assets/js/theme/app.init.js"></script>
  <script src="./assets/js/theme/theme.js"></script>
  <script src="./assets/js/theme/app.min.js"></script>

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   jQuery(document).ready(function () {
  const savedTheme = localStorage.getItem('theme');
  if (savedTheme) {
    $("html").attr("data-bs-theme", savedTheme);
    updateIcon(savedTheme); 
  }

  $("#toggle-theme").on("click", function () {
    let currentTheme = $("html").attr("data-bs-theme");

    let newTheme = currentTheme === "dark" ? "light" : "dark";
    $("html").attr("data-bs-theme", newTheme);

    localStorage.setItem('theme', newTheme);

    updateIcon(newTheme); 
  });


  function updateIcon(theme) {
    const icon = $("#toggle-theme i"); 

  
    if (theme === "dark") {
      icon.removeClass("ti ti-moon moon").addClass("ti ti-sun sun"); 
      $("#toggle-theme")
        .removeClass("nav-link sun light-layout")
        .addClass("nav-link moon dark-layout");
    } else {
      icon.removeClass("ti ti-sun sun").addClass("ti ti-moon moon");
      $("#toggle-theme")
        .removeClass("nav-link moon dark-layout")
        .addClass("nav-link sun light-layout");
    }
  }
});

</script>
</html>