<?php
class Mage_Devtool_Block_Events extends Mage_Core_Block_Template
{
    /**
     * Returns array of all fired events
     * 
     * @return ArrayObject
     */
    public function getEvents()
    {
        return Mage::getSingleton('devtool/event_collection');
    }
}