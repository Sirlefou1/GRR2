<?php
/**
 * edit_entry.php
 * Interface d'édition d'une réservation
 * Ce script fait partie de l'application GRR
 * Dernière modification : $Date: 2010-04-07 15:38:14 $
 * @author    Laurent Delineau <laurent.delineau@ac-poitiers.fr>
 * @copyright Copyright 2003-2008 Laurent Delineau
 * @link      http://www.gnu.org/licenses/licenses.html
 * @package   root
 * @version   $Id: edit_entry.php,v 1.17 2010-04-07 15:38:14 grr Exp $
 * @filesource
 *
 * This file is part of GRR.
 *
 * GRR is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * GRR is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with GRR; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */
/**
 * $Log: edit_entry.php,v $
 * Revision 1.17  2010-04-07 15:38:14  grr
 * *** empty log message ***
 *
 * Revision 1.16  2009-12-16 14:52:31  grr
 * *** empty log message ***
 *
 * Revision 1.15  2009-09-29 18:02:56  grr
 * *** empty log message ***
 *
 * Revision 1.14  2009-06-04 15:30:17  grr
 * *** empty log message ***
 *
 * Revision 1.13  2009-04-14 12:59:17  grr
 * *** empty log message ***
 *
 * Revision 1.12  2009-04-09 14:52:31  grr
 * *** empty log message ***
 *
 * Revision 1.11  2009-03-24 13:30:07  grr
 * *** empty log message ***
 *
 * Revision 1.10  2009-02-27 22:05:03  grr
 * *** empty log message ***
 *
 * Revision 1.9  2009-02-27 13:28:19  grr
 * *** empty log message ***
 *
 * Revision 1.8  2009-01-20 07:19:17  grr
 * *** empty log message ***
 *
 * Revision 1.7  2008-11-16 22:00:58  grr
 * *** empty log message ***
 *
 * Revision 1.6  2008-11-13 21:32:51  grr
 * *** empty log message ***
 *
 * Revision 1.5  2008-11-11 22:01:14  grr
 * *** empty log message ***
 *
 *
 */

ini_set('display_errors', 'On');
error_reporting(E_ALL);
include "include/admin.inc.php";
$grr_script_name = "edit_entry.php";
// Initialisation
if (isset($_GET["id"]))
{
	$id = $_GET["id"];
	settype($id, "integer");
}
else
	$id = NULL;
$period = isset($_GET["period"]) ? $_GET["period"] : NULL;
if (isset($period))
	settype($period,"integer");
if (isset($period))
	$end_period = $period;
$edit_type = isset($_GET["edit_type"]) ? $_GET["edit_type"] : NULL;
if (!isset($edit_type))
	$edit_type = "";
// si $edit_type = "series", cela signifie qu'on édite une "périodicité"
$page = verif_page();
if (isset($_GET["hour"]))
{
	$hour = $_GET["hour"];
	settype($hour, "integer");
	if ($hour < 10)
		$hour = "0".$hour;
}
else
	$hour = NULL;
if (isset($_GET["minute"]))
{
	$minute = $_GET["minute"];
	settype($minute,"integer");
	if ($minute < 10)
		$minute = "0".$minute;
}
else
	$minute = NULL;
$rep_num_weeks='';
global $twentyfourhour_format;
//Si nous ne savons pas la date, nous devons la créer
if (!isset($day) || !isset($month) || !isset($year))
{
	$day   = date("d");
	$month = date("m");
	$year  = date("Y");
}
// s'il s'agit d'une modification, on récupère l'id de l'area et l'id de la room
if (isset($id))
{
	if ($info = mrbsGetEntryInfo($id))
	{
		$area  = mrbsGetRoomArea($info["room_id"]);
		$room = $info["room_id"];
	}
	else
	{
		$area = -1;
		$room = -1;
	}
}
else
{
	// Il s'agit d'une nouvelle réservation
	// Construction des identifiants de la ressource $room, du domaine $area, du site $id_site
	Definition_ressource_domaine_site();
}
// Fichiers de personnalisation de langue pour le domaine
if (@file_exists("language/lang_subst_".$area.".".$locale))
	include "language/lang_subst_".$area.".".$locale;
// Récupération des données concernant l'affichage du planning du domaine
get_planning_area_values($area);
// Affiche-t-on le message "Les champs marqués d'un * sont obligatoires." ?
$affiche_mess_asterisque = false;
// Récupération d'info sur la rerssource
$type_affichage_reser = grr_sql_query1("select type_affichage_reser from ".TABLE_PREFIX."_room where id='".$room."'");
$delais_option_reservation  = grr_sql_query1("select delais_option_reservation from ".TABLE_PREFIX."_room where id='".$room."'");
$qui_peut_reserver_pour  = grr_sql_query1("select qui_peut_reserver_pour from ".TABLE_PREFIX."_room where id='".$room."'");
$back = '';
if (isset($_SERVER['HTTP_REFERER']))
	$back = htmlspecialchars( $_SERVER['HTTP_REFERER']);

$longueur_liste_ressources_max = getSettingValue("longueur_liste_ressources_max");
if ($longueur_liste_ressources_max == '')
	$longueur_liste_ressources_max = 20;
//Vérification de la présence de réservations
if (check_begin_end_bookings($day, $month, $year))
{
	if ((getSettingValue("authentification_obli") == 0) && (getUserName() == ''))
		$type_session = "no_session";
	else
		$type_session = "with_session";
	showNoBookings($day, $month, $year, $area, $back, $type_session);
	exit();
}
//Vérification des droits d''accès
if ((authGetUserLevel(getUserName(), -1) < 2) && (auth_visiteur(getUserName(), $room) == 0))
{
	showAccessDenied($day, $month, $year, $area,$back);
	exit();
}
if (authUserAccesArea(getUserName(), $area) == 0)
{
	showAccessDenied($day, $month, $year, $area,$back);
	exit();
}
if (isset($id) && ($id!=0))
	$compt = 0; // il s'agit d'une modification : on ne compte pas cette résa dans le nombre de réservations déjà effectuées
else
	$compt = 1; // il s'agit d'une nouvelle réservation : on la compte dans le nombre de réservations déjà effectuées

