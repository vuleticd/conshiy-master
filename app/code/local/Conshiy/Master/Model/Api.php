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
class Conshiy_Master_Model_Api extends Mage_Api_Model_Resource_Abstract
{    
	
    public function create($slaveData)
    {
    	// Password should be sent encoded by franchisee website
    	try {
    		$slave = Mage::getModel('conshiymaster/network')
    			->setUrl($slaveData->url)
    			->setUsername($slaveData->username)
    			->setPassword($slaveData->password)
    			->save();
    	} catch (Mage_Core_Exception $e) {
    		$this->_fault('slave_not_registered', $e->getMessage());
    	} catch (Exception $e) {
    		$this->_fault('slave_not_registered', $e->getMessage());
    	}
    	
    	return $slave->getId();
    }
    
    public function update($slaveId, $password)
    {
    	$slave = Mage::getModel('conshiymaster/network')->load($slaveId);
    	
    	if (!$slave->getId()) {
    		$this->_fault('slave_not_found');
    	}
    	
    	try {
    		// Password should be sent encoded by franchisee website
    		$slave->setPassword($password)
    			->save();
    	} catch (Mage_Core_Exception $e) {
    		$this->_fault('slave_not_updated', $e->getMessage());
    	}
    	
    	return true;
    }
    
    public function delete($slaveId)
    {
    	$slave = Mage::getModel('conshiymaster/network')->load($slaveId);

        if (!$slave->getId()) {
            $this->_fault('slave_not_found');
        }

        try {
            $slave->delete();
        } catch (Mage_Core_Exception $e) {
            $this->_fault('slave_not_deleted', $e->getMessage());
        }

        return true;
    }
}
