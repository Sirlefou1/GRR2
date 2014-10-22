<?php
/**
 * month_all.php
 * Interface d'accueil avec affichage par mois des réservation de toutes les ressources d'un domaine
 * Ce script fait partie de l'application GRR
 * Dernière modification : $Date: 2009-12-02 20:11:07 $
 * @author    Laurent Delineau <laurent.delineau@ac-poitiers.fr>
 * @copyright Copyright 2003-2008 Laurent Delineau
 * @link      http://www.gnu.org/licenses/licenses.html
 * @package   root
 * @version   $Id: month_all.php,v 1.17 2009-12-02 20:11:07 grr Exp $
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
include "include/connect.inc.php";
include "include/config.inc.php";
include "include/misc.inc.php";
include "include/functions.inc.php";
include "include/$dbsys.inc.php";
include "include/mincals.inc.php";
include "include/mrbs_sql.inc.php";
$grr_script_name = "month_all.php";
require_once("./include/settings.inc.php");
if (!loadSettings())
	die("Erreur chargement settings");
require_once("./include/session.inc.php");
include "include/resume_session.php";
Definition_ressource_domaine_site();
get_planning_area_values($area);
include "include/language.inc.php";
$affiche_pview = '1';
if (!isset($_GET['pview']))
	$_GET['pview'] = 0;
else
	$_GET['pview'] = 1;
if ($_GET['pview'] == 1)
	$class_image = "print_image";
else
	$class_image = "image";
//Default parameters:
if (empty($debug_flag))
	$debug_flag = 0;
if (empty($month) || empty($year) || !checkdate($month, 1, $year))
{
	$month = date("m");
	$year  = date("Y");
}
if (!isset($day))
	$day = 1;
if ((getSettingValue("authentification_obli") == 0) && (getUserName() == ''))
	$type_session = "no_session";
else
	$type_session = "with_session";
$back = "";
if (isset($_SERVER['HTTP_REFERER']))
	$back = htmlspecialchars($_SERVER['HTTP_REFERER']);
if ($type_session == "with_session")
	$_SESSION['type_month_all'] = "month_all";
$type_month_all = 'month_all';
print_header($day, $month, $year, $area, $type_session);
if (check_begin_end_bookings($day, $month, $year))
{
	showNoBookings($day, $month, $year, $back);
	exit();
}
if ((authGetUserLevel(getUserName(),-1) < 1) && (getSettingValue("authentification_obli") == 1))
{
	showAccessDenied($day, $month, $year, $area,$back);
	exit();
}
if (authUserAccesArea(getUserName(), $area) == 0)
{
	showAccessDenied($day, $month, $year, $area,$back);
	exit();
}
if (getSettingValue("verif_reservation_auto") == 0)
{
	verify_confirm_reservation();
	verify_retard_reservation();
}
$month_start = mktime(0, 0, 0, $month, 1, $year);
$weekday_start = (date("w", $month_start) - $weekstarts + 7) % 7;
$days_in_month = date("t", $month_start);
$month_end = mktime(23, 59, 59, $month, $days_in_month, $year);
if ($enable_periods == 'y')
{
	$resolution = 60;
	$morningstarts = 12;
	$eveningends = 12;
	$eveningends_minutes = count($periods_name) - 1;
}
$this_area_name = "";
$this_room_name = "";
$this_area_name = grr_sql_query1("SELECT area_name FROM ".TABLE_PREFIX."_area WHERE id=$area");
$i = mktime(0,0,0,$month - 1, 1, $year);
$yy = date("Y",$i);
$ym = date("n",$i);
$i = mktime(0,0,0,$month + 1, 1, $year);
$ty = date("Y",$i);
$tm = date("n",$i);
if ($debug_flag)
	echo "<p>DEBUG: month=$month year=$year start=$weekday_start range=$month_start:$month_end\n";
$all_day = preg_replace("/ /", " ", get_vocab("all_day2"));
//Get all meetings for this month in the room that we care about
//row[0] = Start time
//row[1] = End time
//row[2] = Entry ID
//row[3] = Entry name (brief description)
//row[4] = beneficiaire of the booking
//row[5] = Nom de la ressource
//row[6] = Description complète
//row[7] = type
//row[8] = Modération
//row[9] = beneficiaire extérieur
//row[10] = id de la ressource
$sql = "SELECT start_time, end_time, ".TABLE_PREFIX."_entry.id, name, beneficiaire, room_name, ".TABLE_PREFIX."_entry.description, type, ".TABLE_PREFIX."_entry.moderate, beneficiaire_ext, ".TABLE_PREFIX."_room.id
FROM ".TABLE_PREFIX."_entry inner join ".TABLE_PREFIX."_room on ".TABLE_PREFIX."_entry.room_id=".TABLE_PREFIX."_room.id
WHERE (start_time <= $month_end AND end_time > $month_start and area_id='".$area."')
ORDER by start_time, end_time, ".TABLE_PREFIX."_room.room_name";
//Build an array of information about each day in the month.
//The information is stored as:
//d[monthday]["id"][] = ID of each entry, for linking.
//d[monthday]["data"][] = "start-stop" times of each entry.
$res = grr_sql_query($sql);
if (!$res)
	echo grr_sql_error();
else
{
//Permet d'afficher aucune réservation
//if (grr_sql_count($res) == 0) {
//		echo "<div class=\"titre_planning\"><h3>".get_vocab("nothing_found")."</h3></div></body></html>";
//		die();
//	}
//insertion du menu_gauche.php
	include("menu_gauche.php");
	include "chargement.php";
	if ($_GET['pview'] != 1)
		echo "<div id=\"planning\">";
	else
		echo "<div id=\"print_planning\">";
	echo "<div class=\"titre_planning\"><table width=\"100%\">";
	//Test si le format est imprimable
	if ((!isset($_GET['pview'])) || ($_GET['pview'] != 1))
	{
		#Show Go to week before and after links
		echo "\n
		<tr>
			<td align=\"left\">
				<button class=\"btn btn-default btn-xs\" onclick=\"charger();javascript: location.href='month_all.php?year=$yy&amp;month=$ym&amp;area=$area';\"><span class=\"glyphicon glyphicon-backward\"></span>".get_vocab("monthbefore")."</button>
			</td>";
			echo " <td>";
			include "include/trailer.inc.php";
			echo "</td>
			<td align=\"right\">
				<button class=\"btn btn-default btn-xs\" onclick=\"charger();javascript: location.href='month_all.php?year=$ty&amp;month=$tm&amp;area=$area';\">".get_vocab('monthafter')."  <span class=\"glyphicon glyphicon-forward\"></span></button>
			</td>
		</tr>
	</table>";
}
echo " <td>";
echo "<h4 class=\"titre\">" . ucfirst(utf8_strftime("%B %Y", $month_start)) . " ".ucfirst($this_area_name)." - ".get_vocab("all_areas")."</h4>";
if ($_GET['pview'] != 1)
	echo " <a href=\"month_all2.php?year=$year&amp;month=$month&amp;area=$area\"><img src=\"img_grr/change_view.png\" alt=\"".get_vocab("change_view")."\" title=\"".get_vocab("change_view")."\" class=\"image\" /></a>";
echo " </td>";
echo " </tr>";
echo "</table>";
echo "</div>\n";
if (isset($_GET['precedent']))
{
	if ($_GET['pview'] == 1 && $_GET['precedent'] == 1)
	{
		echo "<span id=\"lienPrecedent\">
		<button class=\"btn btn-default btn-xs\" onclick=\"charger();javascript:history.back();\">Précedent</button>
	</span>";
}
}
echo " <div class=\"contenu_planning\">";
for ($i = 0; ($row = grr_sql_row($res, $i)); $i++)
{
	$verif_acces_ressource[$row[10]] = verif_acces_ressource(getUserName(), $row[10]);
	$acces_fiche_reservation[$row[10]] = verif_acces_fiche_reservation(getUserName(), $row[10]);
	if ($debug_flag)
		echo "<br />DEBUG: result $i, id $row[2], starts $row[0], ends $row[1]\n";
	$t = max((int)$row[0], $month_start);
	$end_t = min((int)$row[1], $month_end);
	$day_num = date("j", $t);
	if ($enable_periods == 'y')
		$midnight = mktime(12, 0, 0, $month, $day_num, $year);
	else
		$midnight = mktime(0, 0, 0, $month, $day_num, $year);
	while ($t < $end_t)
	{
		if ($debug_flag)
			echo "<br />DEBUG: Entry $row[2] day $day_num\n";
		$d[$day_num]["id"][] = $row[2];
		$d[$day_num]["id_room"][] = $row[10];
		if (getSettingValue("display_info_bulle") == 1)
			$d[$day_num]["who"][] = get_vocab("reservee au nom de").affiche_nom_prenom_email($row[4], $row[9], "nomail");
		else if (getSettingValue("display_info_bulle") == 2)
			$d[$day_num]["who"][] = $row[6];
		else
			$d[$day_num]["who"][] = "";
		$d[$day_num]["who1"][] = affichage_lien_resa_planning($row[3],$row[2]);
		$d[$day_num]["room"][] = $row[5] ;
		$d[$day_num]["color"][] = $row[7];
		$d[$day_num]["description"][] = affichage_resa_planning($row[6],$row[2]);
		$d[$day_num]["moderation"][] = $row[8];
		$midnight_tonight = $midnight + 86400;
		//Describe the start and end time, accounting for "all day"
		//and for entries starting before/ending after today.
		//There are 9 cases, for start time < = or > midnight this morning,
		//and end time < = or > midnight tonight.
		//Use ~ (not -) to separate the start and stop times, because MSIE
		//will incorrectly line break after a -.
		if ($enable_periods == 'y')
		{
			$start_str = preg_replace("/ /", " ", period_time_string($row[0]));
			$end_str   = preg_replace("/ /", " ", period_time_string($row[1], -1));
			// Debug
			//echo affiche_date($row[0])." ".affiche_date($midnight)." ".affiche_date($row[1])." ".affiche_date($midnight_tonight)."<br />";
			switch (cmp3($row[0], $midnight) . cmp3($row[1], $midnight_tonight))
			{
						case "> < ":         //Starts after midnight, ends before midnight
						case "= < ":         //Starts at midnight, ends before midnight
						if ($start_str == $end_str)
							$d[$day_num]["data"][] = $start_str;
						else
							$d[$day_num]["data"][] = $start_str . "~" . $end_str;
						break;
						case "> = ":         //Starts after midnight, ends at midnight
						$d[$day_num]["data"][] = $start_str . "~24:00";
						break;
						case "> > ":         //Starts after midnight, continues tomorrow
						$d[$day_num]["data"][] = $start_str . "~&gt;";
						break;
						case "= = ":         //Starts at midnight, ends at midnight
						$d[$day_num]["data"][] = $all_day;
						break;
						case "= > ":         //Starts at midnight, continues tomorrow
						$d[$day_num]["data"][] = $all_day . "&gt;";
						break;
						case "< < ":         //Starts before today, ends before midnight
						$d[$day_num]["data"][] = "&lt;~" . $end_str;
						break;
						case "< = ":         //Starts before today, ends at midnight
						$d[$day_num]["data"][] = "&lt;" . $all_day;
						break;
						case "< > ":         //Starts before today, continues tomorrow
						$d[$day_num]["data"][] = "&lt;" . $all_day . "&gt;";
						break;
					}
				}
				else
				{
					switch (cmp3($row[0], $midnight) . cmp3($row[1], $midnight_tonight))
					{
						case "> < ":         //Starts after midnight, ends before midnight
						case "= < ":         //Starts at midnight, ends before midnight
						$d[$day_num]["data"][] = date(hour_min_format(), $row[0]) . "~" . date(hour_min_format(), $row[1]);
						break;
						case "> = ":         //Starts after midnight, ends at midnight
						$d[$day_num]["data"][] = date(hour_min_format(), $row[0]) . "~24:00";
						break;
						case "> > ":         //Starts after midnight, continues tomorrow
						$d[$day_num]["data"][] = date(hour_min_format(), $row[0]) . "~&gt;";
						break;
						case "= = ":         //Starts at midnight, ends at midnight
						$d[$day_num]["data"][] = $all_day;
						break;
						case "= > ":         //Starts at midnight, continues tomorrow
						$d[$day_num]["data"][] = $all_day . "&gt;";
						break;
						case "< < ":         //Starts before today, ends before midnight
						$d[$day_num]["data"][] = "&lt;~" . date(hour_min_format(), $row[1]);
						break;
						case "< = ":         //Starts before today, ends at midnight
						$d[$day_num]["data"][] = "&lt;" . $all_day;
						break;
						case "< > ":         //Starts before today, continues tomorrow
						$d[$day_num]["data"][] = "&lt;" . $all_day . "&gt;";
						break;
					}
				}
				//Only if end time > midnight does the loop continue for the next day.
				if ($row[1] <= $midnight_tonight)
					break;
				$day_num++;
				$t = $midnight = $midnight_tonight;
			}
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
	// Début du tableau affichant le planning
	echo "<table class=\"table-bordered table-striped\">\n";
	// Début affichage première ligne (intitulé des jours)
	echo "<tr>";
	for ($weekcol = 0; $weekcol < 7; $weekcol++)
	{
		$num_week_day = ($weekcol + $weekstarts) % 7;
		// on n'affiche pas tous les jours de la semaine
		if ($display_day[$num_week_day] == 1)
			echo "<th style=\"width:14%;\">" . day_name($num_week_day) . "</th>\n";
	}
	echo "</tr>\n";
	// Fin affichage première ligne (intitulé des jours)
	// Début affichage des lignes affichant les réservations
	// On grise les cellules appartenant au mois précédent
	$weekcol = 0;
	if ($weekcol != $weekday_start)
	{
		echo "<tr>";
		for ($weekcol = 0; $weekcol < $weekday_start; $weekcol++)
		{
			$num_week_day = ($weekcol + $weekstarts)%7;
			if ($display_day[$num_week_day] == 1)
				echo "<td class=\"cell_month_o\" > </td>\n";
		}
	}
	// Début Première boucle sur les jours du mois
	for ($cday = 1; $cday <= $days_in_month; $cday++)
	{
		$num_week_day = ($weekcol + $weekstarts) % 7;
		$t = mktime(0, 0, 0, $month,$cday,$year);
		$name_day = ucfirst(utf8_strftime("%d", $t));
		$jour_cycle = grr_sql_query1("SELECT Jours FROM ".TABLE_PREFIX."_calendrier_jours_cycle WHERE DAY='$t'");
		if ($weekcol == 0)
			echo "<tr>\n";
		if ($display_day[$num_week_day] == 1)
		{
			// début condition "on n'affiche pas tous les jours de la semaine"
			echo "<td valign=\"top\" class=\"cell_month\">";
			// On affiche les jours du mois dans le coin supérieur gauche de chaque cellule
			echo "<div class=\"monthday\"><a title=\"".htmlspecialchars(get_vocab("see_all_the_rooms_for_the_day"))."\" href=\"day.php?year=$year&amp;month=$month&amp;day=$cday&amp;area=$area\">".$name_day;
			if (getSettingValue("jours_cycles_actif") == "Oui" && intval($jour_cycle) > -1)
			{
				if (intval($jour_cycle) > 0)
					echo " - ".get_vocab("rep_type_6")." ".$jour_cycle;
				else
					echo " - ".$jour_cycle;
			}
			echo "</a></div>\n";
			if (est_hors_reservation(mktime(0,0,0,$month,$cday,$year),$area))
			{
				echo "<div class=\"empty_cell\">";
				echo "<img src=\"img_grr/stop.png\" alt=\"".get_vocab("reservation_impossible")."\" title=\"".get_vocab("reservation_impossible")."\" width=\"16\" height=\"16\" class=\"".$class_image."\"  /></div>\n";
			}
			else
			{
					// Des réservation à afficher pour ce jour ?
				if (isset($d[$cday]["id"][0]))
				{
					$n = count($d[$cday]["id"]);
						//Show the start/stop times, 2 per line, linked to view_entry.
						//If there are 12 or fewer, show them, else show 11 and "...".
					for ($i = 0; $i < $n; $i++)
					{
						if ($verif_acces_ressource[$d[$cday]["id_room"][$i]])
						{
								// On n'affiche pas les réservation des ressources non visibles pour l'utilisateur.
							if ($i == 11 && $n > 12)
							{
								echo " ...\n";
								break;
							}
							echo "\n<table width='100%' border='0'><tr>\n";
							tdcell($d[$cday]["color"][$i]);
							echo "<span class=\"small_planning\">";
							if ($acces_fiche_reservation[$d[$cday]["id_room"][$i]])
							{
								if (getSettingValue("display_level_view_entry") == 0)
								{
									$currentPage = 'month_all';
									$id =   $d[$cday]["id"][$i];
									echo "<a title=\"".htmlspecialchars($d[$cday]["who"][$i])."\" href=\"#?w=600\" onclick=\"request($id,$cday,$month,$year,'$currentPage',readData);\" rel=\"popup_name\" class=\"poplight\">";
								}
								else
								{
									echo "<a class=\"lienCellule\" title=\"".htmlspecialchars($d[$cday]["who"][$i])."\" href=\"view_entry.php?id=" . $d[$cday]["id"][$i]
									. "&amp;day=$cday&amp;month=$month&amp;year=$year&amp;page=month_all\">";
								}
							}
							echo $d[$cday]["data"][$i]. "<br />". htmlspecialchars($d[$cday]["room"][$i]). "<br />".$d[$cday]["who1"][$i]." <br/>" ;
							$Son_GenreRepeat = grr_sql_query1("SELECT type_name FROM ".TABLE_PREFIX."_type_area ,".TABLE_PREFIX."_entry  WHERE  ".TABLE_PREFIX."_entry.id= ".$d[$cday]["id"][$i]." AND ".TABLE_PREFIX."_entry.type= ".TABLE_PREFIX."_type_area.type_letter");
							echo $Son_GenreRepeat."<br/>";
							if ($d[$cday]["description"][$i] != "")
								echo $d[$cday]["description"][$i]."<br/>";
							if ((isset($d[$cday]["moderation"][$i])) && ($d[$cday]["moderation"][$i] == 1))
								echo " <img src=\"img_grr/flag_moderation.png\" alt=\"".get_vocab("en_attente_moderation")."\" title=\"".get_vocab("en_attente_moderation")."\" class=\"image\" /> \n";
							if ($acces_fiche_reservation[$d[$cday]["id_room"][$i]])
								echo "</a>";
							echo "</span></td></tr></table>\n";
						}
					}
				}
			}
			echo "</td>\n";
		}
			// fin condition "on n'affiche pas tous les jours de la semaine"
		if (++$weekcol == 7)
		{
			$weekcol = 0;
			echo "</tr>";
		}
	}
		// Fin Première boucle sur les jours du mois !
		// On grise les cellules appartenant au mois suivant
	if ($weekcol > 0)
	{
		for (; $weekcol < 7; $weekcol++)
		{
			$num_week_day = ($weekcol + $weekstarts)%7;
				// on n'affiche pas tous les jours de la semaine
			if ($display_day[$num_week_day] == 1)
				echo "<td class=\"cell_month_o\" > </td>\n";
		}
	}
	echo "</tr></table>";
		//Fermeture du div contenu_Planning
	echo "</div>";
	if ($_GET['pview'] != 1)
		echo "<div id=\"toTop\"> ^ Haut de la page";
	bouton_retour_haut ();
	echo " </div>";
		//Fermeture DIV Panning
	echo " </div>";
		// Affichage d'un message pop-up
	echo  "<div id=\"popup_name\" class=\"popup_block\" ></div>";
	affiche_pop_up(get_vocab("message_records"),"user");
	?>
