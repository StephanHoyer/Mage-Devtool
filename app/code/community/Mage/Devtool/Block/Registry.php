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
 * Mage_Devtool_Block_Registry
 *
 * @category  Mage
 * @package   Mage_Devtool
 * @author    Stephan Hoyer <stephan.hoyer@netresearch.de>
 * @copyright 2011 Netresearch GmbH & Co.KG <http://www.netresearch.de/>
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/leistungen/magento-ecommerce.html
 */
class Mage_Devtool_Block_Registry extends Mage_Core_Block_Template
{
    /**
     * @var array
     */
    protected $registry;

    /**
     * @var array
     */
    protected $singletons = array();

    /**
     * @var array
     */
    protected $helpers = array();

    /**
     * @var array
     */
    protected $others = array();
    
    /**
     * check if getRegistry-function is available in class Mage
     *
     * @return bool
     */
    public function isRegistryEnabled()
    {
        return method_exists(new Mage, 'getRegistry');
    }
    
    /**
     * get registry
     *
     * @return array
     */
    public function getRegistry()
    {
        if ($this->isRegistryEnabled) {
            return Mage::getRegistry();
        }
        return array();
    }
    
    /**
     * get registry entries containing singletons
     *
     * @return array
     */
    public function getSingletons()
    {
        if (!count($this->singletons)) {
            $this->groupEntries();
        }
        return $this->singletons;
    }
    
    /**
     * get registry entries containing other data
     *
     * @return array
     */
    public function getOthers()
    {
        if (!count($this->others)) {
            $this->groupEntries();
        }
        return $this->others;
    }
    
    /**
     * get registry entries containing helpers
     *
     * @return array
     */
    public function getHelpers()
    {
        if (!count($this->helpers)) {
            $this->groupEntries();
        }
        return $this->helpers;
    }
    
    /**
     * group registry entries by type
     *
     * @return array
     */
    protected function groupEntries()
    {
        foreach ($this->getRegistry() as $key => $value) {
            if (strpos($key, 'singleton') == 1
                || strpos($key, 'resource_singleton')
            ) {
                $this->singletons[$key] = $value;
            } else if (strpos($key, 'helper') == 1) {
                $this->helpers[$key] = $value;
            } else {
                $this->others[$key] = $value;
            }  
        }
    }
}
