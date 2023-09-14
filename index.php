<!DOCTYPE html>
<html>
<head>
    <title>Unos osiguranja</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
<link href="css/style.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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

<h2 class="display-4">Unos novog osiguranja</h2><br>

    <!-- Forma za unos novog osiguranja -->
    <div class="h-100 d-flex align-items-center justify-content-center"> 
        <form id="forma_unos" method="post" action="index.php" style="width: 320px;">

            <!-- Ime i prezime -->
            <div class="mb-3">
                <label for="nosilac_osiguranja" class="form-label">Ime i prezime</label>*
                <input type="text" class="form-control" maxlength="50" name="nosilac_osiguranja">
                <div class="error" id="nosilac_osiguranja_error" style="color: red;"></div>
            </div>

            <!-- Datum rodjenja -->
            <div class="mb-3">
                <label for="datum_rodjenja" class="form-label">Datum rođenja</label>*
                <input type="date" class="form-control" placeholder="dd-mm-yyyy" name="datum_rodjenja">
                <div class="error" id="datum_rodjenja_error" style="color: red;"></div>
            </div>

            <!-- Broj pasosa -->
            <div class="mb-3">
                <label for="broj_pasosa" class="form-label">Broj pasoša</label>*
                <input type="text" class="form-control" name="broj_pasosa">
                <div class="error" id="broj_pasosa_error" style="color: red;"></div>
            </div>

            <!-- Broj telefona -->
            <div class="mb-3">
                <label for="telefon" class="form-label">Telefon</label>
                <input type="text" class="form-control" name="telefon" maxlength="10">
                <div class="error" id="telefon_error" style="color: red;"></div>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>*
                <input type="email" class="form-control" name="email" aria-describedby="emailHelp" maxlength="30">
                <div class="error" id="email_error" style="color: red;"></div>
            </div>

            <!-- Datum od do -->
            <div class="mb-3">

                <!-- Datum od -->
                <label for="datum_putovanja_od" class="form-label">Datum putovanja (OD)</label>*
                <input type="date" name="datum_putovanja_od" class="form-control" placeholder="dd-mm-yyyy" min="1997-01-01" max="2030-12-31">

                <!-- Datum do -->
                <label for="datum_putovanja_do" class="form-label">Datum putovanja (DO)</label>*
                <input type="date" name="datum_putovanja_do" class="form-control" placeholder="dd-mm-yyyy" min="1997-01-01" max="2030-12-31">
                <div class="error" id="datum_putovanja_error" style="color: red;"></div>
                <div class="error" id="broj_dana_error" style="color: red;"></div>

                <p>Broj dana u odnosu na odabrani datum: <span id="broj_dana"></span></p>
            </div>

             <!-- Vrsta polise invidualno -->
            <div class="form-check">
                <input class="form-check-input" type="radio" name="vrsta_polise" value="individualno" id="invidualnoRadio" checked>
                <label class="form-check-label">
                Individualno
                </label>
            </div>

            <!-- Vrsta polise grupno -->
            <div class="form-check">
                <input class="form-check-input" type="radio" name="vrsta_polise" value="grupno" id="grupnoRadio">
                <label class="form-check-label">
                Grupno
                </label>
            </div>
            
            <br>
  
            <button type="button" class="btn btn-secondary btn-sm" id="dodajBtn" onclick="dodajOsiguranika()" disabled>Dodaj dodatnog osiguranika</button><br><br>

            <div class="mb-3" id="osiguranici">
                <!-- Ovde će se dinamički dodavati polja za dodatne osiguranike -->
            </div>

            <button type="submit" class="btn btn-primary btn-lg" name="dodaj" id="potvrdiBtn">Potvrdi</button>

            <div id="errorMessages"></div>

            <br><br>

        </form>
    </div>

    <script src="js/script.js"></script>

    <!-- PHP -->
    <?php

// Konekcija sa bazom
$mysqli = new mysqli("localhost", "root", "", "putnoosiguranje");

