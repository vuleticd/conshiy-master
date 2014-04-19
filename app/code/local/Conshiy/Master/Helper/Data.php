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
class Conshiy_Master_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getResourcesOptionArray(){
		$resources = array();
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
		
		return $resources;
	}
}