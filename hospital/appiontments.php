<?php
// Database Connection
include("../connection.php");
// Session Start
session_start();
//if user loggout
if (!isset($_SESSION['hospital_id'])) {
    header("Location: ../login.php");
    exit;
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../admin/assets/style.css">
    <link rel="icon" href="../images/covidlogo.png">
    <link rel="stylesheet" href="https://cdn.usebootstrap.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>


<body>
    <!-- SIDEBAR -->
    <div id="sidebar">
        <header>
            <a href="#"><img src="../images/covidlogo.png" alt="" style="width:120px ; height:120;padding: 20px;"></a>
        </header>
        <ul class="nav">
           
           <li>
               <a href="appiontments.php">
                   <i class="fas fa-users"></i>Appointments
               </a>
           </li>
           <li>
               <a href="addvaccine.php">
                   <i class="fas fa-hospital"></i>Add vaccine
               </a>
           </li>
          

       </ul>
    </div>
    </div>
    </div>
    </div>
    <!-- SIDEBAR END -->
    <!-- NAV STARTS -->
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="../images/admin.jpg" alt="Admin Profile" class="adminpic">
                        <?php echo $_SESSION['hospital_id']; ?> <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu">
            <li><a href="#"><i class="fa-regular fa-bell"></i> Notifications</a></li>
            <li><a href="../logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i>Logout</a></li>
          </ul>
                </li>
            </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- NAV ENDS -->
        <!-- TABLE STARTS -->
                   <div class="container-fluid" id="all-products">
    <h1 class="text-center">HOSPITAL APPOINTMENTS</h1>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Hospital Name</th>
                    <th>Appointment Date</th>
                    <th>Test Name</th>
                    <th>Test Result</th>
                </tr>
            </thead>
            <tbody>
                <!-- PHP -->
                <?php
                $hospital_id = $_SESSION['hospital_id'];
                $query = "SELECT * FROM appointment WHERE hospital_id = $hospital_id";
                $result = mysqli_query($con, $query);

                if (!$result) {
                    die("Error executing the query: " . mysqli_error($con));
                }

                while ($row = mysqli_fetch_assoc($result)): 
                    $patient_id = $row['patient_id'];

                    $patient_query = "SELECT patient_name FROM patient WHERE patient_id = $patient_id";
                    $patient_result = mysqli_query($con, $patient_query);

                    $hospital_query = "SELECT hospital_name FROM hospital WHERE hospital_id = $hospital_id";
                    $hospital_result = mysqli_query($con, $hospital_query);

                    if ($patient_result && $hospital_result):
                        $patient_data = mysqli_fetch_assoc($patient_result);
                        $hospital_data = mysqli_fetch_assoc($hospital_result);

                        $patient_name = $patient_data['patient_name'];
                        $hospital_name = $hospital_data['hospital_name'];
                ?>
                <tr id="row_<?= $row['app_id'] ?>">
                    <td><?= $patient_name ?></td>
                    <td><?= $hospital_name ?></td>
                    <td><?= $row['app_date'] ?></td>
                    <td><?= $row['test_name'] ?></td>
                    <td>
                        <button class="positive-button btn btn-success" data-appid="<?= $row['app_id'] ?>">Positive</button>
                        <button class="negative-button btn btn-danger" data-appid="<?= $row['app_id'] ?>">Negative</button>
                    </td>
                </tr>
                <?php else: ?>
                <tr>
                    <td colspan="5">Error fetching data.</td>
                </tr>
                <?php endif; ?>
                <?php endwhile; ?>
                <!-- PHP -->
            </tbody>
        </table>
    </div>
</div>


                      
        <!-- TABLE END -->

</body>
<!-- SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</html>
    <!-- AJAX  -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".positive-button, .negative-button").forEach(function (button) {
                button.addEventListener("click", function () {
                    var app_id = this.getAttribute("data-appid");
                    var isPositive = this.classList.contains("positive-button");
                    var url = isPositive ? "test_active.php" : "test_deactive.php";
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", url + "?app_id=" + app_id, true);
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var row = document.getElementById("row_" + app_id);
                            if (row) {
                                row.remove();
                            } else {
                                console.error("Row not found.");
                            }
                        }
                    };
                    xhr.send();
                });
            });
        });

    </script>

    <!-- PHP -->

</body>

</html>