<?php
class Tailored_Goshippo_Model_Adminhtml_Observer{
    public function addOrderCustomBlock(Varien_Event_Observer $observer){
        $block = $observer->getBlock();
        if(($block->getNameInLayout() == 'order_info') && ($child = $block->getChild('goshippo.order.info.customblock'))){
            $transport = $observer->getTransport();
            if($transport){
                $html = $transport->getHtml();
                $html .= $child->toHtml();
                $transport->setHtml($html);
            }
        }

    }
}