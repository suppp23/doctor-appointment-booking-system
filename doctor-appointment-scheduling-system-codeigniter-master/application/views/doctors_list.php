<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.0.0/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Your existing styles */
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
        .main-navbar .btn-primary {
            background-color: #007bff;
            border-color: #d0d6dc;
            font-weight: bold;
        }
        .main-navbar .navbar-nav .nav-link:hover {
            color:#1977cc; 
            text-decoration: underline; 
        }
        body {
            font-family: 'Source Sans Pro', sans-serif;
            background-image: url('assets/img/about.jpg');
            background-size: cover;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        .table-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007bff;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            text-align: center;
            padding: 12px;
        }
        table th {
            background-color: white;
            color: red;
            font-weight: bold;
        }
        table td {
            background-color: #f9f9f9;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 5px;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            border-radius: 5px;
        }
        .navbar {
            margin-bottom: 0;
        }
        .modal-content {
            border-radius: 8px;
        }
        .modal-header {
            background-color: #007bff;
            color: white;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .modal-title {
            font-weight: 600;
        }
        .error-message {
            color: red;
            font-size: 0.875em;
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
            <li class="nav-item"><a class="nav-link" href="<?= base_url('doctor/registration'); ?>">ADD DOCTOR</a></li>  
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <?php
    $this->load->model('Doctor_model');
    $doctors = $this->Doctor_model->get_all_doctors();
    ?>

    <?php if (!empty($doctors)): ?>
        <div class="table-container">
            <h2>DOCTORS</h2>
            <table class="table table-bordered table-striped table-responsive">
                <thead>
                    <tr>
                        <th>NAME</th>
                        <th>SPECIALISATION</th>
                        <th>EMAIL-ID</th>
                        <th>PHONE NO.</th>
                        <th>START TIME</th>
                        <th>END TIME</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($doctors as $doctor): ?>
                        <tr id="doctor-<?php echo $doctor['id']; ?>">
                            <td><?php echo htmlspecialchars($doctor['doctor_name']); ?></td>
                            <td><?php echo htmlspecialchars($doctor['specialisation_name']); ?></td>
                            <td><?php echo htmlspecialchars($doctor['email']); ?></td>
                            <td><?php echo htmlspecialchars($doctor['mobile']); ?></td>
                            <td><?php echo htmlspecialchars($doctor['start_time']); ?></td>
                            <td><?php echo htmlspecialchars($doctor['end_time']); ?></td>
                            <td>
                                <button class="btn btn-primary edit-btn" data-id="<?php echo $doctor['id']; ?>">Update</button>
                                <button class="btn btn-danger" onclick="confirmDelete(<?php echo $doctor['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="alert alert-warning">No Doctors found!</p>
    <?php endif; ?>
</div>

<div id="editDoctorModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editDoctorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDoctorModalLabel">Update Doctor</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editDoctorForm" class="needs-validation" novalidate>
                    <div class="form-group">
                        <label for="doctorName">Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="doctorName" name="name" required>
                        <div id="nameError" class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="doctorEmail">Email<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="doctorEmail" name="email" required>
                        <div id="emailError" class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="doctorMobile">Mobile<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="doctorMobile" name="mobile" required>
                        <div id="phoneError" class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="doctorSpecialisation">Specialisation<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="doctorSpecialisation" name="specialisation" required>
                        <div id="specialisationError" class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="doctorStartTime">Start Time<span class="text-danger">*</span></label>
                        <input type="time" class="form-control" id="doctorStartTime" name="start_time" required>
                        <div id="starttimeError" class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="doctorEndTime">End Time<span class="text-danger">*</span></label>
                        <input type="time" class="form-control" id="doctorEndTime" name="end_time" required>
                        <div id="endtimeError" class="error-message"></div>
                    </div>
                    <input type="hidden" id="doctorId" name="id">
                    <button type="button" class="btn btn-primary" id="updateDoctorBtn">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {  
        $('.edit-btn').click(function() {
            var row = $(this).closest('tr');
            var doctorId = $(this).data('id');
            var name = row.find('td:eq(0)').text();
            var email = row.find('td:eq(2)').text();
            var mobile = row.find('td:eq(3)').text();
            var specialisation = row.find('td:eq(1)').text();
            var startTime = row.find('td:eq(4)').text();
            var endTime = row.find('td:eq(5)').text();

            $('#doctorId').val(doctorId);
            $('#doctorName').val(name);
            $('#doctorEmail').val(email);
            $('#doctorMobile').val(mobile);
            $('#doctorSpecialisation').val(specialisation);
            $('#doctorStartTime').val(startTime);
            $('#doctorEndTime').val(endTime);
            $('#editDoctorModal').modal('show');
        });

        $('#updateDoctorBtn').click(function() {
            if (validateForm()) {
                Swal.fire({
                    title: 'UPDATE DOCTOR?',
                    text: "Do you want to update the doctor data?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, update it!',
                    cancelButtonText: 'No, cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = $('#editDoctorForm').serialize();
                        $.ajax({
                            url: '<?php echo site_url('doctor/update'); ?>',
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                if (response.trim() == 'success') {
                                    Swal.fire('Updated!', 'The doctor data has been updated.', 'success').then(() => {
                                        var row = $('#doctor-' + $('#doctorId').val());
                                        row.find('td:eq(0)').text($('#doctorName').val());
                                        row.find('td:eq(1)').text($('#doctorSpecialisation').val());
                                        row.find('td:eq(2)').text($('#doctorEmail').val());
                                        row.find('td:eq(3)').text($('#doctorMobile').val());
                                        row.find('td:eq(4)').text($('#doctorStartTime').val());
                                        row.find('td:eq(5)').text($('#doctorEndTime').val());
                                        $('#editDoctorModal').modal('hide');
                                    });
                                } else {
                                    Swal.fire('Error!', 'There was a problem updating the doctor data: ' + response, 'error');
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                Swal.fire('Error!', 'An error occurred: ' + textStatus, 'error');
                            }
                        });
                    }
                });
            }
        });
    });

    function confirmDelete(doctorId) {
        Swal.fire({
            title: 'DOCTOR DELETION?',
            text: "You won't be able to get back doctor data",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo site_url('doctor/delete'); ?>',
                    type: 'POST',
                    data: { id: doctorId },
                    success: function(response) {
                        if (response.trim() == 'success') {
                            Swal.fire('Deleted!', 'The doctor has been deleted.', 'success').then(() => {
                                $('#doctor-' + doctorId).remove();
                            });
                        } else {
                            Swal.fire('Error!', 'There was a problem deleting the doctor: ' + response, 'error');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire('Error!', 'An error occurred: ' + textStatus, 'error');
                    }
                });
            }
        });
    }

    function validateForm() {
        let isValid = true;
        let name = document.getElementById("doctorName").value.trim();
        let email = document.getElementById("doctorEmail").value.trim();
        let phone = document.getElementById("doctorMobile").value.trim();
        let specialisation = document.getElementById("doctorSpecialisation").value;
        let startTime = document.getElementById("doctorStartTime").value;
        let endTime = document.getElementById("doctorEndTime").value;

        let nameError = document.getElementById('nameError');
        let emailError = document.getElementById('emailError');
        let phoneError = document.getElementById('phoneError');
        let specialisationError = document.getElementById('specialisationError');
        let starttimeError = document.getElementById('starttimeError');
        let endtimeError = document.getElementById('endtimeError');

        nameError.innerHTML = "";
        emailError.innerHTML = "";
        phoneError.innerHTML = "";
        specialisationError.innerHTML = "";
        starttimeError.innerHTML = "";
        endtimeError.innerHTML = "";

        document.getElementById('doctorName').classList.remove('is-invalid');
        document.getElementById('doctorEmail').classList.remove('is-invalid');
        document.getElementById('doctorMobile').classList.remove('is-invalid');
        document.getElementById('doctorSpecialisation').classList.remove('is-invalid');
        document.getElementById('doctorStartTime').classList.remove('is-invalid');
        document.getElementById('doctorEndTime').classList.remove('is-invalid');

        let namePattern = /^[A-Za-z\s]+$/;
        if (name === "" || !namePattern.test(name)) {
            nameError.innerHTML = "Doctor Name is required";
            document.getElementById("doctorName").classList.add('is-invalid');
            isValid = false;
        }
        if (!email.match(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/)) {
            emailError.innerHTML = "Enter a valid Email.";
            document.getElementById("doctorEmail").classList.add('is-invalid');
            isValid = false;
        }

        let phonePattern = /^[6-9][0-9]{9}$/;
        if (!phonePattern.test(phone)) {
            phoneError.innerHTML = "Enter valid 10 digit phone number."
            document.getElementById("doctorMobile").classList.add('is-invalid');
            isValid = false;
        }
        if (specialisation === "") {
            specialisationError.innerHTML = "Enter valid Specialisation."
            document.getElementById("doctorSpecialisation").classList.add('is-invalid');
            isValid = false;
        }

        if (startTime === "") {
            starttimeError.innerHTML = "Enter start time."
            document.getElementById("doctorStartTime").classList.add('is-invalid');
            isValid = false;
        }

        if (endTime === "" || endTime <= startTime) {
            endtimeError.innerHTML = "Enter end time & after start time.";
            document.getElementById("doctorEndTime").classList.add('is-invalid');
            isValid = false;
        }

        return isValid; 
    }
</script>
</body>
</html>
