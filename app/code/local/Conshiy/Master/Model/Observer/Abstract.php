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
abstract class Conshiy_Master_Model_Observer_Abstract
{
	
	abstract protected function getConshiyResourceCode();
	
	abstract protected function getMageResourceCode();
	
	abstract protected function getIdentifier($observer);
	
	
	public function queue($observer){
		$network  = Mage::getModel('conshiymaster/network')->getCollection();
		$identifier = $this->getIdentifier($observer);
		foreach ($network as $slave){
			if( isset($slave['resources']) &&
					in_array($this->getConshiyResourceCode(), explode(',', $slave['resources']))){
						
				$model_id = Mage::getModel('conshiymaster/queue')->getUniqueQueue($this->getMageResourceCode(),
					$identifier,
					$slave->getId()
				);
				$model  = Mage::getModel('conshiymaster/queue');
				if (!$model_id) {
					$model->setSlaveId($slave->getId());
					$model->setUpdatedAt(now());
					$model->setResourceModel($this->getMageResourceCode());
					$model->setResourceIdentifier($identifier);
				} else {
					$model->load($model_id);
					$model->setUpdatedAt(now());
				}
			
				$model->save();
		
			}
		}
	}
}