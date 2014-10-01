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
include "include/connect.inc.php";
include "include/config.inc.php";
include "include/misc.inc.php";
include "include/functions.inc.php";
include "include/$dbsys.inc.php";
include "include/mincals.inc.php";
include "include/mrbs_sql.inc.php";
$grr_script_name = "week_all.php";
// Settings
require_once ("./include/settings.inc.php");
//Chargement des valeurs de la table settingS
if (!loadSettings())
	die("Erreur chargement settings");
// Session related functions
require_once ("./include/session.inc.php");
// Resume session
if (!grr_resumeSession())
{
	if ((getSettingValue("authentification_obli") == 1) || ((getSettingValue("authentification_obli") == 0) && (isset($_SESSION['login']))))
	{
		header("Location: ./logout.php?auto=1&url=$url");
		die();
	}
}
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
if (empty($debug_flag))
	$debug_flag = 0;
$date_now = time();
if (!isset($day) || !isset($month) || !isset($year))
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
}
else
{
	settype($month,"integer");
	settype($day,"integer");
	settype($year,"integer");
	$minyear = strftime("%Y", getSettingValue("begin_bookings"));
	$maxyear = strftime("%Y", getSettingValue("end_bookings"));
	if ($day < 1)
		$day = 1;
	if ($day > 31)
		$day = 31;
	if ($month < 1)
		$month = 1;
	if ($month > 12)
		$month = 12;
	if ($year < $minyear)
		$year = $minyear;
	if ($year > $maxyear)
		$year = $maxyear;
	while (!checkdate($month, $day, $year))
		$day--;
}
if ((getSettingValue("authentification_obli") == 0) && (getUserName() == '' ))
	$type_session = "no_session";
else
	$type_session = "with_session";
$back = '';
if (isset($_SERVER['HTTP_REFERER']))
	$back = htmlspecialchars($_SERVER['HTTP_REFERER']);
Definition_ressource_domaine_site();
if (check_begin_end_bookings($day, $month, $year))
{
	showNoBookings($day, $month, $year, $area,$back,$type_session);
	exit();
}
print_header($day, $month, $year, $area, $type_session);
if ((authGetUserLevel(getUserName(),-1) < 1) && (getSettingValue("authentification_obli") == 1))
{
	showAccessDenied($day, $month, $year, $area,$back);
	exit();
}
if (authUserAccesArea(getUserName(), $area)==0)
{
	showAccessDenied($day, $month, $year, $area,$back);
	exit();
}
function cmp3($a, $b)
{
	if ($a < $b)
		return "< ";
	if ($a == $b)
		return "= ";
	return "> ";
}
if (getSettingValue("verif_reservation_auto") == 0)
{
	verify_confirm_reservation();
	verify_retard_reservation();
}
get_planning_area_values($area);
if ($enable_periods == 'y')
{
	$resolution = 60;
	$morningstarts = 12;
	$morningstarts_minutes = 0;
	$eveningends = 12;
	$eveningends_minutes = count($periods_name)-1;
}
$time = mktime(0, 0, 0, $month, $day, $year);
$time_old = $time;
if (($weekday = (date("w", $time) - $weekstarts + 7) % 7) > 0)
	$time -= $weekday * 86400;
if (!isset($correct_heure_ete_hiver) || ($correct_heure_ete_hiver == 1))
{
	if ((heure_ete_hiver("ete", $year,0) <= $time_old) && (heure_ete_hiver("ete",$year,0) >= $time) && ($time_old != $time) && (date("H", $time) == 23))
		$decal = 3600;
	else
		$decal = 0;
	$time += $decal;
}
$day_week   = date("d", $time);
$month_week = date("m", $time);
$year_week  = date("Y", $time);
$date_start = mktime($morningstarts, 0, 0, $month_week, $day_week, $year_week);
$days_in_month = date("t", $date_start);
if ($debug_flag)
	echo "$month_week $day_week ";