if (UserRoomMaxBooking(getUserName(), $room, $compt) == 0)
{
	showAccessDeniedMaxBookings($day, $month, $year, $area, $room, $back);
	exit();
}
//Vérification si l'on édite une périodicité ($edit_type = "series") ou bien une réservation simple
/*
* Cette page peut ajouter ou modifier une réservation
* Nous devons savoir:
*  - Le nom de la personne qui a réservé
*  - La description de la réservation
*  - La Date (option de sélection pour le jour, mois, année)
*  - L'heure
*  - La durée
*  - Le statut de la réservation en cours
* Premièrement nous devons savoir si c'est une nouvelle réservation ou bien une modification
* Si c'est une modification, nous devons reprendre toute les informations de cette réservation
* Si l'ID est présente, c'est une modification
*/
//Hugo - Mise en place de la page view entry avec des rows quand la réservation existe deja
if (isset($id))
{
	$sql = "select name, beneficiaire, description, start_time, end_time,
	type, room_id, entry_type, repeat_id, option_reservation, jours, create_by, beneficiaire_ext, statut_entry from ".TABLE_PREFIX."_entry where id=$id";
	$res = grr_sql_query($sql);
	if (!$res)
		fatal_error(1, grr_sql_error());
	if (grr_sql_count($res) != 1)
		fatal_error(1, get_vocab('entryid') . $id . get_vocab('not_found'));
	$row = grr_sql_row($res, 0);
	grr_sql_free($res); //fonction qui supprime le contenu de $res (surement ?)
	$breve_description  = $row[0];
	$beneficiaire     	= $row[1];
	$beneficiaire_ext   = $row[12];
	$tab_benef 			= donne_nom_email($beneficiaire_ext);
	$create_by    		= $row[11];
	$description 		= $row[2];
	$statut_entry 		= $row[13];
	$start_day   = strftime('%d', $row[3]); // On utilise la fonction strftime pour repasser la date en format UNIX au format francçais
	$start_month = strftime('%m', $row[3]);
	$start_year  = strftime('%Y', $row[3]);
	$start_hour  = strftime('%H', $row[3]);
	$start_min   = strftime('%M', $row[3]);
	$end_day   = strftime('%d', $row[4]);
	$end_month = strftime('%m', $row[4]);
	$end_year  = strftime('%Y', $row[4]);
	$end_hour  = strftime('%H', $row[4]);
	$end_min   = strftime('%M', $row[4]);
	$duration    = $row[4]-$row[3];
	$type        = $row[5];
	$room_id     = $row[6];
	$entry_type  = $row[7];
	$rep_id      = $row[8];
	$option_reservation  = $row[9];
	$jours_c = $row[10];
	$modif_option_reservation = 'n';
	if ($entry_type >= 1)
	// il s'agit d'une réservation à laquelle est associée une périodicité
	{
		$sql = "SELECT rep_type, start_time, end_date, rep_opt, rep_num_weeks, end_time, type, name, beneficiaire, description
		FROM ".TABLE_PREFIX."_repeat WHERE id='".protect_data_sql($rep_id)."'";
		$res = grr_sql_query($sql);
		if (!$res)
			fatal_error(1, grr_sql_error());
		if (grr_sql_count($res) != 1)
			fatal_error(1, get_vocab('repeat_id') . $rep_id . get_vocab('not_found'));
		$row = grr_sql_row($res, 0);
		grr_sql_free($res);
		$rep_type = $row[0];
		if ($rep_type == 2)
			$rep_num_weeks = $row[4];
		if ($edit_type == "series")
		{
			// on edite la périodicité associée à la réservation et non la réservation elle-même
			$start_day   = (int)strftime('%d', $row[1]);
			$start_month = (int)strftime('%m', $row[1]);
			$start_year  = (int)strftime('%Y', $row[1]);
			$start_hour  = (int)strftime('%H', $row[1]);
			$start_min   = (int)strftime('%M', $row[1]);
			$duration    = $row[5]-$row[1];
			$end_day   = (int)strftime('%d', $row[5]);
			$end_month = (int)strftime('%m', $row[5]);
			$end_year  = (int)strftime('%Y', $row[5]);
			$end_hour  = (int)strftime('%H', $row[5]);
			$end_min   = (int)strftime('%M', $row[5]);
			$rep_end_day   = (int)strftime('%d', $row[2]);
			$rep_end_month = (int)strftime('%m', $row[2]);
			$rep_end_year  = (int)strftime('%Y', $row[2]);
			$type = $row[6];
			$breve_description = $row[7];
			$beneficiaire = $row[8];
			$description = $row[9];
			if ($rep_type == 2)
			{
			  // Toutes les n-semaines
				$rep_day[0] = $row[3][0] != '0';
				$rep_day[1] = $row[3][1] != '0';
				$rep_day[2] = $row[3][2] != '0';
				$rep_day[3] = $row[3][3] != '0';
				$rep_day[4] = $row[3][4] != '0';
				$rep_day[5] = $row[3][5] != '0';
				$rep_day[6] = $row[3][6] != '0';
			}
			else
				$rep_day = array(0, 0, 0, 0, 0, 0, 0);
		}
		else
		{
			// on edite la réservation elle-même et non pas de périodicité associée
			$rep_end_date = strftime($dformat,$row[2]);
			$rep_opt      = $row[3];
			// On récupère les dates de début et de fin pour l'affichage des infos de périodicité
			$start_time = $row[1];
			$end_time 	= $row[5];
		}
	}
	else
	{
		// il s'agit d'une réservation sans periodicité associée
		$flag_periodicite = 'y'; // on permet d'afficher les options de périodicité
		// On initialise les périodicité
		$rep_id        = 0;
		$rep_type      = 0;
		$rep_end_day   = $day;
		$rep_end_month = $month;
		$rep_end_year  = $year;
		$rep_day       = array(0, 0, 0, 0, 0, 0, 0);
		$rep_jour      = 0;  // pour les Jours/Cycle
	}
}
else
{
	//Ici, c'est une nouvelle réservation, les donnée arrivent quelque soit le boutton selectionné. (A VOIR)
	if ($enable_periods == 'y')
		$duration    = 60;
	else
	{
		$duree_par_defaut_reservation_area = grr_sql_query1("select duree_par_defaut_reservation_area from ".TABLE_PREFIX."_area where id='".$area."'");
		if ($duree_par_defaut_reservation_area == 0)
			$duree_par_defaut_reservation_area = $resolution;
		$duration = $duree_par_defaut_reservation_area ;
	}
	$edit_type = "series";
	if (getSettingValue("remplissage_description_breve")=='2')
		$breve_description = $_SESSION['prenom']." ".$_SESSION['nom'];
	else
		$breve_description = "";
	$beneficiaire   = getUserName();
	$tab_benef["nom"] = "";
	$tab_benef["email"] = "";
	$create_by    = getUserName();
	$description = "";
	$start_day   = $day; // $day est le jour passé dans l'url
	$start_month = $month; // dans l'url
	$start_year  = $year; // dans l'url
	$start_hour  = $hour; // dans l'url
	(isset($minute)) ? $start_min = $minute : $start_min ='00';
	//On met la date de fin de periodicité
	if ($enable_periods=='y')
	{
		$end_day   = $day; // $day est le jour passé dans l'url
		$end_month = $month;  //dans l'url
		$end_year  = $year; // dans l'url
		$end_hour  = $hour; // dans l'url
		(isset($minute)) ? $end_min = $minute : $end_min ='00';
	}
	else
	{
		// On fabrique un timestamp
		$now = mktime($hour, $minute, 0, $month, $day, $year);
		$fin = $now + $duree_par_defaut_reservation_area;
		$end_day   = date("d",$fin); // si on a pas $day dans l'url, on prend la date actuelle
		$end_month = date("m",$fin);
		$end_year  = date("Y",$fin);
		$end_hour  = date("H",$fin);
		$end_min = date("i",$fin);
	}
	$type        	= "";
	$room_id    	= $room;
	$id				= 0;
	$rep_id 		= 0;
	$rep_type 		= 0;
	$rep_end_day 	= $day;
	$rep_end_month 	= $month;
	$rep_end_year  	= $year;
	$rep_day       	= array(0, 0, 0, 0, 0, 0, 0); //tableau des jours de répétition
	$rep_jour      	= 0;  // pour les Jours/Cycle
	//$option_reservation = mktime(0,0,0,date("m"),date("d"),date("Y"));
	$option_reservation = -1;
	$modif_option_reservation = 'y';
}
// Si Err=yes il faudra recharger la saisie
if ( isset($_GET["Err"]))
	$Err = $_GET["Err"];
//Transforme $duration en un nombre entier
if ($enable_periods=='y')
	toPeriodString($start_min, $duration, $dur_units);
else
	toTimeString($duration, $dur_units, true);
