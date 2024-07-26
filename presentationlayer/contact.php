<?php include('../admin/includes/headerr.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZEsport Contact-Us</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Open+Sans:wght@300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/contact.css">
    <link rel="apple-touch-icon" sizes="180x180" href="favicon_io/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="favicon_io/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="favicon_io/favicon-16x16.png" />
    <link rel="manifest" href="favicon_io/site.webmanifest">
    <script src="https://kit.fontawesome.com/c9fbbb82ef.js" crossorigin="anonymous"></script>
</head>

<body>
    <main>

        <section class="contact-section">
            <div class="container-fluid text-center" id="landscape"></div>

            <div class="container-fluid d-flex" id="contact">
                <div class="info">
                    <h4>Get in touch</h4>
                    <h2>Have a question? Reach out</h2>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.004646326324!2d36.95006197395923!3d-1.157160698831763!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f3f1449126b37%3A0xd4c08bc42d55ea68!2sZetech%20Un!5e0!3m2!1sen!2ske!4v1699533843149!5m2!1sen!2ske"
                        class="map" allowfullscreen="" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="form">
                    <form class="row g-3" method="POST" action="../datalayer/contact.php">
                        <div class="col-md-6">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname" aria-label="First name"
                                required />
                            <span class="error-message" aria-live="polite"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lname" name="lname" aria-label="Last name"
                                required />
                            <span class="error-message" aria-live="polite"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required />
                            <span class="error-message" aria-live="polite"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="phoneNumber" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" required />
                            <span class="error-message" aria-live="polite"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" aria-label="Subject"
                                required />
                        </div>
                        <div class="col-12">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="3" name="message" required></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-lg" id="button" >Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>


    </main>
    <footer>
    <?php include('footer.php'); ?>
    </footer>
    
    <script src="contact-us.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>