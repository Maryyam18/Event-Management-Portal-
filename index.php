<?php
require_once __DIR__ . '/classes/Manager.php';

$managerObj = new Manager();
$message = '';

//  Add new manager
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_manager'])) {
    $newManager = new Manager($_POST['full_name'], $_POST['email'], $_POST['password']);
    $newManager->save();
    $message = "<div class='alert alert-success text-center'> Manager added successfully!</div>";
}

//  Update manager
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_manager'])) {
    $managerObj->update($_POST['id'], $_POST['full_name'], $_POST['email'], $_POST['password']);
    $message = "<div class='alert alert-success text-center'> Manager updated successfully!</div>";
}

//  Delete
if (isset($_GET['delete_id'])) {
    $managerObj->delete($_GET['delete_id']);
    $message = "<div class='alert alert-danger text-center'> Manager deleted successfully!</div>";
}

//  Read all
$managers = $managerObj->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Portal</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="css/index.css">

<link rel="stylesheet" href="css/sidebar.css">

</head>

<body>
  <?php include 'sidebar.php'; ?>

  <div>
    <h2 class="text-info">Manager List</h2>
  </div>
<div class="container mt-5 pt-5">
  <div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <!-- <h3 class="text-info">Manager List</h3> -->
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="bi bi-plus-circle"></i> Add Manager
      </button>
    </div>

    <?= $message ?>

    <table class="table table-bordered table-hover text-center align-middle">
      <thead>
        <tr>
          <th>User ID</th>
          <th>Full Name</th>
          <th>Email</th>
          <th>Password</th>
          <th>Created At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($managers as $m): ?>
        <tr>
          <td><?= htmlspecialchars($m['user_id']); ?></td>
          <td><?= htmlspecialchars($m['full_name']); ?></td>
          <td><?= htmlspecialchars($m['email']); ?></td>
          <td><?= htmlspecialchars($m['password']); ?></td>
          <td><?= htmlspecialchars($m['created_at']); ?></td>
          <td>
            <button 
              class="btn btn-warning btn-sm"
              data-bs-toggle="modal"
              data-bs-target="#editModal"
              data-id="<?= $m['user_id']; ?>"
              data-name="<?= htmlspecialchars($m['full_name']); ?>"
              data-email="<?= htmlspecialchars($m['email']); ?>"
              data-password="<?= htmlspecialchars($m['password']); ?>"
            >Edit</button>
            <a href="?delete_id=<?= $m['user_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this manager?');">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header">
          <h5 class="modal-title text-info">Add Manager</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="full_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add_manager" class="btn btn-primary w-100">Add Manager</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!--  Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header">
          <h5 class="modal-title text-info">Edit Manager</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="full_name" id="edit_full_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" id="edit_email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="text" name="password" id="edit_password" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="update_manager" class="btn btn-primary w-100">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const editModal = document.getElementById('editModal');
editModal.addEventListener('show.bs.modal', event => {
  const btn = event.relatedTarget;
  document.getElementById('edit_id').value = btn.getAttribute('data-id');
  document.getElementById('edit_full_name').value = btn.getAttribute('data-name');
  document.getElementById('edit_email').value = btn.getAttribute('data-email');
  document.getElementById('edit_password').value = btn.getAttribute('data-password');
});
</script>
</body>
</html>