//Maintenant nous connaissons tous les champs
if (!getWritable($beneficiaire, getUserName(),$id))
{
	showAccessDenied($day, $month, $year, $area,$back);
	exit;
}
// On cherche s'il y a d'autres domaines auxquels l'utilisateur a accès
$nb_areas = 0;
$sql = "select id, area_name from ".TABLE_PREFIX."_area";
$res = grr_sql_query($sql);
$allareas_id = array();
if ($res)
{	
	for ($i = 0; ($row = grr_sql_row($res, $i)); $i++)
	{
		array_push($allareas_id,$row[0]);
		if (authUserAccesArea(getUserName(), $row[0]) == 1)
			$nb_areas++;
	}
}
// Utilisation de la bibliothèque !prototype! dans ce script
//MAJ Hugo FORESTIER - La bibliothèque prototype est remplacé par la bibliothèque jQuery (sans changer le nom de la variable) => A FAIRE
//25/05/2013
$use_prototype = 'y';
//Hugo - Enlever le header pour permettre un meilleure affichage de edit_entry en mode popup (A VOIR)
print_header($day, $month, $year, $area);
?>
<script type="text/javascript" >
function insertChampsAdd(){
	new Ajax.Updater($('div_champs_add'),"edit_entry_champs_add.php",{method: 'get', parameters: $('areas').serialize(true)+'&'+'id=<?php echo $id; ?>&'+'room=<?php echo $room; ?>'});
}
function insertTypes(){
	new Ajax.Updater($('div_types'),"edit_entry_types.php",{method: 'get',parameters: $('areas').serialize(true)+'&'+'type=<?php echo $type; ?>&'+'room=<?php echo $room; ?>'});
}
function insertProfilBeneficiaire(){
	new Ajax.Updater($('div_profilBeneficiaire'),"edit_entry_beneficiaire.php",{method: 'get', parameters: $('beneficiaire').serialize(true)+'&'+'identifiant_beneficiaire=<?php echo $beneficiaire; ?>'});
}
//MAJ Hugo FORESTIER - Mise à jour des fonctions précedentes (prototype) en jQuery
//27/05/2013
jQuery.ajax({
	type: 'GET',
  url: 'edit_entry_champs_add.php', // La requete est envoyé vers edit_entry_champs_add.php
  data: {
	areas:'<?php echo $area; ?>', // Les donnees envoyés au serveur au format JSON
	id: '<?php echo $id; ?>',
	room: '<?php echo $room; ?>',
},
success: function(returnData){
	$("#div_champs_add").html(returnData);
},
error: function(data){
	alert('Erreur lors de l execution de la commande AJAX pour le edit_entry_champs_add.php ');
}
});

jQuery.ajax({
	type: 'GET',
	url: 'edit_entry_types.php',
	data: {
		areas:'<?php echo $area; ?>',
		type: '<?php echo $type; ?>',
		room:'<?php echo $room; ?>',
	},
	success: function(returnData){
		$('#div_types').html(returnData);
	},
	error: function(data){
		alert('Erreur lors de l execution de la commande AJAX pour le edit_entry_types.php ');
	}
});

jQuery.ajax({
  type: 'GET', // Le type de ma requete
  url: 'edit_entry_beneficiaire.php', // L'url vers laquelle la requete sera envoyee
  data: {
	beneficiaire:'ADMINISTRATEUR', // Les donnees que l'on souhaite envoyer au serveur au format JSON
	identifiant_beneficiaire: '<?php echo $beneficiaire; ?>'

},
success: function(returnData){
	$("#div_profilBeneficiaire").html(returnData);
},
error: function(data){
	alert('Erreur lors de l execution de la commande AJAX pour le edit_entry_beneficiaire.php ');
}
});
//Vérification de la forme
// lors d'un clic dans une option
function check_1 ()
{
	menu = document.getElementById('menu2');
	if (menu)
	{
		if (!document.forms["main"].rep_type[2].checked)
		{
			document.forms["main"].elements['rep_day[0]'].checked=false;
			document.forms["main"].elements['rep_day[1]'].checked=false;
			document.forms["main"].elements['rep_day[2]'].checked=false;
			document.forms["main"].elements['rep_day[3]'].checked=false;
			document.forms["main"].elements['rep_day[4]'].checked=false;
			document.forms["main"].elements['rep_day[5]'].checked=false;
			document.forms["main"].elements['rep_day[6]'].checked=false;
			menu.style.display = "none";

		}
		else
			menu.style.display = "";
	}
	// Pour les checkboxes des Jours/Cycles
	<?php
	if (getSettingValue("jours_cycles_actif") == "Oui")
	{
		?>
		menu = document.getElementById('menuP');
		if (menu)
		{
			if (!document.forms["main"].rep_type[5].checked)
				menu.style.display = "none";
			else
				menu.style.display = "";
		}
		<?php
	}
	?>

}
// lors d'un clic dans la liste des semaines
function check_2 ()
{
	document.forms["main"].rep_type[2].checked=true;
	check_1 ();
}
// lors d'un clic dans la liste des mois
function check_3 ()
{
	document.forms["main"].rep_type[3].checked=true;
}
// lors d'un clic dans la liste des bénéficiaires
function check_4 ()
{
	menu = document.getElementById('menu4');
	if (menu)
	{
		if (!document.forms["main"].beneficiaire.options[0].selected)
		{
			menu.style.display = "none";
			<?php
			if (getSettingValue("remplissage_description_breve") == '2')
			{
				?>
				document.forms["main"].name.value=document.forms["main"].beneficiaire.options[document.forms["main"].beneficiaire.options.selectedIndex].text;
				<?php
			}
			?>
		}
		else
		{
			menu.style.display = "";
			<?php
			if (getSettingValue("remplissage_description_breve") == '2')
			{
				?>
				document.forms["main"].name.value="";
				<?php
			}
			?>
		}
	}
}
// lors de l'ouverture et la fermeture de la périodicité
function check_5 ()
{
	var menu; var menup; var menu2;
	menu = document.getElementById('menu1');
	menup = document.getElementById('menuP');
	menu2 = document.getElementById('menu2');

	if ((menu)&&(menu.style.display == "none"))
	{
		menup.style.display = "none";
		menu2.style.display = "none";
	}
	else
		check_1();
}
function setdefault (name,input)
{
	document.cookie = escape(name) + "=" + escape(input) +
	( "" ? ";expires=" + ( new Date( ( new Date() ).getTime() + ( 1000 * lifeTime ) ) ).toGMTString() : "" ) +
	( "" ? ";path=" + path : "") +
	( "" ? ";domain=" + domain : "") +
	( "" ? ";secure" : "");
}
function Load_entry ()
{
	recoverInputs(document.forms["main"],retrieveCookie('Grr_entry'),true);
	<?php
	if (!$id <> "")
	{
		?>
		if (!document.forms["main"].rep_type[0].checked)
			clicMenu('1');
		<?php
	}
	?>
}
function Save_entry ()
{
	setCookie('Grr_entry',getFormString(document.forms["main"],true));
}
//Hugo - Fonction de validation et sauvegarde de la réservation
function validate_and_submit ()
{
//Si le nom du bénéficaire est fournis on execute :
if (document.forms["main"].benef_ext_nom)
{
//Si "(personne extérieure)" est selectionné et que le champ "nom du bénéficiaire" est vide on affiche une alerte et on retourne false
if ((document.forms["main"].beneficiaire.options[0].selected) &&(document.forms["main"].benef_ext_nom.value == ""))
{
	alert ( "<?php echo get_vocab('you_have_not_entered').":" . '\n' . strtolower(get_vocab('nom beneficiaire')) ?>");
	return false;
}
}
//Si on a définis que le remplissage de la description brève est obligatoire, on execute
<?php if (getSettingValue("remplissage_description_breve")=='1')
{
	?>
//Si le champs "description brève" est vide on affiche une alerte et on retourne false
if (document.forms["main"].name.value == "")
{
	alert ( "<?php echo get_vocab('you_have_not_entered') . '\n' . get_vocab('brief_description') . '\n' ?>");
	return false;
}
<?php
}
  // On teste si les champs additionnels obligatoires sont bien remplis
  // Boucle sur tous les areas
foreach ($allareas_id as $idtmp)
{
	   // On récupère les infos sur le champ add
	$overload_fields = mrbsOverloadGetFieldslist($idtmp);
	  // Boucle sur tous les champs additionnels de l'area
	  //$overload_fiel est un "array"
	  //$fieldname : nom des champs input (brève description, description complète...)
	foreach ($overload_fields as $fieldname=>$fieldtype)
	{
		if ($overload_fields[$fieldname]["obligatoire"] == 'y')
		{
		// Le champ est obligatoire : si le tableau est affiché (area sélectionné) et que le champ est vide alors on affiche un message d'avertissement
			if ($overload_fields[$fieldname]["type"] != "list")
				echo "if ((document.getElementById('id_".$idtmp."_".$overload_fields[$fieldname]["id"]."')) && (document.forms[\"main\"].addon_".$overload_fields[$fieldname]["id"].".value == \"\")) {\n";
			else
				echo "if ((document.getElementById('id_".$idtmp."_".$overload_fields[$fieldname]["id"]."')) && (document.forms[\"main\"].addon_".$overload_fields[$fieldname]["id"].".options[0].selected == true)) {\n";
			echo "alert (\"".$vocab["required"]."\");\n";
			echo "return false\n}\n";
		}
		// Si le champ est numérique....
		if ($overload_fields[$fieldname]["type"] == "numeric")
		{
			echo "if (isNaN((document.getElementById('id_".$idtmp."_".$overload_fields[$fieldname]["id"]."')) && (document.forms[\"main\"].addon_".$overload_fields[$fieldname]["id"].".value))) {\n";
			echo "alert (\"".preg_replace('/"/', '\"',$overload_fields[$fieldname]["name"]).preg_replace("/&nbsp;/", " ",$vocab["deux_points"]).$vocab["is_not_numeric"]."\");\n";
			echo "return false\n}\n";

		}
	}
}

if ($enable_periods!='y')
{ 
	?>
	h = parseInt(document.forms["main"].hour.value);
	m = parseInt(document.forms["main"].minute.value);
	if (h > 23 || m > 59)
	{
		alert ("<?php echo get_vocab('you_have_not_entered') . '\n' . get_vocab('valid_time_of_day') ?>");
		return false;
	}
	<?php } ?>
	if (document.forms["main"].type.value=='0')
	{
		alert("<?php echo get_vocab("choose_a_type"); ?>");
		return false;
	}
	<?php
	if ($edit_type == "series")
	{     
		?>

//parseInt convertit string en int
i1 = parseInt(document.forms["main"].id.value);
i2 = parseInt(document.forms["main"].rep_id.value);
n = parseInt(document.forms["main"].rep_num_weeks.value);
if ((document.forms["main"].elements['rep_day[0]'].checked || document.forms["main"].elements['rep_day[1]'].checked || document.forms["main"].elements['rep_day[2]'].checked || document.forms["main"].elements['rep_day[3]'].checked || document.forms["main"].elements['rep_day[4]'].checked || document.forms["main"].elements['rep_day[5]'].checked || document.forms["main"].elements['rep_day[6]'].checked) && (!document.forms["main"].rep_type[2].checked))
{
	alert("<?php echo get_vocab('no_compatibility_with_repeat_type'); ?>");
	return false;
}
if ((!document.forms["main"].elements['rep_day[0]'].checked && !document.forms["main"].elements['rep_day[1]'].checked && !document.forms["main"].elements['rep_day[2]'].checked && !document.forms["main"].elements['rep_day[3]'].checked && !document.forms["main"].elements['rep_day[4]'].checked && !document.forms["main"].elements['rep_day[5]'].checked && !document.forms["main"].elements['rep_day[6]'].checked) && (document.forms["main"].rep_type[2].checked))
{
	alert("<?php echo get_vocab('choose_a_day'); ?>");
	return false;
}
<?php
}


?>
// would be nice to also check date to not allow Feb 31, etc...
//A FAIRE
document.forms["main"].submit();
return true;
}
</script>
<?php

