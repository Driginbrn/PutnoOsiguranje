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

// Validacija
document.addEventListener('DOMContentLoaded', function () {
    const formaUnos = document.getElementById('forma_unos');
    const nosilacOsiguranjaInput = document.querySelector('input[name="nosilac_osiguranja"]');
    const datumRodjenjaInput = document.querySelector('input[name="datum_rodjenja"]');
    const brojPasosaInput = document.querySelector('input[name="broj_pasosa"]');
    const telefonInput = document.querySelector('input[name="telefon"]');
    const emailInput = document.querySelector('input[name="email"]');
    const datumOdInput = document.querySelector('input[name="datum_putovanja_od"]');
    const datumDoInput = document.querySelector('input[name="datum_putovanja_do"]');
    const brojDanaSpan = document.getElementById('broj_dana');
    const datumPutovanjaError = document.getElementById('datum_putovanja_error');
    const brojDanaError = document.getElementById('broj_dana_error');
    const nosilacOsiguranjaError = document.getElementById('nosilac_osiguranja_error');
    const datumRodjenjaError = document.getElementById('datum_rodjenja_error');
    const brojPasosaError = document.getElementById('broj_pasosa_error');
    const telefonError = document.getElementById('telefon_error');
    const emailError = document.getElementById('email_error');

    formaUnos.addEventListener('submit', function (event) {

        // Validacija za nosioca osiguranja
        const nosilacOsiguranjaValue = nosilacOsiguranjaInput.value.trim();
        const nosilacOsiguranjaRegex = /^[A-Z][a-z]+ [A-Z][a-z]+$/;

        if (!nosilacOsiguranjaValue) {
            nosilacOsiguranjaError.textContent = 'Polje "Ime i prezime" ne sme biti prazno.';
            console.log('Nosilac osiguranja: Polje ne sme biti prazno.');
            event.preventDefault(); // Zaustavljanje podnošenja forme
            return;
        } else if (!nosilacOsiguranjaRegex.test(nosilacOsiguranjaValue) || nosilacOsiguranjaValue.length > 50) {
            nosilacOsiguranjaError.textContent = 'Unesite ime i prezime u formatu "Ime Prezime" sa početnim velikim slovima i ne više od 50 karaktera.';
            console.log('Nosilac osiguranja: Unesite ime i prezime u formatu "Ime Prezime" sa početnim velikim slovima i ne više od 50 karaktera.');
            event.preventDefault(); // Zaustavljanje podnošenja forme
            return;
        } else {
            nosilacOsiguranjaError.textContent = '';
        }

        // Validacija za datum rođenja
        const datumRodjenjaValue = datumRodjenjaInput.value;
        if (!datumRodjenjaValue) {
            datumRodjenjaError.textContent = 'Morate odabrati datum rođenja.';
            console.log('Datum rodjenja: Morate odabrati datum rođenja.');
            event.preventDefault(); // Zaustavljanje podnošenja forme
            return;
        } else {
            datumRodjenjaError.textContent = '';
        }

        // Validacija za broj pasoša
        const brojPasosaValue = brojPasosaInput.value.trim();
        if (!/^\d{1,20}$/.test(brojPasosaValue)) {
            brojPasosaError.textContent = 'Broj pasoša mora sadržati samo brojeve i ne sme biti duži od 20 karaktera.';
            console.log('Broj pasoša: Broj pasoša mora sadržati samo brojeve i ne sme biti duži od 20 karaktera.');
            event.preventDefault(); // Zaustavljanje podnošenja forme
            return;
        } else {
            brojPasosaError.textContent = '';
        }

        // Validacija za telefon
        const telefonValue = telefonInput.value.trim();
        if (telefonValue && (!/^\d+$/.test(telefonValue) || telefonValue.length > 10)) {
            telefonError.textContent = 'Telefon može sadržati samo do 10 brojeva.';
            console.log('Telefon: Telefon može sadržati samo do 10 brojeva.');
            event.preventDefault(); // Zaustavljanje podnošenja forme
            return;
        } else {
            telefonError.textContent = '';
        }

        // Validacija za email
        const emailValue = emailInput.value.trim();
        if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(emailValue) || emailValue.length > 30) {
            emailError.textContent = 'Molimo unesite validnu email adresu koja ne sme biti duža od 30 karaktera.';
            console.log('Telefon: Telefon može sadržati samo do 10 brojeva.');
            event.preventDefault(); // Zaustavljanje podnošenja forme
            return;
        } else {
            emailError.textContent = '';
        }

        // Validacija za datume putovanja
        const datumOdValue = new Date(datumOdInput.value);
        const datumDoValue = new Date(datumDoInput.value);

        if (!isNaN(datumOdValue.getTime()) && !isNaN(datumDoValue.getTime()) && datumDoValue >= datumOdValue) {
            const razlika = Math.ceil((datumDoValue - datumOdValue) / (1000 * 60 * 60 * 24));
            if (razlika < 0) {
                datumPutovanjaError.textContent = 'Datum "DO" ne sme biti pre datuma "OD".';
                event.preventDefault(); // Zaustavljanje podnošenja forme
                brojDanaError.textContent = '';
                return;
            } else {
                datumPutovanjaError.textContent = '';
                if (razlika == 1) {
                    brojDanaSpan.textContent = razlika + ' dan';
                } else {
                    brojDanaSpan.textContent = razlika + ' dana';
                }
            }
        } else {
            datumPutovanjaError.textContent = 'Morate ispravno odabrati datume.';
            event.preventDefault(); // Zaustavljanje podnošenja forme
            brojDanaSpan.textContent = '';
            return;
        }

        // Ako su sve validacije prošle, možete omogućiti slanje forme na server
        formaUnos.submit();
        console.log('Form Submit');
    });

    // Računanje broja dana pri promeni datuma
    datumOdInput.addEventListener('change', updateBrojDana);
    datumDoInput.addEventListener('change', updateBrojDana);

    function updateBrojDana() {
        const datumOd = new Date(datumOdInput.value);
        const datumDo = new Date(datumDoInput.value);

        if (!isNaN(datumOd.getTime()) && !isNaN(datumDo.getTime()) && datumDo >= datumOd) {
            const razlika = Math.ceil((datumDo - datumOd) / (1000 * 60 * 60 * 24));
            if (razlika == 1) {
                brojDanaSpan.textContent = razlika + ' dan';
            } else {
                brojDanaSpan.textContent = razlika + ' dana';
            }
        } else {
            brojDanaSpan.textContent = '';
        }
    }
});