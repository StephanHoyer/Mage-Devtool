<?php

class Mage_Devtool_Model_Observer
{
    public function attachToAllEvents()
    {
        $this->attachToEvents('global');
        $this->attachToEvents('frontend');
        $this->attachToEvents('adminhtml');
    }
    
    /**
     * Change config that logEvent method is called on every event 
     * of given areathat is dispached
     *
     * @var String $area can be one of global, frontend, adminhtml
     **/ 
    protected function attachToEvents($area)
    {
        foreach (Mage::getConfig()->getNode($area)->events->children() as $event) {
                $event->observers->devtool->type = 'singleton';
                $event->observers->devtool->class = 'devtool/observer';
                $event->observers->devtool->method = 'logEvent';
        }
    }

    public function logEvent(Varien_Event_Observer $observer)
    {
        $event = Mage::getModel('devtool/event')->init($observer);
        Mage::getSingleton('devtool/event_collection')->add($event);
    }
    
    public function attachEventHtml($observer)
    {
        $response = Mage::app()->getResponse();
        $events = Mage::app()->getLayout()->createBlock(
            'Mage_Devtool_Block_Events',
            'events',
            array('template' => 'devtool/events.phtml')
        )->toHtml();
        $response->setBody(str_replace('{{EVENTS_HTML}}',$events,$response->getBody()));
    }
}