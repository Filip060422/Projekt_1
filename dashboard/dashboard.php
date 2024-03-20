<?php
function displayData() {
    $conn = new mysqli('localhost', 'root', '', 'surveydb');
    $conn->set_charset('utf8');

    $search = '';
    if(isset($_POST['search'])) {
        $search = $_POST['search'];
    }
    
    if(!$search){
    $q = "SELECT 
            users.userID,
            CONCAT(users.name, ' ', users.surname) AS full_name,
            DATE_FORMAT(scores.date, '%d.%m.%Y, %H:%i') AS date,
            scores.score,
            (SELECT COUNT(*) + 1 
             FROM scores AS s
             WHERE s.score > scores.score 
                OR (s.score = scores.score AND s.date < scores.date)) AS zajete_miejsce,
            scores.win,
            CONCAT(address.street, ' ', address.housenumber, 
                   IF(address.apartmentnumber <> '', CONCAT('/', address.apartmentnumber), ''), 
                   ' ', address.zipcode, ' ', address.location) AS full_address,
            surveynps.score AS nps_score,
            surveynps.comment AS nps_comment
        FROM 
            users
        LEFT JOIN 
            scores ON users.userID = scores.userID
        LEFT JOIN 
            address ON users.addressID = address.addressID
        LEFT JOIN 
            surveynps ON scores.surveyID = surveynps.surveyID";

    $result = $conn->query($q);

    if (!$result) {
        die('Query error: ' . $conn->error);
    }

    while ($row = $result->fetch_assoc()) {
        $userID = htmlspecialchars($row['userID']);
        $full_name = htmlspecialchars($row['full_name']);
        $date = htmlspecialchars($row['date']);
        $score = htmlspecialchars($row['score']);
        $zajete_miejsce = htmlspecialchars($row['zajete_miejsce']);
        $win = ($row['win'] == 1) ? '<td class="win"><span><img src="./media/true-icon.svg" alt="true-icon">TAK</span></td>' : '<td class="no-win"><span><img src="./media/false-icon.svg" alt="true-icon">NIE</span></td>';
        $full_address = ($row['full_address'] != NULL) ? htmlspecialchars($row['full_address']) : '<b>-</b>';
        $nps_score = ($row['nps_score'] !== NULL) ? htmlspecialchars($row['nps_score']) : '-';
        $nps_comment = ($row['nps_comment'] !== NULL) ? htmlspecialchars($row['nps_comment']) : '-';

        echo "<tr class='main-table'>" .
        "<td><button class='plus'></button></td>" .
        "<td>".$userID."</td>" .
        "<td>".$full_name."</td>" .
        "<td>".$date."</td>" .
        "<td>".$score."</td>" .
        "<td>".$zajete_miejsce."</td>" .
        $win .
        "<td>". $full_address ."</td>" .
        "</tr>" .
        "<tr class='none'>" .
        "<td colspan='8'>" .
        "<table class='sub-table'>" .
        "<tr>" .
        "<th>Czas rozwiązania konkursu</th>" .
        "<th>Data przesłania danych teleadresowych</th>" .
        "<th>Ocena NPS</th>" .
        "<th>Komentarz</th>" .
        "</tr>" .
        "<tr>" .
        "<td>00:06:12</td>" .
        "<td>".$date."</td>" .
        "<td>".$nps_score."</td>" .
        "<td>".$nps_comment."</td>" .
        "</tr>" .
        "</table>" .
        "</td>" .
        "</tr>";
    }
    } else {
        $q = "SELECT 
        users.userID,
        CONCAT(users.name, ' ', users.surname) AS full_name,
        DATE_FORMAT(scores.date, '%d.%m.%Y, %H:%i') AS date,
        scores.score,
        (SELECT COUNT(*) + 1 
         FROM scores AS s
         WHERE s.score > scores.score 
            OR (s.score = scores.score AND s.date < scores.date)) AS zajete_miejsce,
        scores.win,
        CONCAT(address.street, ' ', address.housenumber, 
               IF(address.apartmentnumber <> '', CONCAT('/', address.apartmentnumber), ''), 
               ' ', address.zipcode, ' ', address.location) AS full_address,
        surveynps.score AS nps_score,
        surveynps.comment AS nps_comment
    FROM 
        users
    LEFT JOIN 
        scores ON users.userID = scores.userID
    LEFT JOIN 
        address ON users.addressID = address.addressID
    LEFT JOIN 
        surveynps ON scores.surveyID = surveynps.surveyID 
    WHERE 
        users.name LIKE '$search%' OR users.surname LIKE '$search%' OR concat(users.name, ' ', users.surname) LIKE '$search%';";

    $result = $conn->query($q);

    if (!$result) {
        die('Query error: ' . $conn->error);
    }

    while ($row = $result->fetch_assoc()) {
        $userID = htmlspecialchars($row['userID']);
        $full_name = htmlspecialchars($row['full_name']);
        $date = htmlspecialchars($row['date']);
        $score = htmlspecialchars($row['score']);
        $zajete_miejsce = htmlspecialchars($row['zajete_miejsce']);
        $win = ($row['win'] == 1) ? '<td class="win"><span><img src="./media/true-icon.svg" alt="true-icon">TAK</span></td>' : '<td class="no-win"><span><img src="./media/false-icon.svg" alt="true-icon">NIE</span></td>';
        $full_address = ($row['full_address'] != NULL) ? htmlspecialchars($row['full_address']) : '<b>-</b>';
        $nps_score = ($row['nps_score'] !== NULL) ? htmlspecialchars($row['nps_score']) : '-';
        $nps_comment = ($row['nps_comment'] !== NULL) ? htmlspecialchars($row['nps_comment']) : '-';

        echo "<tr class='main-table'>" .
        "<td><button class='plus'></button></td>" .
        "<td>".$userID."</td>" .
        "<td>".$full_name."</td>" .
        "<td>".$date."</td>" .
        "<td>".$score."</td>" .
        "<td>".$zajete_miejsce."</td>" .
        $win .
        "<td>". $full_address ."</td>" .
        "</tr>" .
        "<tr class='none'>" .
        "<td colspan='8'>" .
        "<table class='sub-table'>" .
        "<tr>" .
        "<th>Czas rozwiązania konkursu</th>" .
        "<th>Data przesłania danych teleadresowych</th>" .
        "<th>Ocena NPS</th>" .
        "<th>Komentarz</th>" .
        "</tr>" .
        "<tr>" .
        "<td>00:06:12</td>" .
        "<td>".$date."</td>" .
        "<td>".$nps_score."</td>" .
        "<td>".$nps_comment."</td>" .
        "</tr>" .
        "</table>" .
        "</td>" .
        "</tr>";
    }}

    $result->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="container">
        <header class="padding">
            <img src="./media/logo.svg" alt="Logo">
            <div class="button">
                <div class="text">
                    <h3>Karolina Nowak</h3>
                    <p>Panel raportowy</p>
                </div>
                <button class="log-out"></button>
            </div>
        </header>
        <section class="top-area padding">
            <h1>Wiosna Nadchodzi - Konkurs Mediaflex</h1>
            <div class="boxes">
                <div class="box">
                    <h3>Data rozpoczęcia konkursu</h3>
                    <p>06.10.2022, 10:00</p>
                </div>
                <div class="box">
                    <h3>Data zakończenia konkursu</h3>
                    <p>30.10.2022, 10:00</p>
                </div>
                <div class="box">
                    <h3>Limit udziałów</h3>
                    <p>1</p>
                </div>
                <div class="box">
                    <h3>Maksymalna ilość punktów do uzyskania</h3>
                    <p>3</p>
                </div>
                <div class="box">
                    <h3>Liczba zwycięzców</h3>
                    <p>20</p>
                </div>
            </div>
        </section>
        <section class="main-area">
            <div class="buttons">
                <button>Lista uczestników</button>
                <button>Lista zwycięzców</button>
            </div>
            <div class="input">
                <p>Wyszukaj użytkownika</p>
                <form action="dashboard.php" method="post">
                    <div class="input-button">
                        <input type="text" name="search">
                        <button type="submit"></button>
                    </div>
                </form>
            </div>
            <table>
                <tr class="main-table">
                    <th></th>
                    <th>LP</th>
                    <th>Imię i nazwisko</th>
                    <th>Data wzięcia<br>udziału w konkursie</th>
                    <th>Ilość uzyskanych<br>punktów</th>
                    <th>Zajęte<br>miejsce</th>
                    <th>Wygrana</th>
                    <th>Sposób dostarczenia<br>nagrody</th>
                </tr>
                <?php echo displayData(); ?>
            </table>
            <div class="bottom-main-area">
                <div class="left">
                    <p>Pozycje od <span>1</span> do <span>10</span> z <span>270</span> łącznie</p>
                        <label for="positions">Pokaż</label>
                        <select name="positions">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <label for="positions">pozycji</label>
                </div>
                <div class="right">
                    <button>Poprzednia</button>
                    <button class="page">1</button>
                    <button>2</button>
                    <button>3</button>
                    <button>4</button>
                    <button>5</button>
                    <button>Następna</button>
                </div>
            </div>    
        </section>
    </div>
    <script src="./script.js"></script>
</body>
</html>