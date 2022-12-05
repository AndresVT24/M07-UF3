<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
</head>
<body>
    <?php
        try {
            $hostname = "127.0.0.1";
            $dbname = "login";
            $username = "root";
            $pw = "24Andres25";
            $dbh = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
            } catch (PDOException $e) {
                echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
        }

    ?>
    <div>
        <center><h2>LOGIN</h2></center>
        <form action="" method="POST">
            <p>USERNAME</p>
            <input type="text" name="nameLogin">
            <p>PASSWORD</p>
            <input type="password" name="passwordLogin"><br>
            <input type="submit" name="" id="">
        </form>
    </div>
    <div>
        <center><h2>REGISTER</h2></center>
        <form action="" method="POST">
            <p>USERNAME</p>
            <input type="text" name="nameRegister">
            <p>PASSWORD</p>
            <input type="password" name="passwordRegister"><br>
            <input type="submit" name="" id="">
        </form>
    </div>
    <?php

    if(isset($_POST["nameRegister"]) && isset($_POST["passwordRegister"])){
        $user= $_POST["nameRegister"];
        $password=$_POST["passwordRegister"];
        $passwordEncripted = hash('sha512',$password);
        $passwordEncripted = password_hash($passwordEncripted, PASSWORD_DEFAULT);
        $stmt = $dbh->prepare("INSERT into users (userName, password) values(?, ?)");
        $stmt->bindParam(1, $user);
        $stmt->bindParam(2, $passwordEncripted);
        $stmt->execute();
        echo "SE HA REGISTRADO CORRECTAMENTE";
    }

    if(isset($_POST["nameLogin"]) && isset($_POST["passwordLogin"])){
        $user= $_POST["nameLogin"];
        $password= $_POST["passwordLogin"];
        $queryVer = $pdo->prepare("SELECT password from users where userName= '$user';");
        $queryVer->execute();
        $row = $queryVer->fetch();
        $accedido= false;
        while ($row) {
            $verify= hash('sha512', $password);
            $verify = password_verify($verify, $row["password"]);
            if($verify == true){
                echo "SE HA ACCEDIDO CORRECTAMENTE";
                $accedido= true;
            }
            $row = $queryVer->fetch();
        }
        if($accedido == false){
            echo "NO SE HA ACCEDIDO CORRECTAMENTE";
        }
    }

    ?>
</body>
</html>