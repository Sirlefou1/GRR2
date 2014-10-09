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
	if ((getSettingValue("authentification_obli") == 0) && (getUserName() == ''))
		$type_session = "no_session";
	print_header("", "", "", "", $type_session);
	?>
	<form class='contactreservation' id="contactreservation" name="contactreservation" action=''>
		<fieldset><legend><b>Vos coordonnées</b></legend>
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
					<input class="form-control" type="text" id="nom"  size="8" name="nom" placeholder="Votre nom" />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-addon"><span class="glyphicon glyphicon-user"></div>
					<input class="form-control" type="text" size="8" id="prenom"  name="prenom" placeholder="Votre prénom" />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></div>
					<input class="form-control" type="text" id="email" size="8" name="email" placeholder="Votre adresse de courriel" />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-addon"><span class="glyphicon glyphicon-earphone"></div>
					<input class="form-control" type="text" size="8" maxlength="14" id="telephone" name="telephone" placeholder="Votre numéro de téléphone" />
				</div>
			</div>
		</fieldset>
		<fieldset><legend><b>Réservation</b></legend>
			<label for="subject">Sujet :</label>
			<textarea class="form-control" id="subject" name="sujet" cols="30" rows="4"></textarea><br/>
			<label for="domaine">Domaines : </label>
			<select id="area" name="area" class="form-control">
				<?php
				$sql_areaName = "SELECT id, area_name FROM ".TABLE_PREFIX."_area ORDER BY area_name";
				$res_areaName = grr_sql_query($sql_areaName);
				for ($i = 0; ($row_areaName = grr_sql_row($res_areaName, $i)); $i++)
				{
					if (authUserAccesArea(getUserName(),$row_areaName[0]) == 1)
					{
						$id = $row_areaName[0];
						$area_name = $row_areaName[1];
						echo '<option onclick="" value="'.$id.'"> '.$area_name.'</option>'.PHP_EOL;
					}
				}
				?>
			</select>
			<script>
				$(document).ready(function()
				{
					var $domaine = $('#area');
					var $salle = $('#room');
					$domaine.on('change', function()
					{
						var id = $(this).attr("value");
						if (id != '')
						{
							$salle.empty();
							jQuery.ajax({
								type: 'GET',
								url: 'frmcontactlist.php',
								data: {
									id: id
								},
								success: function(returnData)
								{
									$("#room").html(returnData);
								},
								error: function(returnData)
								{
									alert('Erreur lors de l execution de la commande AJAX  ');
								}
							});
						}
					});
				});
			</script>
			<label for="ressource">Ressources : </label>
			<select id="room" name="room" class="form-control">
				<optgroup label="Salles">
					<option> SELECTIONNER UN DOMAINE </option>
				</select>
				<fieldset><legend><b> Début de la réservaton</b></legend>
					<?php
					jQuery_DatePicker('start');
					//echo "&nbsp";
					echo " <select name=\"heure\"> ";
					for ($h = 1 ; $h < 24 ; $h++)
					{
						echo "<option value =\"$h\"> ".sprintf("%02d",$h)."h </option>".PHP_EOL;
					}
					echo "</select>";
					echo " <select name=\"minutes\"> ";
					for ($m = 00 ; $m < 60 ; $m = $m + 30)
					{
						echo "<option value =\"$m\"> ".sprintf("%02d",$m)."min </option>".PHP_EOL;
					}
					echo "</select>".PHP_EOL;
					//echo "&nbsp &nbsp".PHP_EOL;
					echo "<br><br>".PHP_EOL;
					echo " <label for=\"duree\">Durée :   </label><br /><div class=\"col-xs-2\"><input class=\"form-control\" type=\"text\" id=\"duree\" name=\"duree\" size=\"2\" maxlength=\"2\" tabindex=\"5\" /></div>".PHP_EOL;
					echo "&nbsp<div class=\"col-xs-1\">".PHP_EOL;
					echo '<select name="typeDuree" class="form-control">'.PHP_EOL;
					$units = array("heures");
					for ($s = 0; $s < sizeof($units); $s++)
					{
						echo "<option value=\"$units[$s]\">$units[$s] </option>".PHP_EOL;
					}
					?>
				</select>
			</div>
		</fieldset>
		<br/>
		<div id="planning" style="margin-left:0px;">
			<div id="buttonsReservation" style="margin-left:0px;">
			<input class="btn btn-primary" type="submit" name="submit" value="Envoyer la demande de réservation">
				<input class="btn btn-primary" type="reset" name="cancel" value="Annuler">
				<a href='javascript:history.go(-1)'>
					<input class="btn btn-primary" type="button" name="retouraccueil" value="Retour à l'accueil">
				</a>
			</div>
		</div>
	</form>
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