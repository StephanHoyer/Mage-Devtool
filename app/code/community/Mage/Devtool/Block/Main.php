<?php
class Mage_Devtool_Block_Main extends Mage_Core_Block_Template
{
    public function showDevtool()
    {
        return Mage::helper('devtool')->showDevtool();
    }
}