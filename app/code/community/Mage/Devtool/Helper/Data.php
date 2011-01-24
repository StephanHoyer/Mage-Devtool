<?php
/**
 * Magento
 *
 * PHP version 5
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mage
 * @package   Mage_Devtool
 * @author    Stephan Hoyer <stephan.hoyer@netresearch.de>
 * @copyright 2011 Netresearch GmbH & Co.KG <http://www.netresearch.de/>
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/leistungen/magento-ecommerce.html
 */

/**
 * Mage_Devtool_Helper_Data
 *
 * @category  Mage
 * @package   Mage_Devtool
 * @author    Stephan Hoyer <stephan.hoyer@netresearch.de>
 * @copyright 2011 Netresearch GmbH & Co.KG <http://www.netresearch.de/>
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/leistungen/magento-ecommerce.html
 */
class Mage_Devtool_Helper_Data extends Mage_Core_Helper_Abstract
{
    const RECURSION_LABEL = 'R E C U R S I O N';
    const NO_CAPTION_LABEL = 'N O   C A P T I O N';
    
    /**
     * if developer toolbar should be visible
     *
     * @return boolean
     */
    public function isDevtoolVisible()
    {
        if (false == Mage::getSingleton('core/session')->getShowDevtool()) {
            return false;
        }
        return true;
    }
    
    /**
     * turn variable into printable array or html
     *
     * @param mixed   $variable       Variable to get data of
     * @param boolean $asHtml         If we want html output
     * @param array   $trackedObjects List of handled objects to avoid recursion
     *
     * @return array|string
     */
    public function printr($variable, $asHtml=false, $trackedObjects=array())
    {
        if (is_object($variable)) {
            if ($variable instanceof Varien_Object) {
                if (!in_array($variable, $trackedObjects)) {
                    $trackedObjects[] = $variable;
                    $return = array(
                        get_class($variable) => $this->printr(
                            $variable->getData(),
                            false,
                            $trackedObjects
                        )
                    );
                    return $asHtml ? $this->arrayToHtml($return) : $return;
                }
                return self::RECURSION_LABEL;
            } else {
                return "Object of class " . get_class($variable);
            }
        } elseif (is_array($variable)) {
            $return = array();
            foreach ($variable as $key => $value) {
                $return[$key] = $this->printr($value, false, $trackedObjects); 
            }
            return $asHtml ? $this->arrayToHtml($return) : $return;
        }
        return $variable;
    }
    
    /**
     * turn array into html
     *
     * @param array $array Array
     *
     * @return string
     */
    public function arrayToHtml(array $array)
    {
        $returnHtml = '';
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $returnHtml .= sprintf(
                    '<li id="%s"><a href="#">%s</a>%s</li>',
                    uniqid('devtool-'),
                    $key ? $key : self::NO_CAPTION_LABEL,
                    $this->arrayToHtml($value)
                );
            } else {
                $returnHtml .= sprintf(
                    '<li id="%s"><a href="#">%s%s</a></li>',
                    uniqid('devtool-'),
                    $key ? $key : self::NO_CAPTION_LABEL,
                    '&nbsp;&rarr;&nbsp;' . $value
                );
            }
        }
        return '<ul>' . $returnHtml . '</ul>';
    }
}
