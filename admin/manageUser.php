<?php date_default_timezone_set('Asia/Bangkok');
require_once '../controller/conn.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_urole'] != 'admin' ) {
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

    <title>Invoice Manage User</title>
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
                                                <th>ชื่อ-นามสกุล</th>
                                                <th>ชื่อเล่น</th>
                                                <th>ตำแหน่ง </th>
                                                <th>องค์กร</th>
                                                <th>สิทธิ์</th>
                                                <th>เข้าสู่ระบบล่าสุด</th>
                                                <th>เข้าระบบครั้งแรก</th>
                                                <th>อัปเดตข้อมูล</th>
                                            </tr>
                                            <!-- end row -->
                                        </thead>
                                        <tbody>


                                        </tbody>
                                        <tfoot>
                                            <!-- start row -->
                                            <tr>
                                                <th>Id</th>
                                                <th>ชื่อ-นามสกุล</th>
                                                <th>ชื่อเล่น</th>
                                                <th>ตำแหน่ง </th>
                                                <th>องค์กร</th>
                                                <th>สิทธิ์</th>
                                                <th>เข้าสู่ระบบล่าสุด</th>
                                                <th>เข้าระบบครั้งแรก</th>
                                                <th>อัปเดตข้อมูล</th>
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

         <!-- require_once("./bar/setting.php")  -->


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
                [6, 'desc']
            ],
            deferRender: true,
            pageLength: 10,
        });

        $.get(`${apiServer}/listUser/<?php echo $userInfo['organize']?>`, function(data) {

            table.clear();


            for (let i = 0; i < data.length; i++) {

            

                table.row.add([
                    data[i].id,
                    data[i].full_name,
                    data[i].nickname,
                    data[i].position,
                    data[i].organize,
                    '<select class="form-select mb-3 urole-select " data-id="' + data[i].id + '">' +
                    '<option value="admin" ' + (data[i].urole == 'admin' ? 'selected' : '') + '>admin</option>' +
                    '<option value="user" ' + (data[i].urole == 'user' ? 'selected' : '') + '>user</option>' +
                    '<option value="disable" ' + (data[i].urole == 'disable' ? 'selected' : '') + '>disable</option>' +
                    '</select>' +
                    '<button type="button" class="btn bg-warning-subtle change-btn" alt="Change" title="Change" data-id="' + data[i].id + '" data-name="' + data[i].full_name + '">' +
                    '<i class="ti ti-pencil fs-7"></i>' +
                    '</button>' +
                    '<button type="button" class="btn bg-danger-subtle delete-btn" alt="Delete" title="Delete" data-id= ' + data[i].id + ' data-name=' + data[i].full_name + '><i class="ti ti-trash fs-7"></i></button>',
                    data[i].last_login,
                    data[i].user_create_at,
                    data[i].user_update_at,


                ]);
            };


            table.draw();

        });


    });
</script>
<script>
    $(document).on('click', '.change-btn', function() {
        let itemId = $(this).data('id'); // Get the ID from data-id
        let newUrole = $('.urole-select[data-id="' + itemId + '"]').val(); // Get the selected status
        let fullname = $(this).data('name');
        Swal.fire({
            title: 'ยืนยันการเปลี่ยนสิทธิ์การใช้งาน?',
            text: 'ชื่อ : ' + fullname + ', สิทธิ์ใหม่: ' + newUrole,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, change it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to change the status
                $.ajax({
                    url: `${apiServer}/updateRole`, // Update this with your API endpoint
                    type: 'PUT',
                    data: JSON.stringify({
                        id: itemId,
                        urole: newUrole
                    }),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'เปลี่ยนสิทธิ์การใช้งานสำเร็จ!',
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
            let fullname = $(this).data('name');

            // Trigger SweetAlert for confirmation
            Swal.fire({
                title: 'ลบสิทธิ์การเข้าใช้งานระบบ?',
                text: 'ชื่อ : ' + fullname + ', ID: ' + itemId,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `${apiServer}/disableUser`,
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
                                    title: 'ลบสิทธิ์ ' + fullname + 'สำเร็จ!',
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