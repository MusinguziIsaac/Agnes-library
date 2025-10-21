<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    
    try {
        $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $message]);
        
        echo "<script>
            alert('Message sent successfully!');
            window.location.href = 'index.html';
        </script>";
    } catch(PDOException $e) {
        echo "<script>alert('Message failed to send!'); window.history.back();</script>";
    }
}
?>