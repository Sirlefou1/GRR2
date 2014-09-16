<?php
/**
 * week.php
 * Permet l'affichage de la page d'accueil lorsque l'on est en mode d'affichage "semaine".
 * Ce script fait partie de l'application GRR
 * Dernière modification : $Date: 2010-03-03 14:41:34 $
 * @author    Laurent Delineau <laurent.delineau@ac-poitiers.fr>
 * @copyright Copyright 2003-2008 Laurent Delineau
 * @link      http://www.gnu.org/licenses/licenses.html
 * @package   root
 * @version   $Id: week.php,v 1.18 2010-03-03 14:41:34 grr Exp $
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
 * $Log: week.php,v $
 * Revision 1.18  2010-03-03 14:41:34  grr
 * *** empty log message ***
 *
 * Revision 1.17  2009-12-02 20:11:08  grr
 * *** empty log message ***
 *
 * Revision 1.16  2009-06-04 15:30:17  grr
 * *** empty log message ***
 *
 * Revision 1.15  2009-04-14 12:59:17  grr
 * *** empty log message ***
 *
 * Revision 1.14  2009-04-09 14:52:31  grr
 * *** empty log message ***
 *
 * Revision 1.13  2009-02-27 22:05:03  grr
 * *** empty log message ***
 *
 * Revision 1.12  2009-01-28 16:01:31  grr
 * *** empty log message ***
 *
 * Revision 1.11  2009-01-20 07:19:17  grr
 * *** empty log message ***
 *
 * Revision 1.10  2008-11-16 22:00:59  grr
 * *** empty log message ***
 *
 * Revision 1.9  2008-11-14 07:29:09  grr
 * *** empty log message ***
 *
 * Revision 1.8  2008-11-13 21:32:51  grr
 * *** empty log message ***
 *
 * Revision 1.7  2008-11-11 22:01:14  grr
 * *** empty log message ***
 *
 * Revision 1.6  2008-11-10 08:17:34  grr
 * *** empty log message ***
 *
 * Revision 1.5  2008-11-10 07:06:39  grr
 * *** empty log message ***
 *
 *
 */

include "include/connect.inc.php";
include "include/config.inc.php";
include "include/misc.inc.php";
include "include/functions.inc.php";
include "include/$dbsys.inc.php";
include "include/mincals.inc.php";
include "include/mrbs_sql.inc.php";
include "include/language.inc.php";
$grr_script_name = "week.php";
// Settings
require_once("./include/settings.inc.php");
//Chargement des valeurs de la table settingS
if (!loadSettings())
	die("Erreur chargement settings");

// Session related functions
require_once("./include/session.inc.php");
// Resume session
if (!grr_resumeSession()) {
	if ((getSettingValue("authentification_obli")==1) or ((getSettingValue("authentification_obli")==0) and (isset($_SESSION['login'])))) {
		header("Location: ./logout.php?auto=1&url=$url");
		die();
	}
}


// Construction des identifiants de la ressource $room, du domaine $area, du site $id_site
Definition_ressource_domaine_site();

# Note $room will be -1 if there are no rooms; this is checked for below.
// Récupération des données concernant l'affichage du planning du domaine
get_planning_area_values($area);
// Paramètres langage
include "include/language.inc.php";





// On affiche le lien "format imprimable" en bas de la page
$affiche_pview = '1';
if (!isset($_GET['pview'])) $_GET['pview'] = 0; else $_GET['pview'] = 1;
if ($_GET['pview'] == 1)
	$class_image = "print_image";
else
	$class_image = "image";

if (empty($debug_flag)) $debug_flag = 0;
$date_now = time();
# If we don't know the right date then use today:
if (!isset($day) or !isset($month) or !isset($year))
{
	if ($date_now < getSettingValue("begin_bookings"))
		$date_ = getSettingValue("begin_bookings");
	else if ($date_now > getSettingValue("end_bookings"))
		$date_ = getSettingValue("end_bookings");
	else
		$date_ = $date_now;
	$day   = date("d",$date_);
	$month = date("m",$date_);
	$year  = date("Y",$date_);
} else {
		// Vérification des dates
	settype($month,"integer");
	settype($day,"integer");
	settype($year,"integer");
	$minyear = strftime("%Y", getSettingValue("begin_bookings"));
	$maxyear = strftime("%Y", getSettingValue("end_bookings"));
	if ($day < 1) $day = 1;
	if ($day > 31) $day = 31;
	if ($month < 1) $month = 1;
	if ($month > 12) $month = 12;
	if ($year < $minyear) $year = $minyear;
	if ($year > $maxyear) $year = $maxyear;
		# Make the date valid if day is more then number of days in month:
	while (!checkdate($month, $day, $year))
		$day--;
}


