// Računanje broja dana u odnosu na odabrane datume
const datumOdInput = document.querySelector('input[name="datum_putovanja_od"]');
const datumDoInput = document.querySelector('input[name="datum_putovanja_do"]');
const brojDanaSpan = document.getElementById('broj_dana');

datumOdInput.addEventListener('change', updateBrojDana);
datumDoInput.addEventListener('change', updateBrojDana);

function updateBrojDana() {
    const datumOd = new Date(datumOdInput.value);
    const datumDo = new Date(datumDoInput.value);
    const razlika = Math.ceil((datumDo - datumOd) / (1000 * 60 * 60 * 24));
    if(razlika == 1){
        brojDanaSpan.textContent = razlika + ' dan';
    }else{

    brojDanaSpan.textContent = razlika + ' dana';
    }
}

// Dodatni osiguranik
function dodajOsiguranika() {
    const osiguraniciDiv = document.getElementById('osiguranici');
    const noviOsiguranikDiv = document.createElement('div');

    noviOsiguranikDiv.innerHTML = `<div id="divZaBrisanje">
        <hr>
        <p class="h3">Dodatni osiguranik</p>
        <!-- Ime i prezime -->
            <div class="mb-3">
                <label for="nosilac_osiguranja" class="form-label">Ime i prezime</label>*
                <input type="text" class="form-control" name="d_nosilac_osiguranja" required>
                <div class="error" id="d_nosilac_osiguranja_error" style="color: red;"></div>
            </div>

            <!-- Datum rodjenja -->
            <div class="mb-3">
                <label for="datum_rodjenja" class="form-label">Datum rođenja</label>*
                <input type="date" class="form-control" name="d_datum_rodjenja" required>
            </div>

            <!-- Broj pasosa -->
            <div class="mb-3">
                <label for="broj_pasosa" class="form-label">Broj pasoša</label>*
                <input type="tel" class="form-control" name="d_broj_pasosa" required>
                <div class="error" id="d_broj_pasosa" style="color: red;"></div>
            </div>

            <!-- Button za brisanje -->
            <div class="mb-3">
                <button type="button" class="btn btn-outline-danger btn-sm" id="btnObrisiDiv" onclick="obrisiDiv()" >Obrisi dodatnog osiguranika</button>
            </div>
            <br><br><br>
        </div>
    `;

    osiguraniciDiv.appendChild(noviOsiguranikDiv);
}

// Brisanje dodatnog osiguranika
function obrisiDiv() {
    var divZaBrisanje = document.getElementById('divZaBrisanje');
    if (divZaBrisanje) {
        divZaBrisanje.parentNode.removeChild(divZaBrisanje);
    }
}

// Prvo dobijemo referencu na radio dugme i dugme koje želimo da omogućimo
const grupnoRadio = document.getElementById('grupnoRadio');
const invidualnoRadio = document.getElementById('invidualnoRadio');
const dodajBtn = document.getElementById('dodajBtn');
const potvrdiBtn = document.getElementById('potvrdiBtn');

// Dodajemo event listener na radio dugme
grupnoRadio.addEventListener('change', function() {
// Ako je radio dugme označeno (checked), omogućujemo dugme, inače ga onemogućujemo
if (grupnoRadio.checked) {
    dodajBtn.removeAttribute('disabled');
    potvrdiBtn.setAttribute('name', "dodaj_dodatno");
} else {
    dodajBtn.setAttribute('disabled', true);
}
});

invidualnoRadio.addEventListener('change', function() {
// Ako je radio dugme označeno (checked), omogućujemo dugme, inače ga onemogućujemo
if (invidualnoRadio.checked) {
    dodajBtn.setAttribute('disabled', true);
    potvrdiBtn.setAttribute('name', "dodaj");
}});

