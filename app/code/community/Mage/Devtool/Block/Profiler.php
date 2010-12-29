<?php
class Mage_Devtool_Block_Profiler extends Mage_Core_Block_Template
{
    public function getTimers()
    {
        return Varien_Profiler::getTimers();
    }
}