if ((getSettingValue("authentification_obli")==0) and (getUserName()=='')) {
	$type_session = "no_session";
} else {
	$type_session = "with_session";
}

# Affichage de header
print_header($day, $month, $year, $area, $type_session);

$back = '';
if (isset($_SERVER['HTTP_REFERER'])) $back = htmlspecialchars($_SERVER['HTTP_REFERER']);
// calcul de l'accès à la ressource en fonction du niveau de l'utilisateur
$verif_acces_ressource = verif_acces_ressource(getUserName(), $room);
// Calcul du niveau d'accès aux fiche de réservation détaillées des ressources
$acces_fiche_reservation = verif_acces_fiche_reservation(getUserName(), $room);
// calcul du test si l'utilisateur a la possibilité d'effectuer une réservation, compte tenu
// des limitations éventuelles de la ressources et du nombre de réservations déjà effectuées.
$UserRoomMaxBooking = UserRoomMaxBooking(getUserName(), $room, 1);
// calcul du niverau de droit de réservation
$authGetUserLevel = authGetUserLevel(getUserName(),-1);
// Determine si un visiteur peut réserver une ressource
$auth_visiteur = auth_visiteur(getUserName(),$room);


if (check_begin_end_bookings($day, $month, $year))
{
	showNoBookings($day, $month, $year, $area,$back,$type_session);
	exit();
}
if (((authGetUserLevel(getUserName(),-1) < 1) and (getSettingValue("authentification_obli")==1)) or !$verif_acces_ressource)
{
	showAccessDenied($day, $month, $year, $area,$back);
	exit();
}
if (authUserAccesArea(getUserName(), $area)==0)
{
	showAccessDenied($day, $month, $year, $area,$back);
	exit();
}
# Set the date back to the previous $weekstarts day (Sunday, if 0):
$time = mktime(0, 0, 0, $month, $day, $year);
$time_old = $time;

// date("w", $time) : jour de la semaine en partant de dimancche
// date("w", $time) - $weekstarts : jour de la semaine en partant du jour défini dans GRR
// Si $day ne correspond pas au premier jour de la semaine tel que défini dans GRR,
// on recule la date jusqu'au précédent début de semaine
// Evidemment, problème possible avec les changement été-hiver et hiver-été
if (($weekday = (date("w", $time) - $weekstarts + 7) % 7) > 0)
{
	$time -= $weekday * 86400;
}
// Si le dimanche correspondant au changement d'heure est entre $time et $time_old, on corrige de +1 h ou -1 h.
if (!isset($correct_heure_ete_hiver) or ($correct_heure_ete_hiver == 1)) {
	if ((heure_ete_hiver("ete",$year,0) <= $time_old) and (heure_ete_hiver("ete",$year,0) >= $time) and ($time_old != $time) and (date("H", $time)== 23))
		$decal = 3600;
	else
		$decal = 0;
	$time += $decal;
}

// On vérifie une fois par jour si le délai de confirmation des réservations est dépassé
// Si oui, les réservations concernées sont supprimées et un mail automatique est envoyé.
// On vérifie une fois par jour que les ressources ont été rendue en fin de réservation
// Si non, une notification email est envoyée
if (getSettingValue("verif_reservation_auto")==0) {
	verify_confirm_reservation();
	verify_retard_reservation();
}

// $day_week, $month_week, $year_week sont jours, semaines et années correspondant au premier jour de la semaine
$day_week   = date("d", $time);
$month_week = date("m", $time);
$year_week  = date("Y", $time);



if ($enable_periods=='y') {
	$resolution = 60;
	$morningstarts = 12;
	$morningstarts_minutes = 0;
	$eveningends = 12;
	$eveningends_minutes = count($periods_name)-1;
}


# Define the start of day and end of day (default is 7-7)
$am7=mktime($morningstarts,0,0,$month_week,$day_week,$year_week);
$pm7=mktime($eveningends,$eveningends_minutes,0,$month,$day_week,$year_week);

# Start and end of week:
$week_midnight = mktime(0, 0, 0, $month_week, $day_week, $year_week);
$week_start = $am7;
$week_end = mktime($eveningends, $eveningends_minutes, 0, $month_week, $day_week+6, $year_week);
$this_area_name = "";
$this_room_name = "";



