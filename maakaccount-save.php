<?php
include_once("functions.php");

$db = ConnectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST['Naam'];
    $email = $_POST['Email'];
    $telefoon = $_POST['Telefoon'];
    $wachtwoord = $_POST['Wachtwoord'];
    $toestemming = isset($_POST['Toestemming']) ? $_POST['Toestemming'] : '';

    // Controleer of het toestemmingsvinkje is aangevinkt
    if ($toestemming !== 'on') {
        // Toestemming niet gegeven
        echo "Geef alstublieft toestemming voor de verwerking van uw persoonlijke gegevens.";
        // Je kunt de gebruiker eventueel terugsturen naar het registratieformulier of de fout op een andere manier afhandelen.
        exit;
    }

    // Voer verdere verwerking uit (bijv. opslaan in de database) na succesvolle validatie
    $sql = "INSERT INTO relaties (Naam, Email, Telefoon, Wachtwoord, FKrollenID)
            VALUES ('" . $naam . "', '" . 
                     $email . "', '" .
                     $telefoon . "', '" . 
                     md5($wachtwoord) . "', '" . 
                     10 . "')";

    if ($db->query($sql) == true) {
        if (StuurMail($email, 
                       "Account gegevens Ultima Casa", 
                       "Uw inlog gegevens zijn:
                       
              Naam: " . $naam . "
              E-mailadres: " . $email . "
              Telefoon: " . $telefoon . "
              Wachtwoord: " . $wachtwoord . "
              
              Bewaar deze gegevens goed!
              
              Met vriendelijke groet,
              
              Het Ultima Casa team.",
                       "From: noreply@uc.nl")) {
            $result = 'De gegevens zijn naar uw e-mail adres verstuurd.';
        } else {
            $result = 'Fout bij het versturen van de e-mail met uw gegevens.';
        }
    } else {
        $result .= 'Fout bij het bewaren van uw gegevens.<br><br>' . $sql;
    }
    echo $result . '<br><br>
          <button class="action-button"><a href="index.html">Ok</a></button>';
} else {
    // Ongeldige aanvraag, stuur de gebruiker terug naar het registratieformulier of behandel de fout op een andere manier.
    header("Location: maakaccount.php");
    exit;
}
?>
