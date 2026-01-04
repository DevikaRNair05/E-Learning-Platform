<?php
require_once '../includes/auth.php';
require_once '../includes/header.php';
require_once '../includes/db.php';

function generateToken($length = 32) {
    return bin2hex(random_bytes($length / 2));
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim($_POST['email']);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $token = generateToken();
        $created_at = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("INSERT INTO invites (email, token, created_at, used) VALUES (?, ?, ?, 0)");
        $stmt->bind_param('sss', $email, $token, $created_at);
        if ($stmt->execute()) {
            // Invite link is stored in DB. In production, you would email it to the creator.
            $message = "Invite link has been generated and stored successfully.";
        } else {
            $message = "Failed to store invite. Email may already have a pending invite.";
        }
        $stmt->close();
    } else {
        $message = "Invalid email address.";
    }
}
?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Invite Creator</h2>
    <?php if ($message): ?>
        <div class="alert alert-info text-center"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="post" class="mx-auto" style="max-width:400px;">
        <div class="mb-3">
            <label for="email" class="form-label">Creator Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Send Invite</button>
    </form>
</div>
<?php require_once '../includes/footer.php'; ?>