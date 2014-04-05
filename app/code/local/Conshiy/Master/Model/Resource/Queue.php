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
class Conshiy_Master_Model_Resource_Queue extends Mage_Core_Model_Resource_Db_Abstract
{
	/**
	 * Define main table
	 *
	 */
	protected function _construct()
	{
		$this->_init('conshiymaster/queue', 'id');
	}
	
	/**
	 * Get queue by resource_model, identifier and slave_id
	 *
	 * @param string $resourceModel
	 * @param string $resourceIdentifier
	 * @param int $slaveId
	 * @return int|false
	 */
	public function getUniqueQueue($resourceModel, $resourceIdentifier, $slaveId)
	{
		$adapter = $this->_getReadAdapter();
	
		$select = $adapter->select()
		->from($this->getMainTable(), 'id')
		->where('resource_model = :model AND resource_identifier = :identifier AND slave_id = :slave');
	
		$bind = array(
				':model' => (string)$resourceModel,
				':identifier' => (string)$resourceIdentifier,
				':slave' => (integer)$slaveId
				);
	
		return $adapter->fetchOne($select, $bind);
	}
}
