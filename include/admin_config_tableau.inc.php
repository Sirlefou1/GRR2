<?php
/**
 * admin_config_tableau.inc.php
 *
 * Ce script fait partie de l'application GRR
 * Dernière modification : $Date: 2009-09-29 18:02:57 $
 * @author    Laurent Delineau <laurent.delineau@ac-poitiers.fr>
 * @copyright Copyright 2003-2008 Laurent Delineau
 * @link      http://www.gnu.org/licenses/licenses.html
 * @package   root
 * @version   $Id: admin_config_tableau.inc.php,v 1.5 2009-09-29 18:02:57 grr Exp $
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
 * $Log: admin_config_tableau.inc.php,v $
 * Revision 1.5  2009-09-29 18:02:57  grr
 * *** empty log message ***
 *
 * Revision 1.4  2009-02-27 13:28:20  grr
 * *** empty log message ***
 *
 * Revision 1.3  2008-11-16 22:00:59  grr
 * *** empty log message ***
 *
 * Revision 1.9  2008-11-14 07:29:09  grr
 *
 */

?>
<script type="text/javascript">
function changeclass(objet, myClass) { objet.className = myClass; }
</script>
<?php
echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "<tbody>\n";
echo "<tr>";
for ($k=1;$k<6;$k++) {
echo "<td style=\"width:20%;\">";
if ($page_config == $k) {
    echo "<div style=\"position: relative;\"><div class=\"onglet_off\" style=\"position: relative; top: 0px; padding-left: 20px; padding-right: 20px; min-height: 2.5em;\">".
    get_vocab('admin_config'.$k.'.php')."</div></div>";
} else {
    echo "<div style=\"position: relative;\">
    <div onmouseover=\"changeclass(this, 'onglet_on');\" onmouseout=\"changeclass(this, 'onglet');\" class=\"onglet\" style=\"position: relative; top: 0px; padding-left: 20px; padding-right: 20px; min-height: 2.5em;\">
    <a href=\"admin_config.php?page_config=".$k."\">".get_vocab('admin_config'.$k.'.php')."</a></div></div>";
}
echo "</td>\n";
}
echo "</tr></tbody></table>\n";
?>