$this_area_name = grr_sql_query1("select area_name from ".TABLE_PREFIX."_area where id=$area");
$this_area_resolution = grr_sql_query1("select resolution_area from ".TABLE_PREFIX."_area where id=$area");
$this_room_name = grr_sql_query1("select room_name from ".TABLE_PREFIX."_room where id=$room");
$this_room_name_des = grr_sql_query1("select description from ".TABLE_PREFIX."_room where id=$room");
$this_statut_room = grr_sql_query1("select statut_room from ".TABLE_PREFIX."_room where id=$room");
$this_moderate_room = grr_sql_query1("select moderate from ".TABLE_PREFIX."_room where id=$room");
$this_delais_option_reservation = grr_sql_query1("select delais_option_reservation from ".TABLE_PREFIX."_room where id=$room");
$this_area_comment = grr_sql_query1("select comment_room from ".TABLE_PREFIX."_room where id=$room");
$this_area_show_comment = grr_sql_query1("select show_comment from ".TABLE_PREFIX."_room where id=$room");




# Don't continue if this area has no rooms:
if ($room <= 0)
{
	echo "<h1>".get_vocab("no_rooms_for_area")."</h1>";
	exit;
}
//insertion du menu_gauche.php
include("menu_gauche.php");

echo "<div id=\"planning\">";

include "chargement.php";

echo "<div class=\"titre_planning_week\">";



# Show area and room:
if (($this_room_name_des) and ($this_room_name_des!="-1")) {
	$this_room_name_des = " (".$this_room_name_des.")";
} else {
	$this_room_name_des = "";
}
// Les cellules "jours de semaine"
switch ($dateformat) {
	case "en":
	$dformat = "%A, %b&nbsp;%d";
	break;
	case "fr":
	$dformat = "%A %d&nbsp;%b";
	break;
}




#y? are year, month and day of the previous week.
#t? are year, month and day of the next week.

$i= mktime(0,0,0,$month_week,$day_week-7,$year_week);
$yy = date("Y",$i);
$ym = date("m",$i);
$yd = date("d",$i);

$i= mktime(0,0,0,$month_week,$day_week+7,$year_week);
$ty = date("Y",$i);
$tm = date("m",$i);
$td = date("d",$i);


if (verif_display_fiche_ressource(getUserName(), $room) and $_GET['pview'] != 1)
	echo "<a href='javascript:centrerpopup(\"view_room.php?id_room=$room\",600,480,\"scrollbars=yes,statusbar=no,resizable=yes\")' title=\"".get_vocab("fiche_ressource")."\">
<img src=\"img_grr/details.png\" alt=\"détails\" class=\"".$class_image."\"  /></a>";
if (authGetUserLevel(getUserName(),$room) > 2 and $_GET['pview'] != 1)
	echo "<a href='admin_edit_room.php?room=$room'><img src=\"img_grr/editor.png\" alt=\"configuration\" title=\"".get_vocab("Configurer la ressource")."\" width=\"30\" height=\"30\" class=\"".$class_image."\"  /></a>";

// La ressource est-elle empruntée ?
affiche_ressource_empruntee($room);

if ($this_statut_room == "0")
	echo "<br /><span class=\"texte_ress_tempo_indispo\">".get_vocab("ressource_temporairement_indisponible")."/>";
if ($this_moderate_room == "1")
	echo "<br /><span class=\"texte_ress_moderee\">".get_vocab("reservations_moderees")."/>";
if ($this_area_show_comment == "y" and $_GET['pview'] != 1 and ($this_area_comment!="") and ($this_area_comment!=-1))
	echo "<span style=\"text-align:center;\">".$this_area_comment."/>";



 //Test si le format est imprimable
if ((!isset($_GET['pview'])) || ($_GET['pview'] != 1))
{
	#Show Go to week before and after links
	echo "<table width=\"100%\">
	<tr>
		<td align=\"left\">
			<input type=\"button\" class=\"btn btn-default btn-xs\" onclick=\"charger();javascript: location.href='week.php?year=$yy&amp;month=$ym&amp;day=$yd&amp;room=$room';\" value=\"".get_vocab("weekbefore")."\" />
		</td>
		<td>";

			include "include/trailer.inc.php";

			echo "</td>
			<td align=\"right\">
				<input type=\"button\" class=\"btn btn-default btn-xs\" onclick=\"charger();javascript: location.href='week.php?year=$ty&amp;month=$tm&amp;day=$td&amp;room=$room';\" value=\"".get_vocab('weekafter')."\" />
			</td>
		</tr>
	</table>";
	/*-----MAJ David VOUE --> Ajout de la balise </table> * 14/01/2014*/ 
}
/*-----MAJ Loïs THOMAS  --> Lien qui permet de  le menu à gauche -----*/
//echo "<table><tr>";
		//Test si le format est imprimable
