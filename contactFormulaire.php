<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Formulaire de reservation de salle</title>
	<script src="jquery-1.8.3.min.js"></script>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />
	<script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
	<script src="jquery.validate.js"></script>
	<script src="jquery-ui-timepicker-addon.js"></script>
	<link href="themes/default/css/jquery-ui-timepicker-addon.css" rel="stylesheet" type="text/css">
	<link href="themes/default/css/styles.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css" />
</head>
<?php
include "include/connect.inc.php";
include "include/config.inc.php";
include "include/misc.inc.php";
include "include/functions.inc.php";
include "include/$dbsys.inc.php";
include "include/mincals.inc.php";
include "include/mrbs_sql.inc.php";
$grr_script_name = "contactFormulaire.php";
require_once("./include/settings.inc.php");
if (!loadSettings())
	die("Erreur chargement settings");
require_once("./include/session.inc.php");
include "include/language.inc.php";
?>
<body>
<?php
echo "<form class='contactreservation' id=\"contactreservation\" name=\"contactreservation\" action=''>";
echo " <fieldset><legend><b>Vos coordonnées</b></legend>";
echo "<br />";
echo " <label for=\"nom\"> &nbsp ".get_vocab("nomR")." &nbsp : &nbsp </label><input class=\"form-control\" type=\"text\" id=\"nom\"  size=\"8\"name=\"nom\">";
echo " <label for=\"prenom\"> &nbsp Prenom &nbsp : &nbsp &nbsp</label><input class=\"form-control\" type=\"text\" size=\"8\" id=\"prenom\"  name=\"prenom\">";
echo "<label for=\"email\">&nbsp Email &nbsp : &nbsp</label><input class=\"form-control\" type=\"text\" id=\"email\" size=\"8\" name=\"email\" />";
echo "<label for=\"telephone\"> Téléphone :  &nbsp</label><input class=\"form-control\" type=\"text\" size=\"8\" maxlength=\"14\" id=\"telephone\" name=\"telephone\"  /><br/><br/>";
echo "</fieldset>";
echo "<br />";
echo "<fieldset><legend><b>Réservation</b></legend>";
echo "  <label for=\"subject\">Sujet :</label><br/>";
echo "<br />";
echo " <textarea class=\"form-control\" id=\"subject\" name=\"sujet\" cols=\"30\" rows=\"4\"></textarea><br/>";
echo "<br />";
echo "  <label for=\"domaine\">Domaines : </label>";
echo " <select id=\"area\" name=\"area\">";
echo "<optgroup label=\"Domaines\">";
$sql_areaName = "SELECT id,area_name FROM ".TABLE_PREFIX."_area order by area_name";
$res_areaName = grr_sql_query($sql_areaName);
for ($i = 0; ($row_areaName = grr_sql_row($res_areaName, $i)); $i++)
{
	$id = $row_areaName[0];
	$area_name = $row_areaName[1];
	echo "<option onclick=\"\" value=\"$id\"> $area_name</option>";
}
echo "</select>";
?>
<script>
	$(document).ready(function() {
	var $domaine = $('#area');
	var $salle = $('#room');
	$domaine.on('change', function() {
		var id = $(this).attr("value");
		if (id != '') {
			$salle.empty();
			jQuery.ajax({
							type: 'GET',
							url: 'frmcontactlist.php',
							data: {
									 id: id
									},
									success: function(returnData){
							$("#room").html(returnData);
							},
							error: function(returnData){
								alert('Erreur lors de l execution de la commande AJAX  ');
							}
						});
		}
	});
});
</script>
<?php
echo " <label for=\"ressource\">Ressources : </label>";
echo " <select id=\"room\" name=\"room\">";
echo "<optgroup label=\"Salles\">";
echo " <option > SELECTIONNER UN DOMAINE </option>";
echo "</select>";
echo "<br /><br />";
echo "<fieldset><legend><b> Début de la réservaton</b></legend>";
echo "<br />";
jQuery_DatePicker('start');
echo "&nbsp";
echo " <select name=\"heure\"> ";
for ($h = 1 ; $h < 24 ; $h++)
{
	echo "<option value =\"$h\"> ".sprintf("%02d",$h)."h </option>";
}
echo "</select>";
echo " <select name=\"minutes\"> ";
for ($m = 00 ; $m < 60 ; $m = $m + 30)
{
	echo "<option value =\"$m\"> ".sprintf("%02d",$m)."min </option>";
}
echo "</select>";
echo "&nbsp &nbsp";
echo "<br><br>";
echo " <label for=\"duree\">Durée :   </label><input class=\"form-control\" type=\"text\" id=\"duree\" name=\"duree\" size=\"2\" maxlength=\"2\" tabindex=\"5\" />";
echo "&nbsp";
echo "<select name=\"typeDuree\">";
$units = array("heures");
for ($s = 0; $s < sizeof($units); $s++)
{
	echo "<option value=\"$units[$s]\">$units[$s] </option>";
}
echo "</select>\n";
echo "</fieldset><br/>";
echo "<div id=\"planning\" style=\"margin-left:0px;\"\>";
echo "<div id=\"buttonsReservation\" style=\"margin-left:0px;\"\>";
echo " <input class=\"btn btn-primary\" type=\"submit\" name=\"submit\" value=\"Envoyer la demande de réservation\" />";
echo "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp";
echo " <input class=\"btn btn-primary\" type=\"reset\" name=\"cancel\" value=\"Annuler\" />";
echo "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp ";
echo "<a href='javascript:history.go(-1)'><input class=\"btn btn-primary\" type=\"button\" name=\"retouraccueil\" value=\"Retour à l'accueil\" /></a>";
echo "</div>";
echo " </div>";
echo " </form>";
?>
<script src="jquery.validate.js"></script>
<script >
	jQuery.validator.setDefaults({
		debug: true,
		success: "valid",
		onsubmit: true
	});
	$(" #contactreservation").validate({
		rules: {
			nom: {
				required: true
			},
			prenom: {
				required: true
			},
			email: {
				required: true,
				email: true
			},
			telephone: {
				required: true,
				digits: true
			},
			duree: {
				required: true,
				digits: true
			}
		}
	});
</script>
</body>
</html>