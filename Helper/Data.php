<?php
/**
 * FAQ
 * 
 * @author Slava Yurthev
 */
namespace SY\FAQ\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Store\Model\StoreManagerInterface;
use \Magento\Framework\ObjectManagerInterface;
use \Magento\Framework\App\Helper\Context;
use \Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper {
	public function getConfigValue($field, $storeId = null){
		return $this->scopeConfig->getValue('sy_faq/'.$field, ScopeInterface::SCOPE_STORE, $storeId);
	}
	public function getDefaultCategory($storeId = null){
		return $this->getConfigValue('general/default_category');
	}
}