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
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
            font-family: 'Poppins', 'Segoe UI', Arial, sans-serif;
        }
        .login-card {
            border-radius: 32px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            background: #fff;
            padding: 2.5rem 2rem 2rem 2rem;
            max-width: 380px;
            margin: 0 auto;
            text-align: center;
        }
        .login-card img {
            width: 140px;
            max-width: 100%;
            margin-bottom: 1.5rem;
        }
        .login-title {
            font-size: 2rem;
            font-weight: 700;
            color: #5f2eea;
            margin-bottom: 1rem;
        }
        .login-desc {
            color: #555;
            font-size: 1.08rem;
            margin-bottom: 2rem;
        }
        .btn-login {
            background: linear-gradient(90deg, #7f53ac 0%, #647dee 100%);
            color: #fff;
            border: none;
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 600;
            padding: 0.75rem 0;
            width: 100%;
            box-shadow: 0 4px 16px 0 rgba(127, 83, 172, 0.10);
            transition: background 0.2s;
        }
        .btn-login:hover {
            background: linear-gradient(90deg, #647dee 0%, #7f53ac 100%);
            color: #fff;
        }
    </style>
</head>
<body>
    <?php /* include 'includes/header.php'; */ ?>
    <div class="d-flex flex-column align-items-center justify-content-center min-vh-100">
        <div class="login-card">
            <img src="assets/img/online_school.jpg" alt="Online School">
            <div class="login-title">Discover your next skill</div>
            <div class="login-desc">Learn anything you want! Discover the things you want, try them, and grow with them.</div>
            <a href="<?php echo $google_oauth_url; ?>" class="btn btn-login">Login with Google</a>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
