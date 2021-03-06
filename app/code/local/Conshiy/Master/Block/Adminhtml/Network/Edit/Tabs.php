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
class Conshiy_Master_Block_Adminhtml_Network_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

	public function __construct()
	{
		parent::__construct();
		$this->setId('network_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('conshiymaster')->__('Network Slave Website'));
	}

	protected function _beforeToHtml()
	{
		$this->addTab('form_section', array(
				'label'     => Mage::helper('conshiymaster')->__('API connection'),
				'title'     => Mage::helper('conshiymaster')->__('API connection'),
				'content'   => $this->getLayout()->createBlock('conshiymaster/adminhtml_network_edit_tab_form')->toHtml(),
		));
		
		$this->addTab('entities_section', array(
				'label'     => Mage::helper('conshiymaster')->__('Entities selection'),
				'title'     => Mage::helper('conshiymaster')->__('Entities selection'),
				'content'   => $this->getLayout()->createBlock('conshiymaster/adminhtml_network_edit_tab_entities')->toHtml(),
		));
		 
		return parent::_beforeToHtml();
	}
}