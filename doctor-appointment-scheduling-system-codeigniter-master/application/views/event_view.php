<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            max-width: 40%;
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
                <li class="nav-item"><a class="nav-link" href="<?= base_url('events/view'); ?>">EVENTS</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1 class="text-center" style="color: orangered; font-weight: bold;">EVENTS</h1>
        <form method="POST" action="<?= site_url('events/index') ?>" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="doctor" class="form-label">Doctor Name:</label>
                <select name="doctor" id="doctor" class="form-select" required>
                    <option value="">Select a Doctor</option>
                    <?php foreach ($doctors as $doctor): ?>
                        <option value="<?= $doctor['id']; ?>"><?= $doctor['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Please select a doctor.</div>
            </div>
            <div class="form-group">
                <label for="event_date" class="form-label">Event Date:</label>
                <input type="date" name="event_date" id="event_date" class="form-control" min="<?= date('Y-m-d'); ?>" required>
                <div class="invalid-feedback">Please select a date.</div>
            </div>
            <div class="form-group">
                <label for="event_type" class="form-label">Event Type:</label>
                <select name="event_type" id="event_type" class="form-select" required>
                    <option value=""></option>
                    <option value="1">Break</option>
                    <option value="2">Out of Office</option>
                    <option value="3">Surgical Consultation</option>
                </select>
                <div class="invalid-feedback">Please select an event type.</div>
            </div>
            <div class="form-group">
                <label for="event_start_time" class="form-label">Start Time:</label>
                <input type="time" name="event_start_time" id="event_start_time" class="form-control" required>
                <div class="invalid-feedback">Please select a start time.</div>
            </div>
            <div class="form-group">
                <label for="event_end_time" class="form-label">End Time:</label>
                <input type="time" name="event_end_time" id="event_end_time" class="form-control" required>
                <div class="invalid-feedback">Please select an end time.</div>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 30px;">Create Event</button>
        </form>
    </div>

    <script>
       (function () {
        'use strict';
        var form = document.getElementById('eventForm');
        var endTimeField = form.querySelector('#event_end_time');
        var endTimeError = form.querySelector('#end-time-error');
        
        form.addEventListener('submit', function (event) {
            var startTime = form.querySelector('#event_start_time').value;
            var endTime = form.querySelector('#event_end_time').value;
            
            endTimeField.classList.remove('is-invalid');
            endTimeError.style.display = 'none';
            
            if (startTime && endTime) {
                if (endTime <= startTime) {
                    event.preventDefault();
                    event.stopPropagation();
                    endTimeField.classList.add('is-invalid');
                    endTimeError.style.display = 'block';
                    return false;
                }
            }

        
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);
    })();
    
    <?php if (isset($successMessage)): ?>
        Swal.fire({
            title: 'New Event Registered Successfully!',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = '<?php echo site_url('events/view'); ?>'; 
        });
    <?php endif; ?>
    </script>
</body>
</html>
