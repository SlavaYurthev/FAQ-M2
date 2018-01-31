<?php
/**
 * FAQ
 * 
 * @author Slava Yurthev
 */
namespace SY\FAQ\Model;

use Magento\Framework\Model\AbstractModel;

class Item extends AbstractModel {
	public function __construct(
		\Magento\Framework\Model\Context $context,
		\Magento\Framework\Registry $registry
		){
		parent::__construct($context, $registry);
	}
	protected function _construct() {
		$this->_init('SY\FAQ\Model\ResourceModel\Item');
	}
}