$date_end = mktime($eveningends, $eveningends_minutes, 0, $month_week, $day_week + 6, $year_week);
$this_area_name = grr_sql_query1("SELECT area_name FROM ".TABLE_PREFIX."_area WHERE id=$area");
switch ($dateformat)
{
	case "en":
	$dformat = "%A, %b %d";
	break;
	case "fr":
	$dformat = "%A %d %b";
	break;
}
$i = mktime(0, 0, 0, $month_week, $day_week - 7, $year_week);
$yy = date("Y", $i);
$ym = date("m", $i);
$yd = date("d", $i);
$i = mktime(0, 0, 0, $month_week, $day_week +7 , $year_week);
$ty = date("Y", $i);
$tm = date("m", $i);
$td = date("d", $i);
$all_day = preg_replace("/ /", " ", get_vocab("all_day2"));
$sql = "SELECT start_time, end_time, ".TABLE_PREFIX."_entry.id, name, beneficiaire, ".TABLE_PREFIX."_room.id,type, statut_entry, ".TABLE_PREFIX."_entry.description, ".TABLE_PREFIX."_entry.option_reservation, ".TABLE_PREFIX."_room.delais_option_reservation, ".TABLE_PREFIX."_entry.moderate, beneficiaire_ext
FROM ".TABLE_PREFIX."_entry, ".TABLE_PREFIX."_room, ".TABLE_PREFIX."_area
where
".TABLE_PREFIX."_entry.room_id=".TABLE_PREFIX."_room.id and
".TABLE_PREFIX."_area.id = ".TABLE_PREFIX."_room.area_id and
".TABLE_PREFIX."_area.id = '".$area."' and
start_time <= $date_end AND
end_time > $date_start
ORDER by start_time, end_time, ".TABLE_PREFIX."_entry.id";
$res = grr_sql_query($sql);
if (!$res)
	echo grr_sql_error();
