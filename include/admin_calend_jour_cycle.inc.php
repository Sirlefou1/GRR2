<?php
/**
 * admin_calend_jour_cycle.inc.php
 * Menu da la page de création du calendrier jours/cycles
 * Ce script fait partie de l'application GRR
 * Dernière modification : $Date: 2009-02-27 13:28:20 $
 * @author    Laurent Delineau <laurent.delineau@ac-poitiers.fr>
 * @copyright Copyright 2003-2008 Laurent Delineau
 * @link      http://www.gnu.org/licenses/licenses.html
 * @package   root
 * @version   $Id: admin_calend_jour_cycle.inc.php,v 1.3 2009-02-27 13:28:20 grr Exp $
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
?>
<script type="text/javascript">
	function changeclass(objet, myClass)
	{
		objet.className = myClass;
	}
</script>
<?php
echo '<div style="text-align:center;"><table class="table-header">',PHP_EOL;
echo '<tbody>',PHP_EOL;
echo '<tr>',PHP_EOL;
if (!isset($page_calend))
	$page_calend = 1;
for ($k = 1; $k < 4; $k++)
{
	echo '<td>',PHP_EOL;
	if ($page_calend == $k)
	{
		echo '<div style="position: relative;">',PHP_EOL,'<div class="onglet_off" style="position: relative; top: 0px; padding-left: 30px; padding-right: 30px;">',
		get_vocab('admin_config_calend'.$k.'.php'),'</div>',PHP_EOL,'</div>',PHP_EOL;
	}
	else
	{
		echo '<div style="position: relative;">',PHP_EOL;
		echo '<div onmouseover="changeclass(this, \'onglet_on\');" onmouseout="changeclass(this, \'onglet\');\" class="onglet" style="position: relative; top: 0px; padding-left: 30px; padding-right: 30px;">',PHP_EOL;
		echo '<a href="admin_calend_jour_cycle.php?page_calend=',$k,'">',get_vocab('admin_config_calend'.$k.'.php'),'</a>',PHP_EOL,'</div>',PHP_EOL,'</div>',PHP_EOL;
	}
	echo '</td>',PHP_EOL;
}
echo '</tr>',PHP_EOL,'</tbody>',PHP_EOL,'</table>',PHP_EOL,'</div>',PHP_EOL;
?>
