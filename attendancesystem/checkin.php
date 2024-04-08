<?php
include "conn.php";
ini_set('session.cookie_lifetime', 3600);
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true || (isset($_SESSION['logout_flag']) && $_SESSION['logout_flag'] === true)) {
    header("Location: /capstone/dashboard/dashboard_admin/index.php");
    exit();
}

$session_timeout = 600;
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
    $_SESSION['logout_flag'] = true;

    session_unset();     // unset $_SESSION variable for the run-time
    session_destroy();   // destroy session data in storage
    header("Location: /capstone/dashboard/dashboard_admin/index.php");
    exit();
}


$_SESSION['last_activity'] = time();

if (isset($_GET['logout'])) {
    $_SESSION['logout_flag'] = true;

    session_unset();     // unset $_SESSION variable for the run-time
    session_destroy();   // destroy session data in storage
    header("Location: /capstone/dashboard/dashboard_admin/index.php");
    exit();
}
// Check if the user is logged in
if (isset($_SESSION['admin_logged_in'])) {
    $fname = $_SESSION['admin_fname'];
    $lname = $_SESSION['admin_lname'];
} else {
    // Redirect to login page if user is not logged in
    header("Location: /capstone/dashboard/dashboard_student/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ATTENDANCE SYSTEM</title>

    <!-- Favicons -->
    <link href="img/ui.ico" rel="icon">
    <link href="img/ui.ico" rel="ui.ico">

    <!-- Custom fonts for this template-->
    <link href="/capstone/dashboard/dashboard_admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/capstone/dashboard/dashboard_admin/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="/capstone/dashboard/dashboard_admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar"
            style="background: rgb(3,85,32); background: linear-gradient(305deg, rgba(3,85,32,1) 28%, rgba(9,32,121,1) 60%, rgba(2,0,36,1) 100%, rgba(255,255,255,0.2413340336134454) 100%);">


            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/capstone/dashboard/dashboard_admin/index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-bookmark"></i>
                </div>
                <div class="sidebar-brand-text mx-3">ADMIN</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="/capstone/dashboard/dashboard_admin/index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading mb-2">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <!-- Button trigger modal -->
    <button type="button" class="btn btn- d-flex justify-content-start mb-2 mt-2" style="color: #fff; " data-toggle="modal" data-target="#reviewsModal"onmouseover="this.style.background='linear-gradient(305deg, rgba(9,32,121,1) 75%, rgba(2,0,36,1) 100%, rgba(255,255,255,0.2413340336134454) 100%, #444)';" onmouseout="this.style.background=''; this.style.color='#fff';">
    <i class="fas fa-fw fa-book mr-2"></i>
    <span class="small">EVALUATIONS</span>
</button>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="reviewsModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">EVALUATIONS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-success">EVALUATION LISTS</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>EVALUATION</th>
                                            <th>TITLES</th>
                                            <th>COURSE</th>
                                            <th>FEEDBACKS</th>
                                            <th>RECOMENDATIONS</th>
                                            <th>RATINGS</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>EVALUATION</th>
                                            <th>TITLES</th>
                                            <th>COURSE</th>
                                            <th>FEEDBACKS</th>
                                            <th>RECOMENDATIONS</th>
                                            <th>RATINGS</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </tfoot>
            <tr>

<?php
$getdata = mysqli_query($conn, "SELECT * FROM evaluation");
while ($row = mysqli_fetch_array($getdata)) {


    ?>

                <td> <?php echo $row['evaluationID'] ?> </td>
                <td> <?php echo $row['titles'] ?> </td>
                <td> <?php echo $row['course'] ?> </td>
                <td> <?php echo $row['feedbacks'] ?> </td>
                <td> <?php echo $row['recommendations'] ?> </td>
                <td> <?php echo $row['rating'] ?> </td>
                <td>
                    <form action="delete.php" method="GET" style="margin: 0; padding: 0;">
                        <input type="hidden" name="id" value="<?php echo $row['evaluationID']; ?>">
                        <button type="submit" class="btn btn-danger">DELETE</button>
                    </form>
                </td>
                </tr>

                <?php
}
?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>



<!-- Attendance -->
<button type="button" class="btn btn- d-flex justify-content-start mb-2 mt-2"style="color: #fff" data-toggle="modal" data-target="#attendanceModal"onmouseover="this.style.background='linear-gradient(305deg, rgba(9,32,121,1) 75%, rgba(2,0,36,1) 100%, rgba(255,255,255,0.2413340336134454) 100%, #444)';"
                onmouseout="this.style.background=''; this.style.color='#fff';">
    <i class="fas fa-fw fa-book mr-2"></i>
    <span class="small">ATTENDANCE</span>
</button>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="attendanceModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ATTENDANCE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-success">ATTENDANCE LISTS</h6>
            <form method="post" action="export.php">
         <input type="submit" name="export" class="btn btn-success" value="Export to Excel" />
        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th> ID NUMBER </th>
                                            <th> FIRST NAME </th>
                                            <th> LAST NAME </th>
                                            <th> COURSE </th>
                                            <th> YEAR LEVEL </th>
                                            <th> TIME IN TIME </th>
                                            <th> TIME OUT TIME </th>
                                            <th> ACTION </th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th> ID NUMBER </th>
                                            <th> FIRST NAME </th>
                                            <th> LAST NAME </th>
                                            <th> COURSE </th>
                                            <th> YEAR LEVEL </th>
                                            <th> TIME IN TIME </th>
                                            <th> TIME OUT TIME </th>
                                            <th> ACTION </th>
                                        </tr>
                                    </tfoot>
<tr>
<?php
$getdata = mysqli_query($conn, "SELECT * FROM attendance");
while ($row = mysqli_fetch_array($getdata)) {
    ?>
                <td> <?php echo $row['id_number'] ?> </td>
                <td> <?php echo $row['fname'] ?> </td>
                <td> <?php echo $row['lname'] ?> </td>
                <td> <?php echo $row['course'] ?> </td>
                <td> <?php echo $row['year_level'] ?></td>
                <td> <?php echo $row['checkin_time'] ?> </td>
                <td> <?php echo $row['checkout_time'] ?> </td>
                <td>
                    <form action="delete.php" method="GET" style="margin: 0; padding: 0;">
                        <input type="hidden" name="id" value="<?php echo $row['id_number']; ?>">
                        <button type="submit" class="btn btn-danger">DELETE</button>
                    </form>
                </td>
                </tr>

                <?php
}
?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>




<!-- Divider -->
<hr class="sidebar-divider">
<div class="sidebar-heading">
</div>
<li class="nav-item ">
    <a class="nav-link" href="/capstone/dashboard/dashboard_admin/add_student.php">
        <i class="fas fa-fw fa-wrench"></i>
        <span>USER MANAGEMENT</span>
    </a>
</li>
            
<!-- Divider -->
<hr class="sidebar-divider">
<div class="sidebar-heading">
</div>

<li class="nav-item ">
    <a class="nav-link" href="/capstone/dashboard/dashboard_admin/book_table.php">
        <i class="fas fa-fw fa-wrench"></i>
        <span>BOOK LISTS TABLE</span>
    </a>
</li>
            
<!-- Divider -->
<hr class="sidebar-divider">
<div class="sidebar-heading">
</div>

<li class="nav-item">
    <a class="nav-link" href="/capstone/dashboard/dashboard_admin/approval.php">
        <i class="fas fa-fw fa-wrench"></i>
        <span>APPROVAL LISTS</span>
    </a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">
<div class="sidebar-heading">
</div>




<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link" href="/capstone/attendancesystem/checkin.php">
        <i class="fas fa-fw fa-wrench"></i>
        <span>ATTENDANCE SYSTEM</span>
    </a>
</li>
<hr class="sidebar-divider mt-3 mb-2">
<div class="sidebar-heading">
</div>




            <!-- Heading -->
            <div class="sidebar-heading">
           <!-- CONTENT --> <!-- CONTENT --> <!-- CONTENT -->
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                                <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow"
                    style="background-color: #0b0667; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">

                   
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                                    <?php echo $fname . ' ' . $lname; ?>
                            </a>
                           
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">

                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>

        <!-- Sidebar -->
        
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">TIME IN</h1>
            </div>

            <!-- Content  -->
            <div class="container">
                <form action="checkin.php" method="post">
                    <div class="form-group">
                        <label for="id_number">ID Number:</label>
                        <input type="text" id="id_number" name="id_number" required class="form-control" placeholder="Enter ID Number">
                    </div>

                    <div class="text-center mt-3">
                        <button class="btn btn-success" type="submit" name="checkin">TIME IN</button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <!-- Link to Dashboard as a button -->
                    <a href="/capstone/dashboard/dashboard_admin/index.php" class="btn btn-success">Go to ADMIN DASHBOARD</a>

                    <!-- Link to Checkout as a button -->
                    <a href="checkout.php" class="btn btn-success">Go to TIME OUT</a>
                </div>
            </div>

            <div style="text-align: center; font-weight:bold; margin-top:20px;">
                <?php
                include "conn.php";

                date_default_timezone_set('Asia/Manila');

                if (isset($_POST['checkin'])) {
                    $id_number = mysqli_real_escape_string($conn, $_POST['id_number']);

                    $checkStudentQuery = "SELECT * FROM students WHERE id_number = '$id_number'";
                    $result = mysqli_query($conn, $checkStudentQuery);

                    if (!$result) {
                        echo "Error: " . mysqli_error($conn);
                    } elseif (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $fname = $row['fname'];
                        $lname = $row['lname'];
                        $course = $row['course'];
                        $year_level = $row['year_level'];

                        $checkin_time = date('Y-m-d H:i:s');
                        $insertQuery = "INSERT INTO attendance (id_number, fname, lname, course, year_level, checkin_time) VALUES ('$id_number', '$fname', '$lname', '$course', '$year_level', '$checkin_time')";

                        if (mysqli_query($conn, $insertQuery)) {
                            echo "Check-in is successful!";
                            // Display user information in a table
                            echo "<h2>User Information</h2>";
                            echo "ID: " . $row['id_number'] . "<br>";
                            echo "First name: " . $row['fname'] . "<br>";
                            echo "Last name: " . $row['lname'] . "<br>";
                            echo "Course: " . $row['course'] . "<br>";
                            echo "Year Level: " . $row['year_level'] . "<br>";
                            echo "Check-in Time: " . $checkin_time . "<br>";
                        }
                    } else {
                        echo "Check-in failed: " . mysqli_error($conn);
                    }
                }
                ?>
            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <!-- Footer -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; SAF3 2023</span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="/capstone/index.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="/capstone/dashboard/dashboard_admin/vendor/jquery/jquery.min.js"></script>
    <script src="/capstone/dashboard/dashboard_admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/capstone/dashboard/dashboard_admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/capstone/dashboard/dashboard_admin/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="/capstone/dashboard/dashboard_admin/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="/capstone/dashboard/dashboard_admin/js/demo/chart-area-demo.js"></script>
    <script src="/capstone/dashboard/dashboard_admin/js/demo/chart-pie-demo.js"></script>

    <!-- Page level plugins -->
    <script src="/capstone/dashboard/dashboard_admin/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/capstone/dashboard/dashboard_admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="/capstone/dashboard/dashboard_admin/js/demo/datatables-demo.js"></script>


    <script>
        $(document).ready(function() {
            $('#dataTable1').DataTable();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#dataTable2').DataTable();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#dataTable3').DataTable();
        });
    </script>
</body>

</html>