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
class Conshiy_Master_Block_Adminhtml_Network_Edit_Tab_Entities extends Mage_Adminhtml_Block_Widget_Form
{
    
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('entities_form', array('legend'=>Mage::helper('conshiymaster')->__('Select Entities to Sync')));

		
		$fieldset->addField('note', 'note', array(
				'text'     => $this->__('These entities will be monitored for changes on Master and notifications will be sent to this Slave.'),
		));
		
		if ( Mage::getSingleton('adminhtml/session')->getNetworkData() )
		{
			$data = Mage::getSingleton('adminhtml/session')->getNetworkData();
			Mage::getSingleton('adminhtml/session')->setNetworkData(null);
		} elseif ( Mage::registry('network_data') ) {
			$data = Mage::registry('network_data')->getData();
		}
		
		$this->walkEntities(Mage::getConfig()->getNode('conshiy/enities')->children(), $fieldset, $data);
		
		return parent::_prepareForm();
	}
	
	
	public function walkEntities($entities, $fieldset, $data = array(), $level = 0)
	{
		foreach ( $entities as $k=>$e){
			$selected = false;
			if($e->getName() != 'enabled' && $e->getName() != 'label'){
				
				if( isset($data['resources']) && in_array($e->getName(), explode(',', $data['resources']))){
					$selected = true;
				}
				
				$this->renderField($e, $fieldset, $level, $selected);
				
			}
			
			if($e->count() > 2) {
				$level++;
				$this->walkEntities($e->children(), $fieldset, $data, $level );
			}

		}
		
	}
	
	public function renderField($entity, $fieldset, $level, $selected)
	{
		// present only globaly allowed resources
		if(!((string) $entity->enabled)) return;
		
		$depends = '';
		if($this->depending($entity)){
			$depends = implode(",",$this->depending($entity));
		}
		
		$pad = $level * 20;
		$fieldset->addField($entity->getName(), 'checkbox', array(
					'label'     => $entity->label,
					'name'      => "entities[".$entity->getName()."]",
					'checked' => ( $selected ? true : false ),
					'onclick' => "",
					'onchange' => ($depends ? "toggleEntities('" . $depends . "', this.checked)" : ""),
					'value'  => 1,
					'disabled' => false,
					'style'   => "margin-left:".$pad."px",
					'after_element_html' => '<small></small>'
			));
	}
	
	public function depending($entity)
	{
		$return = array();
		
		$result = $entity->xpath('.//label');
		$plain = array_shift($result);
		
		foreach($result as $lab){
			$parent = $lab->xpath('..');
			$return[] = $parent[0]->getName();
		}
		 
		return $return;
			
	}
	
}