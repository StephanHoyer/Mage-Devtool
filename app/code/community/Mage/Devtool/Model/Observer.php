<?php

class Mage_Devtool_Model_Observer
{
    public function attachToAllEvents()
    {
        foreach (Mage::getConfig()->getNode('frontend')->events->children() as $event) {
                $event->observers->devtool->type = 'singelton';
                $event->observers->devtool->class = 'devtool/observer';
                $event->observers->devtool->method = 'logEvent';
        }
    }

    public function logEvent($event)
    {
        Mage::log(print_r($event,true));
         exit;
    }
    
}