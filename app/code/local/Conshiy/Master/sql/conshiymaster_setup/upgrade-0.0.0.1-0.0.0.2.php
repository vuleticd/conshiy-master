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

/**
 * Create table 'conshiy_queue'
 */

$table = $installer->getConnection()
	->newTable($installer->getTable('conshiymaster/queue'))
	->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'identity'  => true,
		'unsigned'  => true,
		'nullable'  => false,
		'primary'   => true,
	), 'Slave Id')
	->addColumn('resource_model', Varien_Db_Ddl_Table::TYPE_TEXT, 100, array(
		), 'Magento resource model type')
	->addColumn('resource_identifier',  Varien_Db_Ddl_Table::TYPE_TEXT, 100, array(
		), 'Magento unique resource indentifier')
	->addColumn('slave_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false
        ), 'Network slave id')
	->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
		), 'Last Update Time')
	->addIndex($installer->getIdxName(array('conshiymaster/queue', 'queue'), array('slave_id')),
		array('slave_id'))
	->addIndex(
        $installer->getIdxName(
            'conshiymaster/queue',
            array('resource_model', 'resource_identifier', 'slave_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('resource_model', 'resource_identifier', 'slave_id'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
	->addForeignKey(
        $installer->getFkName(
            array('conshiymaster/queue', 'queue'),
            'slave_id',
            'conshiymaster/network',
            'id'
        ),
        'slave_id', $installer->getTable('conshiymaster/network'), 'id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);

$installer->getConnection()->createTable($table);

$installer->endSetup();
