<?php
require 'dbConnect.php';

$events_name = $events_description = $events_presenter = $events_date = $events_time = "";
$success_message = $error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Honeypot field check
    if (!empty($_POST['honeypot'])) {
        die("Bot detected. Submission blocked.");
    }

    $events_name = trim($_POST['events_name']);
    $events_description = trim($_POST['events_description']);
    $events_presenter = trim($_POST['events_presenter']);
    $events_date = trim($_POST['events_date']);
    $events_time = trim($_POST['events_time']);
    $events_date_inserted = date("Y-m-d");
    $events_date_updated = date("Y-m-d");

    if (!empty($events_name) && !empty($events_presenter) && !empty($events_date) && !empty($events_time)) {
        try {
            $sql = "INSERT INTO wdv341_events (events_name, events_description, events_presenter, events_date, events_time, events_date_inserted, events_date_updated)
                    VALUES (:events_name, :events_description, :events_presenter, :events_date, :events_time, :events_date_inserted, :events_date_updated)";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':events_name', $events_name);
            $stmt->bindParam(':events_description', $events_description);
            $stmt->bindParam(':events_presenter', $events_presenter);
            $stmt->bindParam(':events_date', $events_date);
            $stmt->bindParam(':events_time', $events_time);
            $stmt->bindParam(':events_date_inserted', $events_date_inserted);
            $stmt->bindParam(':events_date_updated', $events_date_updated);

            $stmt->execute();
            $success_message = "Event successfully added!";

            $events_name = $events_description = $events_presenter = $events_date = $events_time = "";
            } catch (PDOException $e) {
                $error_message = "Error: " . $e->getMessage();
            }
        } else {
            $error_message = "Please fill in all fields.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <title>Create Event Form</title>
    <style>
        .honeypot { display: none; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2>Event Submission Form</h2>

    <?php
    if (!empty($success_message)) {
        echo "<p class='success'>$success_message</p>";
    }
    if (!empty($error_message)) {
        echo "<p class='error'>$error_message</p>";
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <div class="honeypot">
            <label for="honeypot">Leave this field empty</label>
            <input type="text" id="honeypot" name="honeypot">
        </div>

        <label for="events_name">Event Name:</label>
        <input type="text" id="events_name" name="events_name" value="<?php echo htmlspecialchars($events_name); ?>" required>

        <label for="events_description">Event Description:</label>
        <textarea id="events_description" name="events_description"><?php echo htmlspecialchars($events_description); ?></textarea>

        <label for="events_presenter">Presenter:</label>
        <input type="text" id="events_presenter" name="events_presenter" value="<?php echo htmlspecialchars($events_presenter); ?>" required>

        <label for="events_date">Event Date:</label>
        <input type="date" id="events_date" name="events_date" value="<?php echo htmlspecialchars($events_date); ?>" required>

        <label for="events_time">Event Time:</label>
        <input type="time" id="events_time" name="events_time" value="<?php echo htmlspecialchars($events_time); ?>" required>

        <button type="submit">Submit Event</button>

    </form>

</body>
</html>
