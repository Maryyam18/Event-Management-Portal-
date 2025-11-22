<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar">
    <h3 class="text-xl font-bold text-center mb-6 text-white">Manager Panel</h3>
    <nav>
        <a href="index.php" class="flex items-center p-3 rounded-lg mb-2 text-gray-200 hover:bg-blue-700 <?= $current_page == 'index.php' ? 'active' : '' ?>">
            <i class="fas fa-calendar-event mr-2"></i>Manage Events
        </a>
        <a href="manager_approval.php" class="flex items-center p-3 rounded-lg mb-2 text-gray-200 hover:bg-blue-700 <?= $current_page == 'manager_approval.php' ? 'active' : '' ?>">
            <i class="fas fa-check-square mr-2"></i>User Registrations
        </a>
        <a href="logout.php" class="flex items-center p-3 rounded-lg mb-2 text-gray-200 hover:bg-blue-700">
            <i class="fas fa-sign-out-alt mr-2"></i>Logout
        </a>
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
    .sidebar a.active {
        background: #1e40af;
        color: #fff;
    }
    @media (max-width: 768px) {
        .sidebar { width: 200px; }
    }
    @media (max-width: 640px) {
        .sidebar { width: 100%; height: auto; position: relative; }
    }
</style>