//$id = 0 : c'est une nouvelle réservation
if ($id==0)
//$A = "ajouter une reservation"
	$A = get_vocab("addentry");
else


	if ($edit_type == "series")
	//si le type est "series" on affiche "Modifier la périodicité (et toutes les réservations associées)"
		$A = get_vocab("editseries").grr_help("aide_grr_periodicite");
	else

	//sinon si $copy est definis dans l'url on affiche "Copier cette réservation"
		if (isset($_GET["copy"])) $A = get_vocab("copyentry");
		//sinon on affiche "Modifier cette réservation"
	else $A = get_vocab("editentry");

$B = get_vocab("namebooker"); //Brève description
if (getSettingValue("remplissage_description_breve")=='1') {
	$B .= " *";
	$affiche_mess_asterisque=true;
}
$B .= get_vocab("deux_points");
$C = htmlspecialchars($breve_description);
$D = get_vocab("fulldescription"); //description complète
$E = htmlspecialchars ( $description );
$F = get_vocab("date").get_vocab("deux_points"); //Début de la réservation

//Determine l'ID de "area" de la "room"
$sql = "select area_id from ".TABLE_PREFIX."_room where id=$room_id";
$res = grr_sql_query($sql);
$row = grr_sql_row($res, 0);
$area_id = $row[0];

// Détermine si la ressource est moderée
$moderate = grr_sql_query1("select moderate from ".TABLE_PREFIX."_room where id='".$room_id."'");
echo "<h2>$A</h2>\n";
if ($moderate)
	echo "<h3><span class='texte_ress_moderee'>".$vocab["reservations_moderees"]."</span></h3>\n";
echo "<form id=\"main\" action=\"edit_entry_handler.php\" method=\"get\">\n";
?>

<!--David Fonction -- 10/02/2014 --- changeResolution-->

<script type="text/javascript" >
	function changeResolution( formObj)
	{
		areasObj = eval( "formObj.areas" );
		area = areasObj[areasObj.selectedIndex].value
		resolutionsObj = eval( "formObj.elements['resolutions']" )
		resolutionsObj.options[i] = null
		return (changeResolution)
	}
	<?php
	$sql2 = "select resolution_area from ".TABLE_PREFIX."_area where resolution_area = ".$resolution."'";
	$res2 = grr_sql_query($sql2);
	?>	

</script>

