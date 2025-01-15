<?php date_default_timezone_set('Asia/Bangkok');
require_once '../controller/conn.php';

session_start();
if (empty($_SESSION['user_id']) || $_SESSION['user_urole'] != 'admin') {
  unset($_SESSION['user_id']);
  unset($_SESSION['user_urole']);
  session_destroy();
  header('Location: ../index.php');
  exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM invoice_users WHERE id = $user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute();

if ($stmt->rowCount() > 0) {
  $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
}


?>
<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="../favicon/favicon.ico" />
  <link rel="stylesheet" href="../assets/css/styles.css" />
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" />
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <title>Invoice Admin</title>
</head>

<body class="link-sidebar">

  <div id="main-wrapper">

    <?php require_once("./bar/sidebar.php") ?>
    <div class="page-wrapper">

      <?php require_once("./bar/header.php") ?>
      <!-- sidebar-horizon.php -->


      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="datatables">



            <!-- start Default Ordering -->
            <div class="card">

              <div class="card-body">
                <h3>Invoice Admin Check</h3>
                <div class="table-responsive">
                  <table id="adminBillTable" class="table table-striped table-bordered display text-nowrap">
                    <thead>
                      <!-- start row -->
                      <tr>
                        <th>Id</th>
                        <th>ชื่อเล่น</th>
                        <th>ตำแหน่ง</th>
                        <th>องค์กร </th>
                        <th>รายการ</th>
                        <th>หลักฐาน</th>
                        <th>ช่องทางการชำระเงิน</th>
                        <th>สถานะ</th>
                        <th>การอนุมัติ</th>
                        <th>Create at</th>
                        <th>Update at</th>
                      </tr>
                      <!-- end row -->
                    </thead>
                    <tbody>


                    </tbody>
                    <tfoot>
                      <!-- start row -->
                      <tr>
                        <th>Id</th>
                        <th>ชื่อเล่น</th>
                        <th>ตำแหน่ง</th>
                        <th>องค์กร </th>
                        <th>รายการ</th>
                        <th>หลักฐาน</th>
                        <th>ช่องทางการชำระเงิน</th>
                        <th>สถานะ</th>
                        <th>การอนุมัติ</th>
                        <th>Create at</th>
                        <th>Update at</th>
                      </tr>
                      <!-- end row -->
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
            <!-- end Default Ordering -->
          </div>
        </div>
      </div>
    </div>

    <!-- The Modal -->
<div class="modal fade" id="contentModal" tabindex="-1" aria-labelledby="contentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="contentModalLabel">หลักฐานการชำระเงิน</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <!-- Image Viewer -->
        <img id="modalImage" src="" alt="Image Preview" class="img-fluid d-none">
        <!-- PDF Viewer -->
        <div id="pdfContainer">
        <canvas id="pdfCanvas" class="d-none" width="100%"></canvas></div>
      </div>
    </div>
  </div>
</div>

    <!--  require_once("./bar/setting.php")  -->

<script>
  function openModal(type, src) {
  const modalImage = document.getElementById('modalImage');
  const pdfCanvas = document.getElementById('pdfCanvas');
  const canvasContext = pdfCanvas.getContext('2d');

  
  modalImage.classList.add('d-none');
  pdfCanvas.classList.add('d-none');

  if (type === 'image') {
    
    modalImage.src = src;
    modalImage.classList.remove('d-none');
  } else if (type === 'pdf') {
   

pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.15.349/pdf.worker.min.js';


const loadingTask = pdfjsLib.getDocument(src);
loadingTask.promise.then(function (pdf) {
  pdf.getPage(1).then(function (page) {
    const pdfContainer = document.getElementById('pdfContainer'); 
    const pdfCanvas = document.getElementById('pdfCanvas');
    const canvasContext = pdfCanvas.getContext('2d');

  
    function updateViewport() {
      const containerWidth = pdfContainer.offsetWidth; 
      const pageWidth = page.getViewport({ scale: 1 }).width; 
      const scale = containerWidth / pageWidth; 

      const viewport = page.getViewport({ scale: scale });
      pdfCanvas.width = viewport.width;
      pdfCanvas.height = viewport.height;

      const renderContext = {
        canvasContext: canvasContext,
        viewport: viewport,
      };

    
      canvasContext.clearRect(0, 0, pdfCanvas.width, pdfCanvas.height);
      page.render(renderContext).promise.then(() => {
        pdfCanvas.classList.remove('d-none'); 
      });
    }

     setTimeout(() => {
        updateViewport();
      }, 0);

    window.addEventListener('resize', updateViewport);
  });
});

  } else {
    alert('Unsupported file type!'); 
  }

  // เปิด Modal
  const modal = new bootstrap.Modal(document.getElementById('contentModal'));
  modal.show();
}
</script>

    <div class="dark-transparent sidebartoggler"></div>
    <script src="../assets/js/vendor.min.js"></script>
    <!-- Import Js Files -->
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="../assets/js/theme/app.init.js"></script>
    <script src="../assets/js/theme/theme.js"></script>
    <script src="../assets/js/theme/app.min.js"></script>
    <script src="../assets/js/theme/sidebarmenu.js"></script>

    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.15.349/pdf.min.js"></script>
    <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/datatable/datatable-basic.init.js"></script>

</body>

<script>
   $(document).ready(function () {
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

<script>
  apiServer = "https://invoice.nekoth.com/API.php";
  $(document).ready(function() {
    const table = $('#adminBillTable').DataTable({
      scrollX: true,
      responsive: false,
      autoWidth: false,
      "order": [
        [0, 'desc']
      ],
      deferRender: true,
      pageLength: 10,
    });

    $.get(`${apiServer}/listBillAdmin/<?php echo $userInfo['organize']?>`, function(data) {

      table.clear();




      for (let i = 0; i < data.length; i++) {

        const payment = data[i].payment === '1' ?
          'Application/ATM' :
          data[i].payment === '2' ?
          'เงินสด' :
          data[i].payment === '3' ?
          'เช็คเงินสด' :
          data[i].payment === '4' ?
          'แคชเชียร์เช็ค' :
          '<img src="../img/no-results.png" alt="no-results" width="40">';

        const deleteBtn = data[i].status === '1' ?
          '<button type="button" class="btn bg-danger-subtle delete-btn" alt="Delete" title="Delete" data-id= ' + data[i].bill_id + ' data-des=' + data[i].description + '><i class="ti ti-trash fs-7"></i></button>' :
          '<button type="button" class="btn bg-danger-subtle" alt="Delete" title="Delete" disabled><i class="ti ti-trash fs-7"></i></button>';

          const status = data[i].status === '1' ?
          '<img src="../img/waiting.png" alt="Pending" width="40">' :
          data[i].status === '2' ?
          '<img src="../img/true.png" alt="Approve" width="40">' :
          data[i].status === '3' ?
          '<img src="../img/false.png" alt="Disapprove" width="40">' :
          '<img src="../img/no-results.png" alt="no-results" width="40">';

        const fileExtension = data[i].file.split('.').pop().toLowerCase();


const files = fileExtension === 'pdf' ?
 
  '<img src="../img/pdf.png" width="40px" style="cursor: pointer;" onclick="openModal(\'pdf\', \'../file-bill/' + data[i].file + '\')"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>' :
  (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension) ?
    
    '<img src="../file-bill/' + data[i].file + '" width="40px" style="cursor: pointer;" onclick="openModal(\'image\', \'../file-bill/' + data[i].file + '\')">' :
    ''
  );


        const newData = data[i].create_at && isRecent(data[i].create_at) ?
          '<img src="../img/new.png" alt="new" width="30">' :
          '';


        function isRecent(updateAt) {
          const now = new Date();
          const updateTime = new Date(updateAt);
          const diffInMinutes = (now - updateTime) / (1000 * 60);
          return diffInMinutes <= 60;
        }

        table.row.add([
          data[i].bill_id,
          data[i].nickname,
          data[i].position,
          data[i].organize,
          data[i].description,
          files,
          payment,
          status,
          '<select class="form-select mb-3 status-select " data-id="' + data[i].bill_id + '">' +
          '<option value="1" ' + (data[i].status == 1 ? 'selected' : '') + '>รออนุมัติ</option>' +
          '<option value="2" ' + (data[i].status == 2 ? 'selected' : '') + '>อนุมัติ</option>' +
          '<option value="3" ' + (data[i].status == 3 ? 'selected' : '') + '>ไม่อนุมัติ</option>' +
          '</select>' +
          '<button type="button" class="btn bg-warning-subtle change-btn" alt="Change" title="Change" data-id="' + data[i].bill_id + '" data-des="' + data[i].description + '">' +
          '<i class="ti ti-pencil fs-7"></i></button>' + deleteBtn,
          
          data[i].bill_create_at,
          data[i].bill_update_at,

        ]);
      };


      table.draw();
     
    });


  });
</script>
<script>
  $(document).on('click', '.change-btn', function() {
    let itemId = $(this).data('id'); // Get the ID from data-id
    let newStatus = $('.status-select[data-id="' + itemId + '"]').val(); // Get the selected status
    let description = $(this).data('des');

    switch (newStatus) {
      case '1':
        cf = "รอการอนุมัติ";

        break;
      case '2':
        cf = "อนุมัติ";
        break;

      case '3':
        cf = "ไม่อนุมัติ";
        break;

      default :
      cf = "ไม่มีสถานะ";
      break;
    }



    Swal.fire({
      title: 'ยืนยันการเปลี่ยนสถานะ?',
      text: 'รายการ: ' + description + ', สถานะใหม่: ' + cf,
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, change it!',
      cancelButtonText: 'Cancel',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        
        $.ajax({
          url: `${apiServer}/updateStatus`, 
          type: 'PUT',
          data: JSON.stringify({
            id: itemId,
            status: newStatus
          }),
          contentType: 'application/json',
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              Swal.fire({
                icon: 'success',
                title: 'สถานะถูกเปลี่ยนสำเร็จ!',
                text: response.message,
                timer: 3000,
                confirmButtonText: 'ตกลง'
              }).then(() => {
                window.location.reload(); // Reload page after success
              });
            } else {
              Swal.fire(
                'Error!',
                response.message || 'Something went wrong.',
                'error'
              );
            }
          },
          error: function() {
            Swal.fire(
              'Error!',
              'Could not connect to the server.',
              'error'
            );
          }
        });
      }
    });
  });
</script>

<script>
  $(document).ready(function() {
    // Handle delete button click
    $(document).on('click', '.delete-btn', function() {
      let itemId = $(this).data('id');
      let itemDescription = $(this).data('des'); // Get the id of the item to delete

      // Trigger SweetAlert for confirmation
      Swal.fire({
        title: 'ลบหลักฐานการชำระเงิน?',
        text: 'รายการ : ' + itemDescription + ', ID: ' + itemId,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: `${apiServer}/deleteBill`,
            type: 'PUT',
            data: JSON.stringify({
              id: itemId
            }),
            contentType: 'application/json',
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                Swal.fire({
                  icon: 'success',
                  title: 'ลบรายการ ' + itemDescription + 'สำเร็จ!',
                  text: response.message,
                  timer: 3000,
                  confirmButtonText: 'ตกลง'
                }).then(() => {
                  window.location.reload(); // Reload page after success
                });
              } else {
                Swal.fire(
                  'Error!',
                  response.message || 'Something went wrong.',
                  'error'
                );
              }
            },
            error: function() {
              Swal.fire(
                'Error!',
                'Could not connect to the server.',
                'error'
              );
            }
          });
        }
      });
    });
  });
</script>

</html>