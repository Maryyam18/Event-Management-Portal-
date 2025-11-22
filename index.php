<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: login.php");
    exit;
}
$query = "SELECT * FROM events WHERE manager_id = :manager_id ORDER BY event_id DESC";
$stmt = $conn->prepare($query);
$stmt->execute(['manager_id' => $_SESSION['user_id']]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Portal - Manage Events</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #101644 0%, #1a1f6a 50%, #0f162d 100%);
            min-height: 100vh;
            font-family: 'Georgia', serif;
            color: #1e40af; /* Explicit dark blue for body */
            overflow-x: hidden;
        }
        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23001644"><path d="M0 0L50 20C100 40 200 60 300 50C400 40 500 20 600 20C700 20 800 40 900 50L1000 60L1000 100L0 100Z" opacity="0.1"/></svg>') no-repeat bottom;
            z-index: -1;
        }
        .sidebar { /* Included from manager_sidebar.php */ }
        .content { margin-left: 250px; padding: 2rem; }
        .card {
            background: #fff;
            border-radius: 12px;
            padding: 2.5rem;
            box-shadow: 0 8px 24px rgba(0,0,0,.15);
            animation: fadeInUp 0.8s ease-out;
            color: #1e40af; /* Explicit dark blue for card content */
        }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .btn-primary {
            background: #1e40af; color: #fff; padding: 0.875rem 1.5rem; border-radius: 6px; font-weight: 600;
            transition: all 0.3s; display: inline-flex; align-items: center;
        }
        .btn-primary:hover { background: #1e3a8a; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(30,64,175,.3); }
        .btn-warning { background: #facc15; color: #1f2937; padding: 0.5rem 1rem; border-radius: 6px; font-weight: 600; }
        .btn-warning:hover { background: #eab308; transform: translateY(-2px); }
        .btn-danger { background: #dc2626; color: #fff; padding: 0.5rem 1rem; border-radius: 6px; font-weight: 600; }
        .btn-danger:hover { background: #b91c1c; transform: translateY(-2px); }
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.7); align-items: center; justify-content: center; z-index: 50; }
        .modal.active { display: flex; }
        .modal-content {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            max-width: 600px;
            width: 90%;
            position: relative;
            color: #1e40af; /* Explicit dark blue for modal content */
        }
        .close-btn { position: absolute; top: 1rem; right: 1.5rem; font-size: 1.5rem; cursor: pointer; color: #6b7280; }
        .close-btn:hover { color: #1e40af; }
        .form-input, textarea {
            background: #f9fafb; border: 1px solid #d1d5db; color: #1e40af; padding: 0.875rem; border-radius: 6px; width: 100%;
        }
        .form-input:focus, textarea:focus { border-color: #1e40af; box-shadow: 0 0 0 4px rgba(30,64,175,.15); outline: none; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 1rem; text-align: left; color: #1e40af; } /* Explicit dark blue for table */
        th { background: #f3f4f6; font-weight: 600; }
        tr { border-bottom: 1px solid #e5e7eb; }
        .badge { padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.875rem; font-weight: 500; }
        .bg-success { background: #d1fae5; color: #065f46; }
        .bg-warning { background: #fef3c7; color: #92400e; }
        .bg-danger { background: #fee2e2; color: #991b1b; }
        @media (max-width: 768px) { .content { margin-left: 200px; } }
        @media (max-width: 640px) { .content { margin-left: 0; } .card { padding: 1.5rem; } }
    </style>
</head>
<body>
    <div class="hero-bg"></div>
    <?php include 'manager_sidebar.php'; ?>
    <?php include 'modal.php'; ?>

    <div class="content">
        <div class="card">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Manage Events</h2>
                <button class="btn-primary" onclick="openAddModal()">
                    <i class="fas fa-plus-circle mr-2"></i>Add Event
                </button>
            </div>

            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Location</th>
                            <th>Time</th>
                            <th>Limit</th>
                            <th>Budget</th>
                            <th>Speakers</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($events as $row): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= htmlspecialchars(substr($row['description'], 0, 50)) ?>...</td>
                            <td><?= htmlspecialchars($row['location']) ?></td>
                            <td><?= date('d M Y', strtotime($row['event_time'])) ?></td>
                            <td><?= $row['people_limit'] ?: '∞' ?></td>
                            <td>$<?= number_format($row['budget'], 2) ?></td>
                            <td><?= htmlspecialchars($row['speakers']) ?: 'N/A' ?></td>
                            <td>
                                <span class="badge <?= $row['status'] == 'approved' ? 'bg-success' : ($row['status'] == 'pending' ? 'bg-warning' : 'bg-danger') ?>">
                                    <?= ucfirst($row['status']) ?>
                                </span>
                            </td>
                            <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                            <td>
                                <button class="btn-warning mr-2" onclick="openEditModal(<?= $row['event_id'] ?>, '<?= addslashes($row['title']) ?>', '<?= addslashes($row['description']) ?>', '<?= addslashes($row['location']) ?>', '<?= $row['event_time'] ?>', <?= $row['people_limit'] ?: 'null' ?>, <?= $row['budget'] ?: '0' ?>, '<?= addslashes($row['speakers']) ?: '' ?>')">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="btn-danger" onclick="setDeleteId(<?= $row['event_id'] ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.add('active');
            document.getElementById('AddForm').reset();
        }
        function openEditModal(id, title, desc, loc, time, limit, budget, speakers) {
            document.getElementById('edit_event_id').value = id;
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_description').value = desc;
            document.getElementById('edit_location').value = loc;
            document.getElementById('edit_event_time').value = time.replace(' ', 'T');
            document.getElementById('edit_people_limit').value = limit || '';
            document.getElementById('edit_budget').value = budget || '';
            document.getElementById('edit_speakers').value = speakers || '';
            document.getElementById('editModal').classList.add('active');
        }
        function setDeleteId(id) {
            document.getElementById('delete_event_id').value = id;
            document.getElementById('deleteModal').classList.add('active');
        }
        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }
    </script>
</body>
</html>