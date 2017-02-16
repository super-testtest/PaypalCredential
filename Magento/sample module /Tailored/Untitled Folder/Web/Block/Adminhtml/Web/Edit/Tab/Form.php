<?php

class Company_Web_Block_Adminhtml_Web_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('web_form', array('legend'=>Mage::helper('web')->__('Item information')));

      $fieldset->addField('ipaddress', 'text', array(
          'label'     => Mage::helper('web')->__('IPADDRESS'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'ipaddress',
      ));



      if ( Mage::getSingleton('adminhtml/session')->getWebData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getWebData());
          Mage::getSingleton('adminhtml/session')->setWebData(null);
      } elseif ( Mage::registry('web_data') ) {
          $form->setValues(Mage::registry('web_data')->getData());
      }
      return parent::_prepareForm();
  }
}