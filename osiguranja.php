<!DOCTYPE html>
<html>
<head>
    <title>Pregled unetih polisa</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
<link href="css/style.css" rel="stylesheet">
<body>


<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Putno Osiguranje</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Početna</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="osiguranja.php">Osiguranja</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<br><br><br>

<h2 class="display-4">Pregled unetih polisa</h2><br><br>

<?php 

    // Uspostavljanje veze s bazom podataka
    $conn  = new mysqli("localhost", "root", "", "putnoosiguranje");

    $sql = "SELECT * FROM osiguranje";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        echo "<table class=\"table table-hover table-bordered\" style=\" width: 350px; margin-left: auto; margin-right: auto; \"";
        echo "<tr><th>Nosilac osiguranja</th><th>Akcija</th></tr>";

        while ($row = $result->fetch_assoc()) {
        echo "<tr><form action=\"osiguranja.php\" method=\"post\"><td>" . $row["nosilac_osiguranja"] . "<td> <input type=\"hidden\" name=\"broj_pasosa\" value=" . $row["broj_pasosa"] . "> <button type=\"submit\" class=\"btn btn-outline-primary btn-sm\" name=\"pregled\">Pregled</button> </td></td></form></tr>";
        }

        echo "</table>";
    } else {
        echo "<p class=\"h5\">Nema rezultata.</p><br>";
    }


    // Akcija pojedinačni osiguranici
    if (isset($_POST['pregled'])){

        $broj_pasosa = $_POST['broj_pasosa'];

        $sql = "SELECT * FROM osiguranje WHERE broj_pasosa = '$broj_pasosa'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

      echo "<table class=\"table table-hover table-bordered\" style=\" width: 1000px; margin-left: auto; margin-right: auto; \"";
      echo "<tr> <th>Nosilac osiguranja</th> <th>Datum rođenja</th> <th>Broj pasosa</th> <th>Telefon</th> <th>Email</th> <th>Datum putovanja od</th> <th>Datum putovanja do</th> <th>Broj dana</th> <th>Vrsta polise</th> <th>Akcija</th> </tr>";

      while ($row = $result->fetch_assoc()) {

        // Format datuma
        $originalDatum = $row['datum_rodjenja'];
        $noviDatum = date("d.m.Y", strtotime($originalDatum));
        
        // Broj dana
        $datum_putovanja_od = $row['datum_putovanja_od'];
        $datum_putovanja_do = $row['datum_putovanja_do'];

        $vremenskiZig1 = strtotime($datum_putovanja_od);
        $vremenskiZig2 = strtotime($datum_putovanja_do);

        $razlikaSekunde = abs($vremenskiZig2 - $vremenskiZig1);

        $brojDana = floor($razlikaSekunde / (60 * 60 * 24));

        $grupno = "grupno";
        

        echo "<tr> <form action=\"osiguranja.php\" method=\"post\"> <td>" . $row["nosilac_osiguranja"] . "</td> <td>" . $noviDatum . "</td> <td>" . $row["broj_pasosa"] . "</td> <td>" . $row["telefon"] . "</td> <td>" . $row["email"] . "</td> 
        <td>" . $row["datum_putovanja_od"] . "</td> <td>" . $row["datum_putovanja_do"] . "</td> <td>" . $brojDana . "</td><td>" . $row["vrsta_polise"] . "</td> </form> ";

        if($row["vrsta_polise"] == $grupno){
          echo " <td> <input type=\"hidden\" name=\"broj_pasosa\" value=" . $row["broj_pasosa"] . "> <button type=\"submit\" class=\"btn btn-outline-primary btn-sm\" name=\"pregled_dodatno\">Pregled</button> </td>";
        }
        else{
          echo " <td> <input type=\"hidden\" name=\"broj_pasosa\" value=" . $row["broj_pasosa"] . "> <button type=\"submit\" class=\"btn btn-outline-primary btn-sm\" name=\"pregled_dodatno\" disabled>Pregled</button> </td>";
        }

        echo "</tr>";
        }

        echo "</table>";
        } else {
          echo "<p class=\"h5\">Nema rezultata.</p><br>";
        }
    }

    
    // Akcija dodatni osiguranici
    if (isset($_POST['pregled_dodatno'])){

      $broj_pasosa = $_POST['broj_pasosa'];

      $sql = "SELECT * FROM osiguranje WHERE broj_pasosa = '$broj_pasosa'";

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {

    echo "<table class=\"table table-hover table-bordered\" style=\" width: 1000px; margin-left: auto; margin-right: auto; \"";
    echo "<tr> <th>Nosilac osiguranja</th> <th>Datum rođenja</th> <th>Broj pasosa</th> </tr>";

    while ($row = $result->fetch_assoc()) {

      // Format datuma
      $originalDatum = $row['datum_rodjenja'];
      $noviDatum = date("d.m.Y", strtotime($originalDatum));
      

      echo "<tr> <td>" . $row["nosilac_osiguranja"] . "</td> <td>" . $noviDatum . "</td> <td>" . $row["broj_pasosa"] . "</td> </tr> ";

      }

      echo "</table>";
      } else {
        echo "<p class=\"h5\">Nema rezultata.</p><br>";
      }
  }
    

    

?>

</body>