<script type="text/javascript" >
	function changeRooms( formObj )
	{
		areasObj = eval( "formObj.areas" );
		area = areasObj[areasObj.selectedIndex].value
		roomsObj = eval( "formObj.elements['rooms[]']" )
	// remove all entries
	l = roomsObj.length;
	for (i=l;i>0;i-- )
		roomsObj.options[i] = null

	// add entries based on area selected
	switch (area){
		<?php
	// get the area id for case statement

		if ($enable_periods == 'y')
			$sql = "select id, area_name from ".TABLE_PREFIX."_area where id='".$area."' order by area_name";
		else
			$sql = "select id, area_name from ".TABLE_PREFIX."_area where enable_periods != 'y' order by area_name";
		$res = grr_sql_query($sql);
		if ($res)
		{
			for ($i = 0; ($row = grr_sql_row($res, $i)); $i++)
			{
				if (authUserAccesArea(getUserName(),$row[0])==1)
				{
					print "      case \"".$row[0]."\":\n";
					// get rooms for this area
					$sql2 = "select id, room_name from ".TABLE_PREFIX."_room where area_id='".$row[0]."'";
					// on ne cherche pas parmi les ressources invisibles pour l'utilisateur
					$tab_rooms_noaccess = verif_acces_ressource(getUserName(), 'all');
					foreach ($tab_rooms_noaccess as $key){
						$sql2 .= " and id != $key ";
					}
					$sql2 .= " order by room_name";
					$res2 = grr_sql_query($sql2);
					if ($res2)
					{
						$len = grr_sql_count($res2); // nombre de ressources
						print "roomsObj.size=".min($longueur_liste_ressources_max,$len).";"; // calcul de la longueur de la liste à afficher.
						for ($j = 0; ($row2 = grr_sql_row($res2, $j)); $j++)
							print "        roomsObj.options[$j] = new Option(\"".str_replace('"','\\"',$row2[1])."\",".$row2[0] .")\n";
						// select the first entry by default to ensure
						// that one room is selected to begin with
						print "        roomsObj.options[0].selected = true\n";
						// Affichage des champs additionnels
					}
					print "        break\n";
				}
			}
		}
		?>
	} //switch
}
</script>
<?php
// On construit un tableau pour afficher la partie réservation hors périodicité à gauche et la partie périodicité à droite
echo "<table width=\"100%\" border=\"1\"><tr>\n";
// Première colonne (sans périodicité)
echo "<td style=\"width:50%; vertical-align:top;\">\n";
// Début du tableau de la colonne de gauche
echo "<table width=\"100%\" border=\"0\" class=\"EditEntryTable\">\n";
// Pour pouvoir réserver au nom d'un autre utilisateur il faut :
// - avoir le droit spécifique sur cette ressource ET
// - dans le cas d'une réservation existante, il faut être propriétaire de la réservation
if (((authGetUserLevel(getUserName(), -1, "room") >= $qui_peut_reserver_pour) || (authGetUserLevel(getUserName(), $area, "area") >= $qui_peut_reserver_pour)) && (($id == 0) || (($id!=0) && (authGetUserLevel(getUserName(),$room) > 2) )))
{
	$flag_qui_peut_reserver_pour = "yes";
	echo "<tr><td class=\"E\"><b>".ucfirst(trim(get_vocab("reservation au nom de"))).get_vocab("deux_points").grr_help("aide_grr_effectuer_reservation","modifier_reservant")."</b></td></tr>";
	echo "<tr><td class=\"CL\"><select size=\"1\" name=\"beneficiaire\" id=\"beneficiaire\" onchange=\"setdefault('beneficiaire_default','');check_4();insertProfilBeneficiaire();\">\n";
	echo "<option value=\"\" >".get_vocab("personne exterieure")."</option>\n";
	$sql = "SELECT DISTINCT login, nom, prenom FROM ".TABLE_PREFIX."_utilisateurs WHERE  (etat!='inactif' and statut!='visiteur' ) OR (login='".$beneficiaire."') ORDER BY nom, prenom";
	$res = grr_sql_query($sql);
	if ($res)
	{	
		for ($i = 0; ($row = grr_sql_row($res, $i)); $i++)
		{
			echo "<option value=\"".$row[0]."\" ";
				//Récupère le cookie par defaut
			if ($id == 0 && isset($_COOKIE['beneficiaire_default']))
				$cookie = $_COOKIE['beneficiaire_default'];
			else
				$cookie="";
			if ((!$cookie && strtolower($beneficiaire) == strtolower($row[0])) || ($cookie && $cookie == $row[0]))
				echo " selected=\"selected\" ";
			echo ">$row[1] $row[2]</option>";
		}
	}
	// Si le bénéficiaire actuellement enregistré n'est plus dans la base,
	$test = grr_sql_query1("SELECT login FROM ".TABLE_PREFIX."_utilisateurs WHERE login='".$beneficiaire."'");
	if (($test == -1) && ($beneficiaire != ''))
		echo "<option value=\"-1\" selected=\"selected\" >".get_vocab("utilisateur_inconnu").$beneficiaire.")</option>\n";
echo "</select>&nbsp;<input type=\"button\" value=\"".get_vocab("definir par defaut")."\" onclick=\"setdefault('beneficiaire_default',document.getElementById('main').beneficiaire.options[document.getElementById('main').beneficiaire.options.selectedIndex].value)\" />";
echo "<div id=\"div_profilBeneficiaire\">";
	// Ici, on insère des données avec l'ajax concernant des précisions sur le bénéficiaire sélectionné dans la liste "Réservation au nom de".
echo "</div>";
if (isset($statut_beneficiaire))
	echo $statut_beneficiaire;
if (isset($statut_beneficiaire))
	echo $statut_beneficiaire;
echo "</td></tr>\n";
if ($tab_benef["nom"] != "")
	echo "<tr id=\"menu4\"><td>";
else
	echo "<tr style=\"display:none\" id=\"menu4\"><td>";
echo get_vocab("nom beneficiaire")." *".get_vocab("deux_points")."<input type=\"text\" name=\"benef_ext_nom\" value=\"".htmlspecialchars($tab_benef["nom"])."\" size=\"20\" />";
$affiche_mess_asterisque = true;
if (getSettingValue("automatic_mail") == 'yes')
	echo "<br />".get_vocab("email beneficiaire").get_vocab("deux_points")."<input type=\"text\" name=\"benef_ext_email\" value=\"".htmlspecialchars($tab_benef["email"])."\" size=\"20\" />";
echo "</td></tr>\n";
} 
else
	$flag_qui_peut_reserver_pour = "no";
