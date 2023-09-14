<?php
include('connection.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>User Registration</title>
    <script>
        function showFields(role) {
            var adminFields = document.getElementById('adminFields');
            var hospitalFields = document.getElementById('hospitalFields');
            var patientFields = document.getElementById('patientFields');

            adminFields.style.display = 'none';
            hospitalFields.style.display = 'none';
            patientFields.style.display = '';

            if (role === 'Admin') {
                adminFields.style.display = 'block';
            } else if (role === 'Hospital') {
                hospitalFields.style.display = 'block';
            } else if (role === 'Patient') {
                patientFields.style.display = 'block';
            }
        }
    </script>
</head>

<body>
    <h2>User Registration</h2>
    <form action="register.php" method="post">
        <label for="user_type">User Type:</label>
        <select id="user_type" name="user_type" onchange="showFields(this.value)" required>
            <option value="">Select User Type</option>
            <option value="Admin">Admin</option>
            <option value="Hospital">Hospital</option>
            <option value="Patient">Patient</option>
        </select><br><br>

        <!-- Admin Fields -->
        <div id="adminFields" style="display: none;">
            <label for="username">Admin Username:</label>
            <input type="text" name="username"><br><br>
            <label for="admin_email">Admin Email:</label>
            <input type="text" name="admin_email"><br><br>
            
            <label for="admin_password">Admin Password:</label>
            <input type="text" name="admin_password"><br><br>
        </div>

        <!-- Hospital Fields -->
        <div id="hospitalFields" style="display: none;">
            <label for="hospital_name">Hospital Name:</label>
            <input type="text" name="hospital_name"><br><br>
            <label for="hospital_location">Location:</label>
            <select name="location">
                <option value="Karachi">Karachi</option>
                <option value="Lahore">Lahore</option>
                <option value="Islamabad">Islamabad</option>
                <option value="Multan">Multan</option>
            </select>
       <label for="hospital_name">Password:</label>
            <input type="text" name="hospital_password"><br><br>
          
        </div>

        <!-- Patient Fields -->
        <div id="patientFields" style="display: none;">
            <label for="patient_name">Patient Name:</label>
            <input type="text" id="patient_name" name="patient_name"><br><br>
            <label for="patient_address">Patient Address:</label>
            <input type="text" name="address"><br><br>

            <label for="patient_email">Email:</label>
                        <input type="text" name="email"><br><br>
            <label for="patient_password">Password:</label>
            <input type="text" name="password"><br><br>



        </div>

        <input type="submit" value="Register" name="submit">
    </form>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userType = $_POST["user_type"];
    if (isset($_POST['submit'])) {
        // Process the form data based on user type
        if ($userType === "Admin") {
            $adminusername = $_POST["username"];
            $adminemail = $_POST["admin_email"];
            $adminpassword = $_POST["admin_password"];
            $query = "INSERT INTO admin (username, email, password) VALUES ('$adminusername', '$adminemail', '$adminpassword')";

            // Perform admin registration logic here
            // Insert data into the Admin table in your database
        } elseif ($userType === "Hospital") {
            $hospitalname = $_POST["hospital_name"];
            $hospitallocation = $_POST["location"];
            $hospitalpassword = $_POST["hospital_password"];
            $query = "INSERT INTO hospital (hospital_name, location, password) VALUES ('$hospitalname', '$hospitallocation', '$hospitalpassword')";

            // Perform hospital registration logic here
            // Insert data into the Hospital table in your database
        } elseif ($userType === "Patient") {
            $patientname = $_POST["patient_name"];
            $patientaddress = $_POST["address"];
            $patientemail = $_POST["email"];
            $patientpassword = $_POST["patient_password"];
            $query = "INSERT INTO patient (patient_name, address, email, password) VALUES ('$patientname', '$patientaddress', '$patientemail', '$patientpassword')";
        }

        // Execute the SQL query
        if (mysqli_query($con, $query)) {
            echo "Registration successful!";
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
}
?>

</body>

</html>