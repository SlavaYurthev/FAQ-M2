<?php
/**
 * FAQ
 * 
 * @author Slava Yurthev
 */
namespace SY\FAQ\Model;

use Magento\Framework\Model\AbstractModel;

class Group extends AbstractModel {
	protected $_objectManager;
	public function __construct(
		\Magento\Framework\Model\Context $context,
		\Magento\Framework\ObjectManagerInterface $objectManager,
		\Magento\Framework\Registry $registry
		){
		$this->_objectManager = $objectManager;
		parent::__construct($context, $registry);
	}
	protected function _construct() {
		$this->_init('SY\FAQ\Model\ResourceModel\Group');
	}
	public function getItems(){
		$collection = $this->_objectManager->create('\SY\FAQ\Model\Item')->getCollection();
		$collection->addFieldToFilter('active', true);
		$collection->addFieldToFilter('group_id', $this->getData('id'));
		$collection->setOrder('sort', 'asc');
		return $collection;
	}
}