echo "<tr><td class=\"E\"><b>$B</b></td></tr>
<tr><td class=\"CL\"><input id=\"name\" name=\"name\" size=\"80\" value=\"$C\" /></td></tr>
<tr><td class=\"E\"><b>$D</b></td></tr>
<tr><td class=\"TL\"><textarea name=\"description\" rows=\"2\" cols=\"80\">$E</textarea></td></tr>";
echo "<tr><td><div id=\"div_champs_add\">";
// Ici, on insère tous ce qui concerne les champs additionnels avec de l'ajax !
echo "</div>";
echo "</td></tr>\n";
// Début réservation
echo "<tr><td class=\"E\"><b>$F</b></td></tr>\n";
echo "<tr><td class=\"CL\">";
echo "<table border=\"0\"><tr><td>";
//MAJ Hugo FORESTIER - Appel de la fonction jQuery_DatePicker pour la date de début
//17/05/2013
jQuery_DatePicker('start');
echo "</td><td class=\"E\"><b>";
// Heure ou créneau de début de réservation
if ($enable_periods=='y')
{
	echo get_vocab("period")."</b>\n";
	echo "<select name=\"period\">";
	foreach ($periods_name as $p_num => $p_val)
	{
		echo "<option value=\"".$p_num."\"";
		if (( isset( $period ) && $period == $p_num ) || $p_num == $start_min)
			echo " selected=\"selected\"";
		echo ">$p_val</option>\n";
	}
	echo "</select>\n";
}
else
{
//MAJ Hugo FORESTIER - Mise en place du TimePicker
//28/05/2013
	echo get_vocab("time")."</b>";

//MAJ Hugo FORESTIER - Mise en place du isset dans le cas ou on modifie une réservation
//05/06/2013
	if (isset ($_GET['id']))
	{
//MAJ David VOUE Ajout du paramètre $resolution
//30/01/2013
//MAJ David VOUE - Rangement des paramètres
//31/01/2013
//jQuery_TimePicker ('start','',$start_hour,$start_min,$resolution,'','');
		jQuery_TimePicker ('start','','','',$start_hour,$start_min,$resolution);
//MAJ David VOUE - Rangement des paramètres
//31/01/2013
//jQuery_TimePicker ('end','end_','','',$end_hour,$end_min,$resolution);
	}
//Le cas ou on creer une réservation ($start_hour, $start_min, $end_hour, $end_min ne sont donc pas definis)
	else
	{
//MAJ David VOUE - Ajout du paramètre $resolution
//30/01/2013
		jQuery_TimePicker ('start','','','','','',$resolution);
//jQuery_TimePicker ('end','end_','','','','',$resolution);
	}
	if (!$twentyfourhour_format)
	{
		$checked = ($start_hour < 12) ? "checked=\"checked\"" : "";
		echo "<input name=\"ampm\" type=\"radio\" value=\"am\" $checked />".date("a",mktime(1,0,0,1,1,1970));
		$checked = ($start_hour >= 12) ? "checked=\"checked\"" : "";
		echo "<input name=\"ampm\" type=\"radio\" value=\"pm\" $checked />".date("a",mktime(13,0,0,1,1,1970));
	}
}
echo "</td></tr></table>\n";
echo "</td></tr>";
if ($type_affichage_reser == 0)
{
  // Durée
	echo "<tr><td class=\"E\"><b>".get_vocab("duration")."</b></td></tr>\n";
  //echo "<tr><td class=\"CL\"><input name=\"duration\" size=\"7\" value=\"".$duration."\" />";
	echo "<tr><td class=\"CL\">";
	spinner($duration);
	echo "<select name=\"dur_units\" size=\"1\">\n";
	if ($enable_periods == 'y')
		$units = array("periods", "days");
	else
	{
		//Test de la durée max de réservation
		$duree_max_resa_area = grr_sql_query1("select duree_max_resa_area from ".TABLE_PREFIX."_area where id='".$area."'");
		if ($duree_max_resa_area < 0)
			$units = array("minutes", "hours", "days", "weeks");
		else if ($duree_max_resa_area < 60)
			$units = array("minutes");
		else if ($duree_max_resa_area < 60*24)
			$units = array("minutes", "hours");
		else if ($duree_max_resa_area < 60*24*7)
			$units = array("minutes", "hours", "days");
		else
			$units = array("minutes", "hours", "days", "weeks");
	}
	while (list(,$unit) = each($units))
	{
		echo "<option value=\"".$unit."\"";
		if ($dur_units == get_vocab($unit)) echo " selected=\"selected\"";
		echo ">".get_vocab($unit)."</option>\n";
	}
	echo "</select>\n";
	// Affichage du créneau "journée entière"
	// Il reste un bug lorsque l'heure finale dépasse 24 h
	//A VOIR
	$fin_jour = $eveningends;
	$minute = $resolution/60;
	$minute_restante = $minute % 60;
	$heure_ajout = ($minute - $minute_restante)/60;
	if ($minute_restante < 10)
		$minute_restante = "0".$minute_restante;
	$heure_finale = round($fin_jour+$heure_ajout,0);
	if ($heure_finale > 24)
	{
		$heure_finale_restante = $heure_finale % 24;
		$nb_jour = ($heure_finale - $heure_finale_restante)/24;
		$heure_finale = $nb_jour. " ". $vocab["days"]. " + ". $heure_finale_restante;
	}
	$af_fin_jour = $heure_finale." H ".$minute_restante;
	echo "<input name=\"all_day\" type=\"checkbox\" value=\"yes\" />".get_vocab("all_day");
	if ($enable_periods!='y')
		echo " (".$morningstarts." H - ".$af_fin_jour.")";
	echo "</td></tr>\n";
}
else
{
  // Date de fin de réservation
	echo "<tr><td class=\"E\"><b>".get_vocab("fin_reservation").get_vocab("deux_points")."</b></td></tr>\n";
	echo "<tr><td class=\"CL\" >";
	echo "<table border=\"0\"><tr><td>\n";
	//Appel de la fonction jQuery_DatePicker pour la date de fin
	//17/05/2013
	jQuery_DatePicker('end');
	echo "</td>";
	//Heure ou créneau de fin de réservation
	if ($enable_periods == 'y')
	{
		echo "<td class=\"E\"><b>".get_vocab("period")."</b></td>\n";
		echo "<td class=\"CL\">\n";
		echo "<select name=\"end_period\">";
		foreach ($periods_name as $p_num => $p_val)
		{
			echo "<option value=\"".$p_num."\"";
			if ((isset($end_period) && $end_period == $p_num ) || ($p_num+1) == $end_min)
				echo " selected=\"selected\"";
			echo ">$p_val</option>\n";
		}
		echo "</select>\n</td>\n";
	}
	else
	{
		//MAJ Hugo FORESTIER - Mise en place du TimePicker
		//28/05/2013
		echo "<td class=\"E\"><b>".get_vocab("time")."</b><td class=\"CL\">";
		//MAJ Hugo FORESTIER - Mise en place du isset dans le cas ou on modifie une réservation
		//05/06/2013
		//MAJ David VOUE - Ajout du paramètre $resolution
		//30/01/2013
		if (isset ($_GET['id']))
			jQuery_TimePicker ('end', 'end_', '', '', $end_hour, $end_min, $resolution);
		//Le cas ou on creer une réservation ($start_hour, $start_min, $end_hour, $end_min ne sont donc pas definis)
		else
			jQuery_TimePicker ('end', 'end_', '', '', '', '', $resolution);
		if (!$twentyfourhour_format)
		{
			$checked = ($end_hour < 12) ? "checked=\"checked\"" : "";
			echo "<input name=\"ampm\" type=\"radio\" value=\"am\" $checked />".date("a", mktime(1, 0, 0, 1, 1, 1970));
			$checked = ($end_hour >= 12) ? "checked=\"checked\"" : "";
			echo "<input name=\"ampm\" type=\"radio\" value=\"pm\" $checked />".date("a", mktime(13, 0, 0, 1, 1, 1970));
		}
		echo "</td>";
	}
	echo "</tr></table>\n</td></tr>";
}
// Option de réservation
if (($delais_option_reservation > 0) && (($modif_option_reservation == 'y') || ((($modif_option_reservation == 'n') && ($option_reservation != -1)) ) ))
{
	$day   = date("d");
	$month = date("m");
	$year  = date("Y");
	echo "<tr bgcolor=\"#FF6955\"><td class=\"E\"><b>".get_vocab("reservation_a_confirmer_au_plus_tard_le");
	if ($modif_option_reservation == 'y')
	{
		echo "<select name=\"option_reservation\" size=\"1\">\n";
		$k = 0;
		$selected = 'n';
		$aff_options = "";
		while ($k < $delais_option_reservation + 1)
		{
			$day_courant = $day + $k;
			$date_courante = mktime(0, 0, 0, $month, $day_courant, $year);
			$aff_date_courante = time_date_string_jma($date_courante, $dformat);
			$aff_options .= "<option value = \"".$date_courante."\" ";
			if ($option_reservation == $date_courante)
			{
				$aff_options .= " selected=\"selected\" ";
				$selected = 'y';
			}
			$aff_options .= ">".$aff_date_courante."</option>\n";
			$k++;
		}
		echo "<option value = \"-1\">".get_vocab("Reservation confirmee")."</option>\n";
		if (($selected == 'n') && ($option_reservation != -1))
			echo "<option value = \"".$option_reservation."\" selected=\"selected\">".time_date_string_jma($option_reservation,$dformat)."</option>\n";
		echo $aff_options;
		echo "</select>";
	}
	else
	{
		echo "<input type=\"hidden\" name=\"option_reservation\" value=\"".$option_reservation."\" />&nbsp;<b>".
		time_date_string_jma($option_reservation,$dformat)."</b>\n";
		echo "<br /><input type=\"checkbox\" name=\"confirm_reservation\" value=\"y\" />".get_vocab("confirmer reservation")."\n";
	}
	echo "<br />".get_vocab("avertissement_reservation_a_confirmer")."</b>\n";
	echo "</td></tr>\n";

}
// create area selector if javascript is enabled as this is required
// if the room selector is to be updated.
echo "<tr ";
if ($nb_areas == 1)
	echo "style=\"display:none\" ";
echo "><td class=\"E\"><b>".get_vocab("match_area").get_vocab("deux_points")."</b></td></tr>\n";
echo "<tr ";
if ($nb_areas == 1)
	echo "style=\"display:none\" ";
echo "><td class=\"CL\" style=\"vertical-align:top;\" >\n";
//echo "<select name=\"areas\" onchange=\"changeRooms(this.form)\" >";
echo "<select id=\"areas\" name=\"areas\" onchange=\"changeRooms(this.form);changeResolution(this.form);insertChampsAdd();insertTypes()\" >";
// get list of areas
if ($enable_periods == 'y')
	$sql = "select id, area_name from ".TABLE_PREFIX."_area where id='".$area."' order by area_name";
else
	$sql = "select id, area_name from ".TABLE_PREFIX."_area where enable_periods != 'y' order by area_name";
