<?php
/**
 * day.php
 * Permet l'affichage de la page d'accueil lorsque l'on est en mode d'affichage "jour".
 * Ce script fait partie de l'application GRR
 * Dernière modification : $Date: 2009-12-02 20:11:07 $
 * @author    Laurent Delineau <laurent.delineau@ac-poitiers.fr>
 * @copyright Copyright 2003-2008 Laurent Delineau
 * @link      http://www.gnu.org/licenses/licenses.html
 * @package   root
 * @version   $Id: day.php,v 1.20 2009-12-02 20:11:07 grr Exp $
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
$grr_script_name = "day.php";
require_once("./include/settings.inc.php");
if (!loadSettings())
	die("Erreur chargement settings");
require_once("./include/session.inc.php");
if (!grr_resumeSession())
{
	if ((getSettingValue("authentification_obli") == 1) || ((getSettingValue("authentification_obli") == 0) && (isset($_SESSION['login']))))
	{
		header("Location: ./logout.php?auto=1&url=$url");
		die();
	}
}
include "include/language.inc.php";
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
	settype($month, "integer");
	settype($day, "integer");
	settype($year, "integer");
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
if (!grr_resumeSession())
{
	if ((getSettingValue("authentification_obli") == 1) || ((getSettingValue("authentification_obli") == 0) && (isset($_SESSION['login']))))
	{
		header("Location: ./logout.php?auto=1&url=$url");
		die();
	}
}
Definition_ressource_domaine_site();
$affiche_pview = '1';
if (!isset($_GET['pview']))
	$_GET['pview'] = 0;
else
	$_GET['pview'] = 1;
if ($_GET['pview'] == 1)
	$class_image = "print_image";
else
	$class_image = "image";
$back = '';
if (isset($_SERVER['HTTP_REFERER']))
	$back = htmlspecialchars($_SERVER['HTTP_REFERER']);
if ((getSettingValue("authentification_obli") == 0) && (getUserName() == ''))
	$type_session = "no_session";
else
	$type_session = "with_session";
get_planning_area_values($area);
if ($area <= 0)
{
	print_header($day, $month, $year, $area,$type_session);
	echo "<h1>".get_vocab("noareas")."</h1>";
	echo "<a href='admin_accueil.php'>".get_vocab("admin")."</a>\n</body></html>";
	exit();
}
print_header($day, $month, $year, $area, $type_session);
if ((authGetUserLevel(getUserName(), -1) < 1) && (getSettingValue("authentification_obli") == 1))
{
	showAccessDenied($day, $month, $year, $area, $back);
	exit();
}
if (authUserAccesArea(getUserName(), $area) == 0)
{
	showAccessDenied($day, $month, $year, $area, $back);
	exit();
}
if (check_begin_end_bookings($day, $month, $year))
{
	showNoBookings($day, $month, $year, $area, $back, $type_session);
	exit();
}
if (getSettingValue("verif_reservation_auto") == 0)
{
	verify_confirm_reservation();
	verify_retard_reservation();
}
$ind = 1;
$test = 0;
while (($test == 0) && ($ind <= 7))
{
	$i = mktime(0, 0, 0, $month, $day - $ind, $year);
	$test = $display_day[date("w",$i)];
	$ind++;
}
$yy = date("Y",$i);
$ym = date("m",$i);
$yd = date("d",$i);
$i = mktime(0, 0, 0, $month, $day, $year);
$jour_cycle = grr_sql_query1("SELECT Jours FROM ".TABLE_PREFIX."_calendrier_jours_cycle WHERE day='$i'");
$ind = 1;
$test = 0;
while (($test == 0) && ($ind <= 7))
{
	$i = mktime(0, 0, 0, $month, $day + $ind, $year);
	$test = $display_day[date("w", $i)];
	$ind++;
}
$ty = date("Y",$i);
$tm = date("m",$i);
$td = date("d",$i);
$am7 = mktime($morningstarts, 0, 0, $month, $day, $year);
$pm7 = mktime($eveningends, $eveningends_minutes, 0, $month, $day, $year);
$this_area_name = grr_sql_query1("SELECT area_name FROM ".TABLE_PREFIX."_area WHERE id='".protect_data_sql($area)."'");
$sql = "SELECT ".TABLE_PREFIX."_room.id, start_time, end_time, name, ".TABLE_PREFIX."_entry.id, type, beneficiaire, statut_entry, ".TABLE_PREFIX."_entry.description, ".TABLE_PREFIX."_entry.option_reservation, ".TABLE_PREFIX."_entry.moderate, beneficiaire_ext
FROM ".TABLE_PREFIX."_entry, ".TABLE_PREFIX."_room
WHERE ".TABLE_PREFIX."_entry.room_id = ".TABLE_PREFIX."_room.id
AND area_id = '".protect_data_sql($area)."'
AND start_time < ".($pm7+$resolution)." AND end_time > $am7 ORDER BY start_time";
$res = grr_sql_query($sql);
if (!$res)
	echo grr_sql_error();
else
{
	for ($i = 0; ($row = grr_sql_row($res, $i)); $i++)
	{
		$start_t = max(round_t_down($row[1], $resolution, $am7), $am7);
		$end_t = min(round_t_up($row[2], $resolution, $am7) - $resolution, $pm7);
		$cellules[$row[4]] = ($end_t - $start_t) / $resolution + 1;
		$compteur[$row[4]] = 0;
		for ($t = $start_t; $t <= $end_t; $t += $resolution)
		{
			$today[$row[0]][$t]["id"]    		= $row[4];
			$today[$row[0]][$t]["color"] 		= $row[5];
			$today[$row[0]][$t]["data"]  		= "";
			$today[$row[0]][$t]["who"]			= "";
			$today[$row[0]][$t]["statut"] 		= $row[7];
			$today[$row[0]][$t]["moderation"] 	= $row[10];
			$today[$row[0]][$t]["option_reser"] = $row[9];
			$today[$row[0]][$t]["description"] 	= affichage_resa_planning($row[8], $row[4]);
		}
		if ($row[1] < $am7)
		{
			$today[$row[0]][$am7]["data"] = affichage_lien_resa_planning($row[3], $row[4]);
			if (getSettingValue("display_info_bulle") == 1)
				$today[$row[0]][$am7]["who"] = get_vocab("reservation au nom de").affiche_nom_prenom_email($row[6], $row[11], "nomail");
			else if (getSettingValue("display_info_bulle") == 2)
				$today[$row[0]][$am7]["who"] = $row[8];
			else
				$today[$row[0]][$am7]["who"] = "";
		}
		else
		{
			$today[$row[0]][$start_t]["data"] = affichage_lien_resa_planning($row[3], $row[4]);
			if (getSettingValue("display_info_bulle") == 1)
				$today[$row[0]][$start_t]["who"] = get_vocab("reservation au nom de").affiche_nom_prenom_email($row[6], $row[11]);
			else if (getSettingValue("display_info_bulle") == 2)
				$today[$row[0]][$start_t]["who"] = $row[8];
			else
				$today[$row[0]][$start_t]["who"] = "";
		}
	}
}
grr_sql_free($res);
$sql = "SELECT room_name, capacity, id, description, statut_room, show_fic_room, delais_option_reservation, moderate FROM ".TABLE_PREFIX."_room WHERE area_id='".protect_data_sql($area)."' ORDER BY order_display, room_name";
$res = grr_sql_query($sql);
if (!$res)
	fatal_error(0, grr_sql_error());
if (grr_sql_count($res) == 0)
{
	echo "<h1>".get_vocab('no_rooms_for_area')."</h1>";
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
	echo "<div class=\"titre_planning\">";
	if ((!isset($_GET['pview'])) || ($_GET['pview'] != 1))
	{
		echo "<table class=\"table-header\"><tr><td class=\"left\"><button class=\"btn btn-default btn-xs\" onclick=\"charger();javascript: location.href='day.php?year=$yy&amp;month=$ym&amp;day=$yd&amp;area=$area';\"> <span class=\"glyphicon glyphicon-backward\"></span> ".get_vocab('daybefore')."</button></td><td>";
		include "include/trailer.inc.php";
		echo "</td><td class=\"right\"><button class=\"btn btn-default btn-xs\" onclick=\"charger();javascript: location.href='day.php?year=$ty&amp;month=$tm&amp;day=$td&amp;area=$area';\"> ".get_vocab('dayafter')."  <span class=\"glyphicon glyphicon-forward\"></span></button></td></tr></table>";
	}
	echo "<h4 class=\"titre\">" . ucfirst(utf8_strftime($dformat, $am7));
	if (getSettingValue("jours_cycles_actif") == "Oui" && intval($jour_cycle) >- 1)
	{
		if (intval($jour_cycle) > 0)
			echo " - ".get_vocab("rep_type_6")." ".$jour_cycle;
		else
			echo " - ".$jour_cycle;
	}
	echo " ".ucfirst($this_area_name)." - ".get_vocab("all_areas")."</h4>";
	echo " </div>\n";
	if (isset($_GET['precedent']))
	{
		if ($_GET['pview'] == 1 && $_GET['precedent'] == 1)
			echo "<span id=\"lienPrecedent\"><button class=\"btn btn-default btn-xs\" onclick=\"charger();javascript:history.back();\">Précedent</button></span>";
	}
	echo "<div class=\"contenu_planning\">" ;
	echo "<table class=\"table-bordered\">";
	echo "<tr>\n<th style=\"width:5%;\">";
	if ($enable_periods == 'y')
		echo get_vocab("period");
	else
		echo get_vocab("time");
	echo  "</th>";
	$tab[1][] = " ";
	$room_column_width = (int)(90 / grr_sql_count($res));
	$nbcol = 0;
	$rooms = array();
	$a = 0;
	for ($i = 0; ($row = grr_sql_row($res, $i)); $i++)
	{
		$id_room[$i] = $row[2];
		$nbcol++;
		if (verif_acces_ressource(getUserName(), $id_room[$i]))
		{
			$room_name[$i] = $row[0];
			$statut_room[$id_room[$i]] =  $row[4];
			$statut_moderate[$id_room[$i]] =  $row[7];
			$acces_fiche_reservation = verif_acces_fiche_reservation(getUserName(), $id_room[$i]);
			if ($row[1]  && $_GET['pview'] != 1)
				$temp = "<br /><span class=\"small\">($row[1] ".($row[1] > 1 ? get_vocab("number_max2") : get_vocab("number_max")).")</span>";
			else
				$temp = "";
			if ($statut_room[$id_room[$i]] == "0"  && $_GET['pview'] != 1)
				$temp .= "<br /><span class=\"texte_ress_tempo_indispo\">".get_vocab("ressource_temporairement_indisponible")."</span>";
			if ($statut_moderate[$id_room[$i]] == "1"  && $_GET['pview'] != 1)
				$temp .= "<br /><span class=\"texte_ress_moderee\">".get_vocab("reservations_moderees")."</span>";
			echo "<th style=\"width:$room_column_width%;\" ";
			if ($statut_room[$id_room[$i]] == "0")
				echo "class='avertissement' ";
			$a = $a + 1;
			echo "><a id=\"afficherBoutonSelection$a\" class=\"lienPlanning\" href=\"#\" onclick=\"afficherMoisSemaine($a)\" style=\"display:inline;\">".htmlspecialchars($row[0])."</a>\n";
			echo "<a id=\"cacherBoutonSelection$a\" class=\"lienPlanning\" href=\"#\" onclick=\"cacherMoisSemaine($a)\" style=\"display:none;\">".htmlspecialchars($row[0])."</a>\n";
			if (htmlspecialchars($row[3]. $temp != ''))
			{
				if (htmlspecialchars($row[3] != ''))
					$saut = "<br />";
				else
					$saut = "";
				echo $saut.htmlspecialchars($row[3]) . $temp."\n";
			}
			echo "<br />";
			if (verif_display_fiche_ressource(getUserName(), $id_room[$i]) && $_GET['pview'] != 1)
				echo "<a href='javascript:centrerpopup(\"view_room.php?id_room=$id_room[$i]\",600,480,\"scrollbars=yes,statusbar=no,resizable=yes\")' title=\"".get_vocab("fiche_ressource")."\">
			<span class=\"glyphcolor glyphicon glyphicon-search\"></span></a>";
			if (authGetUserLevel(getUserName(),$id_room[$i]) > 2 && $_GET['pview'] != 1)
				echo "<a href='admin_edit_room.php?room=$id_room[$i]'><span class=\"glyphcolor glyphicon glyphicon-cog\"></span></a><br/>";
			affiche_ressource_empruntee($id_room[$i]);
			echo "<span id=\"boutonSelection$a\" style=\"display:none;\">
			<input type=\"button\" class=\"btn btn-default btn-xs\" title=\"".htmlspecialchars(get_vocab("see_week_for_this_room"))."\" onclick=\"charger();javascript: location.href='week.php?year=$year&amp;month=$month&amp;cher=$day&amp;room=$id_room[$i]';\" value=\" ".get_vocab('week')." \"/>
			<input type=\"button\" class=\"btn btn-default btn-xs\" title=\"".htmlspecialchars(get_vocab("see_month_for_this_room"))."\" onclick=\"charger();javascript: location.href='month.php?year=$year&amp;month=$month&amp;day=$day&amp;room=$id_room[$i]';\" value=\" ".get_vocab('month')." \"/>";
			echo "</span>";
			echo "</th>";
			$tab[1][$i + 1] = htmlspecialchars($row[0]);
			if (htmlspecialchars($row[3]. $temp != ''))
			{
				if (htmlspecialchars($row[3] != ''))
					$saut = "<br />";
				else
					$saut = "";
				$tab[1][$i + 1] .="<br />-".$saut."<i><span class =\"small\">". htmlspecialchars($row[3]) . $temp."\n</span></i>";
			}
			$tab[1][$i + 1] .= "<br />";
			if (verif_display_fiche_ressource(getUserName(), $id_room[$i]))
				$tab[1][$i + 1] .= "<a href='javascript:centrerpopup(\"view_room.php?id_room=$id_room[$i]\",600,480,\"scrollbars=yes,statusbar=no,resizable=yes\")' title=\"".get_vocab("fiche_ressource")."\">
			<span class=\"glyphcolor glyphicon glyphicon-search\"></span></a>";
			if (authGetUserLevel(getUserName(),$id_room[$i]) > 2 && $_GET['pview'] != 1)
				$tab[1][$i + 1] .= "<a href='admin_edit_room.php?room=$id_room[$i]'><span class=\"glyphcolor glyphicon glyphicon-cog\"></span></a>";
			$rooms[] = $row[2];
			$delais_option_reservation[$row[2]] = $row[6];
		}
	}
	if (count($rooms) == 0)
	{
		echo "<br /><h1>".get_vocab("droits_insuffisants_pour_voir_ressources")."</h1><br />";
		include "include/trailer.inc.php";
		exit;
	}
	echo "<tr>\n<th style=\"width:5%;\">";
	if ($enable_periods == 'y')
		$tab[2][] = get_vocab('period');
	else
		$tab[2][] = get_vocab('time');
	echo "\n</tr>\n";
	$tab_ligne = 3;
	for ($t = $am7; $t <= $pm7; $t += $resolution)
	{
		echo "<tr>\n";
		tdcell("cell_hours");
		if ($enable_periods == 'y')
		{
			$time_t = date("i", $t);
			$time_t_stripped = preg_replace( "/^0/", "", $time_t );
			echo $periods_name[$time_t_stripped] . "</td>\n";
			$tab[$tab_ligne][] = $periods_name[$time_t_stripped];
		}
		else
		{
			echo affiche_heure_creneau($t,$resolution)."</td>\n";
			$tab[$tab_ligne][] = affiche_heure_creneau($t,$resolution);
		}
		while (list($key, $room) = each($rooms))
		{
			if (verif_acces_ressource(getUserName(), $room))
			{
				if (isset($today[$room][$t]["id"]))
				{
					$id    = $today[$room][$t]["id"];
					$color = $today[$room][$t]["color"];
					$descr = $today[$room][$t]["data"];
				}
				else
					unset($id);
				if ((isset($id)) && (!est_hors_reservation(mktime(0, 0, 0, $month, $day, $year), $area)))
					$c = $color;
				else if ($statut_room[$room] == "0")
					$c = "avertissement";
				else
					$c = "empty_cell";
				if ((isset($id)) && (!est_hors_reservation(mktime(0, 0, 0, $month, $day, $year), $area)))
				{
					if ( $compteur[$id] == 0 )
					{
						if ($cellules[$id] != 1)
						{
							if (isset($today[$room][$t + ($cellules[$id] - 1) * $resolution]["id"]))
							{
								$id_derniere_ligne_du_bloc = $today[$room][$t + ($cellules[$id] - 1) * $resolution]["id"];
								if ($id_derniere_ligne_du_bloc != $id)
									$cellules[$id] = $cellules[$id]-1;
							}
						}
						tdcell_rowspan ($c, $cellules[$id]);
					}
					$compteur[$id] = 1;
				}
				else
					tdcell ($c);
				if ((!isset($id)) || (est_hors_reservation(mktime(0, 0, 0, $month, $day, $year), $area)))
				{
					$hour = date("H", $t);
					$minute  = date("i", $t);
					$date_booking = mktime($hour, $minute, 0, $month, $day, $year);
					if (est_hors_reservation(mktime(0, 0, 0, $month, $day, $year), $area))
					{
						echo "<img src=\"img_grr/stop.png\" alt=\"".get_vocab("reservation_impossible")."\"  title=\"".get_vocab("reservation_impossible")."\" width=\"16\" height=\"16\" class=\"".$class_image."\"  />";
						$tab[$tab_ligne][] = "<img src=\"img_grr/stop.png\" alt=\"".get_vocab("reservation_impossible")."\"  title=\"".get_vocab("reservation_impossible")."\" width=\"16\" height=\"16\" class=\"".$class_image."\"  />";
					}
					else
					{
						if (((authGetUserLevel(getUserName(), -1) > 1) || (auth_visiteur(getUserName(), $room) == 1)) && (UserRoomMaxBooking(getUserName(), $room, 1) != 0) && verif_booking_date(getUserName(), -1, $room, $date_booking, $date_now, $enable_periods) && verif_delais_max_resa_room(getUserName(), $room, $date_booking) && verif_delais_min_resa_room(getUserName(), $room, $date_booking) && (($statut_room[$room] == "1") || (($statut_room[$room] == "0") && (authGetUserLevel(getUserName(),$room) > 2) )) && $_GET['pview'] != 1)
						{
							if ($enable_periods == 'y')
							{
								echo "<a href=\"edit_entry.php?room=$room&amp;period=$time_t_stripped&amp;year=$year&amp;month=$month&amp;day=$day&amp;page=day\" title=\"".get_vocab("cliquez_pour_effectuer_une_reservation")."\" ><span class=\"glyphicon glyphicon-plus\"></span></a>";
								$tab[$tab_ligne][] = "<a href=\"edit_entry.php?room=$room&amp;period=$time_t_stripped&amp;year=$year&amp;month=$month&amp;day=$day&amp;page=day\" title=\"".get_vocab("cliquez_pour_effectuer_une_reservation")."\" ><span class=\"glyphicon glyphicon-plus\"></span></a>";
							}
							else
							{
								echo "<a href=\"edit_entry.php?room=$room&amp;hour=$hour&amp;minute=$minute&amp;year=$year&amp;month=$month&amp;day=$day&amp;page=day\" title=\"".get_vocab("cliquez_pour_effectuer_une_reservation")."\" ><span class=\"glyphicon glyphicon-plus\"></span></a>";
								$tab[$tab_ligne][] = "<a href=\"edit_entry.php?room=$room&amp;hour=$hour&amp;minute=$minute&amp;year=$year&amp;month=$month&amp;day=$day&amp;page=day\" title=\"".get_vocab("cliquez_pour_effectuer_une_reservation")."\" ><span class=\"glyphicon glyphicon-plus\"></span></a>";
							}
						}
						else
						{
							echo " ";
							$tab[$tab_ligne][] = " ";
						}
					}
						echo "</td>\n";
					}
					else if ($descr != "")
					{
						if ((isset($today[$room][$t]["statut"])) && ($today[$room][$t]["statut"] != '-'))
						{
							echo " <img src=\"img_grr/buzy.png\" alt=\"".get_vocab("ressource actuellement empruntee")."\" title=\"".get_vocab("ressource actuellement empruntee")."\" width=\"20\" height=\"20\" class=\"image\" /> \n";
							$tab[$tab_ligne][] = " <img src=\"img_grr/buzy.png\" alt=\"".get_vocab("ressource actuellement empruntee")."\" title=\"".get_vocab("ressource actuellement empruntee")."\" width=\"20\" height=\"20\" class=\"image\" /> \n";
						}
						if (($delais_option_reservation[$room] > 0) && (isset($today[$room][$t]["option_reser"])) && ($today[$room][$t]["option_reser"] != -1))
						{
							echo " <img src=\"img_grr/small_flag.png\" alt=\"".get_vocab("reservation_a_confirmer_au_plus_tard_le")."\" title=\"".get_vocab("reservation_a_confirmer_au_plus_tard_le")." ".time_date_string_jma($today[$room][$t]["option_reser"],$dformat)."\" width=\"20\" height=\"20\" class=\"image\" /> \n";
							$tab[$tab_ligne][] = " <img src=\"img_grr/small_flag.png\" alt=\"".get_vocab("reservation_a_confirmer_au_plus_tard_le")."\" title=\"".get_vocab("reservation_a_confirmer_au_plus_tard_le")." ".time_date_string_jma($today[$room][$t]["option_reser"],$dformat)."\" width=\"20\" height=\"20\" class=\"image\" /> \n";
						}
						if ((isset($today[$room][$t]["moderation"])) && ($today[$room][$t]["moderation"] == '1'))
						{
							echo " <img src=\"img_grr/flag_moderation.png\" alt=\"".get_vocab("en_attente_moderation")."\" title=\"".get_vocab("en_attente_moderation")."\" class=\"image\" /> \n";
							$tab[$tab_ligne][] = " <img src=\"img_grr/flag_moderation.png\" alt=\"".get_vocab("en_attente_moderation")."\" title=\"".get_vocab("en_attente_moderation")."\" class=\"image\" /> \n";
						}
						if (($statut_room[$room] == "1") || (($statut_room[$room] == "0") && (authGetUserLevel(getUserName(), $room) > 2) ))
						{
							if ($acces_fiche_reservation)
							{
								if (getSettingValue("display_level_view_entry") == 0)
								{
									$currentPage = 'day';
									echo "<a title=\"".htmlspecialchars($today[$room][$t]["who"])."\" href=\"#?w=600\" onclick=\"request($id,$day,$month,$year,'$currentPage',readData);\" rel=\"popup_name\" class=\"poplight\">$descr";
								}
								else
								{
									echo "<a class=\"lienCellule\" title=\"".htmlspecialchars($today[$room][$t]["who"])."\" href=\"view_entry.php?id=$id&amp;day=$day&amp;month=$month&amp;year=$year&amp;page=day\">$descr";
									$tab[$tab_ligne][] = "<a title=\"".htmlspecialchars($today[$room][$t]["who"])."\" href=\"view_entry.php?id=$id&amp;day=$day&amp;month=$month&amp;year=$year&amp;page=day\">$descr</a>";
								}
							}
							else
							{
								echo " $descr";
								$tab[$tab_ligne][] = " $descr";
							}
							$sql = "SELECT type_name,start_time,end_time FROM ".TABLE_PREFIX."_type_area ,".TABLE_PREFIX."_entry  WHERE  ".TABLE_PREFIX."_entry.id= ".$today[$room][$t]["id"]." AND ".TABLE_PREFIX."_entry.type= ".TABLE_PREFIX."_type_area.type_letter";
							$res = grr_sql_query($sql);
							for ($i = 0; ($row = grr_sql_row($res, $i)); $i++)
							{
								$type_name  = $row[0];
								$start_time = $row[1];
								$end_time   = $row[2];
								echo "<br/>".date('H:i', $start_time)."~".date('H:i', $end_time)."<br/>";
								if ($type_name != -1)
									echo  $type_name;
							}
							if ($today[$room][$t]["description"]!= "")
							{
								echo "<br /><i>".$today[$room][$t]["description"]."</i>";
								$tab[$tab_ligne][] = "<br /><i>".$today[$room][$t]["description"]."</i>";
							}
						}
						else
						{
							echo " $descr";
							$tab[$tab_ligne][] = " $descr";
						}
						if ($acces_fiche_reservation)
							echo "</a>";
						echo "</td>\n";
					}
				}
			}
			echo "</tr>\n";
			reset($rooms);
			$tab_ligne++;
		}
		echo "</table>";
	}
	grr_sql_free($res);
	if ($_GET['pview'] != 1)
	{
		echo "<div id=\"toTop\">\n<b>".get_vocab("top_of_page")."</b>\n";
		bouton_retour_haut ();
		echo "\n</div>";
	}
	echo "\n</div>";
	echo "\n</div>";
	affiche_pop_up(get_vocab("message_records"), "user");
	echo "\n<div id=\"popup_name\" class=\"popup_block\" ></div>";
	?>
