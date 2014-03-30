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

$installer = $this;
$installer->startSetup();

try {
	// create role
	$role = Mage::getModel('api/roles');
	$role->setName(Mage::getConfig()->getNode('conshiy/master')->role_name)
	     ->setParentId(0)
	     ->setRoleType(Mage_Api_Model_Acl::ROLE_TYPE_GROUP)
	     ->save();
	
	Mage::getModel("api/rules")
		->setRoleId($role->getId())
		->setResources(array("all"))
		->saveRel();
		
	// create usser	
	$user = Mage::getModel('api/user')
				->setData(array(
				'username' => Mage::getConfig()->getNode('conshiy/master')->username,
				'firstname' => 'Conshiy',
				'lastname' => 'Slave',
				'email' => 'slave@server.com',
				'api_key' => 'conshypassword',
				'api_key_confirmation' => 'conshypassword',
				'is_active' => 1,
				'user_roles' => '',
				'assigned_user_role' => '',
				'role_name' => '',
				'roles' => array($role->getId())
		));
	$user->save();
	// assign user to role
	$user->setRoleIds(array($role->getId()))
		->setRoleUserId($user->getUserId())
		->saveRelations();
		
} catch (Exception $e) {
	die($e->getMessage());
}

/**
 * Create table 'custom_shipping_options'
 */

$table = $installer->getConnection()
	->newTable($installer->getTable('conshiymaster/network'))
	->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'identity'  => true,
		'unsigned'  => true,
		'nullable'  => false,
		'primary'   => true,
	), 'Slave Id')
	->addColumn('url', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'Slave Base URL')
	->addColumn('username',  Varien_Db_Ddl_Table::TYPE_TEXT, 40, array(
		), 'Slave API username')
	->addColumn('password', Varien_Db_Ddl_Table::TYPE_TEXT, 100, array(
		), 'Slave API password');

$installer->getConnection()->createTable($table);

$installer->endSetup();
