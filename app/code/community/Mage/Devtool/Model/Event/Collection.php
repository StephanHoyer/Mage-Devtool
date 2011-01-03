<?php 
class Mage_Devtool_Model_Event_Collection extends ArrayObject
{
    public function add(Mage_Devtool_Model_Event $event)
    {
        Mage::log($event->getName());
        $this->append($event);
        Mage::log($this->count());
    }
}
