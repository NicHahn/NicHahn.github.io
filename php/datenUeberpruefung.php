<?php
// PHP-Mailer hinzufügen
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once 'phpmailer/src/Exception.php';
require_once 'phpmailer/src/PHPMailer.php';
const HTML_ERROR_START = '<div class="alert alert-danger" role="alert"><p class="m-0">';
const HTML_ERROR_END = '</p></div>';
const HTML_SUCCESS_START = '<div class="alert alert-success" role="alert"><p class="m-0">';
const HTML_SUCCESS_END = '</p></div>';
/**
 *  1. Überprüfung, ob das Formular abgesendet wurde, denn wir erhalten die Daten erst, wenn das Formular abgesendet wurde.
 */
if (isset($_POST['submit'])) {
  /**
   *  2. Alle Eingangsdaten filtern
   *  - Dazu verwenden wir die Funktion htmlspecialchars()
   *  - die Funktion trim() wird genutzt, um alle Leerzeichen am Anfang und Ende des Strings (Zeichenkette) zu entfernen
   */
  $name = htmlspecialchars(trim($_POST['name']));
  $email = htmlspecialchars(trim($_POST['email']));
  $subject = htmlspecialchars(trim($_POST['subject']));
  $message = htmlspecialchars(trim($_POST['message']));

  // Empfänger, nur zum Testen
  $receiver =  htmlspecialchars(trim($_POST['receiver']));
  /**
   *  3. Kriterienprüfung
   *  - Kriterien, wie z.B., wie viele Zeichen müssen mindestens eingegeben werden, ...
   *
   *  Was brauchen wir dafür?
   *  1. Array, welches die ganzen Fehler zugeordnet bekommt
   *
   *  Beachte:
   *  Alle Daten, welche durch das Formular abgesendet werden, sind erstmal Strings, dies heißt, dass man diese zuerst in deren gewünschten Typ umwandeln muss
   */
  $errors = [];
  $success = false;
  /**
   *  input textfeld | name="name"
   *  Typ: string
   *  Kriterien: mindestens 3 Zeichen lang
   */
  if (empty($name)) {
	$errors[] = HTML_ERROR_START . 'Bitte geben Sie Ihren Namen an!' . HTML_ERROR_END;
  } else if (strlen($name) < 3){
	$errors[] = HTML_ERROR_START . 'Der Name muss mindestens 3 Zeichen lang sein!' . HTML_ERROR_END;
  }
  /**
   *  input emailfeld | name="email"
   *  Typ: string
   *  Kriterien: mindestens 7 Zeichen lang
   */
  if (empty($email)) {
	$errors[] = HTML_ERROR_START . 'Bitte geben Sie Ihre E-Mail-Adresse an!' . HTML_ERROR_END;
  } else if (strlen($email) < 7) {
	$errors[] = HTML_ERROR_START . 'Die E-Mail-Adresse muss mindestens 7 Zeichen lang sein!' . HTML_ERROR_END;
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$errors[] = HTML_ERROR_START . 'Bitte geben Sie eine gültige E-Mail-Adresse an!' . HTML_ERROR_END;
  }
  /**
   *  input textfeld | name="subject"
   *  Typ: string
   *  Kriterien: mindestens 3 Zeichen lang, maximal 50 Zeichen lang
   */
  if (empty($subject)) {
	$errors[] = HTML_ERROR_START . 'Bitte geben Sie einen Betreff an!' . HTML_ERROR_END;
  } else if (strlen($subject) < 3) {
	$errors[] = HTML_ERROR_START . 'Der Betreff muss mindestens 3 Zeichen lang sein!' . HTML_ERROR_END;
  } else if (strlen($subject) > 50) {
	$errors[] = HTML_ERROR_START . 'Der Betreff darf maximal 50 Zeichen lang sein!' . HTML_ERROR_END;
  }
  /**
   *  textarea | name="message"
   *  Typ: string
   *  Kriterien: mindestens 10 Zeichen lang (man kann erwarten, dass eine Nachricht länger als 10 Zeichen lang ist)
   */
  if (empty($message)) {
	$errors[] = HTML_ERROR_START . 'Bitte geben Sie eine Nachricht an!' . HTML_ERROR_END;
  } else if (strlen($message) < 10) {
	$errors[] = HTML_ERROR_START . 'Die Nachricht muss mindestens 10 Zeichen lang sein!' . HTML_ERROR_END;
  }
  
  // nur zum Testen
  if (empty($receiver)) {
	$errors[] = HTML_ERROR_START . 'nici.hahn@web.de' . HTML_ERROR_END;
  }
  /**
   *  4. Überprüfung, ob Fehler vorhanden sind, wenn nicht, dann Mailversand ausführen
   *  - für den Mailversand verwenden wir den PHPMailer
   */
  if (count($errors) === 0) {
	$mailer = new PHPMailer();
	$mailer->CharSet = 'UTF-8'; // Charset setzen (für richtige Darstellung von Sonderzeichen/Umlauten)
	$mailer->setFrom($email, $name); // Absenderemail und -name setzen
	$mailer->addAddress($receiver); // Empfängeradresse
	$mailer->isHTML(true);
	$mailer->Subject = 'Neue Nachricht vom Kontaktformular'; // Betreff der Email
	$mailer->Body = '<h3>Neue Nachricht von: ' . $name . '</h3>
			   <h4>E-Mail-Adresse: ' . $email . '</h4>
			   <h2>Betreff: ' . $subject . '</h2>
			   <p>' . nl2br($message) . '</p>'; // Inhalt der Email
	/**
	 * Überprüfung, ob Mail abgesendet wurde, wenn nicht: Fehlermeldung ausgeben, wenn ja: Erfolgsmeldung ausgeben
	 */
	if (!$mailer->send()) {
	  $errors[] = HTML_ERROR_START . 'Es ist ein Fehler aufgetreten. Bitte versuchen Sie es in ein paar Minuten nochmal!' . HTML_ERROR_END;
	} else {
	  $success = HTML_SUCCESS_START . 'Ihre Nachricht wurde erfolgreich abgesendet!' . HTML_SUCCESS_END;
	}
  }
}