<?php
require_once __DIR__ . '/classes/Event.php';
$eventObj = new Event();

if (isset($_GET['approve'])) $eventObj->approve($_GET['approve']);
if (isset($_GET['reject'])) $eventObj->reject($_GET['reject']);

$events = $eventObj->getAll();
?>
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
<?php include 'sidebar.php'; ?>
  <div>
    <h2 class="text-info">Event Approval Panel</h2>
  </div>
<div class="container mt-5 pt-5">
  <div class="card p-4">
    <!-- <h3 class="text-info">Event Approval Panel</h3> -->
    <table class="table table-bordered table-hover text-center align-middle mt-3">
      <thead class="table-primary text-light">
        <tr>
          <th>Event ID</th>
          <th>Title</th>
          <th>Manager</th>
          <th>Budget</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($events as $event): ?>
        <tr>
          <td><?= $event['event_id'] ?></td>
          <td><?= htmlspecialchars($event['title']) ?></td>
          <td><?= htmlspecialchars($event['manager_name']) ?></td>
          <td>$<?= htmlspecialchars($event['budget']) ?></td>
          <td>
            <?php if ($event['status'] == 'pending'): ?>
              <span class="badge bg-warning text-dark">Pending</span>
            <?php elseif ($event['status'] == 'approved'): ?>
              <span class="badge bg-success">Approved</span>
            <?php else: ?>
              <span class="badge bg-danger">Rejected</span>
            <?php endif; ?>
          </td>
          <td>
            <?php if ($event['status'] == 'pending'): ?>
              <a href="?approve=<?= $event['event_id'] ?>" class="btn btn-approve btn-sm">Approve</a>
              <a href="?reject=<?= $event['event_id'] ?>" class="btn btn-reject btn-sm">Reject</a>
            <?php else: ?>
              <em>Action Taken</em>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
