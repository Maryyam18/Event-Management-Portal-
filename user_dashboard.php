<?php
session_start();
include 'db_connect.php';

// ---- Security -------------------------------------------------
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 3) {
    header("Location: login.php");
    exit;
}
$user_id   = $_SESSION['user_id'];
$full_name = $_SESSION['full_name'];

// ---- OOP -------------------------------------------------------
class User { private $name; public function __construct($n){$this->name=$n;} public function getName(){return $this->name;} }
$user = new User($full_name);

// ---- Register for an event ------------------------------------
if (isset($_POST['register_event'])) {
    $event_id = (int)$_POST['event_id'];
    $stmt = $conn->prepare("INSERT INTO registrations (event_id, user_id, status)
                            VALUES (?, ?, 'pending')
                            ON CONFLICT ON CONSTRAINT registrations_event_id_user_id_key
                            DO UPDATE SET status = 'pending'");
    $stmt->execute([$event_id, $user_id]);
}

// ---- Submit feedback -------------------------------------------
if (isset($_POST['submit_feedback'])) {
    $event_id = (int)$_POST['event_id'];
    $rating   = (int)$_POST['rating'];
    $comment  = trim($_POST['comment']);
    $stmt = $conn->prepare("INSERT INTO feedback (event_id, user_id, rating, comments)
                            VALUES (?, ?, ?, ?)");
    $stmt->execute([$event_id, $user_id, $rating, $comment]);
}

// ---- Determine which view to show -------------------------------
$view = $_GET['view'] ?? 'all';   // all | my | feedback

// ---- Fetch data for the selected view -------------------------
if ($view === 'my') {
    $stmt = $conn->prepare("
        SELECT e.*, r.status AS reg_status 
        FROM events e
        JOIN registrations r ON e.event_id = r.event_id
        WHERE r.user_id = ? AND r.status IN ('pending','approved')
        ORDER BY e.event_time DESC");
    $stmt->execute([$user_id]);
    $events = $stmt->fetchAll();
    $pageTitle = 'My Registrations';
} elseif ($view === 'feedback') {
    $stmt = $conn->prepare("
        SELECT e.*, r.status AS reg_status 
        FROM events e
        JOIN registrations r ON e.event_id = r.event_id
        WHERE r.user_id = ? AND r.status = 'approved'
        ORDER BY e.event_time DESC");
    $stmt->execute([$user_id]);
    $events = $stmt->fetchAll();
    $pageTitle = 'Provide Feedback';
} else { // all
    $stmt = $conn->prepare("
        SELECT e.*, r.status AS reg_status 
        FROM events e
        LEFT JOIN registrations r ON e.event_id = r.event_id AND r.user_id = ?
        WHERE e.status = 'approved' ORDER BY e.event_time DESC");
    $stmt->execute([$user_id]);
    $events = $stmt->fetchAll();
    $pageTitle = 'All Events';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?> - <?= htmlspecialchars($user->getName()) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body{background:linear-gradient(135deg,#101644 0%,#1a1f6a 50%,#0f162d 100%);min-height:100vh;font-family:'Georgia',serif;color:#e2e8f0;overflow-x:hidden;}
        .sidebar{position:fixed;top:0;left:0;width:250px;height:100vh;background:#1e3a8a;color:#fff;padding:1.5rem;box-shadow:2px 0 5px rgba(0,0,0,.2);z-index:1000;}
        .sidebar h3{font-size:1.5rem;font-weight:700;margin-bottom:2rem;text-align:center;}
        .sidebar a{color:#e2e8f0;display:block;padding:.75rem;border-radius:6px;margin-bottom:.5rem;transition:background .2s;}
        .sidebar a:hover{background:#1e40af;color:#fff;}
        .sidebar .active{background:#1e40af;color:#fff;}
        .content{margin-left:250px;padding:2rem;}
        .event-card{background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,.1);transition:transform .3s,box-shadow .3s;}
        .event-card:hover{transform:translateY(-8px);box-shadow:0 12px 24px rgba(0,0,0,.2);}
        .btn-primary{background:#1e40af;color:#fff;border:none;border-radius:6px;padding:.875rem 1.5rem;font-weight:600;transition:background .3s,transform .2s,box-shadow .2s;width:100%;display:flex;align-items:center;justify-content:center;}
        .btn-primary:hover{background:#1e3a8a;transform:translateY(-2px);box-shadow:0 4px 12px rgba(30,64,175,.3);}
        .modal{background:rgba(0,0,0,.7);position:fixed;inset:0;display:none;align-items:center;justify-content:center;z-index:50;}
        .modal-content{background:#fff;border-radius:12px;padding:2rem;max-width:600px;width:90%;position:relative;}
        .close-btn{position:absolute;top:1rem;right:1.5rem;font-size:1.5rem;cursor:pointer;color:#6b7280;}
        .close-btn:hover{color:#1e40af;}
        .container{max-width:1200px;margin:0 auto;}
        .status-tag { padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.875rem; font-weight: 500; }
        .status-pending { background-color: #facc15; color: #854d0e; }
        .status-approved { background-color: #34d399; color: #065f46; }
        @media (max-width:768px){.sidebar{width:200px;}.content{margin-left:200px;}}
        @media (max-width:640px){.sidebar{width:100%;height:auto;position:relative;}.content{margin-left:0;}}
    </style>
</head>
<body>
<!-- ==== SIDEBAR ==== -->
<div class="sidebar">
    <h3>Event Portal</h3>
    <nav>
        <a href="?view=all"      class="<?= $view==='all'?'active':'' ?>"><i class="fas fa-list mr-2"></i>All Events</a>
        <a href="?view=my"       class="<?= $view==='my'?'active':'' ?>"><i class="fas fa-calendar-check mr-2"></i>My Registrations</a>
        <a href="?view=feedback" class="<?= $view==='feedback'?'active':'' ?>"><i class="fas fa-comment-dots mr-2"></i>Provide Feedback</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
    </nav>
</div>

<!-- ==== MAIN CONTENT ==== -->
<div class="content">
    <div class="container">
        <h1 class="text-3xl font-bold mb-6"><i class="fas fa-user mr-2"></i>Welcome, <?= htmlspecialchars($user->getName()) ?></h1>

        <?php if (empty($events)): ?>
            <p class="text-gray-400">No events to display.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($events as $e): ?>
                    <div class="event-card">
                        <div class="bg-gradient-to-r from-blue-700 to-blue-900 h-40 flex items-center justify-center">
                            <i class="fas fa-calendar-day text-6xl text-white opacity-70"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($e['title']) ?></h3>
                            <p class="text-gray-600 mt-2"><i class="fas fa-map-marker-alt mr-2"></i><?= htmlspecialchars($e['location']) ?></p>
                            <p class="text-gray-600"><i class="fas fa-clock mr-2"></i><?= date('d M Y, h:i A', strtotime($e['event_time'])) ?></p>
                            <?php if (isset($e['reg_status'])): ?>
                                <p class="mt-2">
                                    <span class="status-tag <?= $e['reg_status'] === 'approved' ? 'status-approved' : 'status-pending' ?>">
                                        Status: <?= ucfirst($e['reg_status']) ?>
                                    </span>
                                </p>
                            <?php endif; ?>

                            <?php if ($view === 'feedback'): ?>
                                <?php
                                $stmt = $conn->prepare("SELECT feedback_id FROM feedback WHERE event_id = ? AND user_id = ?");
                                $stmt->execute([$e['event_id'], $user_id]);
                                $has = $stmt->fetch();
                                $past = strtotime($e['event_time']) < time();
                                ?>
                                <?php if ($has): ?>
                                    <p class="text-green-600 mt-2">Feedback already given.</p>
                                <?php elseif ($past): ?>
                                    <button onclick="openFeedback(<?= $e['event_id'] ?>)" class="btn-primary mt-3">
                                        Give Feedback
                                    </button>
                                <?php else: ?>
                                    <p class="text-gray-500 mt-2">Event not finished yet.</p>
                                <?php endif; ?>
                            <?php else: ?>
                                <button onclick="openModal(<?= $e['event_id'] ?>)" class="btn-primary mt-4">
                                    View Details
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- ==== EVENT DETAIL MODAL ==== -->
<div id="eventModal" class="modal">
    <div class="modal-content">
        <span onclick="closeModal()" class="close-btn">&times;</span>
        <div id="modalContent"></div>
    </div>
</div>

<!-- ==== FEEDBACK MODAL ==== -->
<div id="feedbackModal" class="modal">
    <div class="modal-content">
        <span onclick="closeFeedback()" class="close-btn">&times;</span>
        <div id="feedbackContent"></div>
    </div>
</div>

<script>
    // ---- Event details modal ----
    function openModal(id){
        fetch('event_details.php?event_id='+id)
            .then(r=>r.text())
            .then(html=>{document.getElementById('modalContent').innerHTML=html;document.getElementById('eventModal').style.display='flex';})
            .catch(()=>{document.getElementById('modalContent').innerHTML='<p class="text-red-600">Error loading details.</p>';document.getElementById('eventModal').style.display='flex';});
    }
    function closeModal(){document.getElementById('eventModal').style.display='none';}

    // ---- Feedback modal ----
    function openFeedback(id){
        fetch('feedback_form.php?event_id='+id)
            .then(r=>r.text())
            .then(html=>{document.getElementById('feedbackContent').innerHTML=html;document.getElementById('feedbackModal').style.display='flex';});
    }
    function closeFeedback(){document.getElementById('feedbackModal').style.display='none';}
</script>
</body>
</html>