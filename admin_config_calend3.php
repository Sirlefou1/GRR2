<?php
/**
 * admin_config_calend3.php
 * Interface permettant la la réservation en bloc de journées entières
 * Ce script fait partie de l'application GRR
 * Dernière modification : $Date: 2009-04-14 12:59:17 $
 * @author    Laurent Delineau <laurent.delineau@ac-poitiers.fr>
 * @copyright Copyright 2003-2008 Laurent Delineau
 * @link      http://www.gnu.org/licenses/licenses.html
 * @package   root
 * @version   $Id: admin_config_calend3.php,v 1.7 2009-04-14 12:59:17 grr Exp $
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
$grr_script_name = "admin_calend_jour_cycle.php";
$back = '';
if (isset($_SERVER['HTTP_REFERER']))
	$back = htmlspecialchars($_SERVER['HTTP_REFERER']);
	check_access(6, $back);
	print_header("", "", "", $type="with_session");
	// Affichage de la colonne de gauche
	if (!isset($_GET['pview']))
		include "admin_col_gauche.php";
	// Affichage du tableau de choix des sous-configurations des jours/cycles (créer et voir le calendrier des jours/cycles)
	if (!isset($_GET['pview']))
		include "include/admin_calend_jour_cycle.inc.php";
	echo "<h3>".get_vocab('calendrier_jours/cycles');
	echo "</h3>\n";
	if (!isset($_GET['pview']))
	{
		echo get_vocab("explication_Jours_Cycles3");
		echo "<br />".get_vocab("explication_Jours_Cycles4")."<br />\n";
	}
// Modification d'un jour cycle
// intval($jour)=-1 : pas de jour cycle
// intval($jour)=0 : Titre
// intval($jour)>0 : Jour cycle
	if (!isset($_GET['pview']) && isset($_GET['date']))
	{
		$jour_cycle = grr_sql_query1("select Jours from ".TABLE_PREFIX."_calendrier_jours_cycle  WHERE DAY = ".$_GET['date']."");
		echo "<fieldset style=\"padding-top: 8px; padding-bottom: 8px; width: 80%; margin-left: auto; margin-right: auto;\">\n";
		echo "<legend>".get_vocab('Journee du')." ".affiche_date($_GET['date'])."</legend>\n";
		echo "<form id=\"main\" method=\"get\" action=\"admin_calend_jour_cycle.php\">\n";
		echo "<div><input type='radio' name='selection' value='0'";
		if (intval($jour_cycle) == -1)
			echo " checked=\"checked\"";
		echo " />".get_vocab('Cette journee ne correspond pas a un jour cycle')."<br />\n";
		echo "<input type='radio' name='selection' value='1'";
		if (intval($jour_cycle) > 0)
			echo " checked=\"checked\"";
		echo " />\n".get_vocab("nouveau_jour_cycle");
		echo "<select name=\"newDay\" size=\"1\" onclick=\"check(1)\">";
		for ($i = 1; $i < (getSettingValue("nombre_jours_Jours/Cycles") + 1); $i++)
		{
			echo "<option value=\"".$i."\" ";
			if ($jour_cycle == $i)
				echo " selected=\"selected\"";
			echo " >j".$i."</option>";
		}
		echo "</select>\n";
		echo "<input name=\"newdate\" type=\"hidden\" value=\"".$_GET['date']."\" />";
		echo "<input type=\"hidden\" value=\"3\" name=\"page_calend\" /><br />";
		echo "<input type='radio' name='selection' value='2'";
		if (intval($jour_cycle) == 0)
			echo " checked=\"checked\"";
		echo " />".get_vocab('Nommer_journee_par_le_titre_suivant').get_vocab('deux_points');
		echo "<input type=\"text\" name=\"titre\" onfocus=\"check(2)\"";
		if (!intval($jour_cycle) > 0)
			echo " value=\"".$jour_cycle."\"";
		echo "/><br /><br /><div style=\"text-align:center;\"><input type=\"submit\" value=\"Enregistrer\" /></div>\n";
		echo "</div></form>\n";
		echo "</fieldset>\n";
	}
	// Enregistrement du nouveau jour cycle
	if (isset($_GET['selection']))
	{
		if ($_GET['selection'] == 0)
		{
			grr_sql_query("delete from ".TABLE_PREFIX."_calendrier_jours_cycle WHERE DAY = ".$_GET['newdate']."");
		}
		elseif ($_GET['selection'] == 1)
		{
			grr_sql_query("delete from ".TABLE_PREFIX."_calendrier_jours_cycle WHERE DAY = ".$_GET['newdate']."");
			grr_sql_query("insert into ".TABLE_PREFIX."_calendrier_jours_cycle set Jours =".$_GET['newDay'].", DAY = ".$_GET['newdate']."");
		}
		elseif ($_GET['selection'] == 2)
		{
			grr_sql_query("delete from ".TABLE_PREFIX."_calendrier_jours_cycle WHERE DAY = ".$_GET['newdate']."");
			grr_sql_query("insert into ".TABLE_PREFIX."_calendrier_jours_cycle set Jours ='".protect_data_sql($_GET['titre'])."', DAY = ".$_GET['newdate']."");
		}
	}
	$basetime = mktime(12, 0, 0, 6, 11 + $weekstarts, 2000);
	echo "<table cellspacing=\"20\" border=\"0\">\n";
	$n = getSettingValue("begin_bookings");
	$end_bookings = getSettingValue("end_bookings");
	$debligne = 1;
	$month = strftime("%m", getSettingValue("begin_bookings"));
	$year = strftime("%Y", getSettingValue("begin_bookings"));
	$inc = 0;
	while ($n <= $end_bookings)
	{
		if ($debligne == 1)
		{
			echo "<tr>\n";
			$inc = 0;
			$debligne = 0;
		}
		$inc++;
		echo "<td>\n";
		echo cal($month, $year);
		echo "</td>";
		if ($inc == 3)
		{
			echo "</tr>";
			$debligne = 1;
		}
		$month++;
		if ($month == 13)
		{
			$year++;
			$month = 1;
		}
		$n = mktime(0, 0, 0, $month, 1, $year);
	}
	if ($inc < 3)
	{
		$k = $inc;
		while ($k < 3)
		{
			echo "<td> </td>\n";
			$k++;
		} // while
		echo "</tr>";
	}
	echo "</table>";
	if (!isset($_GET['pview']))
	{
		echo "\n<div class=\"format_imprimable\"><a href=\"admin_calend_jour_cycle.php?page_calend=3&amp;pview=1\">Format Imprimable</a></div>\n";
		echo "</td>\n</tr>";
		echo "</table>";
	}
	// fin de l'affichage de la colonne de droite
	?>
	<script type="text/javascript" >
		function check (select)
		{
			document.getElementById('main').selection[select].checked=true;
		}
	</script>
</body>
</html>