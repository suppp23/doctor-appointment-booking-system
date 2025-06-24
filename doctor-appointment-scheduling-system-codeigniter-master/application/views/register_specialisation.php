<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register Specialisations</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        }
        .main-navbar .navbar-nav .nav-link:hover {
            color: #1977cc;
            text-decoration: underline;
        }
        body {
            font-family: 'Source Sans Pro', sans-serif;
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            margin-top: 100px;
            max-width: 600px;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .form-group label {
            font-weight: bold;
        }
        .error-message {
            color: red;
            font-size: 0.9rem;
            margin-top: 5px;
        }
        .is-invalid {
            border-color: red !important;
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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="<?= base_url(); ?>">HOME</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('specialisation/list'); ?>">SPECIALISATION</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <h2 class="text-center" style="color:orangered; font-weight:bold">Register Specialisation</h2>
    <form id="specialisationForm" method="POST" class="needs-validation" novalidate>
        <div class="form-group">
            <label for="specialisation_name">Specialisation Name<span class="text-danger">*</span>:</label>
            <input type="text" class="form-control" id="specialisation_name" placeholder="Enter Specialisation" name="specialisation_name" required>
            <div id="specialisation_name_error" class="error-message"></div>
        </div>
        <div class="form-group">
            <label for="description">Description<span class="text-danger">*</span>:</label>
            <textarea class="form-control" rows="4" id="description" placeholder="Description" name="description" required></textarea>
            <div id="description_error" class="error-message"></div>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:20px;">Register</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#specialisationForm').on('submit', function(e) {
            e.preventDefault(); 
            if (validateForm()) {
                var formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('specialisation/register'); ?>',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                confirmButtonText: 'OK'
                            }).then(() => {
                              
                                window.location.href = '<?= base_url('specialisation/list'); ?>'; 
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message,
                                confirmButtonText: 'Try Again'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'An unexpected error occurred. Please try again later.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });

    function validateForm() {
        var isValid = true;
        var specialisationName = $('#specialisation_name').val().trim();
        var description = $('#description').val().trim();
        var specialisationNameError = $('#specialisation_name_error');
        var descriptionError = $('#description_error');
        specialisationNameError.html("");
        descriptionError.html("");
        $('#specialisation_name').removeClass('is-invalid');
        $('#description').removeClass('is-invalid');

        if (specialisationName === "") {
            specialisationNameError.html("Specialisation name is required.");
            $('#specialisation_name').addClass('is-invalid');
            isValid = false;
        }
        
        var wordCount = description.split(/\s+/).length;
        if (wordCount < 5) {
            descriptionError.html("Description must be at least 5 words.");
            $('#description').addClass('is-invalid');
            isValid = false;
        }   
        return isValid;
    }
</script>
</body>
</html>
