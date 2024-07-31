<?php 
    include('functions.php');
    $pageTitle = 'Forgot Password';

    if(isset($_SESSION['auth'])){
        redirect('admin_dashboard.php', 'You are already logged in');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Zesport Forgot Password</title>
</head>
<body>
<div class="py-4 bg-secondary text-center">
    <h4 class="text-white">Forgot Password</h4>
</div>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4>Forgot Password</h4>
                    </div>
                </div>
            
                <div class="card-body">
                    <?= alertMessage();?>
                    <form action="forgot-password-code.php" method="POST">
                        <div class="mb-3">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn bt-primary w-100" name="forgot_password">Send Reset Link</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<?php include('includes/footer.php'); ?>
