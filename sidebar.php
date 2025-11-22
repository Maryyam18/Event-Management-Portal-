<div class="sidebar">
    <h3 class="text-xl font-bold text-center mb-6">Admin Panel</h3>
    <nav>
        <a href="admin_dashboard.php" class="flex items-center p-3 rounded-lg mb-2 text-gray-200 hover:bg-blue-700 active:bg-blue-700"><i class="fas fa-users mr-2"></i> Manage Managers</a>
        <a href="event_approval.php" class="flex items-center p-3 rounded-lg mb-2 text-gray-200 hover:bg-blue-700"><i class="fas fa-check-square mr-2"></i> Approvals</a>
        <a href="analytics.php" class="flex items-center p-3 rounded-lg mb-2 text-gray-200 hover:bg-blue-700"><i class="fas fa-chart-bar mr-2"></i> Analytics</a>
        <a href="logout.php" class="flex items-center p-3 rounded-lg mb-2 text-gray-200 hover:bg-blue-700"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
    </nav>
</div>
<style>
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
    @media (max-width: 768px) {
        .sidebar { width: 200px; }
    }
    @media (max-width: 640px) {
        .sidebar { width: 100%; height: auto; position: relative; }
    }
</style>