<?php
/**
 * mincals.inc.php
 * Fonctions permettant d'afficher le mini calendrier
 * Ce script fait partie de l'application GRR
 * Dernière modification : $Date: 2010-01-06 10:21:20 $
 * @author    Laurent Delineau <laurent.delineau@ac-poitiers.fr>
 * @copyright Copyright 2003-2008 Laurent Delineau
 * @link      http://www.gnu.org/licenses/licenses.html
 * @package   root
 * @version   $Id: mincals.inc.php,v 1.7 2010-01-06 10:21:20 grr Exp $
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
function minicals($year, $month, $day, $area, $room, $dmy)
{
	global $display_day, $vocab;
	get_planning_area_values($area);
	class Calendar
	{
		var $month;
		var $year;
		var $day;
		var $h;
		var $area;
		var $room;
		var $dmy;
		var $week;
		var $mois_precedent;
		var $mois_suivant;

		/**
		 * @param string $day
		 * @param string $month
		 * @param string $year
		 * @param integer $h
		 * @param integer $mois_precedent
		 * @param integer $mois_suivant
		 */
		function Calendar($day, $month, $year, $h, $area, $room, $dmy, $mois_precedent, $mois_suivant)
		{
			$this->day   = $day;
			$this->month = $month;
			$this->year  = $year;
			$this->h     = $h;
			$this->area  = $area;
			$this->room  = $room;
			$this->dmy   = $dmy;
			$this->mois_precedent = $mois_precedent;
			$this->mois_suivant = $mois_suivant;
		}
		function getCalendarLink($month, $year)
		{
			return "";
		}

		/**
		 * @param integer $day
		 * @param double $month
		 */
		function getDateLink($day, $month, $year)
		{
			global $vocab;
			if ($this->dmy != 'day')
			{
				if (isset($this->room))
					return "<a onclick=\"charger();\" class=\"calendar\" title=\"".htmlspecialchars(get_vocab("see_all_the_rooms_for_the_day"))."\" href=\"".$this->dmy.".php?year=$year&amp;month=$month&amp;day=$day&amp;room=".$this->room."\"";
				return "<a onclick=\"charger();\" class=\"calendar\" title=\"".htmlspecialchars(get_vocab("see_all_the_rooms_for_the_day"))."\" href=\"".$this->dmy.".php?year=$year&amp;month=$month&amp;day=$day&amp;area=".$this->area."\"";
			}
			if ($this->dmy == 'day')
			{
				if (isset($this->room))
					return "<a onclick=\"charger();\" class=\"calendar\" title=\"".htmlspecialchars(get_vocab("see_all_the_rooms_for_the_day"))."\" href=\"day.php?year=$year&amp;month=$month&amp;day=$day&amp;room=".$this->room."\"";
				return "<a onclick=\"charger();\" class=\"calendar\" title=\"".htmlspecialchars(get_vocab("see_all_the_rooms_for_the_day"))."\" href=\"day.php?year=$year&amp;month=$month&amp;day=$day&amp;area=".$this->area."\"";
			}
		}
		function getHTML()
		{
			global $weekstarts, $vocab, $type_month_all, $display_day, $nb_display_day;
			// Calcul de la date courante
			$date_today = mktime(12, 0, 0, $this->month, $this->day, $this->year);
			// Calcul du numéro de semaine courante
			$week_today = numero_semaine($date_today);
			if (!isset($weekstarts))
				$weekstarts = 0;
			$s = "";
			$daysInMonth = getDaysInMonth($this->month, $this->year);
			// Calcul de la date au 1er du mois de la date courante
			$date = mktime(12, 0, 0, $this->month, 1, $this->year);
			$first = (strftime("%w",$date) + 7 - $weekstarts) % 7;
			$monthName = utf8_strftime("%B", $date);
			$prevMonth = $this->getCalendarLink($this->month - 1 >   0 ? $this->month - 1 : 12, $this->month - 1 >   0 ? $this->year : $this->year - 1);
			$nextMonth = $this->getCalendarLink($this->month + 1 <= 12 ? $this->month + 1 :  1, $this->month + 1 <= 12 ? $this->year : $this->year + 1);
			$s .= "\n<table class=\"calendar\">\n";
			$s .= "<caption>";
			if (($this->h) && (($this->dmy == 'month') || ($this->dmy == 'month_all') || ($this->dmy == 'month_all2')))
				$bg_lign = "week";
			else
				$bg_lign = 'calendarcol1';
			//Permet de récupérer le numéro de la 1ere semaine affichée par le mini calendrier.
			$week = numero_semaine($date);
			$weekd = $week;
			// on ajoute un lien vers l''année précédente
			if ($this->mois_precedent == 1)
			{
				$tmp = mktime(0, 0, 0, ($this->month), 1, ($this->year) - 1);
				$lastmonth = date("m",$tmp);
				$lastyear = date("Y",$tmp);
				if (($this->dmy != 'day') && ($this->dmy != 'week_all') && ($this->dmy != 'month_all') && ($this->dmy != 'month_all2'))
					$s .= "<div class=\"btn-group\"><button title=\"".htmlspecialchars(get_vocab("previous_year"))."\" class=\"btn btn-default btn-xs\" onclick=\"charger();javascript: location.href='month.php?year=$lastyear&amp;month=$lastmonth&amp;day=1&amp;area=$this->area&amp;room=$this->room';\"><span class=\"glyphicon glyphicon-backward\"></span></button>\n";
				else
					$s .= "<div class=\"btn-group\"><button title=\"".htmlspecialchars(get_vocab("previous_year"))."\" class=\"btn btn-default btn-xs\" onclick=\"charger();javascript: location.href='".$type_month_all.".php?year=$lastyear&amp;month=$lastmonth&amp;day=1&amp;area=$this->area';\"><span class=\"glyphicon glyphicon-backward\"></span></button>\n";
				$tmp = mktime(0, 0, 0, ($this->month) - 1, 1, $this->year);
				$lastmonth = date("m",$tmp);
				$lastyear = date("Y",$tmp);
				if (($this->dmy != 'day') && ($this->dmy != 'week_all') && ($this->dmy != 'month_all') && ($this->dmy != 'month_all2'))
					$s .= "<button title=\"".htmlspecialchars(get_vocab("see_month_for_this_room"))."\" class=\"btn btn-default btn-xs\" onclick=\"charger();javascript: location.href='month.php?year=$lastyear&amp;month=$lastmonth&amp;day=1&amp;area=$this->area&amp;room=$this->room';\"><span class=\"glyphicon glyphicon-chevron-left\"></span></button>\n";
				else
					$s .= "<button title=\"".htmlspecialchars(get_vocab("see_month_for_this_room"))."\" class=\"btn btn-default btn-xs\" onclick=\"charger();javascript: location.href='".$type_month_all.".php?year=$lastyear&amp;month=$lastmonth&amp;day=1&amp;area=$this->area';\"><span class=\"glyphicon glyphicon-chevron-left\"></span></button>\n";
			}
			//Lien du mois acutel
			if (($this->dmy != 'day') && ($this->dmy != 'week_all') && ($this->dmy != 'month_all') && ($this->dmy != 'month_all2'))
				$s .= "<button title=\"".htmlspecialchars(get_vocab("see_all_the_rooms_for_the_month"))."\" class=\"btn btn-default btn-xs\" onclick=\"charger();javascript: location.href='month.php?year=$this->year&amp;month=$this->month&amp;day=1&amp;area=$this->area&amp;room=$this->room';\">$monthName $this->year</button>\n";
			else
				$s .= "<button title=\"".htmlspecialchars(get_vocab("see_all_the_rooms_for_the_month"))."\" class=\"btn btn-default btn-xs\" onclick=\"charger();javascript: location.href='".$type_month_all.".php?year=$this->year&amp;month=$this->month&amp;day=1&amp;area=$this->area';\">$monthName $this->year</button>\n";
			// on ajoute un lien vers le mois suivant
			if ($this->mois_suivant == 1)
			{
				$tmp = mktime(0, 0, 0, ($this->month) + 1, 1, $this->year);
				$nextmonth = date("m",$tmp);
				$nextyear = date("Y",$tmp);
				if (($this->dmy != 'day') && ($this->dmy != 'week_all') && ($this->dmy != 'month_all') && ($this->dmy != 'month_all2'))
					$s .= "<button title=\"".htmlspecialchars(get_vocab("see_month_for_this_room"))."\" class=\"btn btn-default btn-xs\" onclick=\"charger();javascript: location.href='month.php?year=$nextyear&amp;month=$nextmonth&amp;day=1&amp;area=$this->area&amp;room=$this->room';\"><span class=\"glyphicon glyphicon-chevron-right\"></span></button>\n";
				else
					$s .= "<button title=\"".htmlspecialchars(get_vocab("see_month_for_this_room"))."\" class=\"btn btn-default btn-xs\" onclick=\"charger();javascript: location.href='".$type_month_all.".php?year=$nextyear&amp;month=$nextmonth&amp;day=1&amp;area=$this->area';\"><span class=\"glyphicon glyphicon-chevron-right\"></span></button>\n";
				$tmp = mktime(0, 0, 0, ($this->month), 1, ($this->year) + 1);
				$nextmonth = date("m",$tmp);
				$nextyear= date("Y",$tmp);
				if (($this->dmy != 'day') && ($this->dmy != 'week_all') && ($this->dmy != 'month_all') && ($this->dmy != 'month_all2'))
					$s .= "<button title=\"".htmlspecialchars(get_vocab("following_year"))."\" class=\"btn btn-default btn-xs\" onclick=\"charger();javascript: location.href='month.php?year=$nextyear&amp;month=$nextmonth&amp;day=1&amp;area=$this->area&amp;room=$this->room';\"><span class=\"glyphicon glyphicon-forward\"></span></button></div>\n";
				else
					$s .= "<button title=\"".htmlspecialchars(get_vocab("following_year"))."\" class=\"btn btn-default btn-xs\" onclick=\"charger();javascript: location.href='".$type_month_all.".php?year=$nextyear&amp;month=$nextmonth&amp;day=1&amp;area=$this->area';\"><span class=\"glyphicon glyphicon-forward\"></span></button></div>\n";
			}
			//Hugo - Variable qui permet de rester dans la meme room au changement de salle
			$action = $_SERVER['PHP_SELF']."?year=".date('Y',time())."&amp;month=".date('m',time())."&amp;day=".date('d',time());
			if (isset($_GET['area']) && $_GET['area'] != null)
				$action .= "&amp;area=".$_GET['area'] ;
			if (isset($_GET['room']) && $_GET['room'] != null)
				$action .= "&amp;room=".$_GET['room'] ;
			if (isset($_GET['id_site']) && $_GET['id_site'] != null)
				$action .= "&amp;site=".$_GET['id_site'] ;
			$s.= "<br/><button title=\"".htmlspecialchars(get_vocab("gototoday"))."\" class=\"btn btn-default btn-xs\" onclick=\"charger();javascript: location.href='".$action."';\">".get_vocab("gototoday")."</button>";
			$s .= "</caption>";
			$s .= "<tr><td class=\"calendarcol1\">".get_vocab("semaine")."</td>\n";
			$s .= getFirstDays();
			$s .= "</tr>\n";
			$d = 1 - $first;
			$temp = 1;
			while ($d <= $daysInMonth)
			{
				if (($week_today == $week) && ($this->h) && (($this->dmy == 'week_all') || ($this->dmy == 'week')))
					$bg_lign = " class=\"week\"";
				else
					$bg_lign = '';
				$s .= "<tr ".$bg_lign."><td class=\"calendarcol1 lienSemaine\">";
				#Affichage du numéro de la semaine en cours à droite du calendrier et génère un lien sur la semaine voulue.
				if (($this->dmy != 'day') && ($this->dmy != 'week_all') && ($this->dmy != 'month_all') && ($this->dmy != 'month_all2'))
					$s .="<a onclick=\"charger();\" title=\"".htmlspecialchars(get_vocab("see_week_for_this_room"))."\" href=\"week.php?year=$this->year&amp;month=$this->month&amp;day=$temp&amp;area=$this->area&amp;room=$this->room\">".sprintf("%02d",$week)."</a>";
				else
					$s .="<a onclick=\"charger();\" title=\"".htmlspecialchars(get_vocab("see_week_for_this_area"))."\" href=\"week_all.php?year=$this->year&amp;month=$this->month&amp;day=$temp&amp;area=$this->area\">".sprintf("%02d",$week)."</a>";
				$temp = $temp + 7;
				while ((!checkdate($this->month, $temp, $this->year)) && ($temp > 0))
					$temp--;
				#Nouveau affichage, affiche le numéro de la semaine dans l'année.Incrémentation de ce numéro à chaque nouvelle semaine.
				$date = mktime(12, 0, 0, $this->month, $temp, $this->year);
				$week = numero_semaine($date);
				$s .= "</td>\n";
				for ($i = 0; $i < 7; $i++)
				{
					$j = ($i + 7 + $weekstarts) % 7;
					if ($display_day[$j] == "1")
					{
						// début condition "on n'affiche pas tous les jours de la semaine"
						if (($this->dmy == 'day') && ($d == $this->day) && ($this->h))
							$s .= "<td class=\"week\">";
						else
							$s .= "<td class=\"cellcalendar\">";
						if ($d > 0 && $d <= $daysInMonth)
						{
							$link = $this->getDateLink($d, $this->month, $this->year);
							if ($link == "")
								$s .= $d;
							#Permet de colorer la date affichée sur la page
							elseif (($d == $this->day) && ($this->h))
								$s .= $link."><span class=\"cal_current_day\">$d</span></a>";
							else
								$s .= $link.">$d</a>";
						}
						else
							$s .= " ";
						$s .= "</td>\n";
					}
					// fin condition "on n'affiche pas tous les jours de la semaine"
					$d++;
				}
				$s .= "</tr>\n";
			}
			if ($week - $weekd < 6)
				$s .= "";
			$s .= "</table>\n";
			return $s;
		}
	}
	$nb_calendar = getSettingValue("nb_calendar");
	if ($nb_calendar >= 1)
	{
		$month_ = array();
		if ($nb_calendar % 2 == 1)
			$milieu = ($nb_calendar + 1) / 2;
		else
			$milieu = $nb_calendar / 2;
		// Les mois avant le mois courant
		for ($k = 1; $k < $milieu; $k++)
			$month_[] = mktime(0, 0, 0, $month + $k - $milieu, 1, $year);
		// Le mois courant
		$month_[] = mktime(0, 0, 0, $month, $day, $year);
		// Les mois après le mois courant
		for ($k = $milieu; $k < $nb_calendar; $k++)
			$month_[] = mktime(0, 0, 0, $month + $k - $milieu + 1, 1, $year);
		$ind = 1;
		foreach ($month_ as $key)
		{
			if ($ind == 1)
				$mois_precedent = 1;
			else
				$mois_precedent = 0;
			if ($ind == $nb_calendar)
				$mois_suivant = 1;
			else
				$mois_suivant = 0;
			if ($ind == $milieu)
				$flag_surlignage = 1;
			else
				$flag_surlignage = 0;
			$cal = new Calendar(date("d",$key), date("m",$key), date("Y",$key), $flag_surlignage, $area, $room, $dmy, $mois_precedent, $mois_suivant);
			echo $cal->getHTML();
			$ind++;
		}
	}
}
?>
