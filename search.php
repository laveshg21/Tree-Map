<?php
// Include external stylesheets
echo "<link href='style.css' rel='stylesheet' type='text/css' />";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css' rel='stylesheet' 
        integrity='sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65' 
        crossorigin='anonymous'>";

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$db = "tree map";

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search query from the URL
$query = $_GET['query'];
$min_length = 3;

if (strlen($query) >= $min_length) {
    $query = htmlspecialchars($query);

    // Prepare and execute the SQL query
    $sql = "
        SELECT * 
        FROM team_3_tree_map___sheet1__1_ 
        WHERE (`COL 1` LIKE '%$query%') 
        OR (`COL 2` LIKE '%$query%') 
        OR (`COL 3` LIKE '%$query%') 
        OR (`COL 4` LIKE '%$query%') 
        OR (`COL 5` LIKE '%$query%') 
        OR (`COL 6` LIKE '%$query%') 
        OR (`COL 7` LIKE '%$query%') 
        OR (`COL 8` LIKE '%$query%')
    ";

    $raw_results = mysqli_query($conn, $sql);

    if (mysqli_num_rows($raw_results) > 0) {
        echo "<h1>Search results:<br></h1>";

        while ($results = mysqli_fetch_array($raw_results)) {
            echo "
                <div class='card mb-3' style='max-width: 80vw;'>
                    <div class='row g-0'>
                        <div class='col-md-4'>
                            <img class='imgCate' src='" . $results['COL 7'] . "'>
                        </div>
                        <div class='col-md-8'>
                            <div class='card-body'>
                                <h5 class='card-title'>" . $results['COL 1'] . "</h5>
                                <p class='card-text'>
                                    <b>Location:</b> " . $results['COL 3'] . "<br>
                                    <b>Scientific Name:</b> " . $results['COL 5'] . "<br>
                                    <b>Uses:</b> " . $results['COL 8'] . "
                                </p>
                                <p class='card-text'>
                                    <small class='text-muted'>
                                        <button type='button' class='btn btn-outline-success'>
                                            <a href='" . $results['COL 4'] . "'>Find me</a>
                                        </button>
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            ";
        }
    } else {
        echo "No results found.";
    }
} else {
    echo "Minimum length for search query is $min_length characters.";
}

?>
