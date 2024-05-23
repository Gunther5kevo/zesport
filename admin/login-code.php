<?php

include('function.php');

if(isset ($_POST ['loginBtn'])){
    $emailInput = validate($_POST ['email']);
    $passwordInput = validate($_POST ['password']);

    $email = filter_var($emailInput, FILTER_SANITIZE_EMAIL);
    $password = filter_var($passwordInput, FILTER_SANITIZE_STRING);

    if($email != '' &&password != ''){
        $query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
        $result = mysqli_query ($conn, $query);

        if($result){
            if(mysqli_num_rows ($result) === 1){
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                if($row ['role'] =='admin'){
                    
                    if($role['is_ban'] == 1){
                        redirect('login.php', 'Your account has been banned Please contact admin');
                    }


                    $_SESSION['auth'] =true;
                    $_SESSION['loggedInUserRole'] =$row['role'];
                    $_SESSION['loggedInUser'] = [
                        'name' => $row ['name'],
                        'email' => $row ['email']
                    ];

                    redirect('admin_dashboard.php', 'Logged In Successfully');
                }else{
                    $_SESSION['auth'] =true;
                    $_SESSION['loggedInUserRole'] =$row['role'];
                    $_SESSION['loggedInUser'] = [
                        'name' => $row ['name'],
                        'email' => $row ['email']
                    ];
                    redirect('../presentationlayer/index.php', 'Logged In Successfully');
                }
            }
        }else{
            redirect('login_php', 'Something Went wrong');
        }
    }else{
        redirect('login_php', 'ALL Fields Required');
    }
}
?>