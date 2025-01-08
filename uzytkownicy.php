<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal społecznościowy</title>
    <link rel="stylesheet" href="styl5.css">
</head>
<body>
    <?php
        $conn=mysqli_connect("localhost","root", "", "portal");
    ?>
    <header class="d-flex">
        <div class="b-left">
            <h2>Nasze osiedle</h2>
        </div>
        <div class="b-right">
            <?php
                $query="SELECT COUNT(*) FROM dane;";
                $result=mysqli_query($conn, $query);
                $row=mysqli_fetch_row($result);
                echo "<h5>Liczba użytkowników portalu: ".$row[0]."</h5>"
            ?>
        </div>
    </header>
    <main class="d-flex">
        <section class="m-left">
            <h3>Logowanie</h3>
            <form action="uzytkownicy.php" method="post">
                <label for="login">login</label><br>
                <input type="text" name="login" id="login"><br>
                <label for="haslo">hasło</label><br>
                <input type="password" name="haslo" id="haslo"><br>
                <input type="submit" value="Zaloguj">
            </form>
        </section>
        <section class="m-right">
            <h3>Wizytówka</h3>
            <div class="wizytowka">
        
            <?php
            if(isset($_POST["login"])&&isset($_POST["haslo"])){
                $login=$_POST["login"];
                $haslo=$_POST["haslo"];
                if($login!=""&&$haslo!=""){
                    $query="SELECT haslo FROM uzytkownicy WHERE login = '$login';";
                    $result=mysqli_query($conn, $query);
                    $row=mysqli_fetch_assoc($result);
                    $num=mysqli_num_rows($result);
                    if(isset($row["haslo"])){
                        if($row["haslo"]==sha1($haslo)){
                            $query2="SELECT login, rok_urodz, przyjaciol, hobby, zdjecie FROM uzytkownicy JOIN dane USING(id) WHERE login='$login';";
                            $result2=mysqli_query($conn, $query2);
                            $row=mysqli_fetch_assoc($result2);
                            echo "<img src='".$row["zdjecie"]."' alt='osoba'>";
                            echo "<h4>".$row["login"]."(".date("Y")-$row["rok_urodz"].")</h4>";
                            echo "<p>hobby: ".$row["hobby"]."</p>";
                            echo "<h1><img src='icon-on.png'>".$row["przyjaciol"]."</h1>";
                            echo "<a href='dane.html'><button>Więcej informacji</button></a>";
                        }else{
                            echo "hasło nieprawidłowe";
                        }
                    }else{
                        echo "login nie istnieje";
                    }
                }
            }
                mysqli_close($conn);
            ?>
            </div>
        </section>
    </main>
    <footer>
        Stronę wykonał: Jakub Ryz
    </footer>
</body>
</html>