<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category    Conshiy
 * @package     Conshiy_Master
 * @copyright   Copyright (c) 2014 a356 Development (http://www.a356dev.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Conshiy_Master_Block_Adminhtml_Network_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('network_form', array('legend'=>Mage::helper('conshiymaster')->__('Connection to Slave Website API')));
		 
		$fieldset->addField('note', 'note', array(
				'text'     => $this->__('API user submitted here must have permissions to access Conshiy Jobs API resources on slave website!<br>Master website will not be able to send update notifications to slave if details provided below are not correct.'),
		));

		$fieldset->addField('url', 'text', array(
	  			'label'		=> Mage::helper('conshiymaster')->__('API SOAP V2 WSDL Url'),
				'name'		=> 'url',
				'required'	=> true,
			));

		$fieldset->addField('username', 'text', array(
				'label'		=> Mage::helper('conshiymaster')->__('API username'),
				'name'		=> 'username',
				'required'	=> false,
			));
		 
		$fieldset->addField('password', 'password', array(
				'label'     => Mage::helper('conshiymaster')->__('API Token'),
				'name'      => 'password',
		  		'required'  => true,
			));

		 
		if ( Mage::getSingleton('adminhtml/session')->getNetworkData() )
		{
			$form->setValues(Mage::getSingleton('adminhtml/session')->getNetworkData());
			Mage::getSingleton('adminhtml/session')->setNetworkData(null);
		} elseif ( Mage::registry('network_data') ) {
			$form->setValues(Mage::registry('network_data')->getData());
		}
		return parent::_prepareForm();
	}
}