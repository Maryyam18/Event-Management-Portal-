<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit;
}
require_once __DIR__ . '/classes/Analytics.php';
$analytics = new Analytics();
$counts = $analytics->getCounts();
$statuses = $analytics->getEventStatuses();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Analytics Dashboard - Event Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #101644 0%, #1a1f6a 50%, #0f162d 100%); min-height: 100vh; font-family: 'Georgia', serif; color: #1e40af; overflow-x: hidden; }
        .hero-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23001644"><path d="M0 0L50 20C100 40 200 60 300 50C400 40 500 20 600 20C700 20 800 40 900 50L1000 60L0 100Z" opacity="0.1"/></svg>') no-repeat bottom; z-index: -1; }
        .sidebar { position: fixed; top: 0; left: 0; width: 250px; height: 100vh; background: #1e3a8a; color: #fff; padding: 1.5rem; box-shadow: 2px 0 5px rgba(0,0,0,.2); z-index: 1000; }
        .content { margin-left: 250px; padding: 2rem; }
        .card { background: #fff; border-radius: 12px; padding: 2rem; box-shadow: 0 8px 24px rgba(0,0,0,.15); animation: fadeInUp 0.8s ease-out; color: #1e40af; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .stat-card { background: #fff; border-radius: 8px; padding: 1.5rem; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,.1); color: #1e40af; }
        .stat-card h4 { font-size: 1.25rem; margin-bottom: 1rem; }
        .stat-card h2 { font-size: 2rem; font-weight: 700; }
        .badge { padding: 0.5rem 1rem; border-radius: 4px; font-weight: 500; }
        .bg-success { background: #d1fae5; color: #065f46; }
        .bg-warning { background: #fef3c7; color: #92400e; }
        .bg-danger { background: #fee2e2; color: #991b1b; }
        @media (max-width: 768px) { .content { margin-left: 200px; } }
        @media (max-width: 640px) { .content { margin-left: 0; } .card { padding: 1.5rem; } }
    </style>
</head>
<body>
    <div class="hero-bg"></div>
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <div class="container max-w-7xl mx-auto">
            <h2 class="text-2xl font-bold mb-6">Analytics</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="stat-card"><h4><i class="fas fa-user-tie mr-2"></i>Managers</h4><h2><?= $counts['managers'] ?></h2></div>
                <div class="stat-card"><h4><i class="fas fa-calendar-alt mr-2"></i>Events</h4><h2><?= $counts['events'] ?></h2></div>
                <div class="stat-card"><h4><i class="fas fa-users mr-2"></i>Users</h4><h2><?= $counts['users'] ?></h2></div>
                <div class="stat-card"><h4><i class="fas fa-clipboard-check mr-2"></i>Registrations</h4><h2><?= $counts['registrations'] ?></h2></div>
            </div>
            <div class="card">
                <h4 class="text-center text-2xl font-bold mb-4">Event Status Overview</h4>
                <div class="flex justify-around">
                    <div><span class="badge bg-success">Approved</span> <?= $statuses['approved'] ?></div>
                    <div><span class="badge bg-warning">Pending</span> <?= $statuses['pending'] ?></div>
                    <div><span class="badge bg-danger">Rejected</span> <?= $statuses['rejected'] ?></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>