<?php
// index.php - Login page with Google OAuth
session_start();
require_once 'config.php';
require_once 'includes/db.php';

// Handle Google OAuth callback
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);
        $oauth2 = new Google_Service_Oauth2($client);
        $userinfo = $oauth2->userinfo->get();
        $email = $userinfo->email;
        $name = $userinfo->name;
        // Check if user exists
        $stmt = $conn->prepare("SELECT id, role FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $role);
            $stmt->fetch();
        } else {
            // New user: determine role
            // Admin: first user, else check invite for creator, else student
            $role = 'student';
            $result = $conn->query("SELECT COUNT(*) FROM users");
            $row = $result->fetch_row();
            if ($row[0] == 0) {
                $role = 'admin';
            } else {
                // Check invite for creator
                $stmt2 = $conn->prepare("SELECT id FROM invites WHERE email = ? AND used = 0");
                $stmt2->bind_param('s', $email);
                $stmt2->execute();
                $stmt2->store_result();
                if ($stmt2->num_rows > 0) {
                    $role = 'creator';
                    // Mark invite as used
                    $stmt2->bind_result($invite_id);
                    $stmt2->fetch();
                    $conn->query("UPDATE invites SET used = 1 WHERE id = $invite_id");
                }
                $stmt2->close();
            }
            // Insert new user
            $stmt3 = $conn->prepare("INSERT INTO users (email, name, role) VALUES (?, ?, ?)");
            $stmt3->bind_param('sss', $email, $name, $role);
            $stmt3->execute();
            $user_id = $stmt3->insert_id;
            $stmt3->close();
        }
        $stmt->close();
        // Set session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['role'] = $role;
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Google authentication failed.';
    }
}

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online School - Login</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container d-flex flex-column align-items-center justify-content-center min-vh-100">
        <div class="card p-5 shadow-lg text-center" style="max-width:400px;">
            <img src="assets/img/online_school.svg" alt="Online School" class="mb-4" style="width:120px;">
            <h2 class="mb-3">Online School</h2>
            <p class="mb-4">Home study during the pandemic, lots of learning. Lots of professional teachers, and easy to understand.</p>
            <a href="<?php echo $google_oauth_url; ?>" class="btn btn-primary btn-block">Login with Google</a>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
