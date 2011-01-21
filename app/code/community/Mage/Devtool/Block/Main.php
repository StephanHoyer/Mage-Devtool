<?php
class Mage_Devtool_Block_Main extends Mage_Core_Block_Template
{
    public function isDevtoolVisible()
    {
        return Mage::helper('devtool')->isDevtoolVisible();
    }
}