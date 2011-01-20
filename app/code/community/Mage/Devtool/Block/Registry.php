<?php
class Mage_Devtool_Block_Registry extends Mage_Core_Block_Template
{
    protected $registry;
    protected $singletons = array();
    protected $helpers = array();
    protected $others = array();
    
    public function getRegistry()
    {
        if (method_exists(new Mage, 'getRegistry')) {
            return Mage::getRegistry();
        }
        return array(''=>'no getRegistry() method found in class Mage');
    }
    
    public function getSingletons()
    {
        if (!count($this->singletons)) {
            $this->sortEntrys();
        }
        return $this->singletons;
    }
    
    public function getOthers()
    {
        if (!count($this->others)) {
            $this->sortEntrys();
        }
        return $this->others;
    }
    
    public function getHelpers()
    {
        if (!count($this->helpers)) {
            $this->sortEntrys();
        }
        return $this->helpers;
    }
    
    protected function sortEntrys()
    {
        foreach ($this->getRegistry() as $key => $value) {
            if (strpos($key, 'singleton') == 1 || strpos($key, 'resource_singleton')) {
                $this->singletons[$key] = $value;
            } else if (strpos($key, 'helper') == 1) {
                $this->helpers[$key] = $value;
            } else {
                $this->others[$key] = $value;
            }  
        }
    }
}