else
{
	for ($i = 0; ($row = grr_sql_row($res, $i)); $i++)
	{
		$t = max((int)$row[0], $date_start);
		$end_t = min((int)$row[1], $date_end);
		$day_num = date("j", $t);
		$month_num = date("m", $t);
		$year_num = date("Y", $t);
		if ($enable_periods == 'y')
			$midnight = mktime(12, 0, 0, $month_num, $day_num, $year_num);
		else
			$midnight = mktime(0, 0, 0, $month_num, $day_num, $year_num);
		if ($debug_flag)
			echo "<br />DEBUG: result $i, id $row[2], starts $row[0], ends $row[1], temps en heures : ".($row[1]- $row[0]) / (60 * 60).", midnight : $midnight \n";
		while ($t <= $end_t)
		{
			if ($debug_flag)
				echo "<br />DEBUG: Entry $row[2] day $day_num\n";
			$d[$day_num]["id"][] = $row[2];
			if (getSettingValue("display_info_bulle") == 1)
				$d[$day_num]["who"][] = get_vocab("reservee au nom de").affiche_nom_prenom_email($row[4], $row[12], "nomail");
			else if (getSettingValue("display_info_bulle") == 2)
				$d[$day_num]["who"][] = $row[8];
			else
				$d[$day_num]["who"][] = "";
			$d[$day_num]["who1"][] = affichage_lien_resa_planning($row[3], $row[2]);
			$d[$day_num]["id_room"][]=$row[5] ;
			$d[$day_num]["color"][]=$row[6];
			$d[$day_num]["res"][] = $row[7];
			$d[$day_num]["description"][] = affichage_resa_planning($row[8], $row[2]);;
			if ($row[10] > 0)
				$d[$day_num]["option_reser"][] = $row[9];
			else
				$d[$day_num]["option_reser"][] = -1;
			$d[$day_num]["moderation"][] = $row[11];
			$midnight_tonight = $midnight + 86400;
			if (!isset($correct_heure_ete_hiver) || ($correct_heure_ete_hiver == 1))
			{
				if (heure_ete_hiver("hiver",$year_num,0) == mktime(0, 0, 0, $month_num, $day_num, $year_num))
					$midnight_tonight += 3600;
				if (date("H",$midnight_tonight) == "01")
					$midnight_tonight -= 3600;
			}
			if ($enable_periods == 'y')
			{
				$start_str = preg_replace("/ /", "&nbsp;", period_time_string($row[0]));
				$end_str   = preg_replace("/ /", "&nbsp;", period_time_string($row[1], -1));
				switch (cmp3($row[0], $midnight) . cmp3($row[1], $midnight_tonight))
				{
					case "> < ":
					case "= < ":
					if ($start_str == $end_str)
						$d[$day_num]["data"][] = $start_str;
					else
						$d[$day_num]["data"][] = $start_str . "~" . $end_str;
					break;
					case "> = ":
					$d[$day_num]["data"][] = $start_str . "~24:00";
					break;
					case "> > ":
					$d[$day_num]["data"][] = $start_str . "~&gt;";
					break;
					case "= = ":
					$d[$day_num]["data"][] = $all_day;
					break;
					case "= > ":
					$d[$day_num]["data"][] = $all_day . "&gt;";
					break;
					case "< < ":
					$d[$day_num]["data"][] = "&lt;~" . $end_str;
					break;
					case "< = ":
					$d[$day_num]["data"][] = "&lt;" . $all_day;
					break;
					case "< > ":
					$d[$day_num]["data"][] = "&lt;" . $all_day . "&gt;";
					break;
				}
			}
			else
			{
				switch (cmp3($row[0], $midnight) . cmp3($row[1], $midnight_tonight))
				{
					case "> < ":
					case "= < ":
					$d[$day_num]["data"][] = date(hour_min_format(), $row[0]) . "~" . date(hour_min_format(), $row[1]);
					break;
					case "> = ":
					$d[$day_num]["data"][] = date(hour_min_format(), $row[0]) . "~24:00";
					break;
					case "> > ":
					$d[$day_num]["data"][] = date(hour_min_format(), $row[0]) . "~&gt;";
					break;
					case "= = ":
					$d[$day_num]["data"][] = $all_day;
					break;
					case "= > ":
					$d[$day_num]["data"][] = $all_day . "&gt;";
					break;
					case "< < ":
					$d[$day_num]["data"][] = "&lt;~" . date(hour_min_format(), $row[1]);
					break;
					case "< = ":
					$d[$day_num]["data"][] = "&lt;" . $all_day;
					break;
					case "< > ":
					$d[$day_num]["data"][] = "&lt;" . $all_day . "&gt;";
					break;
				}
			}
			if ($row[1] <= $midnight_tonight)
				break;
			$t = $midnight = $midnight_tonight;
			$day_num = date("j", $t);
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
$sql = "SELECT room_name, capacity, id, description, statut_room FROM ".TABLE_PREFIX."_room WHERE area_id='".$area."' ORDER BY order_display, room_name";
$res = grr_sql_query($sql);
if (isset($_GET['precedent']))
{
	if ($_GET['pview'] == 1 && $_GET['precedent'] == 1)
		echo "<span id=\"lienPrecedent\">\n<button class=\"btn btn-default btn-xs\" onclick=\"charger();javascript:history.back();\">Précedent</button>\n</span>";
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
	include("menu_gauche.php");
	if ($_GET['pview'] != 1)
		echo "<div id=\"planning\">";
	else
		echo "<div id=\"print_planning\">";
	include "chargement.php";
	echo "<div class=\"titre_planning\"><table width=\"100%\">";
	if ((!isset($_GET['pview'])) || ($_GET['pview'] != 1))
	{
		echo "
		<tr>
			<td align=\"left\">
				<input type=\"button\" class=\"btn btn-default btn-xs\" onclick=\"charger();javascript: location.href='week_all.php?year=$yy&amp;month=$ym&amp;day=$yd&amp;area=$area';\" value=\"&lt;&lt; ".get_vocab("weekbefore")." \"/>
			</td>
			<td>";
				include "include/trailer.inc.php";
				echo "</td>
				<td align=\"right\">
					<input type=\"button\" class=\"btn btn-default btn-xs\" onclick=\"charger();javascript: location.href='week_all.php?year=$ty&amp;month=$tm&amp;day=$td&amp;area=$area';\" value=\" ".get_vocab('weekafter')."  &gt;&gt;\"/>
				</td>
			</tr>
		</table>";
	}
	echo "<h4 class=\"titre\">".utf8_strftime($dformat, $date_start)." au ". utf8_strftime($dformat, $date_end). " $this_area_name - ".get_vocab("all_rooms")."</h4>";
	echo "</div>";
	echo "\n<div class=\"contenu_planning\">\n" ;
	echo "<table cellspacing=\"0\" border=\"1\" width=\"100%\">\n<thead><tr>";
	echo "<th width=\"10%\">&nbsp;</th>\n";
	$t = $time;
	$num_week_day = $weekstarts;
	for ($weekcol = 0; $weekcol < 7; $weekcol++)
	{
		$num_day = strftime("%d", $t);
		$temp_month = strftime("%m", $t);
		$temp_month2 = strftime("%b", $t);
		$temp_year = strftime("%Y", $t);
		$jour_cycle = grr_sql_query1("SELECT Jours FROM ".TABLE_PREFIX."_calendrier_jours_cycle WHERE day='$t'");
		$t += 86400;
		if (!isset($correct_heure_ete_hiver) || ($correct_heure_ete_hiver == 1))
		{
			if (heure_ete_hiver("hiver",$temp_year,0) == mktime(0, 0, 0, $temp_month, $num_day, $temp_year))
				$t += 3600;
			if (date("H", $t) == "01")
				$t -= 3600;
		}
		if ($display_day[$num_week_day] == 1)
		{
			echo "<th width=\"10%\"><a onclick=\"charger()\" class=\"lienPlanning\" href='day.php?year=".$temp_year."&amp;month=".$temp_month."&amp;day=".$num_day."&amp;area=".$area."'>"  . day_name(($weekcol + $weekstarts)%7) . " ".$num_day. " ".$temp_month2."</a>";
			if (getSettingValue("jours_cycles_actif") == "Oui" && intval($jour_cycle) >- 1)
				if (intval($jour_cycle) > 0)
					echo "<br />".get_vocab("rep_type_6")." ".$jour_cycle;
				else
					echo "<br />".$jour_cycle;
				echo "</th>\n";
			}
			$num_week_day++;
			$num_week_day = $num_week_day % 7;
		}
		echo "</tr></thead>";
		$li = 0;
		for ($ir = 0; ($row = grr_sql_row($res, $ir)); $ir++)
		{
			$verif_acces_ressource = verif_acces_ressource(getUserName(), $row[2]);
			if ($verif_acces_ressource)
			{
				$acces_fiche_reservation = verif_acces_fiche_reservation(getUserName(), $row[2]);
				$UserRoomMaxBooking = UserRoomMaxBooking(getUserName(), $row[2], 1);
				$authGetUserLevel = authGetUserLevel(getUserName(), -1);
				$auth_visiteur = auth_visiteur(getUserName(), $row[2]);
				echo "<tr>\n";
				echo tdcell("cell_hours")."<a title=\"".htmlspecialchars(get_vocab("see_week_for_this_room"))."\" href='week.php?year=".$year."&amp;month=".$month."&amp;day=".$day."&amp;area=".$area."&amp;room=".$row[2]."'>" . htmlspecialchars($row[0]) ."</a><br />\n";
				if ($row[4] == "0")
					echo "<span class=\"texte_ress_tempo_indispo\">".get_vocab("ressource_temporairement_indisponible")."</span><br />";
				if (verif_display_fiche_ressource(getUserName(), $row[2]) && $_GET['pview'] != 1)
					echo "<a href='javascript:centrerpopup(\"view_room.php?id_room=$row[2]\",600,480,\"scrollbars=yes,statusbar=no,resizable=yes\")' title=\"".get_vocab("fiche_ressource")."\">
				<span class=\"glyphcolor glyphicon glyphicon-search\"></span></a>";
				if (authGetUserLevel(getUserName(),$row[2]) > 2 && $_GET['pview'] != 1)
					echo "<a href='admin_edit_room.php?room=$row[2]'><span class=\"glyphcolor glyphicon glyphicon-cog\"></span></a>";
				affiche_ressource_empruntee($row[2]);
				echo "</td>";
				$li++;
				$t = $time;
				$t2 = $time;
				$num_week_day = $weekstarts;
				for ($k = 0; $k <= 6; $k++)
				{
					$cday = date("j", $t2);
					$cmonth = strftime("%m", $t2);
					$cyear = strftime("%Y", $t2);
					$t2 += 86400;
					if (!isset($correct_heure_ete_hiver) || ($correct_heure_ete_hiver == 1))
					{
						$temp_day = strftime("%d", $t2);
						$temp_month = strftime("%m", $t2);
						$temp_year = strftime("%Y", $t2);
						if (heure_ete_hiver("hiver", $temp_year,0) == mktime(0, 0, 0, $temp_month, $temp_day, $temp_year))
							$t2 +=3600;
						if (date("H", $t2) == "01")
							$t2 -=3600;
					}
					if ($display_day[$num_week_day] == 1)
					{
						$no_td = TRUE;
						if ((isset($d[$cday]["id"][0])) && !(est_hors_reservation(mktime(0, 0, 0, $cmonth, $cday, $cyear), $area)))
						{
							$n = count($d[$cday]["id"]);
							for ($i = 0; $i < $n; $i++)
							{
								if ($d[$cday]["id_room"][$i]==$row[2])
								{
									if ($no_td)
									{
										echo "<td class=\"cell_month\">";
										$no_td = FALSE;
									}
									if ($acces_fiche_reservation)
									{
										if (getSettingValue("display_level_view_entry") == 0)
										{
											$currentPage = 'week_all';
											$id = $d[$cday]["id"][$i];
											echo "<a title=\"".htmlspecialchars($d[$cday]["who"][$i])."\" href=\"#?w=500\" onclick=\"request($id,$cday,$cmonth,$cyear,'$currentPage',readData);\" rel=\"popup_name\" class=\"poplight\">";
										}
										else
											echo "<a class=\"lienCellule\" title=\"".htmlspecialchars($d[$cday]["who"][$i])."\" href=\"view_entry.php?id=" . $d[$cday]["id"][$i]."&amp;page=week_all&amp;day=$cday&amp;month=$cmonth&amp;year=$cyear&amp;\">";
										echo "\n<table width='100%' border='0'><tr>";
										tdcell($d[$cday]["color"][$i]);
										if ($d[$cday]["res"][$i] !='-')
											echo "&nbsp;<img src=\"img_grr/buzy.png\" alt=\"".get_vocab("ressource actuellement empruntee")."\" title=\"".get_vocab("ressource actuellement empruntee")."\" width=\"20\" height=\"20\" class=\"image\" />&nbsp;\n";
										if ((isset($d[$cday]["option_reser"][$i])) && ($d[$cday]["option_reser"][$i] != -1))
											echo "&nbsp;<img src=\"img_grr/small_flag.png\" alt=\"".get_vocab("reservation_a_confirmer_au_plus_tard_le")."\" title=\"".get_vocab("reservation_a_confirmer_au_plus_tard_le")."&nbsp;".time_date_string_jma($d[$cday]["option_reser"][$i],$dformat)."\" width=\"20\" height=\"20\" class=\"image\" />&nbsp;\n";
										if ((isset($d[$cday]["moderation"][$i])) && ($d[$cday]["moderation"][$i] == 1))
											echo "&nbsp;<img src=\"img_grr/flag_moderation.png\" alt=\"".get_vocab("en_attente_moderation")."\" title=\"".get_vocab("en_attente_moderation")."\" class=\"image\" />&nbsp;\n";
										$Son_GenreRepeat = grr_sql_query1("SELECT ".TABLE_PREFIX."_type_area.type_name FROM ".TABLE_PREFIX."_type_area,".TABLE_PREFIX."_entry  WHERE  ".TABLE_PREFIX."_entry.type=".TABLE_PREFIX."_type_area.type_letter  AND ".TABLE_PREFIX."_entry.id = '".$d[$cday]["id"][$i]."';");
										if ($Son_GenreRepeat == -1)
											echo "<span class=\"small_planning\">".$d[$cday]["data"][$i]."";
										else
											echo "<span class=\"small_planning\">".$d[$cday]["data"][$i]."<br/>". $Son_GenreRepeat."<br/>";
										echo $d[$cday]["who1"][$i]. "<br/>" ;
										if ($d[$cday]["description"][$i] != "")
											echo "<i>".$d[$cday]["description"][$i]."</i>";
										echo "</a>";
										echo "</span>";
									}
									else
									{
										echo "\n<table width='100%' border='0'><tr>";
										tdcell($d[$cday]["color"][$i]);
										if ($d[$cday]["res"][$i] != '-')
											echo "&nbsp;<img src=\"img_grr/buzy.png\" alt=\"".get_vocab("ressource actuellement empruntee")."\" title=\"".get_vocab("ressource actuellement empruntee")."\" width=\"20\" height=\"20\" class=\"image\" />&nbsp;\n";
										if ((isset($d[$cday]["option_reser"][$i])) && ($d[$cday]["option_reser"][$i] != -1))
											echo "&nbsp;<img src=\"img_grr/small_flag.png\" alt=\"".get_vocab("reservation_a_confirmer_au_plus_tard_le")."\" title=\"".get_vocab("reservation_a_confirmer_au_plus_tard_le")."&nbsp;".time_date_string_jma($d[$cday]["option_reser"][$i],$dformat)."\" width=\"20\" height=\"20\" class=\"image\" />&nbsp;\n";
										if ((isset($d[$cday]["moderation"][$i])) && ($d[$cday]["moderation"][$i == 1]))
											echo "&nbsp;<img src=\"img_grr/flag_moderation.png\" alt=\"".get_vocab("en_attente_moderation")."\" title=\"".get_vocab("en_attente_moderation")."\" class=\"image\" />&nbsp;\n";
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
										if ($d[$cday]["description"][$i] != "")
											echo "<i>".$d[$cday]["description"][$i]."</i>";
										echo "</a>";
										echo "</span>";
									}
									echo "</td></tr></table>";
								}
							}
						}
						if ($no_td)
						{
							if ($row[4] == 1)
								echo "<td class=\"empty_cell\">";
							else
								echo "<td class=\"avertissement\">";
						}
						else
							echo "<div class=\"empty_cell\">";
						$hour = date("H", $date_now);
						$date_booking = mktime(24, 0, 0, $cmonth, $cday, $cyear);
						if (est_hors_reservation(mktime(0, 0, 0, $cmonth, $cday, $cyear), $area))
							echo "<img src=\"img_grr/stop.png\" alt=\"".get_vocab("reservation_impossible")."\" title=\"".get_vocab("reservation_impossible")."\" width=\"16\" height=\"16\" class=\"".$class_image."\" />";
						else
						{
							if ((($authGetUserLevel > 1) || ($auth_visiteur == 1)) && ($UserRoomMaxBooking != 0) && verif_booking_date(getUserName(), -1, $row[2], $date_booking, $date_now, $enable_periods) && verif_delais_max_resa_room(getUserName(), $row[2], $date_booking) && verif_delais_min_resa_room(getUserName(), $row[2], $date_booking) && plages_libre_semaine_ressource($row[2], $cmonth, $cday, $cyear) && (($row[4] == "1") || (($row[4] == "0") && (authGetUserLevel(getUserName(),$row[2]) > 2) )) && $_GET['pview'] != 1)
							{
								if ($enable_periods == 'y')
									echo "<a href=\"edit_entry.php?room=".$row[2]."&amp;period=&amp;year=$cyear&amp;month=$cmonth&amp;day=$cday&amp;page=week_all\" title=\"".get_vocab("cliquer_pour_effectuer_une_reservation")."\"><span class=\"glyphicon glyphicon-plus\"></span></a>";
								else
									echo "<a href=\"edit_entry.php?room=".$row[2]."&amp;hour=$hour&amp;minute=0&amp;year=$cyear&amp;month=$cmonth&amp;day=$cday&amp;page=week_all\" title=\"".get_vocab("cliquez_pour_effectuer_une_reservation")."\"><span class=\"glyphicon glyphicon-plus\"></span></a>";
							}
							else
								echo "&nbsp;";
						}
						if (!$no_td)
							echo "</div>";
						echo "</td>\n";
					}
					$num_week_day++;
					$num_week_day = $num_week_day % 7;
				}
				echo "</tr>";
			}
		}
	}
	echo "</table>\n";
	if ($_GET['pview'] != 1)
		echo "<div id=\"toTop\"><b>".get_vocab("top_of_page")."</b>";
	bouton_retour_haut ();
	echo "</div>";
	echo "</div>";
	echo "</div>";
	echo "<div id=\"popup_name\" class=\"popup_block\" ></div>";
	echo "<div id=\"popup_name2\" class=\"popup_block2\" ></div>";
	?>
