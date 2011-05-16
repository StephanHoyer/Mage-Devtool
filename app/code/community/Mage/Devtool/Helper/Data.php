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
    const EMPTY_ARRAY_LABEL = 'E M P T Y   A R R A Y';
    
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
            } elseif($variable instanceof Varien_Data_Collection) {
                if($variable->count() <= 0) {
                    return self::EMPTY_ARRAY_LABEL;
                }
                $collection = clone $variable;
                return $asHtml ? $this->arrayToHtml($collection->toArray()) : $collection->toArray();
            } elseif($variable instanceof Mage_Core_Model_Message_Collection) {
                if($variable->count() <= 0) {
                    return $this->__("No Messages");
                }
                $messages = clone $variable;
                $return = array();
                $i = 0;
                foreach ($messages->getItems() as $message) {
                    $return[$this->__('Message %d',$i++)] = $message->toString();
                }
                return $asHtml ? $this->arrayToHtml($return) : $return;
            } else {
                return $this->__("Object of class %s", get_class($variable));
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
            $key = trim($key);
            if (is_array($value)) {
                $returnHtml .= sprintf(
                    '<li id="%s"><a href="#">%s</a>%s</li>',
                    uniqid('devtool-'),
                    $key ? htmlentities($key) : self::NO_CAPTION_LABEL,
                    $this->arrayToHtml($value)
                );
            } else {
                $value = trim($value);
                $returnHtml .= sprintf(
                    '<li id="%s" class="open">
                        <a href="#">%s</a>
                        <ul>
                            <li id="%s" class="jstree-type-text">
                                <a href="#">%s</a>
                            </li>
                        </ul>
                    </li>',
                    uniqid('devtool-'),
                    $key ? htmlentities($key) : self::NO_CAPTION_LABEL,
                    uniqid('devtool-'),
                    $value ? htmlentities($value) : self::NO_CAPTION_LABEL
                );
            }
        }
        return '<ul>' . $returnHtml . '</ul>';
    }
    
    public function log($value)
    {
        Mage::getSingleton('devtool/log_collection')->add(
            Mage::getModel('devtool/log')
                ->setStack(debug_backtrace())
                ->setValue($value)
        );
    }
}
