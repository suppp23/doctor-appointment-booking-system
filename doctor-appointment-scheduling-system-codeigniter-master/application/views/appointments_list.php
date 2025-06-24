<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jsPDF Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <!-- jsPDF AutoTable Plugin -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.17/jspdf.plugin.autotable.min.js"></script>

     <script src="https://cdn.jsdelivr.net/npm/exceljs@4.0.1/dist/exceljs.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1/dist/chart.min.js"></script> <!-- Chart.js v4 -->

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
            margin-top: 20px;
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
        #searchInput {
            width: 15%;
            padding: 5px 40px 5px 15px;
            margin-left:auto;
            margin-bottom: 12px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 6px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .slot_container {
            margin-top: 5px;    
        }
        #slot_container button {
            width: 150px;
            margin: 5px;
            text-align: center;
            background-color: #04aa6d;
        }
        .slot_button {
            color: white; 
        }
        .slot_button.selected {
            background-color: red !important; 
            color: white; 
        }

        #appointmentsChart {
            width: 100%;
            height: 400px; 
            max-width: 600px;
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
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('appointment/index'); ?>"> ADD APPOINTMENTS</a></li>  
                </ul>
            </div>
        </div>
    </nav>

 <div class="container">
    <h2 class="text-center">Appointments</h2>
    <div class="d-flex justify-content-center mb-4">
        <canvas id="appointmentsChart" width="400" height="400"></canvas>
    </div>
    <div class="d-flex justify-content-between mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Search..." onkeyup="filterTable()">
        <button class="btn btn-primary" onclick="reloadAppointments()">Reload</button>
        <button class="btn btn-success" id="download-pdf">Download PDF</button>
        <button class="btn btn-info" id="download-xlsx">Download Excel</button>
    </div>
    <table class="table table-bordered" id="appointmentsTable">
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Doctor Name</th>
                <th>Slot Date</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td><?= $appointment['patient_name']; ?></td>
                    <td><?= $appointment['doctor_name']; ?></td>
                    <td><?= $appointment['slot_date']; ?></td>
                    <td><?= $appointment['slot_start_time']; ?></td>
                    <td><?= $appointment['slot_end_time']; ?></td> 
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    function filterTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toLowerCase();
        const table = document.getElementById("appointmentsTable");
        const tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            const td = tr[i].getElementsByTagName("td");
            let found = false;
            for (let j = 0; j < td.length - 1; j++) {
                if (td[j]) {
                    const txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
            }
            tr[i].style.display = found ? "" : "none";
        }
    }
    function reloadAppointments() {
        location.reload();
    }
    var appointmentCounts = <?php echo json_encode($appointment_counts); ?>;
var ctx = document.getElementById('appointmentsChart').getContext('2d');

// Log the raw data to check its structure
console.log("Appointment Counts Data:", appointmentCounts);

// Proceed only if appointmentCounts is an array
if (Array.isArray(appointmentCounts) && appointmentCounts.length > 0) {

    // Map doctor names and appointment counts
    var labels = appointmentCounts.map(function(item) {
        // Check if doctor_name exists, if not use fallback
        var doctorName = item.doctor_name || 'Doctor ' + item.doctor_id;
        console.log("Doctor Name:", doctorName);
        return doctorName;  // Use either the doctor name or fallback
    });

    var data = appointmentCounts.map(function(item) {
        var count = item.appointment_count || 0; 
        console.log("Appointment Count:", count);
        return count; 
    });

    console.log("Labels:", labels); 
    console.log("Data:", data);     

    // Ensure the canvas context is available
    if (!ctx) {
        console.error("Canvas context not found. Check if canvas exists with the id 'appointmentsChart'.");
    } else {
        console.log("Canvas found and ready to render chart.");
    }

    if (ctx) {
        var appointmentsChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Appointments Count',
                    data: data,
                    backgroundColor: ['orange', 'green', 'blue', 'yellow', 'violet', 'purple', 'brown'],
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' appointments';
                            }
                        }
                    }
                }
            }
        });
    } else {
        console.error("Canvas context is still unavailable.");
    }

} else {
    console.error("Appointment data is not an array or is empty.");
}


    document.getElementById('download-pdf').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;  
        const doc = new jsPDF();
        doc.setFontSize(18);
        doc.text('Appointments List', 20, 20);
        const headers = ['Patient Name', 'Doctor Name', 'Slot Date', 'Start Time', 'End Time'];
        const rows = <?php echo json_encode($appointments); ?>.map(function(appointment) {
            return [
                appointment.patient_name,
                appointment.doctor_name,
                appointment.slot_date,
                appointment.slot_start_time,
                appointment.slot_end_time
            ];
        });
        doc.autoTable({
            head: [headers],
            body: rows
        });
        doc.save('appointments.pdf');
    });

    document.getElementById('download-xlsx').addEventListener('click', function () {
            const appointments = <?php echo json_encode($appointments); ?>;
            const workbook = new ExcelJS.Workbook();
            const worksheet = workbook.addWorksheet('Appointments');
            worksheet.columns = [
                { header: 'Patient Name', key: 'patient_name', width: 30 },
                { header: 'Doctor Name', key: 'doctor_name', width: 30 },
                { header: 'Slot Date', key: 'slot_date', width: 20 },
                { header: 'Start Time', key: 'slot_start_time', width: 20 },
                { header: 'End Time', key: 'slot_end_time', width: 20 }
            ];
            appointments.forEach(function(appointment) {
                worksheet.addRow({
                    patient_name: appointment.patient_name,
                    doctor_name: appointment.doctor_name,
                    slot_date: appointment.slot_date,
                    slot_start_time: appointment.slot_start_time,
                    slot_end_time: appointment.slot_end_time
                });
            });
            workbook.xlsx.writeBuffer().then(function(buffer) {
                const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = 'appointments.xlsx';
                link.click();
            });
        });
    
</script>
</body>
</html>
           
