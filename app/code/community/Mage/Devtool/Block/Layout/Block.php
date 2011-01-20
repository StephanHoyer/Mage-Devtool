<?php
class Mage_Devtool_Block_Layout_Block extends Mage_Core_Block_Template
{
    public function init(Mage_Core_Model_Layout $layout, $blockName)
    {
        $this->setLayout($layout);
        $this->_block = $layout->getBlock($blockName);
        return $this;
    }
    
    protected function _toHtml()
    {
        $output = '<a href="#">'.$this->_block->getNameInLayout().'</a><ul>';
        foreach ($this->_block->getSortedChildren() as $child) {
            $block = new Mage_Devtool_Block_Layout_Block();
            if($this->getLayout()) {
                $output .= '<li id="'.$child.'">'.$block->init($this->getLayout(), $child)->toHtml().'</li>';
            }
        }
        return $output.'</ul>';
    }
}