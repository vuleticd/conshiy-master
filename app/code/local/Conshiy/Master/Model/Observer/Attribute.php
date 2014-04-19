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
	
	public function getConshiyResourceCode(){
		return 'catalog_product_attribute';
	}
	
	public function getMageResourceCode(){
		return 'catalog_entity_attribute';
	}
	
	public function getIdentifier($observer){
		$identifier = $observer->getEvent()->getAttribute()->getData('attribute_code');
		return $identifier;
	}
	
	
}