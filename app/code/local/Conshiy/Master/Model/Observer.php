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
class Conshiy_Master_Model_Observer
{
	/**
	 * before consiy slave api user is changed prevent username changes
	 * @param unknown_type $observer
	 */
	public function preventUsernameChange($observer){
		//Mage::log('preventUsernameChange');
		$user = $observer->getEvent()->getDataObject();
		if( $user->getOrigData('username') == Mage::getConfig()->getNode('conshiy/master')->username && 
			$user->getOrigData('username') != $user->getData('username')	
			) {
			
			Mage::throwException(Mage::helper('adminhtml')->__('You can not change username for this API user. It must remain "'. Mage::getConfig()->getNode('conshiy/master')->username .'"'));
			return;
		} 
	}
	
	/**
	 * if password is changed notify network
	 * @param unknown_type $observer
	 */
	public function notifyNetwork($observer){
		//Mage::log('notifyNetwork');
		$request = Mage::app()->getFrontController()->getRequest();
		$user = $observer->getEvent()->getDataObject();
		if( $user->getOrigData('username') == Mage::getConfig()->getNode('conshiy/master')->username &&
				$user->getData('api_key') &&
				$user->getOrigData('api_key') != $user->getData('api_key')
		) {
			$new_api_password = $request->getPost('new_api_key');
			// Loop trough network and notify each of changed password
			return;
		}
	}

}
