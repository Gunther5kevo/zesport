<?php

include('functions.php');

if (isset($_POST['login'])) {
    $emailInput = validate($_POST['email']);
    $passwordInput = validate($_POST['password']);

    $email = filter_var($emailInput, FILTER_SANITIZE_EMAIL);
    $password = filter_var($passwordInput, FILTER_SANITIZE_STRING);

    if ($email != '' && $password != '') {
        try {
            // Prepare the SQL query using placeholders for safety
            $query = "SELECT * FROM users WHERE email = :email AND password = :password LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['email' => $email, 'password' => $password]);

            // Fetch the result
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                if ($row['role'] == 'admin') {
                    if ($row['is_ban'] == 1) {
                        redirect('login.php', 'Your account has been banned. Please contact admin.');
                    }

                    $_SESSION['auth'] = true;
                    $_SESSION['loggedInUserRole'] = $row['role'];
                    $_SESSION['loggedInUser'] = [
                        'name' => $row['name'],
                        'email' => $row['email']
                    ];

                    redirect('admin_dashboard.php', 'Logged In Successfully');
                } else {
                    $_SESSION['auth'] = true;
                    $_SESSION['loggedInUserRole'] = $row['role'];
                    $_SESSION['loggedInUser'] = [
                        'name' => $row['name'],
                        'email' => $row['email']
                    ];
                    redirect('../presentationlayer/index.php', 'Logged In Successfully');
                }
            } else {
                redirect('login.php', 'Invalid Email or Password');
            }
        } catch (PDOException $e) {
            redirect('login.php', 'Something went wrong: ' . $e->getMessage());
        }
    } else {
        redirect('login.php', 'All Fields Required');
    }
}
