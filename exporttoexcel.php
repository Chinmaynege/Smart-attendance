<?php
// Connect to the database
require 'connectDB.php';
// Set the India time zone
date_default_timezone_set('Asia/Kolkata');

// date() function with the time zone
$currentTime = date("d-m-Y H:i:s"); 
$output = '';

if (isset($_POST["Excel"])) {
    if (empty($_POST['date1']) || empty($_POST['date2'])) {
        $date1 = $_SESSION['date1'];
        $date2 = $_SESSION['date2'];
    } else {
        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];
    }

    $sql = "";
    $params = array();

    if (isset($_POST['rollsearch'])) {
        $rollnumber = $_POST['rollsearch'];
        $sql = "SELECT * FROM users_logs WHERE serialnumber = ?";
        $params[] = $rollnumber;
    } else if (isset($_POST['namesearch'])) {
        $name = $_POST['namesearch'];
        $sql = "SELECT * FROM users_logs WHERE username = ?";
        $params[] = $name;
    } else {
        $sql = "SELECT * FROM users_logs WHERE DATE(checkindate) BETWEEN ? AND ? ORDER BY id DESC";
        $params[] = $date1;
        $params[] = $date2;
    }

    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        // Bind parameters
        if (count($params) > 0) {
            mysqli_stmt_bind_param($stmt, str_repeat('s', count($params)), ...$params);
        }

        // Execute the query
        mysqli_stmt_execute($stmt);

        // Get the result
        $result = mysqli_stmt_get_result($stmt);

        if ($result->num_rows > 0) {
            $output .= '<table class="table" border="1">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Roll Number</th>
                                <th>Fingerprint ID</th>
                                <th>Date</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                            </tr>';

            while ($row = $result->fetch_assoc()) {
                $output .= '<tr>
                                <td>' . $row['id'] . '</td>
                                <td>' . $row['username'] . '</td>
                                <td>' . $row['serialnumber'] . '</td>
                                <td>' . $row['fingerprint_id'] . '</td>
                                <td>' . $row['checkindate'] . '</td>
                                <td>' . $row['timein'] . '</td>
                                <td>' . $row['timeout'] . '</td>
                            </tr>';
            }

            $output .= '</table>';

            header('Content-Type: application/xls');
            header('Content-Disposition: attachment; filename=reports' . time().$currentTime. '.xls');

            echo $output;
            exit();
        }
    }

    header("Location: reports.php");
    exit();
}
?>
