<?php
// Start output buffering - this prevents the output from being sent to the browser
ob_start();

$connect = mysqli_connect(
    'db', # service name
    'php_docker', # username
    'password', # password
    'php_docker' # db table
);

$table_name = "php_docker_table";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($connect, $_POST['title']);
    $body = mysqli_real_escape_string($connect, $_POST['body']);

    $query = "INSERT INTO $table_name (title, body) VALUES ('$title', '$body')";
    if (mysqli_query($connect, $query)) {
        // Redirect to the same page to avoid resubmission on refresh
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connect);
    }
}
// Display form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Posting Web App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <form method="POST" action="">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <label for="body">Body:</label>
        <textarea id="body" name="body" required></textarea>
        <input type="submit" value="Submit">
    </form>
    <hr>
    <?php
    // Fetch and display posts
    $query = "SELECT * FROM $table_name ORDER BY date_created DESC";
    $response = mysqli_query($connect, $query);

    while($i = mysqli_fetch_assoc($response)) {
        echo '<div class="post">';
        echo '<h2>'.$i['title'].'</h2>';
        echo '<p>'.$i['body'].'</p>';
        echo '<time>'.$i['date_created'].'</time>';
        echo '</div>';
    }
    ?>
</div>

</body>
</html>
<?php

// Flush the output buffer - this sends the output to the browser
ob_end_flush();
?>