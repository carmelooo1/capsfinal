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

    <title>USERS</title>

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

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background: rgb(3,85,32); background: linear-gradient(305deg, rgba(3,85,32,1) 28%, rgba(9,32,121,1) 60%, rgba(2,0,36,1) 100%, rgba(255,255,255,0.2413340336134454) 100%);">


            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/capstone/dashboard/dashboard_admin/studentmanagement.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-bookmark"></i>
                </div>
                <div class="sidebar-brand-text mx-3">USERS</div>
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
            <button type="button" class="btn btn- d-flex justify-content-start mb-2 mt-2" style="color: #fff; " data-toggle="modal" data-target="#reviewsModal" onmouseover="this.style.background='linear-gradient(305deg, rgba(9,32,121,1) 75%, rgba(2,0,36,1) 100%, rgba(255,255,255,0.2413340336134454) 100%, #444)';" onmouseout="this.style.background=''; this.style.color='#fff';">
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
                                    <h6 class="m-0 font-weight-bold text-primary">EVALUATION LISTS</h6>
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
            <button type="button" class="btn btn- d-flex justify-content-start mb-2 mt-2" style="color: #fff" data-toggle="modal" data-target="#attendanceModal" onmouseover="this.style.background='linear-gradient(305deg, rgba(9,32,121,1) 75%, rgba(2,0,36,1) 100%, rgba(255,255,255,0.2413340336134454) 100%, #444)';" onmouseout="this.style.background=''; this.style.color='#fff';">
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
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">ATTENDANCE LISTS</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th> ID NUMBER </th>
                                                    <th> NAME </th>
                                                    <th> COURSE </th>
                                                    <th> YEAR LEVEL </th>
                                                    <th> CHECK IN TIME </th>
                                                    <th> CHECK OUT TIME </th>
                                                    <th> ACTION </th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th> ID NUMBER </th>
                                                    <th> NAME </th>
                                                    <th> COURSE </th>
                                                    <th> YEAR LEVEL </th>
                                                    <th> CHECK IN TIME </th>
                                                    <th> CHECK OUT TIME </th>
                                                    <th> ACTION </th>
                                                </tr>
                                            </tfoot>
                                            <tr>
                                                <?php
                                                $getdata = mysqli_query($conn, "SELECT * FROM attendance");
                                                while ($row = mysqli_fetch_array($getdata)) {
                                                ?>
                                                    <td> <?php echo $row['id_number'] ?> </td>
                                                    <td><?php echo $row['fname'] . ' ' . $row['lname']; ?></td>

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


            <!-- Divider -->
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









        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow" style="background-color: #0b0667; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">




                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">


                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">

                            <!-- Dropdown - User Information -->
                            <ul class="navbar-nav ml-auto">

                                <div class="topbar-divider d-none d-sm-block"></div>


                                <!-- Dropdown - User Information -->
                                <li class="nav-item dropdown no-arrow">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
                                        <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                                        <?php echo $fname . ' ' . $lname; ?>
                                    </a>
                                    <!-- Dropdown - User Information -->
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Logout
                                        </a>
                                    </div>
                                </li>

                            </ul>

                </nav>
                <!-- End of Topbar -->



                <!-- Table without Modal -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-success">STUDENT LISTS</h6>
                        <div>
                            <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#regteacherModal">
                                Add Teacher
                            </button>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#regstudentModal">
                                Add Student
                            </button>
                        </div>
                    </div>


                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="dataTable5" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th> ID-NUMBER </th>
                                        <th> FIRST NAME </th>
                                        <th> LAST NAME </th>
                                        <th> COURSE </th>
                                        <th> YEAR LEVEL </th>
                                        <th> EMAIL </th>
                                        <th> ACTION </th>
                                        <th> ACTION </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $getdata = mysqli_query($conn, "SELECT * FROM students");
                                    while ($row = mysqli_fetch_array($getdata)) {
                                    ?>
                                        <tr>
                                            <td> <?php echo $row['id_number'] ?> </td>
                                            <td> <?php echo $row['fname'] ?> </td>
                                            <td> <?php echo $row['lname'] ?> </td>
                                            <td> <?php echo $row['course'] ?></td>
                                            <td> <?php echo $row['year_level'] ?></td>
                                            <td> <?php echo $row['email'] ?></td>
                                            <td>
                                                <!-- Update Button -->
                                                <button type="button" class="btn btn-primary btn-sm update-btn" data-id_number="<?php echo $row['id_number']; ?>">Update</button>
                                            </td>
                                            <td>
                                                <!-- Delete Button -->
                                                <button type="button" class="btn btn-danger btn-sm delete-btn" data-id_number="<?php echo $row['id_number']; ?>">Delete</button>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-success">TEACHER LISTS</h6>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="teacherTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Teacher ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Fetch teacher data from database
                                        $getTeacherData = mysqli_query($conn, "SELECT * FROM teachers");
                                        while ($teacherRow = mysqli_fetch_array($getTeacherData)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $teacherRow['id_number']; ?></td>
                                                <td><?php echo $teacherRow['fname']; ?></td>
                                                <td><?php echo $teacherRow['lname']; ?></td>
                                                <td><?php echo $teacherRow['email']; ?></td>
                                                <td>
                                                    <!-- Update Button -->
                                                    <button type="button" class="btn btn-primary btn-sm teacher-update-btn" data-id_number="<?php echo $teacherRow['id_number']; ?>">Update</button>
                                                </td>
                                                <td>
                                                    <!-- Delete Button -->
                                                    <button type="button" class="btn btn-danger btn-sm teacher-delete-btn" data-id_number="<?php echo $teacherRow['id_number']; ?>">Delete</button>
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

                    <script>
                        $(document).ready(function() {
                            $('#teacherTable').dataTable({
                                searching: true // Enable search feature
                            });
                        });
                    </script>












                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            // Delete functionality
                            $('.delete-btn').on('click', function() {
                                var id_number = $(this).data('id_number');
                                if (confirm('Are you sure you want to delete this record?')) {
                                    // Perform AJAX request to delete the record with the given id_number
                                    $.ajax({
                                        url: 'delete_student.php',
                                        method: 'POST',
                                        data: {
                                            id_number: id_number
                                        },
                                        success: function(response) {
                                            // Handle success response
                                            console.log(response);
                                            location.reload();
                                        },
                                        error: function(xhr, status, error) {
                                            console.error(xhr.responseText);
                                        }
                                    });
                                }
                            });
                        });
                    </script>

                    <script>
                        $(document).ready(function() {
                            // Delete functionality
                            $('.teacher-delete-btn').on('click', function() {
                                var id_number = $(this).data('id_number');
                                if (confirm('Are you sure you want to delete this record?')) {
                                    // Perform AJAX request to delete the record with the given id_number
                                    $.ajax({
                                        url: 'process_delete_teacher.php',
                                        method: 'POST',
                                        data: {
                                            id_number: id_number
                                        },
                                        success: function(response) {
                                            // Handle success response
                                            console.log(response);
                                            location.reload();
                                        },
                                        error: function(xhr, status, error) {
                                            console.error(xhr.responseText);
                                        }
                                    });
                                }
                            });
                        });
                    </script>



                    <div class="modal fade" id="regstudentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Register an Account</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <!-- Registration Form/ CREATE ACCOUNT -->
                                <form action="process.php" method="POST">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="idnumber" class="form-label">ID Number:</label>
                                            <input type="text" class="form-control" name="regform_id" placeholder="Enter ID number" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="firstName" class="form-label">First Name:</label>
                                            <input type="text" class="form-control" name="regform_fname" placeholder="Enter first name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="lastName" class="form-label">Last Name:</label>
                                            <input type="text" class="form-control" name="regform_lname" placeholder="Enter last name" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="course" class="form-label">Course:</label>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="regform_course" id="course_ccje" value="CCCJE" required>
                                                <label class="form-check-label" for="course_ccje">CCJE</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="regform_course" id="course_coe" value="COE" required>
                                                <label class="form-check-label" for="course_ccje">COE</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="regform_course" id="course_cite" value="CITE" required>
                                                <label class="form-check-label" for="course_cite">CITE</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="regform_course" id="course_bsa" value="BSA" required>
                                                <label class="form-check-label" for="course_bsa">BSA</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="regform_course" id="course_cma" value="CMA" required>
                                                <label class="form-check-label" for="course_cma">CMA</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="regform_course" id="course_coed" value="COED" required>
                                                <label class="form-check-label" for="course_coed">COED</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="regform_course" id="course_cahs" value="CAHS" required>
                                                <label class="form-check-label" for="course_cahs">CAHS</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="regform_course" id="course_mar" value="come" required>
                                                <label class="form-check-label" for="course_mar">COME</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="regform_course" id="course_shs" value="SHS" required>
                                                <label class="form-check-label" for="course_shs">SHS</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="regform_course" id="course_gschool" value="BEED" required>
                                                <label class="form-check-label" for="course_gschool">BEED</label>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="yearlevel" class="form-label">Year Level:</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="regform_yearlevel[]" value="1" id="yearlevel1">
                                                <label class="form-check-label" for="yearlevel1">Year 1</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="regform_yearlevel[]" value="2" id="yearlevel2">
                                                <label class="form-check-label" for="yearlevel2">Year 2</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="regform_yearlevel[]" value="3" id="yearlevel3">
                                                <label class="form-check-label" for="yearlevel3">Year 3</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="regform_yearlevel[]" value="4" id="yearlevel3">
                                                <label class="form-check-label" for="yearlevel3">Year 4</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="regEmail" class="form-label">Email address:</label>
                                            <input type="email" class="form-control" name="regform_email" id="regEmail" placeholder="Enter email here..." required>
                                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="regPassword">Password:</label>
                                            <input type="password" value="" name="regform_password" id="regPassword2" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required placeholder="Enter password here...">
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirmPassword">Confirm Password:</label>
                                            <input type="password" value="" name="regform_password2" id="confirmPassword2" class="form-control" required placeholder="Confirm password">
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" onclick="myFunction('regPassword2, confirmPassword2')"> Show password
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-secondary">CLEAR</button>
                                        <button type="submit" name="regformstudent" class="btn btn-primary">REGISTER</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                    <!-- Teacher Registration Modal -->
                    <div class="modal fade" id="regteacherModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Register an Account</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <!-- Registration Form/ CREATE ACCOUNT -->
                                <form action="process.php" method="POST">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="idnumber" class="form-label">ID Number:</label>
                                            <input type="text" class="form-control" name="regform_id" placeholder="Enter ID number" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="firstName" class="form-label">First Name:</label>
                                            <input type="text" class="form-control" name="regform_fname" placeholder="Enter first name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="lastName" class="form-label">Last Name:</label>
                                            <input type="text" class="form-control" name="regform_lname" placeholder="Enter last name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="regEmail" class="form-label">Email address:</label>
                                            <input type="email" class="form-control" name="regform_email" id="regEmail" placeholder="Enter email here..." required>
                                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="regPassword">Password:</label>
                                            <input type="password" value="" name="regform_password" id="regPassword" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required placeholder="Enter password here...">
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirmPassword">Confirm Password:</label>
                                            <input type="password" value="" name="regform_password2" id="confirmPassword" class="form-control" required placeholder="Confirm password">
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" onclick="myFunction('regPassword, confirmPassword')"> Show password
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-secondary">CLEAR</button>
                                        <button type="submit" name="regformteacher" class="btn btn-primary">REGISTER</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <!-- End of Main Content -->



            <!-- Update Student Modal -->
            <div class="modal fade" id="updateStudentModal" tabindex="-1" role="dialog" aria-labelledby="updateStudentModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateStudentModalLabel">Update Student</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for updating an existing student -->
                            <form id="updateStudentForm" method="post">
                                <!-- Hidden input field for student ID -->
                                <input type="hidden" id="updateStudentId" name="updateStudentId">
                                <!-- Input fields for student details -->
                                <div class="form-group">
                                    <label for="updateStudentIdNumber">ID Number:</label>
                                    <input type="text" class="form-control" id="updateStudentIdNumber" name="updateStudentIdNumber">
                                </div>
                                <div class="form-group">
                                    <label for="updateStudentFirstName">First Name:</label>
                                    <input type="text" class="form-control" id="updateStudentFirstName" name="updateStudentFirstName">
                                </div>
                                <div class="form-group">
                                    <label for="updateStudentLastName">Last Name:</label>
                                    <input type="text" class="form-control" id="updateStudentLastName" name="updateStudentLastName">
                                </div>
                                <div class="form-group">
                                    <label for="updateStudentCourse">Course:</label>
                                    <input type="text" class="form-control" id="updateStudentCourse" name="updateStudentCourse">
                                </div>
                                <div class="form-group">
                                    <label for="updateStudentYearLevel">Year Level:</label>
                                    <input type="text" class="form-control" id="updateStudentYearLevel" name="updateStudentYearLevel">
                                </div>
                                <div class="form-group">
                                    <label for="updateStudentEmail">Email:</label>
                                    <input type="email" class="form-control" id="updateStudentEmail" name="updateStudentEmail">
                                </div>
                                <!-- Submit button -->
                                <button type="submit" class="btn btn-primary" name="updateStudent">Update Student</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Update teacher Modal -->
            <div class="modal fade" id="updateteacherModal" tabindex="-1" role="dialog" aria-labelledby="updateStudentModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateteacherModalLabel">Update Student</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for updating an existing teacher -->
                            <form id="updateteacherForm" method="post">
                                <!-- Hidden input field for teacher ID -->
                                <input type="hidden" id="updateteacherId" name="updateteacherId">
                                <!-- Input fields for student details -->
                                <div class="form-group">
                                    <label for="updateteacherIdNumber">ID Number:</label>
                                    <input type="text" class="form-control" id="updateteacherIdNumber" name="updateteacherIdNumber">
                                </div>
                                <div class="form-group">
                                    <label for="updateteacherFirstName">First Name:</label>
                                    <input type="text" class="form-control" id="updateteacherFirstName" name="updateteacherFirstName">
                                </div>
                                <div class="form-group">
                                    <label for="updateteacherLastName">Last Name:</label>
                                    <input type="text" class="form-control" id="updateteacherLastName" name="updateteacherLastName">
                                </div>

                                <div class="form-group">
                                    <label for="updateteacherEmail">Email:</label>
                                    <input type="email" class="form-control" id="updateteacherEmail" name="updateteacherEmail">
                                </div>

                                <!-- Submit button -->
                                <button type="submit" class="btn btn-primary" name="updateTeacher">Update Teacher</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>





            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                // Function to fetch old data and populate the update form
                $(document).on("click", ".teacher-update-btn", function() {
                    var id_number = $(this).data("id_number");
                    $.ajax({
                        url: 'fetch_teacher_details.php',
                        type: 'POST',
                        data: {
                            id_number: id_number
                        },
                        success: function(response) {
                            var teacher = JSON.parse(response);
                            $('#updateteacherId').val(teacher.id);
                            $('#updateteacherIdNumber').val(teacher.id_number);
                            $('#updateteacherFirstName').val(teacher.fname);
                            $('#updateteacherLastName').val(teacher.lname);
                            $('#updateteacherEmail').val(teacher.email);
                            $('#updateteacherModal').modal('show');
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });


                // Update teacher modal process
                $('#updateteacherForm').submit(function(event) {
                    event.preventDefault(); // Prevent default form submission
                    var formData = $(this).serialize();
                    $.ajax({
                        url: 'process_update_teacher.php',
                        method: 'POST',
                        data: formData,
                        success: function(response) {
                            // Handle success response
                            console.log(response);
                            // can close the modal
                            $('#updateteacherModal').modal('hide');
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            </script>

            <script>
                // Function to fetch old data and populate the update form
                $(document).on("click", ".teacher-update-btn", function() {
                    var id_number = $(this).data("id_number");
                    $.ajax({
                        url: 'fetch_teacher_details.php',
                        type: 'POST',
                        data: {
                            id_number: id_number
                        },
                        success: function(response) {
                            var teacher = JSON.parse(response);
                            $('#updateteacherId').val(teacher.id);
                            $('#updateteacherIdNumber').val(teacher.id_number);
                            $('#updateteacherFirstName').val(teacher.fname);
                            $('#updateteacherLastName').val(teacher.lname);
                            $('#updateteacherEmail').val(teacher.email);
                            $('#updateteacherModal').modal('show');
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });


                // Update Student modal process
                $('#updateteacherForm').submit(function(event) {
                    event.preventDefault(); // Prevent default form submission
                    var formData = $(this).serialize();
                    $.ajax({
                        url: 'process_update_teacher.php',
                        method: 'POST',
                        data: formData,
                        success: function(response) {
                            // Handle success response
                            console.log(response);
                            // can close the modal
                            $('#updateteacherModal').modal('hide');
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            </script>

            <script>
                // Function to fetch old data and populate the update form
                $(document).on("click", ".update-btn", function() {
                    var id_number = $(this).data("id_number");
                    $.ajax({
                        url: 'fetch_student_details.php',
                        type: 'POST',
                        data: {
                            id_number: id_number
                        },
                        success: function(response) {
                            var student = JSON.parse(response);
                            $('#updateStudentId').val(student.id);
                            $('#updateStudentIdNumber').val(student.id_number);
                            $('#updateStudentFirstName').val(student.fname);
                            $('#updateStudentLastName').val(student.lname);
                            $('#updateStudentCourse').val(student.course);
                            $('#updateStudentYearLevel').val(student.year_level);
                            $('#updateStudentEmail').val(student.email);
                            $('#updateStudentModal').modal('show');
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });


                // Update Student modal process
                $('#updateStudentForm').submit(function(event) {
                    event.preventDefault(); // Prevent default form submission
                    var formData = $(this).serialize();
                    $.ajax({
                        url: 'process_update_student.php',
                        method: 'POST',
                        data: formData,
                        success: function(response) {
                            // Handle success response
                            console.log(response);
                            // can close the modal
                            $('#updateStudentModal').modal('hide');
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            </script>



        </div>
        <!-- End of Main Content -->
    </div>

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

    <script>
        $(document).ready(function() {
            $('#dataTable4').DataTable();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#dataTable5').DataTable();
        });
    </script>

    <script>
        function myFunction(ids) {
            var idArray = ids.split(',');
            for (var i = 0; i < idArray.length; i++) {
                var x = document.getElementById(idArray[i].trim());
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }
        }
    </script>


</body>

</html>