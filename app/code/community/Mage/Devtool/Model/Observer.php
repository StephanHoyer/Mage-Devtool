<?php

class Mage_Devtool_Model_Observer
{
    const PARAM_NAME_SHOW_DEVTOOL = 'show-devtool';
    const PARAM_NAME_HIDE_DEVTOOL = 'hide-devtool';
    
    public function attachToAllEvents($observer)
    {
        if (false == Mage::helper('devtool')->isDevtoolVisible()) {
            return;
        }
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
        if (false == Mage::helper('devtool')->isDevtoolVisible()) {
            return;
        }
        $event = Mage::getModel('devtool/event')->init($observer);
        Mage::getSingleton('devtool/event_collection')->add($event);
    }
    
    public function attachEventHtml($observer)
    {
        if (false == Mage::helper('devtool')->isDevtoolVisible()) {
            return;
        }
        $response = Mage::app()->getResponse();
        $events = Mage::app()->getLayout()->createBlock(
            'Mage_Devtool_Block_Events',
            'events',
            array('template' => 'devtool/events.phtml')
        )->toHtml();
        $response->setBody(str_replace(
            Mage_Devtool_Block_Events_Placeholder::EVENTS_HTML_PLACEHOLDER,
            $events,
            $response->getBody()
        ));
    }
    
    /**
     * Checks for devtool related get-parameteters 
     **/
    public function checkParams($observer)
    {
        $params = $observer
            ->getControllerAction()
            ->getRequest()
            ->getParams();
        if(array_key_exists(self::PARAM_NAME_SHOW_DEVTOOL, $params)) {
            Mage::getSingleton('core/session')->setShowDevtool(true);
        }
        if(array_key_exists(self::PARAM_NAME_HIDE_DEVTOOL, $params)) {
            Mage::getSingleton('core/session')->setShowDevtool(false);
        }
    }
}