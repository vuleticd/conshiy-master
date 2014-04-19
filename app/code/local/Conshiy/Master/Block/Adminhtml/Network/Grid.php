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

class Conshiy_Master_Block_Adminhtml_Network_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('networkGrid');
		$this->setDefaultSort('id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
	}
	
	protected function _prepareCollection()
	{
		$collection = Mage::getModel('conshiymaster/network')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
	
		$this->addColumn('url', array(
				'header'    => Mage::helper('conshiymaster')->__('Url'),
				'align'     =>'left',
				'index'     => 'url',
		));
	
		$this->addColumn('username', array(
				'header'    => Mage::helper('conshiymaster')->__('API Username'),
				'align'     => 'left',
				'index'     => 'username',
		));
	
		return parent::_prepareColumns();
	}
	
	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('id');
		$this->getMassactionBlock()->setFormFieldName('network');
	
		$this->getMassactionBlock()->addItem('delete', array(
				'label'    => Mage::helper('conshiymaster')->__('Delete'),
				'url'      => $this->getUrl('*/*/massDelete'),
				'confirm'  => Mage::helper('conshiymaster')->__('Are you sure?')
		));
	
		$resources = array(
            ''	=> ''
        );
		foreach(Mage::getConfig()->getNode('conshiy/enities')->children() as $ch){
			if($ch->getName() != 'enabled' && $ch->getName() != 'label'){
				$result = $ch->xpath('.//label');
				foreach($result as $lab){
					$parent = $lab->xpath('..');
					if(( (string) $parent[0]->enabled )){
						$resources[$parent[0]->getName()] = (string) $parent[0]->label;
					}
				}
			}
		}

		$this->getMassactionBlock()->addItem('sync', array(
				'label'=> Mage::helper('conshiymaster')->__('Synchronize'),
				'url'  => $this->getUrl('*/*/massSync', array('_current'=>true)),
				'additional' => array(
						'visibility' => array(
								'name' => 'sync',
								'type' => 'select',
								'class' => 'required-entry',
								'label' => Mage::helper('conshiymaster')->__('Resource'),
								'values' => $resources
						)
				)
		));
		
		return $this;
	}
	
	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
}