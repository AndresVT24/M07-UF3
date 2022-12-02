<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXERCICI 2</title>
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
        //$query = $pdo->prepare('SELECT Continent from country group by Continent;');
        //$query->execute();

        //anem agafant les fileres d'amb una amb una
        //$row = $query->fetch();
    ?>
    <form action="" method="GET">
        <input type="text" name="country" placeholder="Nom Pais">
        <input type="submit">
    </form>
    <?php
        if(isset($_GET["country"])){
            $country= $_GET["country"];
            $queryCont = $pdo->prepare("SELECT country.Name as Name, countrylanguage.Language as Language, countrylanguage.IsOfficial as Official, countrylanguage.Percentage as Percentage from country inner join countrylanguage on country.Code = countrylanguage.CountryCode where country.Name like '%{$country}%';");
            $queryCont->execute();
            echo "<table border='1'>";
            $row = $queryCont->fetch();
            while ( $row ) {
                echo "<tr>";
                    echo "<td>".$row['Name']."</td>";
                    echo "<td>".$row['Language']."</td>";
                    echo "<td>".$row['Official']."</td>";
                    echo "<td>".$row['Percentage']."</td>";
                echo "</tr>";
                $row = $queryCont->fetch();
            }
            echo "</table>";
            
        }
        unset($pdo); 
        unset($query);
        unset($queryCont);

    ?>
</body>
</html>