

<?php include 'userregistrations.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Event Approvals</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="css/event-approval.css">
<link rel="stylesheet" href="css/sidebar.css">
<link rel="stylesheet" href="css/index.css">
</head>

<body>

  <div>
    <h2 class="text-info">Event Approval Panel</h2>
  </div>
<div class="container mt-5 pt-5">
  <div class="card p-4">
    <!-- <h3 class="text-info">Event Approval Panel</h3> -->
    <table class="table table-bordered table-hover text-center align-middle mt-3">
      <thead class="table-primary text-light">
        <tr>
           <th>#</th>
          <th>UserName</th>
          <th>EventId</th>
          <th>EventName</th>
            <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>


      <tbody>

   <?php 



    $query = "select users.full_name,registrations.registration_id , registrations.event_id,registrations.status,events.title from registrations join users on registrations.user_id= users.user_id join events on events.event_id=registrations.event_id";
     $stmt = $conn->prepare($query);
          $stmt->execute();
          $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $i = 1;
          foreach ($events as $row) {
              echo "<tr>
                  <td>{$i}</td>
                  <td>" . htmlspecialchars($row['full_name']) . "</td>
                  <td>" . htmlspecialchars($row['event_id']) . "</td>
                  <td>" . htmlspecialchars($row['title']) . "</td>
           <td>";
        
    // Status badge
    if ($row['status'] == 'pending') {
        echo '<span class="badge bg-warning text-dark">Pending</span>';
    } elseif ($row['status'] == 'approved') {
        echo '<span class="badge bg-success">Approved</span>';
    } else {
        echo '<span class="badge bg-danger">Rejected</span>';
    }
    
    echo "</td><td>";
    
    // Action buttons
    if ($row['status'] == 'pending') {
        echo "<form method='POST' class='d-inline-block me-2'>
            <input type='hidden' name='event_id' value='" . $row['registration_id'] . "'>
            <button type='submit' name='action' value='approve' class='btn btn-success btn-sm'>Approve</button>
          </form>
          <form method='POST' class='d-inline-block'>
            <input type='hidden' name='event_id' value='" . $row['registration_id'] . "'>
            <button type='submit' name='action' value='reject' class='btn btn-danger btn-sm'>Reject</button>
          </form>";
    }else {
    echo "<em>Action Taken</em>";
}
   $i++;    
          }
      ?>
  </tbody>
     
    </table>
  </div>
</div>
</body>
</html>