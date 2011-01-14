<?php 
class Mage_Devtool_Model_Event extends Mage_Core_Model_Abstract
{
    /**
     * @var Varien_Event_Observer 
     */
    protected $_observer;
    
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
    
    public function getParams()
    {
        $params = array();
        foreach ($this->_observer->getData() as $name => $param) {
            if ($name !== "event") {
                $params[$name] = $param;
            }
        }
        return $params;
    }
}
