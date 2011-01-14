<?php 
class Mage_Devtool_Model_Event_Collection extends ArrayObject
{
    public function add(Mage_Devtool_Model_Event $event)
    {
        $this->offsetSet($event->getName(), $event);
    }
}
