<?php include('includes/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .background-span {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('../presentationlayer/assets/img/avatar/dashboard.jpg');
            background-size: cover;
            background-position: center;
            z-index: -1; /* Ensure the span is behind other content */
        }

        .content {
            position: relative;
            z-index: 1; /* Ensure the content is above the background image */
        }
    </style>
</head>
<body>
    <div class="background-span"></div>

    <div class="container content">
        <div class="row">
            <div class="col-md-3 mb-4">
             <?= alertMessage();?>
                <div class="card card-body p-3">
                    <h5 class="font-weight-bolder mb-0"> 
                        Welcome!
                    </h5>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php include('includes/footer.php'); ?>
