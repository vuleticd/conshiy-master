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
class Conshiy_Master_Block_Adminhtml_Network_Edit_Tab_Entities extends Mage_Adminhtml_Block_Template
{
	public function __construct()
    {
        parent::__construct();
        $this->setTemplate('conshiy/entities/tree.phtml');
    }
    
    public function getEntitiesCollection()
    {
    	$c = Mage::getConfig()->getNode('conshiy/enities');
    	$collection = array(
    			'catalog_product',
    				'catalog_category',
    				'catalog_product_attribute_set',
    					'catalog_product_attribute'
    			);
    	
    	return $c;
    }
}