<?php
/**
 * FAQ
 * 
 * @author Slava Yurthev
 */
namespace SY\FAQ\Block\Category;

class Sidebar extends \Magento\Framework\View\Element\Template {
	protected $_registry;
	protected $_objectManager;
	public function __construct(
			\Magento\Framework\View\Element\Template\Context $context,
			\Magento\Framework\ObjectManagerInterface $objectManager,
			\Magento\Framework\Registry $registry
		){
		$this->_registry = $registry;
		$this->_objectManager = $objectManager;
		parent::__construct($context);
	}
	public function getCategory(){
		return $this->_registry->registry('category');
	}
	public function getItems(){
		$catId = $this->_objectManager->get('\SY\FAQ\Helper\Data')->getDefaultCategory(
				$this->_storeManager->getStore()->getId()
			);
		if($this->getCategory()){
			$catId = $this->getCategory()->getId();
		}
		$collection = $this->_objectManager->get('\SY\FAQ\Model\Category')->getCollection();
		$collection->addFieldToFilter('active', true);
		$collection->addFieldToFilter('parent_id', $catId);
		$collection->setOrder('sort', 'asc');
		return $collection;
	}
}