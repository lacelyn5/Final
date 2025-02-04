<?php
include 'include/header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

require_once 'classes/User.php'; 
require_once 'classes/Event.php'; 
require_once 'classes/Session.php'; 

$session = new Session();  
$user = new User(); 
$event = new Event();  


if (!$session->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$editMode = false;
$editEvent = null;
$requestMethod = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_SPECIAL_CHARS); 
if ($requestMethod == 'POST') {
    $postData = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS); 

    if (isset($postData['create'])) {
        $name = $postData['name'] ?? '';
        $description = $postData['description'] ?? '';
        $event_date = $postData['event_date'] ?? '';
        $location = $postData['location'] ?? '';
        $user_id = $session->get('user_id');
        $event->create($user_id, $name, $description, $event_date, $location);
    } elseif (isset($postData['edit'])) {
        $id = $postData['id'] ?? 0;
        $name = $postData['name'] ?? '';
        $description = $postData['description'] ?? '';
        $event_date = $postData['event_date'] ?? '';
        $location = $postData['location'] ?? '';
        $event->update($id, $name, $description, $event_date, $location);
    } elseif (isset($postData['delete'])) {
        $id = $postData['id'] ?? 0;
        $event->delete($id);
    } elseif (isset($postData['edit_mode'])) {
        $editMode = true;
        $id = $postData['id'] ?? 0;
        $editEvent = $event->getEventById($id);
    }
}
$user_id = $session->get('user_id');
$events = $event->getEventsByUser($user_id);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Include Custom CSS (you need to make sure this file exists) -->
    <link rel="stylesheet" href="css/styles.css"> <!-- Adjust this path if needed -->
</head>
<body>
<div class="container mt-5">
    <h2>Manage Events</h2>

    <form method="post" action="events.php">
        <input type="hidden" name="id" value="<?php echo $editEvent['id'] ?? ''; ?>">
        <div class="form-group mb-3">
            <label for="name">Event Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($editEvent['name'] ?? ''); ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($editEvent['description'] ?? ''); ?></textarea>
        </div>
        <div class="form-group mb-3">
            <label for="event_date">Date and Time:</label>
            <input type="datetime-local" class="form-control" id="event_date" name="event_date" value="<?php echo htmlspecialchars($editEvent['event_date'] ?? ''); ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="location">Location:</label>
            <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($editEvent['location'] ?? ''); ?>" required>
        </div>
        <button type="submit" name="<?php echo $editMode ? 'edit' : 'create'; ?>" class="btn btn-primary">
            <?php echo $editMode ? 'Update Event' : 'Create Event'; ?>
        </button>
    </form>

    <h3 class="mt-5">Your Events</h3>
    <ul class="list-group">
        <?php foreach ($events as $event) : ?>
            <li class="list-group-item">
                <strong><?php echo htmlspecialchars($event['name']); ?></strong><br>
                <?php echo htmlspecialchars($event['description']); ?><br>
                <?php echo htmlspecialchars($event['event_date']); ?><br>
                <?php echo htmlspecialchars($event['location']); ?>
                <form method="post" action="events.php" style="display: inline;">
                    <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
                    <button type="submit" name="edit_mode" class="btn btn-secondary btn-sm">Edit</button>
                    <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
