<?php
include "include/connect.inc.php";
include "include/config.inc.php";
include "include/misc.inc.php";
include "include/functions.inc.php";
include "include/$dbsys.inc.php";
include "include/mincals.inc.php";
include "include/mrbs_sql.inc.php";
$grr_script_name = "pdfgenerator.php";
require_once("./include/settings.inc.php");
if (!loadSettings())
	die("Erreur chargement settings");
require_once("./include/session.inc.php");
include "include/resume_session.php";
include "include/language.inc.php";
setlocale(LC_TIME, 'french');
if (isset($_POST['civ']))
{
	$logo = $_POST['logo'];
	$etablisement = $_POST['etat'];
	$civ = $_POST['civ'];
	$nom = $_POST['nom'];
	$orga = $_POST['orga'];
	$prenom = $_POST['prenom'];
	$adresse = $_POST['adresse'];
	$ville = $_POST['ville'];
	$cp = $_POST['cp'];
	$id = $_POST['id'];
	$salle = $_POST['salle'];
	$jour = $_POST['jour'];
	$date = $_POST['date'];
	$heure = $_POST['heure'];
	$heure2 = $_POST['heure2'];
	$jour2 = $_POST['jour2'];
	$cle = $_POST['cle'];
	echo '<!DOCTYPE html>
	<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	</head>
	<body>
		<div id="pdf">
				<div class="row">
					<div class="col-md-1">
						<img src="'.$logo.'" width="100" height="100" alt="logo">
					</div>
					<div class="col-md-4 col-md-offset-7">
						'.$etablisement.'
					</div>
				</div>
				<br>
				<br>
				<br>
				<br>
				<br>
				<div class="row">
					<div class="col-md-4 col-md-offset-8">
						<address>
							'.$civ.' '.$prenom.' '.$nom.'<br>
							'.$orga.'<br>
							'.$adresse.'<br>
							'.$cp.' '.$ville.'
						</address>
					</div>
				</div>
				<br>
				<br>
				<br>
				<br>
				<br>
				<div class="col-md-4">
					<strong>Objet : Réservation de salle</strong>
				</div>

				<br>
				<br>
				<br>

				<div class="row">
					<div class="col-md-8 col-md-offset-1">
						'.$civ.',<br>
						Comme suite à votre demande du '.$date.' dernier,<br><br>
						J\'ai le plaisir de vous informer que la salle '.$salle.' sera mise à votre disposition,
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<br>
						<strong>Du '.$jour.' à '.$heure.'</strong>
						<br>
						<strong>Au  '.$jour2.' à '.$heure2.'</strong>
						<br>
						<br>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8 col-md-offset-1">
						Vous pourrez retirer les clés auprès du service '.$cle.'. Eles devront être remises immédiatement après dans la boîte aux letres de la Mairie.<br><br>
						Restant à votre disposition pour tous renseignements complémentaires,<br>
						Je vous prie de croire, '.$civ.', à l\'assurance des mes sentiments les meilleurs.
					</div>
				</div>
				<br>
				<br>
				<br>
				<br>
				<br>
				<div class="row">
					<div class="col-md-3 col-md-offset-7">
						Signature
					</div>
				</div>
			</div>
		<script src="http://html2canvas.hertzen.com/build/html2canvas.js"></script>
		<script type="text/javascript" src="js/jspdf.min.js"></script>
		<script type="text/javascript">
			var pdf = new jsPDF(\'p\',\'pt\',\'a4\');

			pdf.addHTML(document.body,function() {
				pdf.output(\'dataurl\');
			});
</script>
</body>
</html>';
}

else
{
	if (isset($_GET['id']))
		$id = $_GET['id'];
	else
		header('Location: '.getSettingValue("grr_url"));
	$sql = "SELECT * FROM ".TABLE_PREFIX."_entry WHERE id='".$id."'";
	$res = grr_sql_query($sql);
	if (!$res)
		fatal_error(0, grr_sql_error());
	$row = grr_sql_row($res, 0);
	$sql = "SELECT room_name FROM ".TABLE_PREFIX."_room WHERE id='".$row[5]."'";
	$res = grr_sql_query($sql);
	$row2 = grr_sql_row($res, 0);
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	</head>
	<body>
		<form method="post" class="contact-us" action="pdfgenerator.php" target="_blank">
			<h2>Test de formulaire</h2>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
				<input list="civ" class="form-control" placeholder="Civilité" name="civ" type="text" required>
				<datalist id="civ">
					<option value="Monsieur"></option>
					<option value="Madame"></option>
				</datalist>
			</div>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
				<input class="form-control" placeholder="Nom" name="nom" type="text" required>
			</div>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
				<input class="form-control" placeholder="Prénom" name="prenom" type="text" required>
			</div>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
				<input class="form-control" placeholder="Organisme" name="orga" type="text" value="<?php echo $row[10]; ?>" required>
			</div>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>
				<input  class="form-control" placeholder="Adresse" type="text" name="adresse" required>
			</div>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
				<input class="form-control" placeholder="Etablissement" name="etat" type="text" value="<?php echo getSettingValue("company"); ?>" required>
			</div>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
				<input class="form-control" placeholder="Ville" name="ville" type="text" required>
			</div>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
				<input class="form-control" placeholder="Code postal" name="cp" type="text" required>
			</div>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
				<input class="form-control" placeholder="Clé" name="cle" type="text" required>
			</div>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
				<input class="form-control" placeholder="Date de la demande" name="date" type="text" value="<?php echo utf8_encode(strftime('%A %d %B %Y' ,strtotime($row[6]))); ?>" required>
			</div>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
				<input class="form-control" placeholder="Id de la reservation" name="id" type="text" value="<?php echo $id; ?>"required>
			</div>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
				<input class="form-control" placeholder="Salle" name="salle" type="text" value="<?php echo $row2[0]; ?>" required>
			</div>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
				<input class="form-control" placeholder="jour" name="jour" type="text" value="<?php echo utf8_encode(strftime('%A %d %B %Y' ,$row[1])); ?>" required>
			</div>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
				<input class="form-control" placeholder="Heure de début" name="heure" type="text" value="<?php echo strftime('%H:%M' ,$row[1]); ?>" required>
			</div>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
				<input class="form-control" placeholder="jour2" name="jour2" type="text" value="<?php echo utf8_encode(strftime('%A %d %B %Y' ,$row[2])); ?>" required>
			</div>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
				<input class="form-control" placeholder="Heure de fin" name="heure2" type="text" value="<?php echo strftime('%H:%M' , $row[2]); ?>" required>
			</div>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
				<input class="form-control" placeholder="Logo" name="logo" type="text" value="images/<?php echo getSettingValue("logo"); ?>" required>
			</div>

			<div class="control-group">
				<div class="controls">
					<button type="submit" value="ok" class="btn btn-primary" >Envoyer</button>
				</div>
			</div>
		</form>
	</body>
	</html>
	<?php
}
?>
