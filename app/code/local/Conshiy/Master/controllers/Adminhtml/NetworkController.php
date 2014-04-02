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
class Conshiy_Master_Adminhtml_NetworkController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('conshiy_menu/network_menu');
	
		return $this;
	}
	
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}
	
	public function editAction() {
	
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('conshiymaster/network')->load($id);
	
		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}
	
			Mage::register('network_data', $model);
	
			$this->loadLayout();
			$this->_setActiveMenu('conshiy_menu');
	
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
	
			$this->_addContent($this->getLayout()->createBlock('conshiymaster/adminhtml_network_edit'))
			->_addLeft($this->getLayout()->createBlock('conshiymaster/adminhtml_network_edit_tabs'));
	
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('conshiymaster')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
	
	public function newAction() {
		$this->_forward('edit');
	}
	
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			$model = Mage::getModel('conshiymaster/network');
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			// test if API connection can be established
			try{
				Mage::getModel('conshiymaster/api_client')->login(
					$model->getUrl(),
					$model->getUsername(),
					$model->getPassword()
				);
			} catch (SOAP_Fault $fault){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}
	
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('conshiymaster')->__('Website was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
	
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('conshiymaster')->__('Unable to save website data'));
		$this->_redirect('*/*/');
	}
	
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('conshiymaster/network');
					
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
	
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Website was successfully removed from network'));
				$this->_redirect('*/*/');
				return;
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		$this->_redirect('*/*/');
	}
	
	public function massDeleteAction() {
		$ids = $this->getRequest()->getParam('network');
		if(!is_array($ids)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
		} else {
			try {
				foreach ($ids as $id) {
					$model = Mage::getModel('conshiymaster/network')->load($id);
					$model->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(
				Mage::helper('adminhtml')->__(
				'Total of %d record(s) were successfully deleted', count($ids)
				)
				);
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}
		$this->_redirect('*/*/index');
	}
	
}