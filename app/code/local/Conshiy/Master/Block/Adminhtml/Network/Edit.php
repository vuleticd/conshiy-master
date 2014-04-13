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
class Conshiy_Master_Block_Adminhtml_Network_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
	{
		parent::__construct();
		 
		$this->_objectId = 'id';
		$this->_controller = 'adminhtml_network';
		$this->_blockGroup = 'conshiymaster';

		$this->_updateButton('save', 'label', Mage::helper('conshiymaster')->__('Save Changes'));
		$this->_updateButton('delete', 'label', Mage::helper('conshiymaster')->__('Delete Website'));

		$this->_addButton('saveandcontinue', array(
				'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
				'onclick'   => 'saveAndContinueEdit()',
				'class'     => 'save',
			), -100);

		$this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
				
			function toggleEntities(children, checked){
				var spl = children.split(',');
				for (var index = 0, len = spl.length; index < len; ++index) {
  					var item = spl[index];
  					$(item).checked = checked;
				}				
            }
        ";
	}

	public function getHeaderText()
	{
		if( Mage::registry('network_data') && Mage::registry('network_data')->getId() ) {
			return Mage::helper('conshiymaster')->__("Edit Website '%s'", $this->htmlEscape(Mage::registry('network_data')->getUrl()));
		} else {
			return Mage::helper('conshiymaster')->__('Add Website');
		}
	}

	protected function _prepareLayout() {
		parent::_prepareLayout();
		
	}
}