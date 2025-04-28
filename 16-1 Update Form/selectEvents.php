<?php
require 'dbConnect.php';

try {
    $sql = "SELECT events_id, events_name, events_description, events_presenter, events_date, events_time 
            FROM wdv341_events";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching events: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <title>All Current Events</title>
</head>
<body>
    <h1>All Events</h1>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Description</th>
                <th>Presenter</th>
                <th>Date</th>
                <th>Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($events)) : ?>
                <?php foreach ($events as $event) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($event['events_name']); ?></td>
                        <td><?php echo htmlspecialchars($event['events_description']); ?></td>
                        <td><?php echo htmlspecialchars($event['events_presenter']); ?></td>
                        <td><?php echo htmlspecialchars($event['events_date']); ?></td>
                        <td><?php echo htmlspecialchars($event['events_time']); ?></td>
                        <td>
                            <a href="updateEvent.php?recid=<?php echo $event['events_id']; ?>">Update</a>
                            </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr><td colspan="6">No events found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>