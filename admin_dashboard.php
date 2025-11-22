<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit;
}
require_once __DIR__ . '/classes/Manager.php';
$managerObj = new Manager();
$message = '';
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_manager'])) {
    try {
        $managerObj = new Manager($_POST['full_name'], $_POST['password']);
        $managerObj->save();
        $message = "<div class='bg-green-100 text-green-800 p-3 rounded text-center mb-4'>Manager added successfully!</div>";
    } catch (Exception $e) {
        $message = "<div class='bg-red-100 text-red-800 p-3 rounded text-center mb-4'>" . $e->getMessage() . "</div>";
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_manager'])) {
    $managerObj->update($_POST['id'], $_POST['full_name'], $_POST['password']);
    $message = "<div class='bg-green-100 text-green-800 p-3 rounded text-center mb-4'>Manager updated successfully!</div>";
}
if (isset($_GET['delete_id'])) {
    $managerObj->delete($_GET['delete_id']);
    $message = "<div class='bg-red-100 text-red-800 p-3 rounded text-center mb-4'>Manager deleted successfully!</div>";
}
$managers = $managerObj->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Portal - Manage Managers</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #101644 0%, #1a1f6a 50%, #0f162d 100%); min-height: 100vh; font-family: 'Georgia', serif; color: #1e40af; overflow-x: hidden; }
        .hero-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23001644"><path d="M0 0L50 20C100 40 200 60 300 50C400 40 500 20 600 20C700 20 800 40 900 50L1000 60L0 100Z" opacity="0.1"/></svg>') no-repeat bottom; z-index: -1; }
        .sidebar { position: fixed; top: 0; left: 0; width: 250px; height: 100vh; background: #1e3a8a; color: #fff; padding: 1.5rem; box-shadow: 2px 0 5px rgba(0,0,0,.2); z-index: 1000; }
        .content { margin-left: 250px; padding: 2rem; }
        .card { background: #fff; border-radius: 12px; padding: 2.5rem; box-shadow: 0 8px 24px rgba(0,0,0,.15); animation: fadeInUp 0.8s ease-out; color: #1e40af; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .btn-primary { background: #1e40af; color: #fff; padding: 0.875rem 1.5rem; border-radius: 6px; font-weight: 600; transition: all 0.3s; }
        .btn-primary:hover { background: #1e3a8a; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(30,64,175,.3); }
        .btn-warning { background: #facc15; color: #1f2937; padding: 0.5rem 1rem; border-radius: 6px; font-weight: 600; }
        .btn-warning:hover { background: #eab308; transform: translateY(-2px); }
        .btn-danger { background: #dc2626; color: #fff; padding: 0.5rem 1rem; border-radius: 6px; font-weight: 600; }
        .btn-danger:hover { background: #b91c1c; transform: translateY(-2px); }
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.7); align-items: center; justify-content: center; z-index: 50; }
        .modal.active { display: flex; }
        .modal-content { background: #fff; border-radius: 12px; padding: 2rem; max-width: 500px; width: 90%; position: relative; color: #1e40af; }
        .close-btn { position: absolute; top: 1rem; right: 1.5rem; font-size: 1.5rem; cursor: pointer; color: #6b7280; }
        .close-btn:hover { color: #1e40af; }
        .form-input { background: #f9fafb; border: 1px solid #d1d5db; color: #1e40af; padding: 0.875rem; border-radius: 6px; width: 100%; }
        .form-input:focus { border-color: #1e40af; box-shadow: 0 0 0 4px rgba(30,64,175,.15); outline: none; }
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
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Manage Managers</h2>
                <button class="btn-primary" onclick="openAddModal()">
                    <i class="fas fa-plus-circle mr-2"></i>Add Manager
                </button>
            </div>
            <?= $message ?>
            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Full Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($managers as $m): ?>
                        <tr>
                            <td><?= htmlspecialchars($m['user_id']) ?></td>
                            <td><?= htmlspecialchars($m['full_name']) ?></td>
                            <td>
                                <button class="btn-warning mr-2" onclick="openEditModal(<?= $m['user_id'] ?>, '<?= htmlspecialchars($m['full_name']) ?>')">
                                    Edit
                                </button>
                                <a href="?delete_id=<?= $m['user_id'] ?>" class="btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('addModal')">&times;</span>
            <form method="POST">
                <h2 class="text-2xl font-bold text-blue-800 mb-4">Add Manager</h2>
                <div class="mt-4"><label class="block font-medium text-blue-800">Full Name</label><input type="text" name="full_name" class="form-input" required></div>
                <div class="mt-4"><label class="block font-medium text-blue-800">Password</label><input type="password" name="password" class="form-input" required></div>
                <div class="mt-6 flex justify-end"><button type="submit" name="add_manager" class="btn-primary">Add Manager</button></div>
            </form>
        </div>
    </div>
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('editModal')">&times;</span>
            <form method="POST">
                <h2 class="text-2xl font-bold text-blue-800 mb-4">Edit Manager</h2>
                <input type="hidden" name="id" id="edit_id">
                <div class="mt-4"><label class="block font-medium text-blue-800">Full Name</label><input type="text" name="full_name" id="edit_full_name" class="form-input" required></div>
                <div class="mt-4"><label class="block font-medium text-blue-800">Password</label><input type="password" name="password" id="edit_password" class="form-input" required></div>
                <div class="mt-6 flex justify-end"><button type="submit" name="update_manager" class="btn-primary">Save Changes</button></div>
            </form>
        </div>
    </div>
    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.add('active');
        }
        function openEditModal(id, name) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_full_name').value = name;
            document.getElementById('edit_password').value = '';
            document.getElementById('editModal').classList.add('active');
        }
        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }
    </script>
</body>
</html>