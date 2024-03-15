<?php
$conn = new mysqli('localhost', 'root', '', 'surveydb');
$conn->set_charset('utf8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $score = $_POST['score'];

    $conn->query("INSERT INTO scores VALUES ('', '$score', 1)");

    $conn->close();

    // Redirect the user back to the form
    header('Location: quest_survey.html');
    exit;
}
?>