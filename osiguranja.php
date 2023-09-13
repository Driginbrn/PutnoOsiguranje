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
          <a class="nav-link" href="index.php">Početna</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="osiguranja.php">Osiguranja</a>
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

    // Prikaz svih unetih polisa
    $sql = "SELECT * FROM osiguranje";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

      echo "<table class=\"table table-hover table-bordered\" style=\" width: 1500px; margin-left: auto; margin-right: auto; \"";
      echo "<tr> <th>Nosilac osiguranja</th> <th>Datum rođenja</th> <th>Broj pasoša</th> <th>Telefon</th> <th>Email</th> <th>Datum putovanja od</th> <th>Datum putovanja do</th> <th>Broj dana</th> <th>Vrsta polise</th> <th>Akcija</th> </tr>";

      while ($row = $result->fetch_assoc()) {

        // Format datuma
        $originalDatum = $row['datum_rodjenja'];
        $noviDatum = date("d.m.Y.", strtotime($originalDatum));

        // Format datuma od
        $originalDatumOd = $row['datum_putovanja_od'];
        $noviDatumOd = date("d.m.Y.", strtotime($originalDatumOd));

        // Format datuma do
        $originalDatumDo = $row['datum_putovanja_do'];
        $noviDatumDo = date("d.m.Y.", strtotime($originalDatumDo));
        
        // Broj dana
        $datum_putovanja_od = $row['datum_putovanja_od'];
        $datum_putovanja_do = $row['datum_putovanja_do'];

        $vremenskiZig1 = strtotime($datum_putovanja_od);
        $vremenskiZig2 = strtotime($datum_putovanja_do);

        $razlikaSekunde = abs($vremenskiZig2 - $vremenskiZig1);

        $brojDana = floor($razlikaSekunde / (60 * 60 * 24));

        $grupno = "grupno";
        

        echo "<tr> <form action=\"osiguranja.php\" method=\"post\"> <td>" . $row["nosilac_osiguranja"] . "</td> <td>" . $noviDatum . "</td> <td>" . $row["broj_pasosa"] . "</td> <td>";

        // Ako telefon nije unet
        if($row["telefon"] == 0){
          echo"Nije unet";
        }
        else {echo "" . $row["telefon"] . "";
          } 
        echo " <td>" . $row["email"] . "</td> 
        <td>" . $noviDatumOd . "</td> <td>" . $noviDatumDo . "</td> <td>" . $brojDana . "</td> <td>" . $row["vrsta_polise"] . "</td>";

        // Dugme za akciju
        if($row["vrsta_polise"] == $grupno){
          echo " <td> <input type=\"hidden\" name=\"broj_pasosa\" value=" . $row["broj_pasosa"] . "> <button type=\"submit\" class=\"btn btn-outline-primary btn-sm\" name=\"pregled_dodatno\">Pregled</button> </td>";
        }
        else{
          echo " <td> <input type=\"hidden\" name=\"broj_pasosa\" value=" . $row["broj_pasosa"] . "> <button type=\"submit\" class=\"btn btn-outline-dark btn-sm\" name=\"pregled_dodatno\" disabled>Pregled</button> </td>";
        }
        echo "</form> </tr>";
        }

        echo "</table>";
        } else {
          echo "<p class=\"h5\">Nema rezultata.</p><br>";
        }

    
    // Akcija dodatni osiguranici
    if (isset($_POST['pregled_dodatno'])){

      $broj_pasosa = $_POST['broj_pasosa'];

      $sql = "SELECT * FROM dodatni_osiguranik join osiguranje on glavni_osiguranik_id = broj_pasosa WHERE broj_pasosa = '$broj_pasosa'";

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {

    echo "<br> <h2 class=\"display-6\">Pregled dodatnih osiguranika</h2><br>";
    echo "<table class=\"table table-hover table-bordered\" style=\" width: 600px; margin-left: auto; margin-right: auto; \"";
    echo "<tr> <th>Nosilac osiguranja</th> <th>Datum rođenja</th> <th>Broj pasoša</th> </tr>";

    while ($row = $result->fetch_assoc()) {

      // Format datuma rodjenja
      $originalDatum = $row['d_datum_rodjenja'];
      $noviDatum = date("d.m.Y.", strtotime($originalDatum));
      

      echo "<tr> <td>" . $row["d_nosilac_osiguranja"] . "</td> <td>" . $noviDatum . "</td> <td>" . $row["d_broj_pasosa"] . "</td> </tr> ";

      }

      echo "</table>";
      } else {
        echo "<p class=\"h5\">Nema rezultata.</p><br>";
      }
  }
    

    

?>

</body>