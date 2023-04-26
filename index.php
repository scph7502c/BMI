<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Twój wskaźnik BMI</title>
</head>
<body>
    <section>
        <header>
<div class="baner">
<h2>Oblicz wskaźnik BMI</h2>
</div>
<div class="logo">
    <img src="wzor.png" alt="liczymy BMI">
</div>
</header>
<section class="results">
<div class="lewy">
    <img src="rys1.png" alt="zrzuć kalorie!"class="rysimg">
</div>
<div class="prawy">
    <h1>Podaj dane</h1>
    <form action="index.php" method="post">
<p>Waga w kg</p><input type="number" name="waga">
<p>Wzrost w cm</p><input type="number" name="wzrost">
<p><input type="submit" name="sub" value="Licz BMI i zapisz wynik"></p>
</form>
<?php

error_reporting(0);

require_once('connection.php');

$do_bazy = mysqli_connect('localhost', 'root', 'hasloMySQL', 'bmi1');

if(!$do_bazy) {
exit("Błąd połączenia z serwerem MySQL."); 
}


function bmiCount(){ 
@$waga = $_POST['waga'];
@$wzrost = $_POST['wzrost'];
$bmi = 0;

    if($wzrost != 0){
        $bmi = floor(($waga / pow($wzrost, 2)) * 10000);
    }
    return $bmi;
};


$wynikBmi = bmiCount();

$bmiId = 0;

if(bmiCount() < 19){

$bmiId = 2;

} else if($wynikBmi > 19 && $wynikBmi < 26){
    $bmiId = 3;
} else if($wynikBmi > 26 && $wynikBmi < 31){
    $bmiId = 4;
} else if ($wynikBmi >= 31) $bmiId = 5;


$waga = htmlspecialchars($_POST['waga']);
$wzrost = htmlspecialchars($_POST['wzrost']);
$date=date("Y-m-d");
$dodaj = "INSERT INTO wynik values (null, '$bmiId', '$date', '$wynikBmi' )";
$zapytanie1 = mysqli_query($do_bazy, $dodaj);


if (!empty($_POST['waga']) && !empty($_POST['wzrost']) ) {

echo "Twoja waga: ".$waga."<br>"."Twój wzrost: ".$wzrost."<br>"."BMI wynosi: ".$wynikBmi;

?>

</div>
</section>
<div class="glowny" id="ciag">
<table class="tabela">
<tr>
    <th>lp.</th>
    <th>Interpretacja</th>
    <th>zaczyna się od...</th>
</tr>
<tr>

<?php
    //insert data from database to table
    $zapytanie3 = mysqli_query($do_bazy, "SELECT * FROM bmi");  
    $ile = mysqli_num_rows($zapytanie3);
    $wiersz = mysqli_fetch_assoc($zapytanie3);
    $wierszId = $wiersz['id'];
    $wierszWartMin = $wiersz['wart_min'];
    $wierszWartMax = $wiersz['wart_max'];
    $wierszInterpretacja = $wiersz['informacja'];
    $lp = 2;
    for($i = 0; $i < $ile; $i++){
        echo "<tr>";
        echo "<td>".$lp."</td>";
        echo "<td>".$wierszInterpretacja."</td>";
        echo "<td>".$wierszWartMin." - ".$wierszWartMax."</td>";
        echo "</tr>";
        $lp++;
        $wiersz = mysqli_fetch_assoc($zapytanie3);
        @$wierszId = $wiersz['id'];
        @$wierszWartMin = $wiersz['wart_min'];
        @$wierszWartMax = $wiersz['wart_max'];
        @$wierszInterpretacja = $wiersz['informacja'];
    }


}


mysqli_close($do_bazy);
   
?>
</tr>

</table>

</div>
    </section>
    <footer class="stopka"><p>Autor: Damian Temimi</p></footer>
    <script src="skrypt.js">
</script>
</body>
</html>