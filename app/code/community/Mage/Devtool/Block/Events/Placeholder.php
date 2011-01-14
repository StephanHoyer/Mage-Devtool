<?php
class Mage_Devtool_Block_Events_Placeholder extends Mage_Core_Block_Abstract
{
    const EVENTS_HTML_PLACEHOLDER = '{{EVENTS_HTML}}';
    
    protected function _toHtml()
    {
        parent::_toHtml();
        return self::EVENTS_HTML_PLACEHOLDER;
    }
}