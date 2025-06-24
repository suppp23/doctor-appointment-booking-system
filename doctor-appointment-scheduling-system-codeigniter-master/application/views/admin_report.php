<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointment Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Appointment Report</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Role</th>
                <th>Appointment Count</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stats as $row): ?>
                <tr>
                    <td><?php echo $row['role']; ?></td>
                    <td><?php echo $row['count']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html> 