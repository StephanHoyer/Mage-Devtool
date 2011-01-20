<?php
class Mage_Devtool_Block_Registry extends Mage_Core_Block_Template
{
    public function getRegistry()
    {
        return Mage::getRegistry();
    }
}