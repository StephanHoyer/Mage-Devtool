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
 * Mage_Devtool_Block_Session_Core
 *
 * @category  Mage
 * @package   Mage_Devtool
 * @author    Stephan Hoyer <stephan.hoyer@netresearch.de>
 * @copyright 2011 Netresearch GmbH & Co.KG <http://www.netresearch.de/>
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/leistungen/magento-ecommerce.html
 */
class Mage_Devtool_Block_Session_Core extends Mage_Devtool_Block_Session_Abstract
{
    /**
     * get session singleton
     *
     * @return Mage_Core_Model_Session
     */
    public function getSession()
    {
        return Mage::getSingleton('core/session');
    }
}
