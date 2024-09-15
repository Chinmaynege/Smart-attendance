<div class="tbl-content slideInRight animated">
  <table cellpadding="0" cellspacing="0" border="0">
    <tbody>
    <?php
session_start();
// Connect to database
require 'connectDB.php';

// Check if ID or roll search is submitted
if (isset($_POST['search_type'])) {
  if ($_POST['search_type'] === 'id' && isset($_POST['id'])) {
    $searchID = $_POST['id'];
    $sql = "SELECT * FROM users_logs WHERE fingerprint_id = ?";
  } elseif ($_POST['search_type'] === 'roll' && isset($_POST['roll_number'])) {
    $searchRollNumber = $_POST['roll_number'];
    $sql = "SELECT * FROM users_logs WHERE serialnumber = ?";
  } elseif ($_POST['search_type'] === 'name' && isset($_POST['name'])) {
    $searchName = $_POST['name'];
    $sql = "SELECT * FROM users_logs WHERE username = ?";
  } else {
    $sql = "SELECT * FROM users_logs";
  }
} else {
  // Retrieve logs based on date range
  if (isset($_POST['log_date'])) {
    $date1 = $_POST['date1'];
    $date2 = $_POST['date2'];

    if ($date1 != '' && $date2 != '') {
      if ($date1 <= $date2) {
        $_SESSION['seldate1'] = $date1;
        $_SESSION['seldate2'] = $date2;
      } else {
        // Swap dates if date1 is greater than date2
        $_SESSION['seldate1'] = $date2;
        $_SESSION['seldate2'] = $date1;
      }
    } elseif ($date1 != '') {
      $_SESSION['seldate1'] = $date1;
      $_SESSION['seldate2'] = $date1;
    } else {
      $_SESSION['seldate1'] = date("Y-m-d");
      $_SESSION['seldate2'] = date("Y-m-d");
    }
  }

  if (isset($_POST['select_date']) && $_POST['select_date'] == 1) {
    $_SESSION['seldate1'] = date("Y-m-d");
    $_SESSION['seldate2'] = date("Y-m-d");
  }

  $seldate1 = isset($_SESSION['seldate1']) ? $_SESSION['seldate1'] : date("Y-m-d");
  $seldate2 = isset($_SESSION['seldate2']) ? $_SESSION['seldate2'] : date("Y-m-d");

  $sql = "SELECT * FROM users_logs WHERE checkindate BETWEEN '$seldate1' AND '$seldate2' ORDER BY id";
}

$result = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($result, $sql)) {
  echo '<p class="error">SQL Error</p>';
} else {
  if (isset($searchID)) {
    mysqli_stmt_bind_param($result, "s", $searchID);
  } elseif (isset($searchRollNumber)) {
    mysqli_stmt_bind_param($result, "s", $searchRollNumber);
  } elseif (isset($searchName)) {
    mysqli_stmt_bind_param($result, "s", $searchName);
  }

  mysqli_stmt_execute($result);
  $resultl = mysqli_stmt_get_result($result);
}

// Display the logs
if (isset($resultl) && mysqli_num_rows($resultl) > 0) {
  while ($row = mysqli_fetch_assoc($resultl)) {
?>
    <tr>
      <td><?php echo $row['username']; ?></td>
      <td><?php echo $row['serialnumber']; ?></td>
      <td><?php echo $row['fingerprint_id']; ?></td>
      <td><?php echo $row['checkindate']; ?></td>
      <td><?php echo $row['timein']; ?></td>
      <td><?php echo $row['timeout']; ?></td>
    </tr>
<?php
  }
} else {
  echo '<tr><td colspan="7">No logs found.</td></tr>';
}
?>

    </tbody>
  </table>
</div>
