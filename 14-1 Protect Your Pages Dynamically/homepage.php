<?php
session_start();
require "dbConnect.php";
try {
    $sql = "SELECT * FROM wdv341_events";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

if(!isset($_SESSION['validUser']) || $_SESSION['validUser'] !== "yes"){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page - Event Admin System</title>
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
    <h1>Welcome to the Event Admin Homepage</h1>
    <p>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

    <h2>Events Database</h2>

    <?php if(empty($events)): ?>
        <p>No events were found.</p>
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
            <?php foreach ($events as $event): ?>
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
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <p><a href="logout.php">Logout</a></p>
</body>
</html>