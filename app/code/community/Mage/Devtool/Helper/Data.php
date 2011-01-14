<?php
class Mage_Devtool_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function showDevtool()
    {
        if(false == Mage::getSingleton('core/session')->getShowDevtool()) {
            return false;
        }
        return true;
    }
}