// Dodaj novo osiguranje
if (isset($_POST['dodaj'])) {
    if ((!$_POST['nosilac_osiguranja']) || (!$_POST['datum_rodjenja']) || (!$_POST['broj_pasosa']) || (!$_POST['email']) || (!$_POST['datum_putovanja_od']) || (!$_POST['datum_putovanja_do']) || (!$_POST['vrsta_polise'])) {
    echo "Morate popuniti sva polja!<br>";
} else {
    $nosilac_osiguranja = $_POST['nosilac_osiguranja'];
    $datum_rodjenja = $_POST['datum_rodjenja'];
    $broj_pasosa = $_POST['broj_pasosa'];
    $telefon = $_POST['telefon'];
    $email = $_POST['email'];
    $datum_putovanja_od = $_POST['datum_putovanja_od'];
    $datum_putovanja_do = $_POST['datum_putovanja_do'];
    $vrsta_polise = $_POST['vrsta_polise'];

    $sql_dodaj = "INSERT INTO osiguranje (nosilac_osiguranja, datum_rodjenja, broj_pasosa, telefon, email, datum_putovanja_od, datum_putovanja_do, vrsta_polise)";
    $sql_dodaj .= "VALUES ('$nosilac_osiguranja', '$datum_rodjenja', '$broj_pasosa', '$telefon', '$email', '$datum_putovanja_od', '$datum_putovanja_do', '$vrsta_polise')";
    $res_dodaj = $mysqli->query($sql_dodaj);

    if (!$res_dodaj) {
        echo "Greska pri izvrsavanju upita dodavanja!";
        die($mysqli->error);
    }
    echo "<p class=\"h5\">Osiguranje je uspešno dodato!</p><br>";
}
}

// Dodaj novo grupno osiguranje
if (isset($_POST['dodaj_dodatno'])) {
    if ((!$_POST['nosilac_osiguranja']) || (!$_POST['datum_rodjenja']) || (!$_POST['broj_pasosa']) || (!$_POST['email']) || 
    (!$_POST['datum_putovanja_od']) || (!$_POST['datum_putovanja_do']) || (!$_POST['vrsta_polise']) || (!$_POST['d_nosilac_osiguranja']) || (!$_POST['d_datum_rodjenja']) || (!$_POST['d_broj_pasosa']) ) {
    echo "Morate popuniti sva polja!<br>";
} else {
    $nosilac_osiguranja = $_POST['nosilac_osiguranja'];
    $datum_rodjenja = $_POST['datum_rodjenja'];
    $broj_pasosa = $_POST['broj_pasosa'];
    $telefon = $_POST['telefon'];
    $email = $_POST['email'];
    $datum_putovanja_od = $_POST['datum_putovanja_od'];
    $datum_putovanja_do = $_POST['datum_putovanja_do'];
    $vrsta_polise = $_POST['vrsta_polise'];

    $d_nosilac_osiguranja = $_POST['d_nosilac_osiguranja'];
    $d_datum_rodjenja = $_POST['d_datum_rodjenja'];
    $d_broj_pasosa = $_POST['d_broj_pasosa'];

    $sql_dodaj = "INSERT INTO osiguranje (nosilac_osiguranja, datum_rodjenja, broj_pasosa, telefon, email, datum_putovanja_od, datum_putovanja_do, vrsta_polise)";
    $sql_dodaj .= "VALUES ('$nosilac_osiguranja', '$datum_rodjenja', '$broj_pasosa', '$telefon', '$email', '$datum_putovanja_od', '$datum_putovanja_do', '$vrsta_polise')";
    $res_dodaj = $mysqli->query($sql_dodaj);

    if (!$res_dodaj) {
        echo "Greska pri izvrsavanju upita dodavanja!";
        die($mysqli->error);
    }

    $sql_dodaj_dodatno = "INSERT INTO dodatni_osiguranik (d_nosilac_osiguranja, d_datum_rodjenja, d_broj_pasosa, glavni_osiguranik_id)";
    $sql_dodaj_dodatno .= "VALUES ('$d_nosilac_osiguranja', '$d_datum_rodjenja', '$d_broj_pasosa', '$broj_pasosa')";
    $res_dodaj_dodatno = $mysqli->query($sql_dodaj_dodatno);

    if (!$res_dodaj) {
        echo "Greska pri izvrsavanju upita dodavanja!";
        die($mysqli->error);
    }

    echo "<p class=\"h5\">Grupno osiguranje je uspešno dodato!</p><br>";
    }
}

?>

</body>
</html>
