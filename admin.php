<?php
// admin.php
require_once 'config.php';

// Simple authentication (in production, use proper authentication)
$admin_user = 'admin';
$admin_pass = 'password123';

if ($_POST['login'] ?? false) {
    if ($_POST['username'] === $admin_user && $_POST['password'] === $admin_pass) {
        $_SESSION['admin_logged_in'] = true;
    }
}

if (!($_SESSION['admin_logged_in'] ?? false)) {
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Admin Login</title>
        <style>
            body { font-family: Arial, sans-serif; max-width: 400px; margin: 100px auto; padding: 20px; }
            .login-form { background: #f9f9f9; padding: 20px; border-radius: 8px; }
            input, button { width: 100%; padding: 10px; margin: 5px 0; }
        </style>
    </head>
    <body>
        <div class="login-form">
            <h2>Admin Login</h2>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
            </form>
        </div>
    </body>
    </html>';
    exit;
}

// Fetch data
$members = $pdo->query("SELECT * FROM members ORDER BY registration_date DESC")->fetchAll();
$messages = $pdo->query("SELECT * FROM contact_messages ORDER BY submission_date DESC")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>AGNES Library - Admin Panel</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .section { margin: 40px 0; }
    </style>
</head>
<body>
    <h1>AGNES Library Admin Panel</h1>
    
    <div class="section">
        <h2>Member Registrations</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Membership Type</th>
                <th>Payment Method</th>
                <th>Registration Date</th>
                <th>Status</th>
            </tr>
            <?php foreach($members as $member): ?>
            <tr>
                <td><?= $member['id'] ?></td>
                <td><?= htmlspecialchars($member['first_name'] . ' ' . $member['last_name']) ?></td>
                <td><?= htmlspecialchars($member['email']) ?></td>
                <td><?= htmlspecialchars($member['phone']) ?></td>
                <td><?= ucfirst($member['membership_type']) ?></td>
                <td><?= str_replace('_', ' ', ucfirst($member['payment_method'])) ?></td>
                <td><?= $member['registration_date'] ?></td>
                <td><?= ucfirst($member['status']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    
    <div class="section">
        <h2>Contact Messages</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Submission Date</th>
                <th>Status</th>
            </tr>
            <?php foreach($messages as $message): ?>
            <tr>
                <td><?= $message['id'] ?></td>
                <td><?= htmlspecialchars($message['name']) ?></td>
                <td><?= htmlspecialchars($message['email']) ?></td>
                <td><?= htmlspecialchars(substr($message['message'], 0, 100)) . '...' ?></td>
                <td><?= $message['submission_date'] ?></td>
                <td><?= ucfirst($message['status']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>