<?php
session_start();
include 'db_connect.php';

// Control Statements: Session check
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 3) {
    die("Unauthorized");
}

$event_id = (int)$_GET['event_id'];
$user_id  = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM events WHERE event_id = ? AND status = 'approved'");
$stmt->execute([$event_id]);
$event = $stmt->fetch();

if (!$event) die("Event not found");

$stmt = $conn->prepare("SELECT status FROM registrations WHERE event_id = ? AND user_id = ?");
$stmt->execute([$event_id, $user_id]);
$reg = $stmt->fetch();

$alreadyRegistered = $reg && $reg['status'] === 'approved';
$pending = $reg && $reg['status'] === 'pending';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
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
        .btn-primary, .btn-green {
            border: none;
            border-radius: 6px;
            padding: 0.875rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
            display: inline-flex;
            align-items: center;
        }
        .btn-primary { background-color: #1e40af; color: #ffffff; }
        .btn-primary:hover {
            background-color: #1e3a8a;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
        }
        .btn-green { background-color: #059669; color: #ffffff; }
        .btn-green:hover {
            background-color: #047857;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
        }
        .success { background-color: #d1fae5; color: #065f46; padding: 0.75rem; border-radius: 6px; }
        .text-orange-600 { color: #ea580c; }
    </style>
</head>
<body>
    <h2 class="text-2xl font-bold text-blue-800 mb-4"><?= htmlspecialchars($event['title']) ?></h2>
    <p class="text-gray-700 mb-4"><?= nl2br(htmlspecialchars($event['description'])) ?></p>

    <div class="grid grid-cols-2 gap-4 text-gray-600">
        <div><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></div>
        <div><strong>Date & Time:</strong> <?= date('d M Y, h:i A', strtotime($event['event_time'])) ?></div>
        <div><strong>People Limit:</strong> <?= $event['people_limit'] ?: 'Unlimited' ?></div>
        <div><strong>Budget:</strong> $<?= number_format($event['budget'], 2) ?></div>
        <div><strong>Speakers:</strong> <?= htmlspecialchars($event['speakers']) ?></div>
    </div>

    <hr class="my-6">

    <?php if ($alreadyRegistered): ?>
        <p class="success">You are registered for this event!</p>
    <?php elseif ($pending): ?>
        <p class="text-orange-600 font-semibold">Registration pending approval.</p>
    <?php else: ?>
        <form method="POST" action="user_dashboard.php" class="inline">
            <input type="hidden" name="event_id" value="<?= $event_id ?>">
            <button type="submit" name="register_event" class="btn-green">
                <i class="fas fa-check mr-2"></i>Register Now
            </button>
        </form>
    <?php endif; ?>

    <?php
    $eventPassed = strtotime($event['event_time']) < time();
    if ($alreadyRegistered && $eventPassed):
        $stmt = $conn->prepare("SELECT feedback_id FROM feedback WHERE event_id = ? AND user_id = ?");
        $stmt->execute([$event_id, $user_id]);
        $hasFeedback = $stmt->fetch();
    ?>
        <div class="mt-8">
            <h3 class="text-xl font-semibold mb-3">Give Feedback</h3>
            <?php if ($hasFeedback): ?>
                <p class="success">Thank you for your feedback!</p>
            <?php else: ?>
                <form method="POST" action="user_dashboard.php">
                    <input type="hidden" name="event_id" value="<?= $event_id ?>">
                    <div class="mb-3">
                        <label class="block font-medium">Rating (1-5)</label>
                        <select name="rating" class="form-input" required>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <option><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="block font-medium">Comment</label>
                        <textarea name="comment" rows="3" class="form-input"></textarea>
                    </div>
                    <button type="submit" name="submit_feedback" class="btn-primary">
                        <i class="fas fa-star mr-2"></i>Submit Feedback
                    </button>
                </form>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</body>
</html>