<?php
    include_once("db.php");
    session_start();
    if(isset($_REQUEST["logud"])){    
        $_SESSION["session"]= false;

        $_SESSION = array();


        header("Location: index.php");
      
    }

    if(isset($_REQUEST["user"]) && isset($_REQUEST["pass"])){
        $user = $_REQUEST["user"];
        $pass = $_REQUEST["pass"];

        $stmt=$db->prepare("SELECT * FROM Users WHERE `name` = ? AND pass = md5(?);");
        $stmt->bind_param('ss', $user, $pass);
        $stmt->execute();
            $query=$stmt->get_result();
        $stmt->close();
        

        if(mysqli_num_rows($query) == 1){
            $_SESSION["session"] = true;
            $_SESSION["user"] = $user;
            header("Location: index.php");
        }else{
            $_SESSION["session"] = false;
            ?>
            <script>
                alert("Forkert kode eller bruger")
                window.location="index.php"
            </script>
            <?php
            
        }
    }
  
    if(isset($_REQUEST["newUser"])){
        $user = $_REQUEST["newUser"];
        $pass1 = $_REQUEST["newPass1"];
        $pass2 = $_REQUEST["newPass2"];

        if($pass1 == $pass2){

                $stmt=$db->prepare("INSERT INTO `Users`(`name`, `pass`) VALUES (?, md5(?));");
                $stmt->bind_param('ss', $user, $pass1);
                $stmt->execute();
                $stmt->close();

                header("Location: index.php");
        }else{
            $_SESSION["session"] = false;
                    ?>
                    <script>
                        alert("Koden er ikke ens")
                        window.location="index.php"
                    </script>
                    <?php

        }
    }

   

?>
<!DOCTYPE html>
<html>
    <head>
    <title>Start</title>
        <script>
            function nyBruger(){
                window.location="?nybruger"

            }
            function tilbage(){
                window.location="index.php"

            }
        </script>   
    </head>
    <body>
    <?php 
        if(isset($_SESSION["session"]) && $_SESSION["session"] == true){
            echo $_SESSION["user"];
    ?>
        <a href="?logud">Log ud</a>
    <?php
        }elseif(isset($_REQUEST["nybruger"])){
    ?>
    <button onclick="tilbage()"> Tilbage</button>
        <center>
            <h1 href="Chat-app--PHP-"> Opret bruger</h1>
            <form method="post">
                
                <input type="text" name="newUser" placeholder="Brugernavn" required>
                <br>
                <input type="password" name="newPass1" placeholder="Password" required>
                <br>
                <input type="password" name="newPass2" placeholder="Gentag password" required>
                <br>
                <input type="submit" value="Opret bruger">
                
            </form>
        </center>
    <?php
        }else{
            
    ?>
        <center>
        <h1 href="Chat-app--PHP-"> Chat App</h1>
        <form method="post">
            <input type="text" name="user" placeholder="Brugernavn" >
            <br>
            <input type="password" name="pass" placeholder="Password">
            <br>
            <input type="submit" value="Log ind">
        </form>
        <button onclick="nyBruger()"> Ny bruger</button>
        </center>
        <?php }?>
    </body>
</html>