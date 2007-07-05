<?php
/**
* @package    jelix
* @subpackage jtpl_plugin
* @author     Jouanneau Laurent
* @copyright   2006 Jouanneau laurent
* @link        http://www.jelix.org
* @licence    GNU Lesser General Public Licence see LICENCE file or http://www.gnu.org/licenses/lgpl.html
*/

/**
 * function plugin :  include the content of a zone
 *
 * <pre> {zone 'myModule~myzone'}
 * {zone 'myModule~myzone',array('foo'=>'bar)}</pre>
 * @param jTpl $tpl template engine
 * @param string $string the zone selector
 * @param array $params parameters for the zone
 */
function jtpl_function_zone($tpl, $name, $params=array())
{
     echo jZone::get($name, $params);
}

?>