$setting = getSettingValue("menu_gauche");
if ((!isset($_GET['pview'])) || ($_GET['pview'] != 1))
{
	if ($setting == 0)
	{
				/*echo "<td align=\"left\"> ";
				echo "<input type=\"button\" id=\"cacher\" value=\"cacher le menu à gauche.\" onClick=\"divcache()\" style=\"display:inline;\"/>";
				echo "<input type=\"button\" id=\"voir\" value=\"afficher le menu à gauche.\" onClick=\"divaffiche()\" style=\"display:none;\" /> ";
				echo "</td>";*/
			}
		}
		//echo "<td width=\"100%\">";
		echo "<h4 class=\"titre\">".get_vocab("week").get_vocab("deux_points").utf8_strftime($dformat, $week_start)." - ". utf8_strftime($dformat, $week_end);
		echo " ".ucfirst($this_area_name)." - $this_room_name $this_room_name_des</h4>";
		//echo "</td>";
		//echo " </tr></table>";
		echo "</div>\n";
 //Lien précedent dans le format imprimable
		if (isset($_GET['precedent']))
		{
			if ($_GET['pview'] == 1 AND $_GET['precedent'] == 1) {
				echo "<span id=\"lienPrecedent\">
				<button class=\"btn btn-default btn-xs\" onclick=\"charger();javascript:history.back();\">Précedent</button>
			</span>";
		}
	}
	
	echo " <div class=\"contenu_planning\">" ;
#Get all appointments for this week in the room that we care about
# row[0] = Start time
# row[1] = End time
# row[2] = Entry type
# row[3] = Entry name (brief description)
# row[4] = Entry ID
# row[5] = beneficiaire of the booking
# row[6] = status of the booking
# row[7] = Full description
# The range predicate (starts <= week_end && ends > week_start) is
# equivalent but more efficient than the original 3-BETWEEN clauses.
	$sql = "SELECT start_time, end_time, type, name, id, beneficiaire, statut_entry, description, option_reservation, moderate, beneficiaire_ext
	FROM ".TABLE_PREFIX."_entry
	WHERE room_id=$room
	AND start_time < ".($week_end+$resolution)." AND end_time > $week_start ORDER BY start_time";

