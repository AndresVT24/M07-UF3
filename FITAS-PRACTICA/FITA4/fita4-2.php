<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXERCICI 1</title>
</head>
<body>
    <?php
        //connexió dins block try-catch:
        //  prova d'executar el contingut del try
        //  si falla executa el catch
        try {
            $hostname = "127.0.0.1";
            $dbname = "world";
            $username = "admin";
            $pw = "admin123";
            $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
          } catch (PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
          }
        //preparem i executem la consulta
        $query = $pdo->prepare('SELECT Continent from country group by Continent;');
        $query->execute();

        //anem agafant les fileres d'amb una amb una
        $row = $query->fetch();
        ?>
        <form action="" method="GET">
            <?php
            while ( $row ) {
                echo "<input type= 'checkbox' name= 'continent[]' value='{$row['Continent']}'>";
                echo "<label>".$row["Continent"]."</label>";
                echo "<br>";
                $row = $query->fetch();
            }
            ?>
            <input type="submit">
        </form>

        <?php
            if(isset($_GET["continent"])){
                $cont= $_GET["continent"];
                echo "<ul>";
                foreach ($cont as $number => $continente) {
                    $queryCont = $pdo->prepare("SELECT Name from country where Continent= '{$continente}';");
                    $queryCont->execute();
                    $row = $queryCont->fetch();
                    while ( $row ) {
                        echo "<li>".$row['Name']."</li>";
                        $row = $queryCont->fetch();
                    }
                }
                echo "</ul>";
                
            }
            unset($pdo); 
            unset($query);
            unset($queryCont);
    
        ?>
</body>
</html>