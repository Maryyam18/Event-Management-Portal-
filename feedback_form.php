<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 3) die("Unauthorized");
$event_id = (int)$_GET['event_id'];
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT e.event_time FROM events e
                        JOIN registrations r ON e.event_id = r.event_id
                        WHERE e.event_id = ? AND r.user_id = ? AND r.status = 'approved'");
$stmt->execute([$event_id, $user_id]);
$ev = $stmt->fetch();
if (!$ev) die("You are not registered for this event or it is not approved.");
$event_passed = strtotime($ev['event_time']) < time();
$stmt = $conn->prepare("SELECT feedback_id FROM feedback WHERE event_id = ? AND user_id = ?");
$stmt->execute([$event_id, $user_id]);
$already = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Georgia', serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .form-input, select, textarea {
            background-color: #f9fafb;
            border: 1px solid #d1d5db;
            color: #1e40af;
            border-radius: 6px;
            padding: 0.875rem;
            width: 100%;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-input:focus, select:focus, textarea:focus {
            border-color: #1e40af;
            box-shadow: 0 0 0 4px rgba(30, 64, 175, 0.15);
            outline: none;
        }
        .btn-primary {
            background-color: #1e40af;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 0.875rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
            display: inline-flex;
            align-items: center;
        }
        .btn-primary:hover {
            background-color: #1e3a8a;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
        }
        .success { background-color: #d1fae5; color: #065f46; padding: 0.75rem; border-radius: 6px; }
    </style>
</head>
<body>
    <?php if($already): ?>
        <p class="success">You have already submitted feedback for this event.</p>
    <?php elseif(!$event_passed): ?>
        <p class="text-red-600">Cannot give feedback yet. Event has not occurred.</p>
    <?php else: ?>
        <h3 class="text-xl font-semibold mb-4">Give Feedback</h3>
        <form method="POST" action="user_dashboard.php">
            <input type="hidden" name="event_id" value="<?= $event_id ?>">
            <div class="mb-4">
                <label class="block font-medium">Rating (1-5)</label>
                <select name="rating" class="form-input" required>
                    <?php for($i=1;$i<=5;$i++):?><option><?=$i?></option><?php endfor;?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block font-medium">Comment</label>
                <textarea name="comment" rows="3" class="form-input"></textarea>
            </div>
            <button type="submit" name="submit_feedback" class="btn-primary">
                <i class="fas fa-star mr-2"></i>Submit Feedback
            </button>
        </form>
    <?php endif;?>
</body>
</html>