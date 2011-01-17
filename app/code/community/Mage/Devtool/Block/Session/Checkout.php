<?php
class Mage_Devtool_Block_Session_Checkout extends Mage_Devtool_Block_Session_Abstract
{
    public function getSession()
    {
        return Mage::getSingleton('checkout/session');
    }
}