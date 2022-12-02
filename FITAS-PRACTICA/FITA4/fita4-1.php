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
            <select name="continent" id="">
            <?php
            while ( $row ) {
                echo "<option value=".$row['Continent'].">".$row['Continent']."</option>";
                $row = $query->fetch();
            }
            ?>
            </select>
            <input type="submit">
        </form>

        <?php
            if(isset($_GET["continent"])){
                $cont= $_GET["continent"];
                $queryCont = $pdo->prepare("select Name from country where Continent= '$cont';");
                $queryCont->execute();
                $row = $queryCont->fetch();
                echo "<ul>";
                while ( $row ) {
                    echo "<li>".$row['Name']."</li>";
                    $row = $queryCont->fetch();
                }
                echo "</ul>";
            }
    
        ?>

        <?php
        unset($pdo); 
        unset($query);
        unset($queryCont);
        ?>
</body>
</html>