<?php
/*-----MAJ Loïs THOMAS  --> Page de traitement du formulaire contact.php -----*/
include "include/connect.inc.php";
include "include/config.inc.php";
include "include/misc.inc.php";
include "include/$dbsys.inc.php";
include "include/mrbs_sql.inc.php";
$grr_script_name = "week_all.php";
// Settings
require_once("./include/settings.inc.php");
$msg_erreur = "Erreur. Les champs suivants doivent être obligatoirement
remplis :<br/><br/>";
$msg_ok = "Votre demande a bien été prise en compte.";
$message = $msg_erreur;
define('MAIL_DESTINATAIRE','informatique@talmontsainthilaire.fr');
define('MAIL_SUJET','GRR : Réservation d\'une salle ');
 // vérification des champs
if (empty($_POST['nom']))
	$message .= "Votre nom";
if (empty($_POST['prenom']))
	$message .= "Votre prénom<br/>";
if (empty($_POST['email']))
	$message .= "Votre adresse email<br/>";
if (empty($_POST['subject']))
	$message .= "Le sujet de votre demande<br/>";
if (empty($_POST['area']))
	$message .= "Le domaine n'est pas rempli<br/>";
if (empty($_POST['room']))
	$message .= "Aucune salle de choisie<br/>";
if (empty($_POST['jours']))
	$message .= "Aucune jours choisi <br/>";
if (empty($_POST['mois']))
	$message .= "Aucune mois choisi <br/>";
if (empty($_POST['année']))
	$message .= "Aucune année choisie <br/>";
if (empty($_POST['duree']))
	$message .= "Aucune durée choisie <br/>";
foreach ($_POST as $index => $valeur)
	$$index = stripslashes(trim($valeur));
//Préparation de l'entête du mail:
$mail_entete  = "MIME-Version: 1.0\r\n";
$mail_entete .= "From: {$_POST['nom']} "
."<{$_POST['email']}>\r\n";
$mail_entete .= 'Reply-To: '.$_POST['email']."\r\n";
$mail_entete .= 'Content-Type: text/plain; charset="iso-8859-1"';
$mail_entete .= "\r\nContent-Transfer-Encoding: 8bit\r\n";
$mail_entete .= 'X-Mailer:PHP/' . phpversion()."\r\n";
// préparation du corps du mail
$mail_corps  = "Message de :" .$_POST['prenom']." " .$_POST['nom'] . " \n";
$mail_corps  = "Message de :" .$_POST['prenom']." " .$_POST['nom'] . "<br/>";
$mail_corps  = "Email : ".$_POST['email']. "<br/>";
$mail_corps  = "Téléphone : ".$_POST['telephone']. "<br/><br/>";
$mail_corps  = "<b> Sujet de la réservation :".$_POST['sujet']. "</b><br/><br/>";
//Pour récupérer le nom de domaine
$id = $_POST['area'] ;
$sql_areaName = "SELECT area_name FROM ".TABLE_PREFIX."_area where id = \"$id\" ";
$res_areaName = grr_sql_query1($sql_areaName);
$mail_corps  = "Domaines : ".$res_areaName. "<br/> ";
$mail_corps  = "Salle : ".$_POST['room']. "<br/><br/>";
$mail_corps  = "Date  :".$_POST['jours']."/".$_POST['mois']."/".$_POST['annee']. " <br/>";
$mail_corps  = "Heure réservation  : ".$_POST['heure']. "h  ".$_POST['minutes']. "min<br/>";
$mail_corps  = "Durée de la réservation : ".$_POST['duree']. " \n";
$typeDuree = $_POST['typeDuree'];
$typeDureetexte ;
switch($typeDuree)
{
	case 0:
		$typeDureetexte = "minutes";
	break ;
	case 1:
		$typeDureetexte = "heures";
	break ;
	case 2:
		$typeDureetexte = "jours";
	break ;
	case 3:
		$typeDureetexte = "semaines";
}
$mail_corps = $typeDureetexte ;
// envoi du mail
if (mail(MAIL_DESTINATAIRE,MAIL_SUJET,$mail_corps,$mail_entete))
	echo $msg_ok;
else
	echo "Une erreur est survenue lors de l'envoi du formulaire par email<br/><br/>";
?>
