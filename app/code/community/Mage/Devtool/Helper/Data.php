<?php
class Mage_Devtool_Helper_Data extends Mage_Core_Helper_Abstract
{
    const RECURSION_LABEL = 'Recursion';
    
    public function showDevtool()
    {
        if(false == Mage::getSingleton('core/session')->getShowDevtool()) {
            return false;
        }
        return true;
    }
    
    public function printr($variable, $asHtml=false, $trackedObjects=array())
    {
        if (is_object($variable)) {
            if ($variable instanceof Varien_Object) {
                if (!in_array($variable, $trackedObjects)) {
                    $trackedObjects[] = $variable;
                    $return = array(get_class($variable) => $this->printr($variable->getData(), $asHtml, $trackedObjects));
                    return $asHtml ? $this->arrayToHtml($return) : $return;
                }
                return self::RECURSION_LABEL;
            } else {
                return "Object of class " . get_class($variable);
            }
        } elseif (is_array($variable)) {
            $return = array();
            foreach ($variable as $key => $value) {
                $return[$key] = $this->printr($value, false, $trackedObjects); 
            }
            return $asHtml ? $this->arrayToHtml($return) : $return;
        }
        return $asHtml ? $this->arrayToHtml($variable) : $variable;
    }
    
    public function arrayToHtml(array $array)
    {
        $returnHtml = '<ul>';
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $returnHtml .= '<li><span id="' . $key . '">' . $key . '</span>' . $this->arrayToHtml($value) . '</li>';
            } else {
                $returnHtml .= '<li><span id="' . $key . '">' . $key . '&nbsp;&rarr;&nbsp' . $value . '</span></li>';
            }
        }
        return $returnHtml . '</ul>';
    }
}
