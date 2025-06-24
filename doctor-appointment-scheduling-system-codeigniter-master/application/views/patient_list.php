<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients List </title>
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
        }
        .main-navbar .navbar-nav .nav-link:hover {
        color:#1977cc ; 
        text-decoration: underline; 
        }
        .main-navbar .btn-primary {
            background-color: #007bff;
            border-color: #d0d6dc;
            font-weight: bold;
        }
        .main-navbar .navbar-nav .nav-link:hover {
        color:#1977cc ; 
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
            margin-top: 30px;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2{
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
        .navbar {
            margin-bottom: 0;
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
                <li class="nav-item"><a class="nav-link" href="<?= base_url('patient/registration'); ?>">ADD PATIENTS</a></li>  
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <?php if (count($patients) > 0): ?>
            <div class="table-container">
                <h2>Patient List</h2>
                <table class="table table-bordered table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Age</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($patients as $patient): ?>
                            <tr id="patient-<?= $patient['id']; ?>">
                                <td><?= htmlspecialchars($patient['name']); ?></td>
                                <td><?= htmlspecialchars($patient['email']); ?></td>
                                <td><?= htmlspecialchars($patient['mobile']); ?></td>
                                <td><?= htmlspecialchars($patient['age']); ?></td>
                                <td>
                                    <button class="btn btn-primary edit-btn" data-id="<?= $patient['id']; ?>">Edit</button>
                                    <button class="btn btn-danger" onclick="confirmDelete(<?= $patient['id']; ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="alert alert-warning text-center">No patients found!</p>
        <?php endif; ?>
    </div>

    <div id="editPatientModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editPatientModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPatientModalLabel">Edit Patient</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editPatientForm">
                        <div class="form-group">
                            <label for="patientName">Name</label>
                            <input type="text" class="form-control" id="patientName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="patientEmail">Email</label>
                            <input type="email" class="form-control" id="patientEmail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="patientMobile">Mobile</label>
                            <input type="text" class="form-control" id="patientMobile" name="mobile" required>
                        </div>
                        <div class="form-group">
                            <label for="patientAge">Age</label>
                            <input type="number" class="form-control" id="patientAge" name="age" required>
                        </div>
                        <input type="hidden" id="patientId" name="id">
                        <button type="button" class="btn btn-primary" id="updatePatientBtn">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.edit-btn').click(function() {
                var patientId = $(this).data('id');
                $.ajax({
                    url: '<?= base_url('patient/get_patient'); ?>',
                    type: 'GET',
                    data: { id: patientId },
                    success: function(response) {
                        // Fill the modal fields with patient data
                        $('#patientId').val(response.id);
                        $('#patientName').val(response.name);
                        $('#patientEmail').val(response.email);
                        $('#patientMobile').val(response.mobile);
                        $('#patientAge').val(response.age);
                        $('#editPatientModal').modal('show');
                    }
                });
            });

            $('#updatePatientBtn').click(function() {
                var formData = $('#editPatientForm').serialize();
                $.ajax({
                    url: '<?= base_url('patient/update_patient'); ?>',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.trim() === 'success') {
                            Swal.fire('Updated!', 'The patient data has been updated.', 'success');
                            location.reload();
                        } else {
                            Swal.fire('Error!', 'There was a problem updating the patient.', 'error');
                        }
                    }
                });
            });
        });

        function confirmDelete(patientId) {
            Swal.fire({
                title: 'Delete Patient',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('patient/delete_patient'); ?>',
                        type: 'POST',
                        data: { id: patientId },
                        success: function(response) {
                            if (response.trim() === 'success') {
                                $('#patient-' + patientId).remove();
                                Swal.fire('Deleted!', 'The patient has been deleted.', 'success');
                            } else {
                                Swal.fire('Error!', 'There was a problem deleting the patient.', 'error');
                            }
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>
