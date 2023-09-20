<?php
// Database Connection
include("../connection.php");
// Session Start
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>COVID Results</title>
  <link rel="stylesheet" href="../css/style.css   ">

  <link rel="stylesheet" href="https://cdn.usebootstrap.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>

  <!-- SIDEBAR -->
  <div id="sidebar">
    <header>
      <a href="#"><img src="../images/corona_icon.png" alt="" style="width:70px ; padding: 20px;"></a>
    </header>
    <ul class="nav">
      <li>
        <a href="dashboard.php">
          <i class="zmdi zmdi-view-dashboard"></i>Dashboard
        </a>
      </li>
      <li>
        <a href="patientrecord.php">
          <i class="zmdi zmdi-link"></i>Patients
        </a>
      </li>
      <li>
        <a href="hospitaldetails.php">
          <i class="zmdi zmdi-share"></i>Hospitals
        </a>
      </li>
      <li>
        <a href="crdetails.php">
          <i class="zmdi zmdi-widgets"></i>Test Results </a>
      </li>
      <li>
        <a href="testdetails.php">
          <i class="zmdi zmdi-settings"></i>Patient Test Details
        </a>
      </li>

    </ul>
  </div>
  </div>
  </div>
  </div>
  <table style="margin-left: 300px;">
    <tr>
      <th>Patient</th>
      <th>Hospital</th>
      <th>Date</th>
      <th>Results</th>
      <th>Report</th>
    </tr>
    <!-- PHP -->
    <?php
    $query = "SELECT * FROM appointment";
    $result = mysqli_query($con, $query);

    while ($row = mysqli_fetch_assoc($result)) {
      $patient_id = $row['patient_id'];
      $hospital_id = $row['hospital_id'];

      $patient_query = "SELECT patient_name FROM patient WHERE patient_id = $patient_id";
      $patient_result = mysqli_query($con, $patient_query);

      $hospital_query = "SELECT hospital_name FROM hospital WHERE hospital_id = $hospital_id";
      $hospital_result = mysqli_query($con, $hospital_query);

      if ($patient_result && $hospital_result) {
        $patient_data = mysqli_fetch_assoc($patient_result);
        $hospital_data = mysqli_fetch_assoc($hospital_result);

        $patient_name = $patient_data['patient_name'];
        $hospital_name = $hospital_data['hospital_name'];
        ?>
        <tr>
          <td>
            <?= $patient_name ?>
          </td>
          <td>
            <?= $hospital_name ?>
          </td>
          <td>
            <?= $row['app_date'] ?>
          </td>
          <td>
            <?= $row['status'] == 1 ? 'Positive' : 'Negative' ?>
          </td>
          <td><!-- Add the report link or content here --></td>
        </tr>
      <?php } else { ?>
        <tr>
          <td colspan="5">Error fetching data.</td>
        </tr>
      <?php }
    }
    ?>
    <!-- PHP -->
  </table>
</body>

</html>