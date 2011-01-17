<?php
class Mage_Devtool_Block_Layout extends Mage_Core_Block_Template
{
    protected function getBlockDataHtml()
    {
        $output = "";
        $block = new Mage_Devtool_Block_Layout_Block();
        return $block->init($this->getLayout(), 'root')->toHtml();
    }
}