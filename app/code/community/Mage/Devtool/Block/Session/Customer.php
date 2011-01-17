<?php
class Mage_Devtool_Block_Session_Customer extends Mage_Devtool_Block_Session_Abstract
{
    public function getSession()
    {
        return Mage::getSingleton('customer/session');
    }
}