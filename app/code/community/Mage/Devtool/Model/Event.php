<?php 
class Mage_Devtool_Model_Event extends Mage_Core_Model_Abstract
{
    public function init(Varien_Event_Observer $observer)
    {
        $this->_event = $observer->getEvent();
        $this->_observer = $observer;
        return $this;
    }
    
    public function getName()
    {
        return $this->_event->getName();
    }
}
