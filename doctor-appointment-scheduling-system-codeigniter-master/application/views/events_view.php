<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        body {
            font-family: 'Source Sans Pro', sans-serif;
            background-image: url('assets/img/about.jpg');
            background-size: cover;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        .container {
          
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
            background-color: #007bff;
            color: red;
            font-weight: bold;
        }
        table td {
            background-color: #f9f9f9;
        }
        #searchInput {
            width: 15%;
            padding: 5px 40px 5px 15px;
            margin-bottom: 12px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 6px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                <li class="nav-item"><a class="nav-link" href="<?= base_url('events/index'); ?>">ADD EVENTS</a></li>     
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h2>Events</h2>
        <label for="searchInput" style="font-weight: bolder;color:red;">Search Doctor:</label>
        <input type="text" id="searchInput" placeholder="Search" onkeyup="filterTable()">
        
        <?php if ($this->session->flashdata('message')): ?>
            <div class="alert alert-info">
                <?= $this->session->flashdata('message'); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($appointments)) { ?>
            <table class="table table-bordered table-striped table-responsive" id="eventsTable">
                <thead>
                    <tr>
                        <th>Doctor Name</th>
                        <th>Slot Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $row) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['doctor_name']); ?></td>
                            <td><?= htmlspecialchars($row['slot_date']); ?></td>
                            <td><?= htmlspecialchars($row['event_start_time']); ?></td>
                            <td><?= htmlspecialchars($row['event_end_time']); ?></td>
                            <td>
                                <button class="btn btn-danger" onclick="confirmDelete(<?= $row['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No events scheduled yet.</p>
        <?php } ?>
    </div>

    <script>
        function filterTable() {
            const input = document.getElementById("searchInput").value.toUpperCase();
            const table = document.getElementById("eventsTable");
            const rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {
                const doctorNameCell = rows[i].getElementsByTagName("td")[0]; 
                if (doctorNameCell) {
                    const doctorName = doctorNameCell.textContent || doctorNameCell.innerText;
                    rows[i].style.display = doctorName.toUpperCase().indexOf(input) > -1 ? "" : "none";
                }
            }
        }

        function confirmDelete(eventId) {
            Swal.fire({
                title: 'Event Deletion?',
                text: "Do you want to delete this event?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= site_url('events/delete_event/'); ?>' + eventId;
                }
            });
        }
    </script>

</body>
</html>
