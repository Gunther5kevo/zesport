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
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<!-- Custom JavaScript for handling multi-level dropdowns -->

</body>
</html>
<?php include('includes/footer.php'); ?>