$res = grr_sql_query($sql);
if ($res)
{	
	for ($i = 0; ($row = grr_sql_row($res, $i)); $i++)
	{
		if (authUserAccesArea(getUserName(),$row[0]) == 1)
		{
			$selected = "";
			if ($row[0] == $area)
				$selected = "selected=\"selected\"";
			print "<option ".$selected." value=\"".$row[0]."\">".$row[1]."</option>\n";
		}
	}
}
echo "</select>\n";
echo "</td></tr>\n";

// *****************************************
// Edition de la partie ressources
// *****************************************

echo "\n<!-- ************* Ressources edition ***************** -->\n";

echo "<tr><td class=\"E\"><b>".get_vocab("rooms").get_vocab("deux_points")."</b></td></tr>\n";
$sql = "select id, room_name, description from ".TABLE_PREFIX."_room where area_id=$area_id ";
// on ne cherche pas parmi les ressources invisibles pour l'utilisateur
$tab_rooms_noaccess = verif_acces_ressource(getUserName(), 'all');
foreach ($tab_rooms_noaccess as $key)
	$sql .= " and id != $key ";
$sql .= " order by order_display,room_name";
$res = grr_sql_query($sql);
$len = grr_sql_count($res);
echo "<tr><td class=\"CL\" style=\"vertical-align:top;\"><table border=\"0\"><tr><td><select name=\"rooms[]\" size=\"".min($longueur_liste_ressources_max,$len)."\" multiple=\"multiple\">";
//Sélection de la "room" dans l'"area"
if ($res)
{
	for ($i = 0; ($row = grr_sql_row($res, $i)); $i++)
	{
		$selected = "";
		if ($row[0] == $room_id) $selected = "selected=\"selected\"";
		echo "<option $selected value=\"".$row[0]."\">".$row[1]."</option>\n";
	}
}
echo "</select></td><td>".get_vocab("ctrl_click")."</td></tr></table>\n";
echo "</td></tr>\n";
echo "<tr><td><div id=\"div_types\">";
// Ici, on insère tous ce qui concerne les types avec de l'ajax !
echo "</div></td></tr>";
echo "<tr><td class=\"E\">";
// au chargement de la page, on affiche les champs additionnels et les types après que l'id 'areas' ait été définie.
?>
<script type="text/javascript" >
	insertChampsAdd();
	insertTypes();
	insertProfilBeneficiaire();
</script>
<?php
if ($affiche_mess_asterisque)
	get_vocab("required");
echo "&nbsp;</td></tr>\n";
// Fin du tableau de la page de gauche
echo "</table>\n";
// Fin de la colonne de gauche
echo "</td>\n";
// Début colonne de droite
echo "<td style=\"vertical-align:top;\">\n";
// Début tableau de la colonne de droite
echo "<table width=\"100%\" border=\"0\">";
// on récupère la liste des domaines et on génère tous les formulaires.
$sql = "select id from ".TABLE_PREFIX."_area;";
$res = grr_sql_query($sql);
// Dans le cas d'une nouvelle réservation, ou bien si on édite une réservation existante
// *****************************************
// Edition de la partie périodique
//
// *****************************************
echo "\n<!-- ************* Periodic edition ***************** -->\n";
// Tableau des "une semaine sur n"
$weeklist = array("unused","every week","week 1/2","week 1/3","week 1/4","week 1/5");
/*
Explications sur les différents cas de périodicité:
$rep_type = 0 -> Aucune périodicité
$rep_type = 1 -> Chaque jour (sélectionné)
$rep_type = 2 -> "Une semaine sur n". La valeur "n" est alors enregistrée dans $rep_num_weeks
$rep_type = 3 -> Chaque mois, la même date
$rep_type = 5 -> Chaque mois, même jour de la semaine
Attention : dans le formualaire de réservation, les deux cas $rep_type = 3 et $rep_type = 5
sont regroupés dans une liste déroulante correspondant au cas $i = 3 ci-dessous
$rep_type = 4 -> Chaque année, même date
$rep_type = 6 -> Jours cycle
*/
if (($edit_type == "series") || (isset($flag_periodicite)))
{
	echo "<tr><td id=\"ouvrir\" style=\"cursor: inherit\" align=\"center\" class=\"fontcolor4\"><span class=\"bground\"><b><a href='javascript:clicMenu(1);check_5()'>".get_vocab("click_here_for_series_open")."</a></b></span>".grr_help("aide_grr_periodicite")."</td></tr><tr><td style=\"display:none; cursor: inherit\" id=\"fermer\" align=\"center\" class=\"fontcolor4\"><span class=\"bground\"><b><a href='javascript:clicMenu(1);check_5()'>".get_vocab("click_here_for_series_close")."</a></b></span>".grr_help("aide_grr_periodicite")."</td></tr>";
	echo "<tr><td><table border=\"0\" style=\"display:none\" id=\"menu1\" width=\"100%\">\n ";
	echo "<tr><td class=\"F\"><b>".get_vocab("rep_type")."</b></td></tr><tr><td class=\"CL\">\n";
	echo "<table border=\"0\"  width=\"100%\" >\n";
	//Vérifie si le jour cycle est activé ou non
	if (getSettingValue("jours_cycles_actif") == "Oui")
		$max = 7; //$max = 7 Pour afficher l'option Jour cycle dans les péridocidités
	else
		$max = 6; //max = 6 Pour ne pas afficher l'option Jour cycle dans les péridocidités
	for($i = 0; $i < $max ; $i++)
	{
	  if ($i != 5) // Le cas rep_type = 5 (chaque mois, même jour de la semaine)  est traité plus bas comme un sous cas de $i = 3
	  {
	  	echo "<tr><td><input name=\"rep_type\" type=\"radio\" value=\"" . $i . "\"";
	  	if ($i == $rep_type)
	  		echo " checked=\"checked\"";
		// si rep_type = 5 (chaque mois, même jour de la semaine), on sélectionne l'option 3
	  	if (($i == 3) && ($rep_type == 5))
	  		echo " checked=\"checked\"";
	  	echo " onclick=\"check_1()\" /></td><td>";
		// Dans le cas des semaines et des mois, on affichera plutôt un menu déroulant
	  	if (($i != 2) && ($i != 3))
	  		echo get_vocab("rep_type_$i");
	  	echo "\n";
		// Dans le cas d'une périodicité semaine, on précise toutes les n-semaines
	  	if ($i == '2')
	  	{
	  		echo "<select name=\"rep_num_weeks\" size=\"1\" onfocus=\"check_2()\" onclick=\"check_2()\">\n";
	  		echo "<option value=\"1\" >".get_vocab("every week")."</option>\n";
	  		for ($weekit = 2; $weekit < 6; $weekit++)
	  		{
	  			echo "<option value=\"".$weekit."\"";
	  			if ($rep_num_weeks == $weekit)
	  				echo " selected=\"selected\"";
	  			echo ">".get_vocab($weeklist[$weekit])."</option>\n";
	  		}
	  		echo "</select>\n";
	  	}
	  	if ($i == '3')
	  	{
	  		$monthrep3 = "";
	  		$monthrep5 = "";
	  		if ($rep_type == 3)
	  			$monthrep3 = " selected=\"selected\" ";
	  		if ($rep_type == 5)
	  			$monthrep5 = " selected=\"selected\" ";
	  		echo "<select name=\"rep_month\" size=\"1\" onfocus=\"check_3()\" onclick=\"check_3()\">\n";
	  		echo "<option value=\"3\" $monthrep3>".get_vocab("rep_type_3")."</option>\n";
	  		echo "<option value=\"5\" $monthrep5>".get_vocab("rep_type_5")."</option>\n";
	  		echo "</select>\n";
	  	}
	  	echo "</td></tr>\n";
	  }
	}
	echo "</table>\n\n";
	echo "<!-- ***** Fin de périodidité ***** -->\n";
	echo "</td></tr>";
	//echo "\n<tr><td>\n";
	echo "<tr><td class=\"F\"><b>".get_vocab("rep_end_date")."</b></td></tr>\n";
	echo "<tr><td class=\"CL\">";
	//Appel de la fonction jQuery_DatePicker pour la date de fin de répétition */
	//17/05/2013
	jQuery_DatePicker('rep_end');
	echo "</td></tr></table>\n";
	// Tableau des jours de la semaine à cocher si on choisit une périodicité "une semaine sur n"
	echo "<table style=\"display:none\" id=\"menu2\" width=\"100%\">\n";
	echo "<tr><td class=\"F\"><b>".get_vocab("rep_rep_day")."</b></td></tr>\n";
	echo "<tr><td class=\"CL\">";
	//Affiche les checkboxes du jour en fonction de la date de début de semaine.
	for ($i = 0; $i < 7; $i++)
	{
		$wday = ($i + $weekstarts) % 7;
		echo "<input name=\"rep_day[$wday]\" type=\"checkbox\"";
		if ($rep_day[$wday]) echo " checked=\"checked\"";
		echo " onclick=\"check_1()\" />" . day_name($wday) . "\n";
	}
	echo "</td></tr>\n</table>\n";
	// Tableau des jours cycle à cocher si on choisit une périodicité "Jours Cycle"
	echo "<table style=\"display:none\" id=\"menuP\" width=\"100%\">\n";
	echo "<tr><td class=\"F\"><b>Jours/Cycle</b></td></tr>\n";
	echo "<tr><td class=\"CL\">";
	// Affiche les checkboxes du jour en fonction du nombre de jour par jours/cycles
	for ($i = 1; $i < (getSettingValue("nombre_jours_Jours/Cycles") + 1); $i++)
	{
		$wday = $i;
		echo "<input type=\"radio\" name=\"rep_jour_\" value=\"$wday\"";
		if (isset($jours_c))
		{
			if ($i == $jours_c)
				echo " checked=\"checked\"";
		}
		echo " onclick=\"check_1()\" />".get_vocab("rep_type_6")." ".$wday. "\n";
	}
	echo "</td></tr>\n</table></td></tr>\n";

}
else
{
	// On affiche les informations liées à la périodicité
	echo "<tr><td class=\"E\"><b>".get_vocab('periodicite_associe').get_vocab('deux_points')."</b></td></tr>\n";
	if ($rep_type == 2)
		$affiche_period = get_vocab($weeklist[$rep_num_weeks]);
	else
		$affiche_period = get_vocab('rep_type_'.$rep_type);
	echo '<tr><td class="E"><b>'.get_vocab('rep_type').'</b> '.$affiche_period.'</td></tr>'."\n";
	if ($rep_type != 0)
	{
		$opt = '';
		if ($rep_type == 2)
		{
			$nb = 0;
			//Affiche les checkboxes du jour en fonction de la date de début de semaine.
			for ($i = 0; $i < 7; $i++)
			{
				$wday = ($i + $weekstarts) % 7;
				if ($rep_opt[$wday])
				{
					if ($opt != '') $opt .=', ';
					$opt .= day_name($wday);
					$nb++;
				}
			}
		}
		if ($rep_type == 6)
		{
			$nb = 1;
			//Affiche le jour cycle.
			$opt .= get_vocab('jour_cycle').' '.$jours_c;
		}
		if ($opt)
		{
			if ($nb == 1)
				echo '<tr><td class="E"><b>'.get_vocab('rep_rep_day').'</b> '.$opt.'</td></tr>'."\n";
			else
				echo '<tr><td class="E"><b>'.get_vocab('rep_rep_days').'</b> '.$opt.'</td></tr>'."\n";
			if ($enable_periods == 'y')
				list( $start_period, $start_date) =  period_date_string($start_time);
			else
				$start_date = time_date_string($start_time,$dformat);
			$duration = $end_time - $start_time;
			if ($enable_periods == 'y')
				toPeriodString($start_period, $duration, $dur_units);
			else
				toTimeString($duration, $dur_units, true);
			echo '<tr><td class="E"><b>'.get_vocab("date").get_vocab("deux_points").'</b> '.$start_date.'</td></tr>'."\n";
			echo '<tr><td class="E"><b>'.get_vocab("duration").'</b> '.$duration .' '. $dur_units.'</td></tr>'."\n";
			echo '<tr><td class="E"><b>'.get_vocab('rep_end_date').'</b> '.$rep_end_date.'</td></tr>'."\n";
		}
	}
}
// Fin du tableau de la colonne de droite
echo "\n</table>\n";
// Fin de la colonne de droite et fin du tableau
echo "</td></tr></table>\n";
// ANTHONY ARCHAMBEAU BOUTON ET SCRIPT D'APPEL POUR L'UPLOAD de fichiers 
?>
<div id="fixe">
	<?php

