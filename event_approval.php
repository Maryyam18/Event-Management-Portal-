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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event Approvals</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #101644 0%, #1a1f6a 50%, #0f162d 100%); min-height: 100vh; font-family: 'Georgia', serif; color: #1e40af; overflow-x: hidden; }
        .hero-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23001644"><path d="M0 0L50 20C100 40 200 60 300 50C400 40 500 20 600 20C700 20 800 40 900 50L1000 60L0 100Z" opacity="0.1"/></svg>') no-repeat bottom; z-index: -1; }
        .sidebar { position: fixed; top: 0; left: 0; width: 250px; height: 100vh; background: #1e3a8a; color: #fff; padding: 1.5rem; box-shadow: 2px 0 5px rgba(0,0,0,.2); z-index: 1000; }
        .content { margin-left: 250px; padding: 2rem; }
        .card { background: #fff; border-radius: 12px; padding: 2.5rem; box-shadow: 0 8px 24px rgba(0,0,0,.15); animation: fadeInUp 0.8s ease-out; color: #1e40af; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .btn-approve { background: #34d399; color: #065f46; padding: 0.5rem 1rem; border-radius: 6px; font-weight: 600; }
        .btn-approve:hover { background: #2cc185; transform: translateY(-2px); }
        .btn-reject { background: #dc2626; color: #fff; padding: 0.5rem 1rem; border-radius: 6px; font-weight: 600; }
        .btn-reject:hover { background: #b91c1c; transform: translateY(-2px); }
        .badge { padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.875rem; font-weight: 500; }
        .bg-success { background: #d1fae5; color: #065f46; }
        .bg-warning { background: #fef3c7; color: #92400e; }
        .bg-danger { background: #fee2e2; color: #991b1b; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 1rem; text-align: left; color: #1e40af; }
        th { background: #f3f4f6; font-weight: 600; }
        tr { border-bottom: 1px solid #e5e7eb; }
        @media (max-width: 768px) { .content { margin-left: 200px; } }
        @media (max-width: 640px) { .content { margin-left: 0; } .card { padding: 1.5rem; } }
    </style>
</head>
<body>
    <div class="hero-bg"></div>
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <div class="card">
            <h2 class="text-2xl font-bold">Event Approval Panel</h2>
            <div class="overflow-x-auto mt-6">
                <table>
                    <thead>
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
                            <td>$<?= number_format($event['budget'], 2) ?></td>
                            <td>
                                <span class="badge <?= $event['status'] == 'approved' ? 'bg-success' : ($event['status'] == 'pending' ? 'bg-warning' : 'bg-danger') ?>">
                                    <?= ucfirst($event['status']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($event['status'] == 'pending'): ?>
                                <a href="?approve=<?= $event['event_id'] ?>" class="btn-approve">Approve</a>
                                <a href="?reject=<?= $event['event_id'] ?>" class="btn-reject">Reject</a>
                                <?php else: ?>
                                <span class="text-gray-500">Action Taken</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>