<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Appointments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>All Appointments</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Patient ID</th>
                <th>Doctor ID</th>
                <th>Date</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appt): ?>
                <tr>
                    <td><?php echo $appt['id']; ?></td>
                    <td><?php echo $appt['patient_id']; ?></td>
                    <td><?php echo $appt['doctor_id']; ?></td>
                    <td><?php echo $appt['date']; ?></td>
                    <td><?php echo $appt['time']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html> 