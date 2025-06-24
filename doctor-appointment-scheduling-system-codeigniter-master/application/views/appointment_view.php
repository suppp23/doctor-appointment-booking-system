<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.0.0/js/all.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   

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
            margin-top: 60px;
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
        .slot_container {
            margin-top: 5px;    
        }
        #slot_container button {
            width: 150px;
            margin: 5px;
            text-align: center;
            background-color:#04aa6d ;
        }
        .slot-btn {
            margin: 5px;
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
            cursor: pointer;
        }

        .slot-btn:hover {
            background-color: #f0f0f0;
        }

        .slot-btn.selected {
            background-color: #007bff;
            color: white;
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
            <li class="nav-item"><a class="nav-link" href="<?= base_url('appointment/list'); ?>">APPOINTMENTS</a></li>  
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="text-center" style="color:orangered; font-weight:bold;">APPOINTMENT</h2>
        <form id="appointmentForm" method="POST" action="<?= base_url('appointment/book_appointment') ?>" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="specialisation" class="form-label">Specialisation</label>
                <select class="form-control" id="specialisation" name="specialisation" required>
                    <option value="">Select Specialisation</option>
                    <?php foreach ($specialisations as $row): ?>
                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Please select a specialisation.</div>
            </div>
            <div class="form-group">
                <label for="doctor" class="form-label">Doctor</label>
                <select class="form-control" id="doctor" name="doctor" required>
                    <option value="">Select Doctor</option>
                </select>
                <div class="invalid-feedback">Please select a doctor.</div>
            </div>
            <div class="form-group">
                <label for="patient" class="form-label">Patient</label>
                <select class="form-control" id="patient" name="patient" required>
                    <option value="">Select Patient</option>
                    <?php foreach ($patients as $row): ?>
                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Please select a patient.</div>
            </div>
            <div class="form-group">
                <label for="slot_date" class="form-label">Appointment Date</label>
                <input type="date" class="form-control" id="slot_date" name="slot_date" min="<?= date('Y-m-d'); ?>" required>
                <div class="invalid-feedback">Please select a valid date.</div>
            </div>
            <div class="form-group">
                <label for="slot_time" class="form-label">Available Slots</label>
                <div id="slot_container" class="slot_container"></div>
                <input type="hidden" id="selected_slot" name="slot_time" required>
                <div class="invalid-feedback">Please select a slot.</div>
            </div>   
            <button type="submit" class="btn btn-primary">Book Appointment</button> 
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#specialisation').change(function() {
                var specialisation_id = $(this).val();
                $.post('<?= base_url('appointment/fetch_doctors'); ?>', { specialisation_id: specialisation_id }, function(data) {
                    var doctors = JSON.parse(data);
                    var doctor_select = $('#doctor');
                    doctor_select.empty().append('<option value="">Select Doctor</option>');
                    $.each(doctors, function(index, doctor) {
                        doctor_select.append('<option value="' + doctor.id + '">' + doctor.name + '</option>');
                    });
                });
            });
            $('#doctor, #slot_date').change(function() {
                var doctor_id = $('#doctor').val();
                var slot_date = $('#slot_date').val();
                
                if (doctor_id && slot_date) {
                    $.post('<?= base_url('appointment/fetch_slots'); ?>', { doctor_id: doctor_id, slot_date: slot_date }, function(data) {
                        var slots = JSON.parse(data);
                        var slot_container = $('#slot_container');
                        slot_container.empty(); 

                        if (slots.length > 0) {
                            $.each(slots, function(index, slot) {
                                var slot_time = slot.slot_start_time + '-' + slot.slot_end_time;
                                var slot_button = $('<button>')
                                    .addClass('slot-btn')
                                    .text(slot.slot_start_time + ' - ' + slot.slot_end_time)
                                    .data('slot_time', slot_time); 
                                slot_button.click(function() {
                                    $('#selected_slot').val($(this).data('slot_time')); 
                                    slot_container.find('.slot-btn').removeClass('selected'); 
                                    $(this).addClass('selected'); 
                                });

                                slot_container.append(slot_button);
                            });
                        } else {
                            slot_container.append('<p>No available slots</p>');
                        }
                    });
                }
            });

            $('#appointmentForm').submit(function(e) {
                if (!$('#selected_slot').val()) {
                    e.preventDefault(); 
                    alert('Please select a slot first!');
                }
            });
             <?php if (isset($success) && $success): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Appointment booked successfully!',
                    confirmButtonText: 'OK'
                });
            <?php elseif (isset($error) && $error): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Failed!',
                    text: 'Failed to book appointment. Please try again.',
                    confirmButtonText: 'OK'
                });
            <?php endif; ?>
        });
    </script>
</body>
</html>
