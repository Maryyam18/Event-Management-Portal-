<?php
session_start();
include 'db_connect.php';
include 'userregistrations.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: login.php");
    exit;
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
$query = "SELECT users.full_name, registrations.event_id, registrations.status, events.title
          FROM registrations
          JOIN users ON registrations.user_id = users.user_id
          JOIN events ON events.event_id = registrations.event_id
          WHERE events.manager_id = :manager_id";
$stmt = $conn->prepare($query);
$stmt->execute(['manager_id' => $_SESSION['user_id']]);
$registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Registration Approvals</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #101644 0%, #1a1f6a 50%, #0f162d 100%);
            min-height: 100vh;
            font-family: 'Georgia', serif;
            color: #125ab8ff;
            overflow-x: hidden;
        }
        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23001644"><path d="M0 0L50 20C100 40 200 60 300 50C400 40 500 20 600 20C700 20 800 40 900 50L1000 60L0 100Z" opacity="0.1"/></svg>') no-repeat bottom;
            z-index: -1;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background: #1e3a8a;
            color: #fff;
            padding: 1.5rem;
            box-shadow: 2px 0 5px rgba(0,0,0,.2);
            z-index: 1000;
        }
        .content {
            margin-left: 250px;
            padding: 2rem;
        }
        .card {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 2.5rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            animation: fadeInUp 0.8s ease-out;
            max-width: 1200px;
            margin: 0 auto;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .btn-success {
            background-color: #34d399;
            color: #065f46;
            border: none;
            border-radius: 6px;
            padding: 0.5rem 1rem;
            font-weight: 600;
        }
        .btn-success:hover {
            background-color: #2cc185;
            transform: translateY(-2px);
        }
        .btn-danger {
            background-color: #dc2626;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 0.5rem 1rem;
            font-weight: 600;
        }
        .btn-danger:hover {
            background-color: #b91c1c;
            transform: translateY(-2px);
        }
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            padding: 0.75rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
        }
        .alert-danger {
            background-color: #fef2f2;
            color: #dc2626;
            padding: 0.75rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
        }
        .badge {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.875rem;
        }
        .bg-success { background-color: #34d399; color: #065f46; }
        .bg-warning { background-color: #facc15; color: #854d0e; }
        .bg-danger { background-color: #dc2626; color: #fff; }
        .table th, .table td { color: #1f2937; }
        h2 { color: #1e40af; font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem; }
        @media (max-width: 768px) {
            .sidebar { width: 200px; }
            .content { margin-left: 200px; }
        }
        @media (max-width: 640px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .content { margin-left: 0; }
            .card { padding: 1.5rem; margin: 1rem; }
        }
    </style>
</head>
<body>
    <div class="hero-bg"></div>
    <?php include 'manager_sidebar.php'; ?>
    <div class="content">
        <div class="card">
            <h2><i class="fas fa-check-square mr-2"></i>User Registration Approval Panel</h2>
            <?php if (isset($_GET['success'])): ?>
                <div class="alert-success">
                    Registration <?= $_GET['success'] ?> successfully!
                </div>
            <?php elseif (isset($_GET['error'])): ?>
                <div class="alert-danger">
                    Registration <?= $_GET['error'] ?>.
                </div>
            <?php endif; ?>
            <div class="overflow-x-auto mt-4">
                <table class="w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">#</th>
                            <th class="p-3 text-left">User Name</th>
                            <th class="p-3 text-left">Event ID</th>
                            <th class="p-3 text-left">Event Name</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($registrations as $row) {
                            echo "<tr class='border-b'>
                                <td class='p-3'>{$i}</td>
                                <td class='p-3'>" . htmlspecialchars($row['full_name']) . "</td>
                                <td class='p-3'>" . htmlspecialchars($row['event_id']) . "</td>
                                <td class='p-3'>" . htmlspecialchars($row['title']) . "</td>
                                <td class='p-3'>";
                            if ($row['status'] == 'pending') {
                                echo '<span class="badge bg-warning">Pending</span>';
                            } elseif ($row['status'] == 'approved') {
                                echo '<span class="badge bg-success">Approved</span>';
                            } else {
                                echo '<span class="badge bg-danger">Rejected</span>';
                            }
                            echo "</td><td class='p-3 flex space-x-2'>";
                            if ($row['status'] == 'pending') {
                                echo "<form method='POST' class='inline-flex'>
                                    <input type='hidden' name='event_id' value='" . $row['event_id'] . "'>
                                    <button type='submit' name='action' value='approve' class='btn-success'>Approve</button>
                                </form>
                                <form method='POST' class='inline-flex'>
                                    <input type='hidden' name='event_id' value='" . $row['event_id'] . "'>
                                    <button type='submit' name='action' value='reject' class='btn-danger'>Reject</button>
                                </form>";
                            } else {
                                echo "<em>Action Taken</em>";
                            }
                            echo "</td></tr>";
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>