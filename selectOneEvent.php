<?php 
require 'dbConnect.php';

$eventID = 1;

try {
    $sql = "SELECT * FROM wdv341_events WHERE events_id = :eventID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':eventID', $eventID, PDO::PARAM_INT);
    $stmt->execute();

    $event = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>One Event Details</title>
    <style>
        body {
            margin: 15px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 7px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Event Details</h2>

    <?php if(!$event): ?>
        <p>No event was found for that ID.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Event Name</th>
                <th>Description</th>
                <th>Presenter</th>
                <th>Date</th>
                <th>Time</th>
                <th>Date Inserted</th>
                <th>Date Updated</th>
            </tr>
            <tr>
                <td><?= htmlspecialchars($event['events_id']) ?></td>
                <td><?= htmlspecialchars($event['events_name']) ?></td>
                <td><?= htmlspecialchars($event['events_description']) ?></td>
                <td><?= htmlspecialchars($event['events_presenter']) ?></td>
                <td><?= htmlspecialchars($event['events_date']) ?></td>
                <td><?= htmlspecialchars($event['events_time']) ?></td>
                <td><?= htmlspecialchars($event['events_date_inserted']) ?></td>
                <td><?= htmlspecialchars($event['events_date_updated']) ?></td>
            </tr>
        </table>
    <?php endif; ?>
</body>
</html>