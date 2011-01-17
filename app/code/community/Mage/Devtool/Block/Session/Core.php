<?php
class Mage_Devtool_Block_Session_Core extends Mage_Devtool_Block_Session_Abstract
{
    public function getSession()
    {
        return Mage::getSingleton('core/session');
    }
}