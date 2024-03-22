<?php
function displayData() {
    $conn = new mysqli('localhost', 'root', '', 'surveydb');
    $conn->set_charset('utf8');

    $search = '';
    if(isset($_POST['search'])) {
        $search = $_POST['search'];
    }

    if(!$search){
        if(isset($_POST['positions'])) {
            $positions = $_POST['positions'];
        } else {
            $positions = 5;
        }
        if($positions == 5) {
            $betweenOne = 1;
            $betweenTwo = 5;
            if (isset($_POST['page'])) {
                if($_POST['page'] == 1) {
                   $betweenOne = 1;
                   $betweenTwo = 5;
                } else if($_POST['page'] == 2) {
                    $betweenOne = 6;
                    $betweenTwo = 10;
                } else if($_POST['page'] == 3) {
                    $betweenOne = 11;
                    $betweenTwo = 15;
                } else if($_POST['page'] == 4) {
                    $betweenOne = 16;
                    $betweenTwo = 20;
                } else if($_POST['page'] == 5) {
                    $betweenOne = 21;
                    $betweenTwo = 25;
                }
            } else {
                    $betweenOne = 1;
                    $betweenTwo = 5;
            }
        } else if ($_POST['positions'] == 10) {
            $betweenOne = 1;
            $betweenTwo = 10;
            if (isset($_POST['page'])) {
                if($_POST['page'] == 1) {
                    $betweenOne = 1;
                    $betweenTwo = 10;
                } else if($_POST['page'] == 2) {
                    $betweenOne = 11;
                    $betweenTwo = 20;
                } else if($_POST['page'] == 3) {
                    $betweenOne = 21;
                    $betweenTwo = 30;
                } else if($_POST['page'] == 4) {
                    $betweenOne = 31;
                    $betweenTwo = 40;
                } else if($_POST['page'] == 5) {
                    $betweenOne = 41;
                    $betweenTwo = 50;
                }
            } else {
                $betweenOne = 1;
                $betweenTwo = 10;
            }
        } else if ($positions == 15) {
            $betweenOne = 1;
            $betweenTwo = 15;
            if (isset($_POST['page'])) {
                if($_POST['page'] == 1) {
                    $betweenOne = 1;
                    $betweenTwo = 15;
                } else if($_POST['page'] == 2) {
                    $betweenOne = 16;
                    $betweenTwo = 30;
                } else if($_POST['page'] == 3) {
                    $betweenOne = 31;
                    $betweenTwo = 45;
                } else if($_POST['page'] == 4) {
                    $betweenOne = 46;
                    $betweenTwo = 60;
                } else if($_POST['page'] == 5) {
                    $betweenOne = 61;
                    $betweenTwo = 75;
                }
            } else {
                $betweenOne = 1;
                $betweenTwo = 15;
            }
        }
        

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
            surveynps ON scores.surveyID = surveynps.surveyID WHERE users.userid BETWEEN $betweenOne AND $betweenTwo LIMIT $positions;";

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
        if(isset($_POST['positions'])) {
            $positions = $_POST['positions'];
        } else {
            $positions = 5;
        }
        
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
        users.name LIKE '$search%' OR users.surname LIKE '$search%' OR concat(users.name, ' ', users.surname) LIKE '$search%' LIMIT $positions";

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

function items() {
    $conn = new mysqli('localhost', 'root', '', 'surveydb');

    $q = "SELECT COUNT(scores.scoreID) AS total FROM scores;";
    $result = $conn->query($q);
    $row = $result->fetch_assoc();
    $total_pages = $row['total'];

    $items = 0;
    if(isset($_POST['positions'])) {
        if ($_POST['positions'] > $total_pages) {
            $items = $total_pages;  
        } else {
            if($_POST['positions'] == 5) {
                $items = 5;
            } else if($_POST['positions'] == 10) {
                $items = 10;
            } else if($_POST['positions'] == 15) {
                $items = 15;
            }
        }
    } else {
        $items = 5;
    }
    
    if(isset($_POST['page'])) {
        $page = intval($_POST['page']);
        $itemsPerPage = intval($_POST['positions']);

        $items = $itemsPerPage * $page;
        if ($items > $total_pages) {
            $items = $total_pages;
        }
    }


    return $items;
}

function itemsTwo() {
    $itemsTwo = 1;
    if(isset($_POST['positions'])) {
        if($_POST['positions'] == 5) {
            $itemsTwo = items() - 4;
        } else if($_POST['positions'] == 10) {
            $itemsTwo = items() - 9;
        } else if($_POST['positions'] == 15) {
            $itemsTwo = items() - 14;
        }
    }
    return $itemsTwo;
}

function pages() {
    $conn = new mysqli('localhost', 'root', '', 'surveydb');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $q = "SELECT COUNT(scores.scoreID) AS total FROM scores";
    $stmt = $conn->prepare($q);

    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $total_pages = intval($row['total']);

    $stmt->close();
    $conn->close();

    return $total_pages;
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
        <section class="main-area users">
                <div class="buttons">
                    <form action="dashboardWinners.php" method="post">
                        <button type="button" class="button-users button-margin">Lista uczestników</button>
                        <button type="submit" class="button-winners">Lista zwycięzców</button>
                    </form>
                </div>
            <form action="dashboardUsers.php" method="post" id="myForm">
                <div class="users-container">
                    <div class="input">
                        <p>Wyszukaj użytkownika</p>
                            <div class="input-button">
                                <input type="text" name="search">
                                <button type="submit"></button>
                            </div>
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
                            <p>Pozycje od <span><?php echo itemsTwo(); ?></span> do <span><?php echo items(); ?></span> z <span><?php echo pages(); ?></span> łącznie</p>
                            <label for="positions">Pokaż</label>
                                <select id="positions2" name="positions" onchange="submitForm()">
                                <option value="5" <?php if(isset($_POST['positions']) && $_POST['positions'] == "5") echo "selected"; ?>>5</option>
                                <option value="10" <?php if(isset($_POST['positions']) && $_POST['positions'] == "10") echo "selected"; ?>>10</option>
                                <option value="15" <?php if(isset($_POST['positions']) && $_POST['positions'] == "15") echo "selected"; ?>>15</option>
                                </select>
                            <label for="positions">pozycji</label>
                        </div>
                        <div class="right">
                            <button type="submit" name="previous">Poprzednia</button>
                            <button class="page" type="submit" name="page" value="1">1</button>
                            <button type="submit" name="page" value="2">2</button>
                            <button type="submit" name="page" value="3">3</button>
                            <button type="submit" name="page" value="4">4</button>
                            <button type="submit" name="page" value="5">5</button>
                            <button type="submit" name="next">Następna</button>
                        </div>
                    </div>
                </div>
            </form>    
        </section>

    </div>
    <script src="./script.js"></script>
</body>
</html>