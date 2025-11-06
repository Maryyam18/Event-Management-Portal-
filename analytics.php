<?php
require_once __DIR__ . '/classes/Analytics.php';
$analytics = new Analytics();

$counts = $analytics->getCounts();
$statuses = $analytics->getEventStatuses();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Analytics Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="css/analytics.css">
<link rel="stylesheet" href="css/sidebar.css">
<link rel="stylesheet" href="css/index.css">


</head>

<body>
  <?php include 'sidebar.php'; ?>
  <div>
    <h2 class="text-info">Analytics</h2>
  </div>
<div class="container mt-5 pt-5">
  <div class="row g-4">
    <div class="col-md-3"><div class="card stat-card"><h4>👩‍💼 Managers</h4><h2><?= $counts['managers'] ?></h2></div></div>
    <div class="col-md-3"><div class="card stat-card"><h4>📅 Events</h4><h2><?= $counts['events'] ?></h2></div></div>
    <div class="col-md-3"><div class="card stat-card"><h4>👥 Users</h4><h2><?= $counts['users'] ?></h2></div></div>
    <div class="col-md-3"><div class="card stat-card"><h4>📝 Registrations</h4><h2><?= $counts['registrations'] ?></h2></div></div>
  </div>

  <div class="card mt-5 p-4">
    <h4 class="info" style="color: #4ea1ff !important; text-align: center; font-weight: bold; font-size: 2rem;">Event Status Overview</h4>
    <div class="d-flex justify-content-around">
      <div><span class="badge bg-success">Approved</span> <?= $statuses['approved'] ?></div>
      <div><span class="badge bg-warning text-dark">Pending</span> <?= $statuses['pending'] ?></div>
      <div><span class="badge bg-danger">Rejected</span> <?= $statuses['rejected'] ?></div>
    </div>
  </div>
</div>
</body>
</html>
