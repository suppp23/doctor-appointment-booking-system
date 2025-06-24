<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Specialisation List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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
        .main-navbar .btn-primary {
            background-color: #007bff;
            border-color: #d0d6dc;
            font-weight: bold;
        }
        .main-navbar .navbar-nav .nav-link:hover {
            color: #1977cc;
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
        table th,
        table td {
            border-bottom: 2px solid #007bff;
            text-align: center;
            padding: 12px;
        }
        table th {
            color: red;
            font-weight: bolder;
        }
        table td {
            background-color: #f9f9f9;
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
            <span>doctor@quantana.in</span>
            <span class="ms-3">9876543210</span>
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
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="<?= base_url(); ?>">HOME</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('specialisation/register_specialisation'); ?>">ADD SPECIALISATION</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2>Specialisations</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th colspan="2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($specialisations)): ?>
                <?php foreach ($specialisations as $specialisation): ?>
                    <tr id="specialisation-<?= htmlspecialchars($specialisation->id); ?>">
                        <td><?= htmlspecialchars($specialisation->name); ?></td>
                        <td><?= htmlspecialchars($specialisation->description); ?></td>
                        <td>
                            <button class="btn btn-primary edit-btn" data-id="<?= htmlspecialchars($specialisation->id); ?>">Update</button>
                        </td>
                        <td>
                            <button class="btn btn-danger" onclick="confirmDelete(<?= htmlspecialchars($specialisation->id); ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No specialisations found!</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div id="editSpecialisationModal" class="modal fade" tabindex="-1" aria-labelledby="editSpecialisationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSpecialisationModalLabel">Update Specialisation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSpecialisationForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <input type="hidden" id="specialisationId">
                    <button type="button" class="btn btn-primary" id="updateSpecialisationBtn">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
      
        $('.edit-btn').click(function () {
            var id = $(this).data('id');
            var row = $('#specialisation-' + id);
            var name = row.find('td:eq(0)').text();
            var description = row.find('td:eq(1)').text();

            $('#specialisationId').val(id);
            $('#name').val(name);
            $('#description').val(description);
            $('#editSpecialisationModal').modal('show');
        });

        $('#updateSpecialisationBtn').click(function () {
            var id = $('#specialisationId').val();
            var name = $('#name').val();
            var description = $('#description').val();

            $.ajax({
                url: '<?= base_url("specialisation/update") ?>',
                type: 'POST',
                data: {
                    id: id,
                    name: name,
                    description: description
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire('Success', 'Specialisation updated successfully!', 'success');
                        $('#specialisation-' + id + ' td:eq(0)').text(name);
                        $('#specialisation-' + id + ' td:eq(1)').text(description);
                        $('#editSpecialisationModal').modal('hide');
                    } else {
                        Swal.fire('Error', response.message || 'Failed to update specialisation!', 'error');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown); 
                    Swal.fire('Error', 'An error occurred while updating!', 'error');
                }
            });
        });
    });

 
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You wont be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url("specialisation/delete") ?>',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Deleted!', 'Specialisation has been deleted.', 'success');
                            $('#specialisation-' + id).remove();
                        } else {
                            Swal.fire('Error', response.message || 'Failed to delete specialisation!', 'error');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error(textStatus, errorThrown);
                        Swal.fire('Error', 'An error occurred while deleting!', 'error');
                    }
                });
            }
        });
    }
</script>
</body>
</html>