$allowupload = getSettingValue("file"); // CONDITION :  permettre ou non l'upload de fichiers 
if ($allowupload != 0)
{
	// SELON LA VALEUR DE LOPTION FILE DANS LA BDD
	if ((getUserName() != '') && (authGetUserLevel(getUserName(),$room_id) >= 3))
	{
		?>

	<!-- <form>
		<div id="queue"></div>
		<input id="file_upload"  name="file_upload" type="file" multiple="true" >
	</form> -->

	<script type="text/javascript">
		<?php
		$timestamp = time();
		?>
		$(function() {
			$('#file_upload').uploadify({
				'formData'     : {
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
					'id'     : '<?php echo $id ;?>'
				},
				'swf'      : '/uploadify/uploadify.swf',
				'uploader' : '/uploadify/uploadify.php',
				'buttonText'     : 'Lier fichiers ...' ,
				'multi'    : true
			});
		});
	</script>

	<?php
}
}
?> <!--Fermeture des conditions -->



<input type="button" value="<?php echo get_vocab("cancel")?>" onclick="window.location.href='<?php echo $page.".php?year=".$year."&amp;month=".$month."&amp;day=".$day."&amp;area=".$area."&amp;room=".$room; ?>'" />
<input type="button" value="<?php echo get_vocab("save")?>" onclick="Save_entry();validate_and_submit();" />
<input type="hidden" name="rep_id"    value="<?php echo $rep_id?>" />
<input type="hidden" name="edit_type" value="<?php echo $edit_type?>" />
<input type="hidden" name="page" value="<?php echo $page?>" />
<input type="hidden" name="room_back" value="<?php echo $room_id?>" />
<?php
if ($flag_qui_peut_reserver_pour == "no")
	echo "<input type=\"hidden\" name=\"beneficiaire\" value=\"$beneficiaire\" />\n";
if (!isset($statut_entry))
	$statut_entry = "-";
echo "<input type=\"hidden\" name=\"statut_entry\" value=\"$statut_entry\" />\n";
echo "<input type=\"hidden\" name=\"create_by\" value=\"".$create_by."\" />";
if ($id != 0)
{
	if (isset($_GET["copy"]))
		$id = NULL;
	//echo "<input type=\"hidden\" name=\"id\" value=\"0\" />\n";
	else
		echo "<input type=\"hidden\" name=\"id\" value=\"$id\" />\n";
	echo "<input type=\"hidden\" name=\"type_affichage_reser\" value=\"$type_affichage_reser\" />\n"; 
}
?>
</div>
</form>
<script type="text/javascript" >
	document.getElementById('main').name.focus();
	<?php
	if (isset($cookie) && $cookie)
		echo "check_4();";
	if (($id <> "") && (!isset($flag_periodicite)))
		echo "clicMenu('1'); check_5();\n";
	// Si Err=yes il faut recharger la saisie après 1/2 seconde d'attente
	if (isset($Err) && $Err=="yes")
		echo "timeoutID = window.setTimeout(\"Load_entry();check_5();\",500);\n";
	?>
</script>
<?php
include "include/trailer.inc.php";
?>
