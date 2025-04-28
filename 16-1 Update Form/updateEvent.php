<?php
require 'dbConnect.php';
$message = "";
$event = [
    'events_name' => '',
    'events_description' => '',
    'events_presenter' => '',
    'events_date' => '',
    'events_time' => ''
];
if(isset($_GET['recid']) && is_numeric($_GET['recid'])) {
    $recid = (int)$_GET['recid'];

    try{
        $sql = "SELECT events_name, events_description, events_presenter, events_date, events_time
                FROM wdv341_events
                WHERE events_id = :recid";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':recid', $recid, PDO::PARAM_INT);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            $event = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $message = "Event not found.";
        }
    } catch (PDOException $e) {
        $message = "Error fetching event: " . $e->getMessage();
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!empty($_POST['honeypot'])) {
        die("Spam detected.");
    }

    $recid = (int)$_POST['recid'];
    $events_name = trim($_POST['events_name']);
    $events_description = trim($_POST['events_description']);
    $events_presenter = trim($_POST['events_presenter']);
    $events_date = trim($_POST['events_date']);
    $events_time = trim($_POST['events_time']);

    try {
        $sql = "UPDATE wdv341_events 
                SET events_name = :events_name,
                    events_description = :events_description,
                    events_presenter = :events_presenter,
                    events_date = :events_date,
                    events_time = :events_time
                WHERE events_id = :recid";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':events_name', $events_name);
    $stmt->bindParam(':events_description', $events_description);
    $stmt->bindParam(':events_presenter', $events_presenter);
    $stmt->bindParam(':events_date', $events_date);
    $stmt->bindParam(':events_time', $events_time);
    $stmt->bindParam(':recid', $recid, PDO::PARAM_INT);
    $stmt->execute();

    $message = "Event updated successfully!";
    } catch (PDOException $e) {
    $message = "Error updating event: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Event</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Update Event</h1>
    <?php if ($message): ?>
        <p style="color:green;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <?php if (empty($message) || $_SERVER['REQUEST_METHOD'] == 'POST'): ?>
    <form method="post" action="updateEvent.php">
        <label for="events_name">Name:</label><br>
        <input type="text" name="events_name" id="events_name" value="<?php echo htmlspecialchars($event['events_name']); ?>" required><br><br>

        <label for="events_description">Description:</label><br>
        <textarea name="events_description" id="events_description" required><?php echo htmlspecialchars($event['events_description']); ?></textarea><br><br>

        <label for="events_presenter">Presenter:</label><br>
        <input type="text" name="events_presenter" id="events_presenter" value="<?php echo htmlspecialchars($event['events_presenter']); ?>" required><br><br>

        <label for="events_date">Date:</label><br>
        <input type="date" name="events_date" id="events_date" value="<?php echo htmlspecialchars($event['events_date']); ?>" required><br><br>

        <label for="events_time">Time:</label><br>
        <input type="time" name="events_time" id="events_time" value="<?php echo htmlspecialchars($event['events_time']); ?>" required><br><br>

        <!-- HoneyPot Field -->
        <div style="display:none;">
            <label>Leave this field empty</label>
            <input type="text" name="honeypot" value="">
        </div>

        <!-- Hidden field to carry over recid -->
        <input type="hidden" name="recid" value="<?php echo htmlspecialchars($recid); ?>">

        <input type="submit" value="Update Event">
    </form>
    <?php endif; ?>
</body>
</html>