# Chaque tableau row retourné par la requête est une réservation.
# On construit alors un tableau de la forme :
# d[weekday][slot][x], où x = id, color, data.
# [slot] is based at 0 for midnight, but only slots within the hours of
# interest (morningstarts : eveningends) are filled in.
# [id] and [data] are only filled in when the meeting should be labeled,
# which is once for each meeting on each weekday.
# Note: weekday here is relative to the $weekstarts configuration variable.
# If 0, then weekday=0 means Sunday. If 1, weekday=0 means Monday.

	$first_slot = $morningstarts * 3600 / $resolution;
	$last_slot = ($eveningends * 3600 + $eveningends_minutes * 60) / $resolution;

	if ($debug_flag) echo "<br />DEBUG: query=$sql <br />first_slot=$first_slot - last_slot=$last_slot\n";

	$res = grr_sql_query($sql);
	if (! $res) echo grr_sql_error();
	else for ($i = 0; ($row = grr_sql_row($res, $i)); $i++)
	{
		if ($debug_flag)
			echo "<br />DEBUG: result $i, id $row[4], starts $row[0] (".affiche_date($row[0])."), ends $row[1] (".affiche_date($row[1]).")\n";

		# Fill in slots for the meeting. Start at the meeting start time or
		# week start (which ever is later), and end one slot before the meeting
		# end time or week end (which ever is earlier).
		# Note: int casts on database rows for min and max is needed for PHP3.

		// Pour la réservation en cours, on détermine le début de la journée $debut_jour
		$month_current = date("m",$row[0]);
		$day_current = date("d",$row[0]);
		$year_current  = date("Y",$row[0]);
		$debut_jour=mktime($morningstarts,0,0,$month_current,$day_current,$year_current);

		$t = max(round_t_down($row[0], $resolution, $debut_jour), $week_start);
		$end_t = min((int)round_t_up((int)$row[1],
			(int)$resolution, $debut_jour),
		(int)$week_end+1);
		$weekday = (date("w", $t) + 7 - $weekstarts) % 7;

		$prev_weekday = -1; # Invalid value to force initial label.
		$slot = ($t - $week_midnight) % 86400 / $resolution;

		do
		{
			if ($debug_flag) echo "<br />DEBUG: t=$t (".affiche_date($t)."), end_t=$end_t (".affiche_date($end_t)."), weekday=$weekday, slot=$slot\n";

			if ($slot < $first_slot)
			{
						# This is before the start of the displayed day; skip to first slot.
				$slot = $first_slot;
				$t = $weekday * 86400 + $am7;
				continue;
			}

			if ($slot <= $last_slot)
			{
						# This is within the working day; color it.
				$d[$weekday][$slot]["color"] = $row[2];

				$d[$weekday][$slot]["horaireDebut"] = $row[0];
				$d[$weekday][$slot]["horaireFin"] = $row[1] ;
				$d[$weekday][$slot]["duree"] = ($row[1]- $row[0])/$this_area_resolution;
						# Only label it if it is the first time on this day:
				if ($prev_weekday != $weekday)
				{
					$prev_weekday = $weekday;
					$d[$weekday][$slot]["data"] = affichage_lien_resa_planning($row[3],$row[4]);
					$d[$weekday][$slot]["id"] = $row[4];
								// Info-bulle
					if (getSettingValue("display_info_bulle") == 1)
						$d[$weekday][$slot]["who"] = get_vocab("reservee au nom de").affiche_nom_prenom_email($row[5],$row[10],"nomail");
					else if (getSettingValue("display_info_bulle") == 2)
						$d[$weekday][$slot]["who"] = $row[7];
					else
						$d[$weekday][$slot]["who"] = "";
					$d[$weekday][$slot]["statut"] = $row[6];
					$d[$weekday][$slot]["description"] = affichage_resa_planning($row[7],$row[4]);
					$d[$weekday][$slot]["option_reser"] = $row[8];
					$d[$weekday][$slot]["moderation"] = $row[9];
				}
			}
				# Step to next time period and slot:
			$t += $resolution;
			$slot++;

			if ($slot > $last_slot)
			{
						# Skip to first slot of next day:
				$weekday++;
				$slot = $first_slot;
				$t = $weekday * 86400 + $am7;
			}
		} while ($t < $end_t);
	}
	if ($debug_flag)
	{
		echo "<p>DEBUG:<p><pre>\n";
		if (gettype($d) == "array")
			while (list($w_k, $w_v) = each($d))
				while (list($t_k, $t_v) = each($w_v))
					while (list($k_k, $k_v) = each($t_v))
						echo "d[$w_k][$t_k][$k_k] = '$k_v'\n";
					else echo "d is not an array!\n";
					echo "</pre><p>\n";
				}

#This is where we start displaying stuff
				echo "<table cellspacing=\"0\" border=\"1\" width=\"100%\">";

// Affichage de la première ligne contenant le nom des jours (lundi, mardi, ...) et les dates ("10 juil", "11 juil", ...)
				echo "<tr>\n<th style=\"width:5%;\">";

				if ($enable_periods=='y')
					echo get_vocab("period");
				else
					echo get_vocab("time");

echo "</th>\n"; // Première cellule vide


// Affichage du lien sur la journée avec  l'intitulé "du jours" avec lien vers day.php


$num_week_day = $weekstarts;// Pour le calcul des jours à afficher
$k=$day_week;
$i = $time;
$num_week_day = $weekstarts; // Pour le calcul des jours à afficher
for ($t = $week_start; $t <= $week_end; $t += 86400) {
	$num_day = strftime("%d", $t);
	$month_actuel = strftime("%m", $t);
	$year_actuel  = date("Y",$t);
	$jour_cycle = grr_sql_query1("SELECT Jours FROM ".TABLE_PREFIX."_calendrier_jours_cycle WHERE DAY='$i'");
		if ($display_day[$num_week_day] == 1) {// on n'affiche pas tous les jours de la semaine

		echo "<th style=\"width:14%;\"><a onclick=\"charger()\" class=\"lienPlanning\" title=\"".htmlspecialchars(get_vocab("see_all_the_rooms_for_the_day"))."\" href=\"day.php?year=$year_actuel&amp;month=$month_actuel&amp;day=$num_day&amp;area=$area\">". utf8_strftime($dformat, $t)."</a>";

		if (getSettingValue("jours_cycles_actif") == "Oui" and intval($jour_cycle)>-1)
			if (intval($jour_cycle)>0)
				echo "<br />".get_vocab("rep_type_6")." ".$jour_cycle;
			else
				echo "<br />".$jour_cycle;

			echo "</th>\n";
		}
		if (!isset($correct_heure_ete_hiver) or ($correct_heure_ete_hiver == 1)) {
			$num_day = strftime("%d", $t);
				// Si le dernier dimanche d'octobre est dans la semaine, on avance d'une heure
			if (heure_ete_hiver("hiver",$year,0) == mktime(0,0,0,$month,$num_day,$year))
				$t +=3600;
			if ((date("H",$t) == "13") or (date("H",$t) == "02"))
				$t -=3600;
		}
		$i += 86400;
		$k++;
		$num_week_day++;// Pour le calcul des jours à afficher
		$num_week_day = $num_week_day % 7;// Pour le calcul des jours à afficher
	}
