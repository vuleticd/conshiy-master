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
class Conshiy_Master_Model_Observer_Attribute extends Conshiy_Master_Model_Observer_Abstract
{
	public function queue($observer){
		
		$identifier = $observer->getEvent()->getAttribute()->getData('attribute_code');
		
		$network  = Mage::getModel('conshiymaster/network')->getCollection();		
		foreach ($network as $slave){
			
			$model_id = Mage::getModel('conshiymaster/queue')->getUniqueQueue('catalog_entity_attribute', 
						$identifier,
						$slave->getId()
					);
			
			if (!$model_id) {
				$model  = Mage::getModel('conshiymaster/queue');
				$model->setSlaveId($slave->getId());
				$model->setUpdatedAt(now());
				$model->setResourceModel('catalog_entity_attribute');
				$model->setResourceIdentifier($identifier);
			} else {
				$model  = Mage::getModel('conshiymaster/queue')->load($model_id);
				$model->setUpdatedAt(now());
			}		
			
			$model->save();
		}
	}
}