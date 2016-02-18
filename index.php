<html>
<head>
<Title>Registratieformulier</Title>
<style type="text/css">
    body { background-color: #fff; border-top: solid 10px #000;
        color: #333; font-size: .85em; margin: 20; padding: 20;
        font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
    }
    h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
    h1 { font-size: 2em; }
    h2 { font-size: 1.75em; }
    h3 { font-size: 1.2em; }
    table { margin-top: 0.75em; }
    th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
    td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
</style>
</head>
<body>
<h1>Registreer hier!</h1>
<p>Vul je naam en emailadres in en klik op <strong>Registreer</strong>.</p>
<form method="post" action="index.php" enctype="multipart/form-data" >
      Naam  <input type="text" name="name" id="name"/></br>
      Email <input type="text" name="email" id="email"/></br>
      <input type="submit" name="registreer" value="Registreer" />
</form>
<?php
	// DB connection info
    $host = "localhost";
    $user = "root";
    $pwd = "AliensDemo01";
    $db = "test";
    // Zet DB connection op.
    try {
        $conn = new PDO( "mysql:host=$host;dbname=$db", $user, $pwd);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch(Exception $e){
        die(var_dump($e));
    }
    // Registratie info
    if(!empty($_POST)) {
    try {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $date = date("Y-m-d");
        // Insert data
        $sql_insert = "INSERT INTO registration_tbl (name, email, date)
                   VALUES (?,?,?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $email);
        $stmt->bindValue(3, $date);
        $stmt->execute();
    }
    catch(Exception $e) {
        die(var_dump($e));
    }
    echo "<h3>Je bent geregistreerd!</h3>";
    }
    // Haal data op
    $sql_select = "SELECT * FROM registration_tbl";
    $stmt = $conn->query($sql_select);
    $registrants = $stmt->fetchAll();
    if(count($registrants) > 0) {
        echo "<h2>Mensen die geregistreerd zijn:</h2>";
        echo "<table>";
        echo "<tr><th>Naam</th>";
        echo "<th>Email</th>";
        echo "<th>Datum</th></tr>";
        foreach($registrants as $registrant) {
            echo "<tr><td>".$registrant['name']."</td>";
            echo "<td>".$registrant['email']."</td>";
            echo "<td>".date_format(date_create($registrant['date']),'d-m-Y')."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<h3>Er is nog niemand geregistreerd.</h3>";
    }
?>
</body>
</html>