<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $membership_type = $_POST['membership_type'];
    $payment_method = $_POST['payment_method'];
    
    try {
        // Check if email exists
        $check_stmt = $pdo->prepare("SELECT id FROM members WHERE email = ?");
        $check_stmt->execute([$email]);
        
        if ($check_stmt->rowCount() > 0) {
            echo "<script>alert('Email already registered!'); window.history.back();</script>";
        } else {
            // Insert new member
            $stmt = $pdo->prepare("INSERT INTO members (first_name, last_name, email, phone, address, membership_type, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$first_name, $last_name, $email, $phone, $address, $membership_type, $payment_method]);
            
            echo "<script>
                alert('Registration successful! We will contact you soon.');
                window.location.href = 'index.html';
            </script>";
        }
    } catch(PDOException $e) {
        echo "<script>alert('Registration failed!'); window.history.back();</script>";
    }
}
?>