<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Registration</title>
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
                <li class="nav-item"><a class="nav-link" href="<?= base_url('doctor/list'); ?>">DOCTORS</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="text-center" style="color: orangered; font-weight: bold;">Doctor Registration</h2>

        <form id="doctorForm" novalidate>
            <div class="form-group">
                <label for="name">Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                <div class="error-message" id="nameError"></div>
            </div>
            <div class="form-group">
                <label for="email">Email<span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                <div class="error-message" id="emailError"></div>
            </div>
            <div class="form-group">
                <label for="phone">Phone<span class="text-danger">*</span></label>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter 10-digit phone number" required>
                <div class="error-message" id="phoneError"></div>
            </div>
            <div class="form-group">
                <label for="specialisation">Specialisation<span class="text-danger">*</span></label>
                <select class="form-control" id="specialisation" name="specialisation" required>
                    <option value="">Select Specialisation</option>
                    <?php foreach ($specialisations as $specialisation): ?>
                        <option value="<?php echo $specialisation['id']; ?>">
                            <?php echo htmlspecialchars($specialisation['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="error-message" id="specialisationError"></div>
            </div>
            <div class="form-group">
                <label for="start_time">Available Start Time<span class="text-danger">*</span></label>
                <input type="time" class="form-control" id="start_time" name="start_time" required>
                <div class="error-message" id="startTimeError"></div>
            </div>
            <div class="form-group">
                <label for="end_time">Available End Time<span class="text-danger">*</span></label>
                <input type="time" class="form-control" id="end_time" name="end_time" required>
                <div class="error-message" id="endTimeError"></div>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top:20px;">Register</button>
        </form>
    </div>

    <script>
    $(document).ready(function() {
        $('#doctorForm').on('submit', function(e) {
            e.preventDefault(); 
       
            $('.error-message').text('');

            const name = $('#name').val().trim();
            const email = $('#email').val().trim();
            const phone = $('#phone').val().trim();
            const specialisation = $('#specialisation').val();
            const startTime = $('#start_time').val();
            const endTime = $('#end_time').val();

            let valid = true;
            if (!name) {
                $('#nameError').text('Name is required.');
                valid = false;
            }

            if (!email) {
                $('#emailError').text('Email is required.');
                valid = false;
            } else if (!validateEmail(email)) {
                $('#emailError').text('Invalid email format.');
                valid = false;
            }

            if (!phone) {
                $('#phoneError').text('Phone number is required.');
                valid = false;
            } else if (!/^[6-9][0-9]{9}$/.test(phone)) {
                $('#phoneError').text('Phone number must be a 10-digit number starting with 6, 7, 8, or 9.');
                valid = false;
            }

            if (!specialisation) {
                $('#specialisationError').text('Specialisation is required.');
                valid = false;
            }

            if (!startTime) {
                $('#startTimeError').text('Start time is required.');
                valid = false;
            }

            if (!endTime) {
                $('#endTimeError').text('End time is required.');
                valid = false;
            } else if (startTime >= endTime) {
                $('#endTimeError').text('End time must be after start time.');
                valid = false;
            }

            if (valid) {
                $.ajax({
                    url: "<?php echo site_url('doctor/submit_registration'); ?>",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '<?php echo site_url('doctors_list'); ?>'; 
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'There was an issue with the request.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });

        function validateEmail(email) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }
    });
    </script>
</body>
</html>
