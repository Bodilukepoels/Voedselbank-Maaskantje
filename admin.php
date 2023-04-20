    <?php
    //admin cookies
    if (!isset($_COOKIE['admin_logged_in']) || $_COOKIE['admin_logged_in'] !== "true") {
        echo "logged in";
        header("Location: admin_login.php");
        exit();
    }

    require_once 'config.php';
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
            <?php
    include 'navigation.php';
    ?>
        <h1>Admin Dashboard</h1>
        <table>  
        <thead>
            <tr>
                <th>Event Creeeren</th>
                <th>Band Toevoegen</th>
                <th>Band en Event combineren</th>
            </tr>
        </thead>   
        <tbody>   
        <td>  <!-- event form -->
        <form action="add_event.php" method="post">
            <label for="event_name">Event Name:</label>
            <input type="text" name="event_name" id="event_name" required><br><br>
            <label for="event_date">Date:</label>
            <input type="date" name="event_date" id="event_date" required><br><br>
            <label for="start_time">Start Time:</label>
            <input type="time" name="start_time" id="start_time" required><br><br>
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" step="0.01" min="0" required><br><br>
            <input type="submit" value="Create Event">
        </form>
        </td>
        <td>
        <form action="add_band.php" method="post">
            <label for="band_name">Band Name:</label>
            <input type="text" name="band_name" id="band_name" required><br><br>
            <label for="genre">Genre:</label>
            <input type="text" name="genre" id="genre" required><br><br>
            <input type="submit" value="Add Band">
        </form>
        </td>
        <td>
        <form action="associate_band_event.php" method="post">
            <label for="event_id">Event:</label>
            <select name="event_id" id="event_id">
                <?php
                $sql = "SELECT id, name FROM events";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                }
                ?>
            </select><br>
            <label for="band_id">Band:</label>
            <select name="band_id" id="band_id">
                <?php
                //database connection
                $sql = "SELECT id, name FROM bands";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                }
                ?>
            </select><br>
            <input type="submit" value="Associate Band with Event">
        </form>
    </td>
    </tbody>
    </table>
        <a href="logout.php">Logout</a>
    </body>
    </html>
