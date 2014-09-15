<?php
/**
 * week_all.php
 * Permet l'affichage des r?servation d'une semaine pour toutes les ressources d'un domaine.
 * Ce script fait partie de l'application GRR
 * Derni?re modification : $Date: 2009-12-02 20:11:08 $
 * @author    Laurent Delineau <laurent.delineau@ac-poitiers.fr>
 * @copyright Copyright 2003-2008 Laurent Delineau
 * @link      http://www.gnu.org/licenses/licenses.html
 * @package   root
 * @version   $Id: week_all.php,v 1.18 2009-12-02 20:11:08 grr Exp $
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
 * $Log: week_all.php,v $
 * Revision 1.18  2009-12-02 20:11:08  grr
 * *** empty log message ***
 *
 * Revision 1.17  2009-09-29 18:02:57  grr
 * *** empty log message ***
 *
 * Revision 1.16  2009-06-04 20:52:24  grr
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
 * Revision 1.12  2009-01-20 07:19:17  grr
 * *** empty log message ***
 *
 * Revision 1.11  2008-11-16 22:00:59  grr
 * *** empty log message ***
 *
 * Revision 1.10  2008-11-14 07:29:09  grr
 * *** empty log message ***
 *
 * Revision 1.9  2008-11-13 21:32:51  grr
 * *** empty log message ***
 *
 * Revision 1.8  2008-11-11 22:01:14  grr
 * *** empty log message ***
 *
 * Revision 1.7  2008-11-10 08:17:34  grr
 * *** empty log message ***
 *
 * Revision 1.6  2008-11-10 07:06:39  grr
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
$grr_script_name = "week_all.php";
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
};

// Param?tres langage
include "include/language.inc.php";


// On affiche le lien "format imprimable" en bas de la page
$affiche_pview = '1';
if (!isset($_GET['pview'])) $_GET['pview'] = 0; else $_GET['pview'] = 1;
if ($_GET['pview'] == 1)
	$class_image = "print_image";
else
	$class_image = "image";


# Default parameters:
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
	// V?rification des dates
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
$back = '';
if (isset($_SERVER['HTTP_REFERER'])) $back = htmlspecialchars($_SERVER['HTTP_REFERER']);

// Construction des identifiants de la ressource $room, du domaine $area, du site $id_site
Definition_ressource_domaine_site();

if (check_begin_end_bookings($day, $month, $year))
{
	showNoBookings($day, $month, $year, $area,$back,$type_session);
	exit();
}
 # Affichage de header
print_header($day, $month, $year, $area, $type_session);

if ((authGetUserLevel(getUserName(),-1) < 1) and (getSettingValue("authentification_obli")==1))
{
	showAccessDenied($day, $month, $year, $area,$back);
	exit();
}
if (authUserAccesArea(getUserName(), $area)==0)
{
	showAccessDenied($day, $month, $year, $area,$back);
	exit();
}

// Fonction de comparaison
// 3-value compare: Returns result of compare as "< " "= " or "> ".
function cmp3($a, $b)
{
	if ($a < $b) return "< ";
	if ($a == $b) return "= ";
	return "> ";
}

// On v?rifie une fois par jour si le d?lai de confirmation des r?servations est d?pass?
// Si oui, les r?servations concern?es sont supprim?es et un mail automatique est envoy?.
// On v?rifie une fois par jour que les ressources ont ?t? rendue en fin de r?servation
// Si non, une notification email est envoy?e
if (getSettingValue("verif_reservation_auto")==0) {
	verify_confirm_reservation();
	verify_retard_reservation();
}


// R?cup?ration des donn?es concernant l'affichage du planning du domaine
get_planning_area_values($area);


if ($enable_periods=='y') {
	$resolution = 60;
	$morningstarts = 12;
	$morningstarts_minutes = 0;
	$eveningends = 12;
	$eveningends_minutes = count($periods_name)-1;
}

$time = mktime(0, 0, 0, $month, $day, $year);
$time_old = $time;
// date("w", $time) : jour de la semaine en partant de dimancche
// date("w", $time) - $weekstarts : jour de la semaine en partant du jour d?fini dans GRR
// Si $day ne correspond pas au premier jour de la semaine tel que d?fini dans GRR,
// on recule la date jusqu'au pr?c?dent d?but de semaine
// Evidemment, probl?me possible avec les changement ?t?-hiver et hiver-?t?
if (($weekday = (date("w", $time) - $weekstarts + 7) % 7) > 0)
{
	$time -= $weekday * 86400;
}
if (!isset($correct_heure_ete_hiver) or ($correct_heure_ete_hiver == 1)) {
	// Si le dimanche correspondant au changement d'heure est entre $time et $time_old, on corrige de +1 h ou -1 h.
	if  ((heure_ete_hiver("ete",$year,0) <= $time_old) and (heure_ete_hiver("ete",$year,0) >= $time) and ($time_old != $time) and (date("H", $time)== 23))
		$decal = 3600;
	else
		$decal = 0;
	$time += $decal;
}

// $day_week, $month_week, $year_week sont jours, semaines et ann?es correspondant au premier jour de la semaine
$day_week   = date("d", $time);
$month_week = date("m", $time);
$year_week  = date("Y", $time);


//$date_start : date de d?but des r?servation ? extraire
$date_start = mktime($morningstarts,0,0,$month_week,$day_week,$year_week);

// Nombre de jours dans le mois
$days_in_month = date("t", $date_start);

if ($debug_flag)
	echo "$month_week $day_week ";

// $date_end : date de fin des r?servation ? extraire
$date_end = mktime($eveningends, $eveningends_minutes, 0, $month_week, $day_week+6, $year_week);



$this_area_name = grr_sql_query1("select area_name from ".TABLE_PREFIX."_area where id=$area");
# Show Month, Year, Area, Room header:
switch ($dateformat) {
	case "en":
	$dformat = "%A, %b %d";
	break;
	case "fr":
	$dformat = "%A %d %b";
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



# Used below: localized "all day" text but with non-breaking spaces:
$all_day = preg_replace("/ /", " ", get_vocab("all_day2"));

#Get all meetings for this month in the room that we care about
# row[0] = Start time
# row[1] = End time
# row[2] = Entry ID
# row[3] = Entry name (brief description)
# row[4] = beneficiaire of the booking
# row[5] =
# row[6] =color
# row[7] = status of the booking
# row[8] = Full description

$sql = "SELECT start_time, end_time, ".TABLE_PREFIX."_entry.id, name, beneficiaire, ".TABLE_PREFIX."_room.id,type, statut_entry, ".TABLE_PREFIX."_entry.description, ".TABLE_PREFIX."_entry.option_reservation, ".TABLE_PREFIX."_room.delais_option_reservation, ".TABLE_PREFIX."_entry.moderate, beneficiaire_ext
FROM ".TABLE_PREFIX."_entry, ".TABLE_PREFIX."_room, ".TABLE_PREFIX."_area
where
".TABLE_PREFIX."_entry.room_id=".TABLE_PREFIX."_room.id and
".TABLE_PREFIX."_area.id = ".TABLE_PREFIX."_room.area_id and
".TABLE_PREFIX."_area.id = '".$area."' and
start_time <= $date_end AND
end_time > $date_start
ORDER by start_time, end_time, ".TABLE_PREFIX."_entry.id";


# Build an array of information about each day in the month.
# The information is stored as:
#  d[monthday]["id"][] = ID of each entry, for linking.
#  d[monthday]["data"][] = "start-stop" times of each entry.
$res = grr_sql_query($sql);
if (! $res) echo grr_sql_error();
else for ($i = 0; ($row = grr_sql_row($res, $i)); $i++)
{
	# Fill in data for each day during the month that this meeting covers.
	# Note: int casts on database rows for min and max is needed for PHP3.
	$t = max((int)$row[0], $date_start);
	$end_t = min((int)$row[1], $date_end);

	$day_num = date("j", $t);
	$month_num = date("m", $t);
	$year_num = date("Y", $t);
	if ($enable_periods == 'y')
		$midnight = mktime(12,0,0,$month_num,$day_num,$year_num);
	else
		$midnight = mktime(0, 0, 0, $month_num, $day_num, $year_num);
// bug changement heure été/hiver
//    $midnight2 = gmmktime(0, 0, 0, $month_num, $day_num, $year_num);
	if ($debug_flag)
		echo "<br />DEBUG: result $i, id $row[2], starts $row[0], ends $row[1], temps en heures : ".($row[1]- $row[0])/(60*60).", midnight : $midnight \n";
	while ($t <= $end_t)
	{
		if ($debug_flag)
			echo "<br />DEBUG: Entry $row[2] day $day_num\n";
		$d[$day_num]["id"][] = $row[2];
		// Info-bulle
		if (getSettingValue("display_info_bulle") == 1)
			$d[$day_num]["who"][] = get_vocab("reservee au nom de").affiche_nom_prenom_email($row[4],$row[12],"nomail");
		else if (getSettingValue("display_info_bulle") == 2)
			$d[$day_num]["who"][] = $row[8];
		else
			$d[$day_num]["who"][] = "";
		$d[$day_num]["who1"][] = affichage_lien_resa_planning($row[3],$row[2]);
		$d[$day_num]["id_room"][]=$row[5] ;
		$d[$day_num]["color"][]=$row[6];
		$d[$day_num]["res"][] = $row[7];
		$d[$day_num]["description"][] = affichage_resa_planning($row[8],$row[2]);;
		if ($row[10] > 0)
			$d[$day_num]["option_reser"][] = $row[9];
		else
			$d[$day_num]["option_reser"][] = -1;
		$d[$day_num]["moderation"][] = $row[11];
		$midnight_tonight = $midnight + 86400;
		if (!isset($correct_heure_ete_hiver) or ($correct_heure_ete_hiver == 1)) {
			// on s'arrange pour que l'heure $midnight_tonight corresponde à 0 h (00:00:00: )
			if  (heure_ete_hiver("hiver",$year_num,0) == mktime(0,0,0,$month_num,$day_num,$year_num))
				$midnight_tonight +=3600;
			if (date("H",$midnight_tonight) == "01")
				$midnight_tonight -=3600;
		}


		# Describe the start and end time, accounting for "all day"
		# and for entries starting before/ending after today.
		# There are 9 cases, for start time < = or > midnight this morning,
		# and end time < = or > midnight tonight.
		# Use ~ (not -) to separate the start and stop times, because MSIE
		# will incorrectly line break after a -.
		if ($enable_periods == 'y') {
			$start_str = preg_replace("/ /", "&nbsp;", period_time_string($row[0]));
			$end_str   = preg_replace("/ /", "&nbsp;", period_time_string($row[1], -1));
			  // Debug
			  //echo affiche_date($row[0])." ".affiche_date($midnight)." ".affiche_date($row[1])." ".affiche_date($midnight_tonight)."<br />";
			switch (cmp3($row[0], $midnight) . cmp3($row[1], $midnight_tonight))
			{
			case "> < ":         # Starts after midnight, ends before midnight
			case "= < ":         # Starts at midnight, ends before midnight
			if ($start_str == $end_str)
				$d[$day_num]["data"][] = $start_str;
			else
				$d[$day_num]["data"][] = $start_str . "~" . $end_str;
			break;
			case "> = ":         # Starts after midnight, ends at midnight
			$d[$day_num]["data"][] = $start_str . "~24:00";
			break;
			case "> > ":         # Starts after midnight, continues tomorrow
			$d[$day_num]["data"][] = $start_str . "~&gt;";
			break;
			case "= = ":         # Starts at midnight, ends at midnight
			$d[$day_num]["data"][] = $all_day;
			break;
			case "= > ":         # Starts at midnight, continues tomorrow
			$d[$day_num]["data"][] = $all_day . "&gt;";
			break;
			case "< < ":         # Starts before today, ends before midnight
			$d[$day_num]["data"][] = "&lt;~" . $end_str;
			break;
			case "< = ":         # Starts before today, ends at midnight
			$d[$day_num]["data"][] = "&lt;" . $all_day;
			break;
			case "< > ":         # Starts before today, continues tomorrow
			$d[$day_num]["data"][] = "&lt;" . $all_day . "&gt;";
			break;
		}
	} else {
		switch (cmp3($row[0], $midnight) . cmp3($row[1], $midnight_tonight))
		{
			case "> < ":         # Starts after midnight, ends before midnight
			case "= < ":         # Starts at midnight, ends before midnight
			$d[$day_num]["data"][] = date(hour_min_format(), $row[0]) . "~" . date(hour_min_format(), $row[1]);
			break;
			case "> = ":         # Starts after midnight, ends at midnight
			$d[$day_num]["data"][] = date(hour_min_format(), $row[0]) . "~24:00";
			break;
			case "> > ":         # Starts after midnight, continues tomorrow
			$d[$day_num]["data"][] = date(hour_min_format(), $row[0]) . "~&gt;";
			break;
			case "= = ":         # Starts at midnight, ends at midnight
			$d[$day_num]["data"][] = $all_day;
			break;
			case "= > ":         # Starts at midnight, continues tomorrow
			$d[$day_num]["data"][] = $all_day . "&gt;";
			break;
			case "< < ":         # Starts before today, ends before midnight
			$d[$day_num]["data"][] = "&lt;~" . date(hour_min_format(), $row[1]);
			break;
			case "< = ":         # Starts before today, ends at midnight
			$d[$day_num]["data"][] = "&lt;" . $all_day;
			break;
			case "< > ":         # Starts before today, continues tomorrow
			$d[$day_num]["data"][] = "&lt;" . $all_day . "&gt;";
			break;
		}
	}

		# Only if end time > midnight does the loop continue for the next day.
	if ($row[1] <= $midnight_tonight) break;

	$t = $midnight = $midnight_tonight;
	$day_num = date("j", $t);
}
}

if ($debug_flag)
{
	echo "<p>DEBUG: Array of month day data:<p><pre>\n";
	for ($i = 1; $i <= $days_in_month; $i++)
	{
		if (isset($d[$i]["id"]))
		{
			$n = count($d[$i]["id"]);
			echo "Day $i has $n entries:\n";
			for ($j = 0; $j < $n; $j++)
				echo "  ID: " . $d[$i]["id"][$j] .
			" Data: " . $d[$i]["data"][$j] . "\n";
		}
	}
	echo "</pre>\n";
}

# We need to know what all the rooms area called, so we can show them all
# pull the data from the db and store it. Convienently we can print the room
# headings and capacities at the same time

$sql = "select room_name, capacity, id, description, statut_room from ".TABLE_PREFIX."_room where area_id='".$area."' order by order_display, room_name";
$res = grr_sql_query($sql);

# It might be that there are no rooms defined for this area.
# If there are none then show an error and dont bother doing anything
# else

 //Lien précedent dans le format imprimable
if (isset($_GET['precedent']))
{
	if ($_GET['pview'] == 1 && $_GET['precedent'] == 1)
	{
		echo "<span id=\"lienPrecedent\">
		<button class=\"btn btn-default btn-xs\" onclick=\"charger();javascript:history.back();\">Précedent</button>
	</span>";
}
}


if (!$res)
	fatal_error(0, grr_sql_error());
if (grr_sql_count($res) == 0)
{
	echo "<h1>".get_vocab("no_rooms_for_area")."</h1>";
	grr_sql_free($res);
}
else
{
	//insertion du menu_gauche.php
	include("menu_gauche.php");
	echo "<div id=\"planning\">";
	include "chargement.php";
	echo "<div class=\"titre_planning\"><table width=\"100%\">";
	//Test si le format est imprimable
	if ((!isset($_GET['pview'])) || ($_GET['pview'] != 1))
	{
	#Show Go to week before and after links
		echo "\n
		<tr>
			<td align=\"left\">
				<input type=\"button\"  onclick=\"charger();javascript: location.href='week_all.php?year=$yy&amp;month=$ym&amp;day=$yd&amp;area=$area';\" value=\"&lt;&lt; ".get_vocab("weekbefore")." \"/>
			</td>
			<td>";
				include "include/trailer.inc.php";
				echo "</td>
				<td align=\"right\">
					<input type=\"button\"  class=\"btn btn-default btn-xs\" onclick=\"charger();javascript: location.href='week_all.php?year=$ty&amp;month=$tm&amp;day=$td&amp;area=$area';\"  value=\" ".get_vocab('weekafter')."  &gt;&gt;\"/>
				</td>
			</tr>
		</table>";
	}
	  /*-----MAJ David VOUE --> Ajout de la balise </table>
	  * 14/01/2014*/ 

	  /*-----MAJ Loïs THOMAS  --> Lien qui permet de  le menu à gauche -----*/
	  echo "<tr>";
			 //Test si le format est imprimable
	  if ((!isset($_GET['pview'])) or ($_GET['pview'] != 1)) {
			/*-----Maj David VOUE Suppression du bouton "Cacher le menu à gauche"
				* 13/01/2013
				
				echo "<td align=\"left\"> ";
				echo "<input type=\"button\" id=\"cacher\" value=\"cacher le menu à gauche.\" onClick=\"divcache()\" style=\"display:inline;\"/>";
				echo "<input type=\"button\" id=\"voir\" value=\"afficher le menu à gauche.\" onClick=\"divaffiche()\" style=\"display:none;\" /> ";
				echo "</td>";
				*/
			}
			echo "<td>";
			echo "<h2 class=\"titre\">".utf8_strftime($dformat, $date_start)." au ". utf8_strftime($dformat, $date_end)
			. " $this_area_name - ".get_vocab("all_rooms")."</h2>";
			echo "</td>";
			echo " </tr>
		</table>
	</div>";


	echo " <div class=\"contenu_planning\">" ;

	echo "<table cellspacing=\"0\"  border=\"1\" width=\"100%\">\n";
	// Affichage de la première ligne contenant le nom des jours (lundi, mardi, ...) et les dates ("10 juil", "11 juil", ...)
	echo "<th style=\"width:10%;\">&nbsp;</th>\n"; // Première cellule vide
	$t = $time;
	$num_week_day = $weekstarts; // Pour le calcul des jours à afficher
	for ($weekcol = 0; $weekcol < 7; $weekcol++)
	{
		$num_day = strftime("%d", $t);
		$temp_month = strftime("%m", $t);
		$temp_month2 = strftime("%b", $t);
		$temp_year = strftime("%Y", $t);
		$jour_cycle = grr_sql_query1("SELECT Jours FROM ".TABLE_PREFIX."_calendrier_jours_cycle WHERE DAY='$t'");
		$t += 86400;
		if (!isset($correct_heure_ete_hiver) or ($correct_heure_ete_hiver == 1)) {
			// Correction dans le cas d'un changement d'heure
			if  (heure_ete_hiver("hiver",$temp_year,0) == mktime(0,0,0,$temp_month,$num_day,$temp_year))
				$t +=3600;
			if (date("H",$t) == "01")
				$t -=3600;
		}
		if ($display_day[$num_week_day] == 1) {// on n'affiche pas tous les jours de la semaine
		echo "<th style=\"width:10%;\";><a onclick=\"charger()\" class=\"lienPlanning\" href='day.php?year=".$temp_year."&amp;month=".$temp_month."&amp;day=".$num_day."&amp;area=".$area."'>"  . day_name(($weekcol + $weekstarts)%7) . " ".$num_day. " ".$temp_month2."</a>";
		if (getSettingValue("jours_cycles_actif") == "Oui" and intval($jour_cycle)>-1)
			if (intval($jour_cycle)>0)
				echo "<br />".get_vocab("rep_type_6")." ".$jour_cycle;
			else
				echo "<br />".$jour_cycle;
			echo "</th>\n";
		}
		$num_week_day++;// Pour le calcul des jours à afficher
		$num_week_day = $num_week_day % 7;// Pour le calcul des jours à afficher
	}
	echo "</tr>";
	// Fin Affichage de la première ligne contenant les jour

	$li=0;
  // Boucle sur les ressources
	for ($ir = 0; ($row = grr_sql_row($res, $ir)); $ir++)
	{
   // calcul de l'acc?s ? la ressource en fonction du niveau de l'utilisateur
		$verif_acces_ressource = verif_acces_ressource(getUserName(), $row[2]);
   if ($verif_acces_ressource) {  // on n'affiche pas toutes les ressources
	// Calcul du niveau d'acc?s aux fiche de r?servation d?taill?es des ressources
   $acces_fiche_reservation = verif_acces_fiche_reservation(getUserName(), $row[2]);
	// calcul du test si l'utilisateur a la possibilit? d'effectuer une r?servation, compte tenu
	// des limitations ?ventuelles de la ressources et du nombre de r?servations d?j? effectu?es.
   $UserRoomMaxBooking = UserRoomMaxBooking(getUserName(), $row[2], 1);
	// calcul du niverau de droit de r?servation
   $authGetUserLevel = authGetUserLevel(getUserName(),-1);
	// Determine si un visiteur peut r?server une ressource
   $auth_visiteur = auth_visiteur(getUserName(),$row[2]);


	// Affichage de la premi?re colonne (nom des ressources)
   echo "<tr>\n";
   echo tdcell("cell_hours")."<a title=\"".htmlspecialchars(get_vocab("see_week_for_this_room"))."\" href='week.php?year=".$year."&amp;month=".$month."&amp;day=".$day."&amp;area=".$area."&amp;room=".$row[2]."'>" . htmlspecialchars($row[0]) ."</a><br />\n";
	if ($row[4]=="0") echo "<span class=\"texte_ress_tempo_indispo\">".get_vocab("ressource_temporairement_indisponible")."</span><br />"; // Ressource temporairement indisponible
	if (verif_display_fiche_ressource(getUserName(), $row[2]) and $_GET['pview'] != 1)
		echo "<a href='javascript:centrerpopup(\"view_room.php?id_room=$row[2]\",600,480,\"scrollbars=yes,statusbar=no,resizable=yes\")' title=\"".get_vocab("fiche_ressource")."\">
	<img src=\"img_grr/details.png\" alt=\"D?tails\" class=\"".$class_image."\"  /></a>";
	if (authGetUserLevel(getUserName(),$row[2]) > 2 and $_GET['pview'] != 1)
		echo "<a href='admin_edit_room.php?room=$row[2]'><img src=\"img_grr/editor.png\" alt=\"configuration\" title=\"".get_vocab("Configurer la ressource")."\" width=\"30\" height=\"30\" class=\"".$class_image."\"  /></a>";
	// La ressource est-elle emprunt?e ?
	affiche_ressource_empruntee($row[2]);
	echo "</td>";


	$li++;

	$t = $time;
	$t2 = $time;
	$num_week_day = $weekstarts; // Pour le calcul des jours ? afficher
	for ($k = 0; $k<=6; $k++)
	{
		$cday = date("j", $t2);
		$cmonth = strftime("%m", $t2);
		$cyear = strftime("%Y", $t2);

		$t2 += 86400;
		if (!isset($correct_heure_ete_hiver) or ($correct_heure_ete_hiver == 1)) {
			// Correction dans le cas d'un changement d'heure
			$temp_day = strftime("%d", $t2);
			$temp_month = strftime("%m", $t2);
			$temp_year = strftime("%Y", $t2);
			// on s'arrange pour que l'heure $t2 corresponde ? 0 h (00:00:00: )
			if  (heure_ete_hiver("hiver",$temp_year,0) == mktime(0,0,0,$temp_month,$temp_day,$temp_year))
				$t2 +=3600;
			if (date("H",$t2) == "01")
				$t2 -=3600;

		}
		if ($display_day[$num_week_day] == 1) { // condition "on n'affiche pas tous les jours de la semaine"
		# Anything to display for this day?
		$no_td = TRUE; # On signale qu'on a pas encore ouvert la balise <td>
		if ((isset($d[$cday]["id"][0])) and  !(est_hors_reservation(mktime(0,0,0,$cmonth,$cday,$cyear),$area))) {
			$n = count($d[$cday]["id"]);
			# Show the start/stop times, 2 per line, linked to view_entry.
			# If there are 12 or fewer, show them, else show 11 and "...".
			for ($i = 0; $i < $n; $i++) {
				/*if ($i == 11 && $n > 12) {
					echo " ...\n";
					break;
				} */
				if ($d[$cday]["id_room"][$i]==$row[2]) {
					#if ($i > 0 && $i % 2 == 0) echo "<br />"; else echo " ";
					# Il y a une r?servation. Donc, si la balise <td> n'est pas encore ouverte, on le fait
					if ($no_td) {
						echo "<td class=\"cell_month\">";
						$no_td = FALSE;
					}

					if ($acces_fiche_reservation)
					{
						/*MAJ Loïs THOMAS <-----Test permettant de savoir le format d'ouverture pour les informations sur les réservations----->  */
						if (getSettingValue("display_level_view_entry")==0){
							$currentPage ='week_all';
							$id =   $d[$cday]["id"][$i];

							echo "<a title=\"".htmlspecialchars($d[$cday]["who"][$i])."\" href=\"#?w=500\" onclick=\"request($id,$cday,$cmonth,$cyear,'$currentPage',readData);\" rel=\"popup_name\" class=\"poplight\">";

						}
						else
						{
							echo "<a class=\"lienCellule\" title=\"".htmlspecialchars($d[$cday]["who"][$i])."\" href=\"view_entry.php?id=" . $d[$cday]["id"][$i]."&amp;page=week_all&amp;day=$cday&amp;month=$cmonth&amp;year=$cyear&amp;\">";
						}



						echo "\n<table width='100%' border='0'><tr>";
						tdcell($d[$cday]["color"][$i]);


						if ($d[$cday]["res"][$i]!='-')
							echo "&nbsp;<img src=\"img_grr/buzy.png\" alt=\"".get_vocab("ressource actuellement empruntee")."\" title=\"".get_vocab("ressource actuellement empruntee")."\" width=\"20\" height=\"20\" class=\"image\" />&nbsp;\n";
							// si la r?servation est ? confirmer, on le signale
						if ((isset($d[$cday]["option_reser"][$i])) and ($d[$cday]["option_reser"][$i]!=-1)) echo "&nbsp;<img src=\"img_grr/small_flag.png\" alt=\"".get_vocab("reservation_a_confirmer_au_plus_tard_le")."\" title=\"".get_vocab("reservation_a_confirmer_au_plus_tard_le")."&nbsp;".time_date_string_jma($d[$cday]["option_reser"][$i],$dformat)."\" width=\"20\" height=\"20\" class=\"image\" />&nbsp;\n";
							// si la r?servation est ? mod?rer, on le signale
						if ((isset($d[$cday]["moderation"][$i])) and ($d[$cday]["moderation"][$i]==1))
							echo "&nbsp;<img src=\"img_grr/flag_moderation.png\" alt=\"".get_vocab("en_attente_moderation")."\" title=\"".get_vocab("en_attente_moderation")."\" class=\"image\" />&nbsp;\n";


						/*Requete permetttant d'avoir le genre */
						$Son_GenreRepeat = grr_sql_query1("SELECT ".TABLE_PREFIX."_type_area.type_name FROM ".TABLE_PREFIX."_type_area,".TABLE_PREFIX."_entry  WHERE  ".TABLE_PREFIX."_entry.type=".TABLE_PREFIX."_type_area.type_letter  AND ".TABLE_PREFIX."_entry.id = '".$d[$cday]["id"][$i]."';");
						if ($Son_GenreRepeat == -1 )
						{
							echo "<span class=\"small_planning\">".$d[$cday]["data"][$i]."";
						}
						else
						{
							echo "<span class=\"small_planning\">".$d[$cday]["data"][$i]."<br/>". $Son_GenreRepeat."<br/>";
						}
						echo $d[$cday]["who1"][$i]. "<br/>" ;

						if ($d[$cday]["description"][$i]!= "")echo "<i>".$d[$cday]["description"][$i]."</i>";

						echo "</a>";
						echo "</span>";
					}
					else {
						echo "\n<table width='100%' border='0'><tr>";
						tdcell($d[$cday]["color"][$i]);


						if ($d[$cday]["res"][$i]!='-')
							echo "&nbsp;<img src=\"img_grr/buzy.png\" alt=\"".get_vocab("ressource actuellement empruntee")."\" title=\"".get_vocab("ressource actuellement empruntee")."\" width=\"20\" height=\"20\" class=\"image\" />&nbsp;\n";
							// si la r?servation est ? confirmer, on le signale
						if ((isset($d[$cday]["option_reser"][$i])) and ($d[$cday]["option_reser"][$i]!=-1)) echo "&nbsp;<img src=\"img_grr/small_flag.png\" alt=\"".get_vocab("reservation_a_confirmer_au_plus_tard_le")."\" title=\"".get_vocab("reservation_a_confirmer_au_plus_tard_le")."&nbsp;".time_date_string_jma($d[$cday]["option_reser"][$i],$dformat)."\" width=\"20\" height=\"20\" class=\"image\" />&nbsp;\n";
							// si la r?servation est ? mod?rer, on le signale
						if ((isset($d[$cday]["moderation"][$i])) and ($d[$cday]["moderation"][$i]==1))
							echo "&nbsp;<img src=\"img_grr/flag_moderation.png\" alt=\"".get_vocab("en_attente_moderation")."\" title=\"".get_vocab("en_attente_moderation")."\" class=\"image\" />&nbsp;\n";


						/*Requete permetttant d'avoir le genre */
						$Son_GenreRepeat = grr_sql_query1("SELECT ".TABLE_PREFIX."_type_area.type_name FROM ".TABLE_PREFIX."_type_area,".TABLE_PREFIX."_entry  WHERE  ".TABLE_PREFIX."_entry.type=".TABLE_PREFIX."_type_area.type_letter  AND ".TABLE_PREFIX."_entry.id = '".$d[$cday]["id"][$i]."';");
						if ($Son_GenreRepeat == -1 )
						{
							echo "<span class=\"small_planning\">
							<b>". $d[$cday]["data"][$i]."</b><br/>";
						}
						else
						{
							echo "<span class=\"small_planning\">
							". $d[$cday]["data"][$i]."<br/>
							". $Son_GenreRepeat."<br/>";
						}
						echo $d[$cday]["who1"][$i]. " <br/>" ;

						if ($d[$cday]["description"][$i]!= "")echo "<i>".$d[$cday]["description"][$i]."</i>";

						echo "</a>";
						echo "</span>";
					}
					echo "</td></tr></table>";
				}
			}
		}
		if ($no_td) {
			if ($row[4]==1)
				echo "<td class=\"empty_cell\">";
			else
				echo "<td class=\"avertissement\">";
		}
		else
			echo "<div class=\"empty_cell\">";
		//  Possibilité de faire une nouvelle réservation
		$hour = date("H",$date_now); // Heure actuelle
		$date_booking = mktime(24, 0, 0, $cmonth, $cday, $cyear); // minuit
		if (est_hors_reservation(mktime(0,0,0,$cmonth,$cday,$cyear),$area))
			echo "<img src=\"img_grr/stop.png\" alt=\"".get_vocab("reservation_impossible")."\"  title=\"".get_vocab("reservation_impossible")."\" width=\"16\" height=\"16\" class=\"".$class_image."\"  />";
		else
			if ((($authGetUserLevel > 1) or  ($auth_visiteur == 1))
				and ($UserRoomMaxBooking != 0)
				and verif_booking_date(getUserName(), -1, $row[2], $date_booking, $date_now, $enable_periods)
				and verif_delais_max_resa_room(getUserName(), $row[2], $date_booking)
				and verif_delais_min_resa_room(getUserName(), $row[2], $date_booking)
				and plages_libre_semaine_ressource($row[2], $cmonth, $cday, $cyear)
				and (($row[4] == "1") or
					(($row[4] == "0") and (authGetUserLevel(getUserName(),$row[2]) > 2) ))
				and $_GET['pview'] != 1) {
				if ($enable_periods == 'y')
					
				/* David VOUE Redimensionnement de l'icône + 14/01/2014
				 
			/*echo "<a href=\"edit_entry.php?room=".$row[2]."&amp;period=&amp;year=$cyear&amp;month=$cmonth&amp;day=$cday&amp;page=week_all\" title=\"".get_vocab("cliquer_pour_effectuer_une_reservation")."\"><img src=\"img_grr/new.gif\" alt=\"".get_vocab("add")."\" class=\"".$class_image."\"  /></a>";*/
			echo "<a href=\"edit_entry.php?room=".$row[2]."&amp;period=&amp;year=$cyear&amp;month=$cmonth&amp;day=$cday&amp;page=week_all\" title=\"".get_vocab("cliquer_pour_effectuer_une_reservation")."\"><img src=\"img_grr/new.gif\" alt=\"".get_vocab("add")."\" width=\"16\" height=\"16\" class=\"".$class_image."\"  /></a>";

//echo "<a title=\"".get_vocab("cliquez_pour_effectuer_une_reservation")."\" href=\"#?w=800\" onclick=\"request($id,$cday,$month,$year,'$currentPage',readData);\" rel=\"popup_name2\" class=\"popop\"><img src=\"img_grr/new.png\" alt=\"".get_vocab("add")."\" class=\"".$class_image."\"</a>";


			else

				// Hugo A VOIR 07/06/2013
				
				/* David VOUE Redimensionnement de l'icône + 14/01/2014
				
			/*echo "<a href=\"edit_entry.php?room=".$row[2]."&amp;hour=$hour&amp;minute=0&amp;year=$cyear&amp;month=$cmonth&amp;day=$cday&amp;page=week_all\" title=\"".get_vocab("cliquez_pour_effectuer_une_reservation")."\"><img src=\"img_grr/new.gif\" alt=\"".get_vocab("add")."\" class=\"".$class_image."\"  /></a>";*/
			echo "<a href=\"edit_entry.php?room=".$row[2]."&amp;hour=$hour&amp;minute=0&amp;year=$cyear&amp;month=$cmonth&amp;day=$cday&amp;page=week_all\" title=\"".get_vocab("cliquez_pour_effectuer_une_reservation")."\"><img src=\"img_grr/new.gif\" alt=\"".get_vocab("add")."\" width=\"16\" height=\"16\" class=\"".$class_image."\"  /></a>";
//echo "<a title=\"".get_vocab("cliquez_pour_effectuer_une_reservation")."\" href=\"#?w=800\" onclick=\"request($id,$cday,$month,$year,'$currentPage',readData);\" rel=\"popup_name2\" class=\"popop\"><img src=\"img_grr/new.png\" alt=\"".get_vocab("add")."\" class=\"".$class_image."\"</a>";



		} else {
			echo "&nbsp;";
		}
		if (!$no_td)
			echo "</div>";
		echo "</td>\n";
		}  // Fin de la condition "on n'affiche pas tous les jours de la semaine"
		$num_week_day++;// Pour le calcul des jours ? afficher
		$num_week_day = $num_week_day % 7;// Pour le calcul des jours ? afficher

	}
	echo "</tr>";
}
}
}
echo "</table>\n";

if ($_GET['pview'] != 1)

	/*-----MAJ Loïs THOMAS  --> Lien permettant de revenir en haut de la page -----*/
/*echo "<button class=\"btn btn-default btn-xs\" onclick=\"javascript: location.href='#haut_de_page';\">Haut de page</button>";*/


//MAJ Hugo FORESTIER - Mise en place d'un bouton 'retour en haut de la page' en jQuery
//14/05/2013
//echo "<div id=\"toTop\"> ^ Haut de la page";

//MAJ David VOUE - Mise en place du get_vocab ("top_of_page") conçernant le haut de la page
//07/02/2014

echo "<div id=\"toTop\"><b>".get_vocab("top_of_page")."</b>";
bouton_retour_haut ();
echo " </div>";


	//Fermture DIV contenu
echo " </div>";

//Fermeture DIV Panning
echo " </div>";
	  //DIV POPUP
echo  "<div id=\"popup_name\" class=\"popup_block\" ></div>";
	  //DIV POPUP
echo  "<div id=\"popup_name2\" class=\"popup_block2\" ></div>";
?>
