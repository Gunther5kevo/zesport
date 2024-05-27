<?php
include('functions.php');

if (isset($_SESSION['auth'])) {
    if (isset($_SESSION['loggedInUserRole']) && isset($_SESSION['loggedInUser']['email'])) {
        $role = validate($_SESSION['loggedInUserRole']);
        $email = validate($_SESSION['loggedInUser']['email']);

        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT * FROM users WHERE email = :email AND role = :role LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);

            $stmt->execute();
            $row = $stmt->fetch();

            if ($row === false) {
                logoutSession();
                redirect('login.php', 'Access Denied');
            } else {
                if ($row['role'] !== 'admin') {
                    logoutSession();
                    redirect('login.php', 'Access Denied');
                }
            }
        } catch (PDOException $e) {
            logoutSession();
            redirect('login.php', 'Something went wrong: ' . $e->getMessage());
        }
    } else {
        redirect('login.php', 'Login to continue..');
    }
} else {
    redirect('login.php', 'Login to continue..');
}
?>
