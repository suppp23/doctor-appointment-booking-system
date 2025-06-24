<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.0.0/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .top-navbar {
            background-color: #1977cc;
            color: #fff;
            padding: 0.5rem 1rem;
        }
        .top-navbar .contact-info {
            color: #fff;
        } 
        .top-navbar .social-icons a {
            color: #fff;
            margin-left: 15px;
        }
        .main-navbar {
            background-color: #f8f9fa;
            z-index: 997;
            height: 100px;
        }
        .main-navbar .navbar-nav .nav-link {
            color: #007bff;
            font-weight: bold;
        }
        .main-navbar .navbar-brand {
            color: #007bff;
            font-weight: bold;
            transition: color 0.5s, text-decoration 0.3s;
        }
        .main-navbar .navbar-nav .nav-link:hover {
            color: #1977cc;
            text-decoration: underline;
        }
        body {
            font-family: 'Source Sans Pro', sans-serif;
            background-image: url('assets/img/about.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 600px;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .form-group label {
            font-weight: bold;
        }
        .is-invalid {
            border-color: red;
        }
        .form-control.is-invalid::placeholder {
            color: red;
        }
        .error-message {
            color: red;
            font-size: 0.9rem;
            display: none;
        }
    </style>
</head>
<body>

<nav class="top-navbar">
    <div class="container-fluid d-flex justify-content-between">
        <div class="contact-info">
            <span><i class="fas fa-envelope"></i> doctor@quantana.in</span>
            <span class="ms-3"><i class="fas fa-phone"></i> 9876543210</span>
        </div>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin"></i></a>
        </div>
    </div>
</nav>
<nav class="navbar navbar-expand-lg main-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">MedSched</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="<?= base_url(); ?>">HOME</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('patient/list'); ?>">PATIENTS</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
    <h2 class="text-center" style="color: orangered; font-weight: bold;">Patient Registration</h2>

    
    <form action="<?= base_url('patient/submit_patient') ?>" method="POST" class="needs-validation" novalidate>
        <div class="form-group">
            <label for="name">Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" value="<?= set_value('name') ?>" required>
            <?= form_error('name', '<div class="text-danger">', '</div>'); ?>
        </div>
        <div class="form-group">
            <label for="email">Email<span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" value="<?= set_value('email') ?>" required>
            <?= form_error('email', '<div class="text-danger">', '</div>'); ?>
        </div>
        <div class="form-group">
            <label for="phone">Phone<span class="text-danger">*</span></label>
            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter 10-digit number" value="<?= set_value('phone') ?>" required>
            <?= form_error('phone', '<div class="text-danger">', '</div>'); ?>
        </div>
        <div class="form-group">
            <label for="age">Age <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="age" placeholder="Enter Age" name="age" value="<?= set_value('age') ?>" required min="1" max="100">
            <?= form_error('age', '<div class="text-danger">', '</div>'); ?>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Register</button>
    </form>
</div>


<?php if (isset($success) && $success === TRUE): ?>
    <script>
        Swal.fire({
            title: 'New Patient Registered!',
            text: 'Registration successful!',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(function() {
           
            window.location.href = '<?= base_url("patient/registration") ?>'; 
        });
    </script>
<?php elseif (isset($error) && $error === TRUE): ?>
    <script>
        Swal.fire({
            title: 'Error!',
            text: 'There was an issue with the registration. Please try again.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
<?php endif; ?>

</body>
</html>