// Fin de l'affichage de la première ligne

	echo "</tr>\n";


// Début affichage des lignes contenant les réservations
// Première boucle basée sur les créneaux de temps
// Deuxième boucle interne sur les jours de la semaine


# $t is the date/time for the first day of the week (Sunday, if $weekstarts=0).
# $wt is for the weekday in the inner loop.
	$t = $am7;
	$nb_case=0;
	$semaine_changement_heure_ete = 'no';
	$semaine_changement_heure_hiver = 'no';
	for ($slot = $first_slot; $slot <= $last_slot; $slot++)
	{
		# Show the time linked to the URL for highlighting that time:
		echo "<tr>";
		tdcell("cell_hours");
		if ($enable_periods=='y'){
			$time_t = date("i", $t);
			$time_t_stripped = preg_replace( "/^0/", "", $time_t );
			echo $periods_name[$time_t_stripped] . "</td>\n";
		} else {
			echo affiche_heure_creneau($t,$resolution)."</td>\n";
		}
		$wt = $t;

		$empty_color = "empty_cell";

		# See note above: weekday==0 is day $weekstarts, not necessarily Sunday.
		$num_week_day = $weekstarts;// Pour le calcul des jours à afficher
		for ($weekday = 0; $weekday < 7; $weekday++)
		{
				# Three cases:
				# color:  id:   Slot is:   Color:    Link to:
				# -----   ----- --------   --------- -----------------------
				# unset   -     empty      white,red add new entry
				# set     unset used       by type   none (unlabelled slot)
				# set     set   used       by type   view entry

			$wday = date("d", $wt);
			$wmonth = date("m", $wt);
			$wyear = date("Y", $wt);
			$hour = date("H",$wt);
			$minute  = date("i",$wt);

			if (!isset($correct_heure_ete_hiver) or ($correct_heure_ete_hiver == 1)) {
						// Gestion du passage à l'heure d'été
				$temp =   mktime(0,0,0,$wmonth,$wday,$wyear);
						// On regarde s'il s'agit du dernier dimanche de mars
				if (heure_ete_hiver("ete",$wyear,0) == $temp) {
					$semaine_changement_heure_ete = 'yes';
					$temp2 =   mktime($hour,0,0,$wmonth,$wday,$wyear);
								// 2 h du matin
					if (heure_ete_hiver("ete", $wyear,2) == $temp2) {
										// On insère une case vide
						if ($display_day[$num_week_day] == 1)
							echo tdcell($empty_color)."-</td>\n";
										// On compte le nombre de cases insérées
						$nb_case++;
						$insere_case = 'y';
								// Après deux heures du matin, on avance d'une heure
					} else if (heure_ete_hiver("ete", $wyear,2) < $temp2) {
						$hour = date("H",$wt-3600);
						$decale_slot = 1;
						$insere_case = 'n';
					}
						// On regarde s'il s'agit du dernier dimanche d'octobre
				} else if (heure_ete_hiver("hiver",$wyear,0) == $temp) {
					$semaine_changement_heure_hiver = 'yes';
					$temp2 =   mktime($hour,0,0,$wmonth,$wday,$wyear);
								// 2 h du matin
					if (heure_ete_hiver("hiver", $wyear,2) == $temp2) {
										// On compte le nombre de cases
						$nb_case = $nb_case + 0.5;
										// On n'insère pas de cellule
						$insere_case = 'n';
								// Après deux heures du matin, on retarde d'une heure
					} else if (heure_ete_hiver("hiver", $wyear,2) < $temp2) {
						$hour = date("H",$wt+3600);
						$decale_slot = -1;
						$insere_case = 'n';
					}
				} else {
					$decale_slot = 0;
					$insere_case = 'n';
								// Dans le cas où on est dans une semaine de changement d'heure
								// Pour les jours qui suivent le dimanche, il faut continuer de décaler
					if (($semaine_changement_heure_ete == 'yes') and (heure_ete_hiver("ete",$wyear,0) < $temp)) {
						$decale_slot = 1;
						$hour = date("H",$wt-3600);
					}
					if (($semaine_changement_heure_hiver == 'yes') and (heure_ete_hiver("hiver",$wyear,0) < $temp)) {
						$decale_slot = -1;
						$hour = date("H",$wt+3600);
					}

				}
			} else {
				$decale_slot = 0;
				$insere_case = 'n';
			}
				// Fin gestion du passage à l'heure d'été

			if (($insere_case=='n') and ($display_day[$num_week_day] == 1)) {
				if (!isset($d[$weekday][$slot-$decale_slot*$nb_case]["color"])) // il s'agit d'un créneau libre
				{
					$date_booking = mktime($hour, $minute, 0, $wmonth, $wday, $wyear);
					if ($this_statut_room == "0") tdcell("avertissement"); else tdcell($empty_color);

					if (est_hors_reservation(mktime(0,0,0,$wmonth,$wday,$wyear),$area))
						echo "<img src=\"img_grr/stop.png\" alt=\"".get_vocab("reservation_impossible")."\"  title=\"".get_vocab("reservation_impossible")."\" width=\"16\" height=\"16\" class=\"".$class_image."\"  />";
					else
						if ((($authGetUserLevel > 1) or  ($auth_visiteur == 1))
							and ($UserRoomMaxBooking != 0)
							and verif_booking_date(getUserName(), -1,$room, $date_booking, $date_now, $enable_periods)
							and verif_delais_max_resa_room(getUserName(), $room, $date_booking)
							and verif_delais_min_resa_room(getUserName(), $room, $date_booking)
							and (($this_statut_room == "1") or
								(($this_statut_room == "0") and (authGetUserLevel(getUserName(),$room) > 2) ))
							and $_GET['pview'] != 1) {
							if ($enable_periods=='y') {
								echo "<a href=\"edit_entry.php?room=$room"
								. "&amp;period=$time_t_stripped&amp;year=$wyear&amp;month=$wmonth"
								. "&amp;day=$wday&amp;page=week\" title=\"".get_vocab("cliquez_pour_effectuer_une_reservation")."\"><img src=\"img_grr/new.gif\" alt=\"".get_vocab("add")."\" cz class=\"".$class_image."\"  />";
								echo "</a>";
							} else {
								echo "<a href=\"edit_entry.php?room=$room"
								. "&amp;hour=$hour&amp;minute=$minute&amp;year=$wyear&amp;month=$wmonth"
								. "&amp;day=$wday&amp;page=week\" title=\"".get_vocab("cliquez_pour_effectuer_une_reservation")."\"><img src=\"img_grr/new.gif\" alt=\"".get_vocab("add")."\" width=\"16\" height=\"16\" class=\"".$class_image."\"  />";
								echo "</a>";
							}
						} else {
							echo "&nbsp;";
						}

					} else {
						if (est_hors_reservation(mktime(0,0,0,$wmonth,$wday,$wyear),$area))
							echo tdcell($empty_color)."<img src=\"img_grr/stop.png\" alt=\"".get_vocab("reservation_impossible")."\"  title=\"".get_vocab("reservation_impossible")."\" width=\"16\" height=\"16\" class=\"".$class_image."\"  />";
						else {
							if (isset($d[$weekday][$slot-$decale_slot*$nb_case]["id"])) {

								$nbrow =  $d[$weekday][$slot-$decale_slot*$nb_case]["duree"];
								tdcell_rowspan($d[$weekday][$slot-$decale_slot*$nb_case]["color"],$nbrow);


								if ($acces_fiche_reservation)
								{
									/*MAJ Loïs THOMAS <-----Test permettant de savoir le format d'ouverture pour les informations sur les réservations----->  */
									if (getSettingValue("display_level_view_entry")==0){
										$currentPage ='week';
										$id =  $d[$weekday][$slot-$decale_slot*$nb_case]["id"];

										echo "<a title=\"".htmlspecialchars($d[$weekday][$slot-$decale_slot*$nb_case]["who"])."\"  href=\"#?w=500\" onclick=\"request($id,$wday,$wmonth,$wyear,'$currentPage',readData);\" rel=\"popup_name\" class=\"poplight\">" ;

									}
									else
									{
										echo "<a class=\"lienCellule\" title=\"".htmlspecialchars($d[$weekday][$slot-$decale_slot*$nb_case]["who"])."\"  href=\"view_entry.php?id=" . $d[$weekday][$slot-$decale_slot*$nb_case]["id"]."&amp;day=$wday&amp;month=$wmonth&amp;year=$wyear&amp;page=week\">";
									}
								}


								echo $d[$weekday][$slot-$decale_slot*$nb_case]["data"]."";

								/*MAJ Loïs THOMAS <-----Requete permettant d'avoir le genre----->  */
								$Son_GenreRepeat = grr_sql_query1("SELECT type_name FROM ".TABLE_PREFIX."_type_area ,".TABLE_PREFIX."_entry  WHERE  ".TABLE_PREFIX."_entry.id= ". $d[$weekday][$slot-$decale_slot*$nb_case]['id']." AND ".TABLE_PREFIX."_entry.type= ".TABLE_PREFIX."_type_area.type_letter");
								if ($Son_GenreRepeat != -1){
									/*Affichage du genre et des horaires */

										/*MAJ David VOUE <----Ajouts de <br> pour aérer le texte
										 *16/01/2014*/
										echo "<br />" .date('H:i',$d[$weekday][$slot-$decale_slot*$nb_case]["horaireDebut"])."~". date('H:i',$d[$weekday][$slot-$decale_slot*$nb_case]["horaireFin"])."";
										echo " <br/>". $Son_GenreRepeat ." <br/><br/>" ;
									}



									if ($d[$weekday][$slot-$decale_slot*$nb_case]["description"]!= "")
										echo "<i>".$d[$weekday][$slot-$decale_slot*$nb_case]["description"]."</i>";

									if ($acces_fiche_reservation)echo"</a>";
								}


						// si la ressource est "occupée, on l'affiche
								if ((isset($d[$weekday][$slot-$decale_slot*$nb_case]["statut"])) and ($d[$weekday][$slot-$decale_slot*$nb_case]["statut"]!='-')) echo "&nbsp;<img src=\"img_grr/buzy.png\" alt=\"".get_vocab("ressource actuellement empruntee")."\" title=\"".get_vocab("ressource actuellement empruntee")."\" width=\"20\" height=\"20\" class=\"image\" />&nbsp;\n";
						// si la réservation est à confirmer, on le signale
								if (($this_delais_option_reservation > 0) and (isset($d[$weekday][$slot-$decale_slot*$nb_case]["option_reser"])) and ($d[$weekday][$slot-$decale_slot*$nb_case]["option_reser"]!=-1)) echo "&nbsp;<img src=\"img_grr/small_flag.png\" alt=\"".get_vocab("reservation_a_confirmer_au_plus_tard_le")."\" title=\"".get_vocab("reservation_a_confirmer_au_plus_tard_le")."&nbsp;".time_date_string_jma($d[$weekday][$slot-$decale_slot*$nb_case]["option_reser"],$dformat)."\" width=\"20\" height=\"20\" class=\"image\" />&nbsp;\n";
						// si la réservation est à modérer, on le signale
								if ((isset($d[$weekday][$slot-$decale_slot*$nb_case]["moderation"])) and ($d[$weekday][$slot-$decale_slot*$nb_case]["moderation"]=='1'))
									echo "&nbsp;<img src=\"img_grr/flag_moderation.png\" alt=\"".get_vocab("en_attente_moderation")."\" title=\"".get_vocab("en_attente_moderation")."\" class=\"image\" />&nbsp;\n";


							}
						}


						echo "</td>\n";
					}
					$wt += 86400;
				$num_week_day++;// Pour le calcul des jours à afficher
				$num_week_day = $num_week_day % 7;// Pour le calcul des jours à afficher

			}
		// Heure
			if ($enable_periods=='y'){
				$time_t = date("i", $t);
				$time_t_stripped = preg_replace( "/^0/", "", $time_t );
			}
			$t += $resolution;
		}



		echo "</table>";
		if ($_GET['pview'] != 1)

			/*-----MAJ Loïs THOMAS  --> Lien permettant de revenir en haut de la page -----*/
		/*echo "<button class=\"btn btn-default btn-xs\" onclick=\"javascript: location.href='#haut_de_page';\">Haut de page</button>";*/


//MAJ Hugo FORESTIER - Mise en place d'un bouton 'retour en haut de la page' en jQuery
//14/05/2013
//echo "<div id=\"toTop\"> ^ Haut de la page";

		echo "<div id=\"toTop\"><b>".get_vocab("top_of_page")."</b>";
		bouton_retour_haut ();
		echo " </div>";


//Fermture DIV contenu
		echo " </div>";
//Fermeture DIV Panning
		echo " </div>";
//DIV POP UP
		echo  "<div id=\"popup_name\" class=\"popup_block\" ></div>";
// Affichage d'un message pop-up
		affiche_pop_up(get_vocab("message_records"),"user");



		?>





