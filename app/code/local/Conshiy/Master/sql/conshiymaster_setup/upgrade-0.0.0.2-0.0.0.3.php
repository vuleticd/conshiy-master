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
$installer  = $this;
$installer->startSetup();

$installer->getConnection()
	->addColumn($installer->getTable('conshiymaster/network'),
		'resources',
		array(
				'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
				'nullable' => false,
				'default' => '',
				'comment' => 'Enabled Resources'
		)
);
$installer->endSetup();