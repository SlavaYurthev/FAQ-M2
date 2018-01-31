<?php
/**
 * FAQ
 * 
 * @author Slava Yurthev
 */
namespace SY\FAQ\Block;

class Category extends \Magento\Framework\View\Element\Template {
	protected $_registry;
	protected $_objectManager;
	protected $_groups;
	public $_template = 'SY_FAQ::category.phtml';
	public function __construct(
			\Magento\Framework\View\Element\Template\Context $context,
			\Magento\Framework\ObjectManagerInterface $objectManager,
			\Magento\Framework\Registry $registry
		){
		$this->_registry = $registry;
		$this->_objectManager = $objectManager;
		parent::__construct($context);
	}
	public function getGroups(){
		if(!$this->_groups){
			if($this->getData('category_id')){
				$categoryId = $this->getData('category_id');
			}
			else{
				$categoryId = $this->_objectManager->get('\SY\FAQ\Helper\Data')->getDefaultCategory(
					$this->_storeManager->getStore()->getId()
				);
				if($this->getCategory()){
					$categoryId = $this->getCategory()->getId();
				}
			}
			$collection = $this->_objectManager->create('\SY\FAQ\Model\Group')->getCollection();
			$collection->addFieldToFilter('active', true);
			$collection->addFieldToFilter('category_id', $categoryId);
			$collection->setOrder('sort', 'asc');
			$this->_groups = $collection;
		}
		return $this->_groups;
	}
	public function getCategory(){
		return $this->_category = $this->_registry->registry('category');
	}
	protected function _prepareLayout(){
		// Only if registry defined
		if($this->getCategory()){
			$this->pageConfig->getTitle()->set(__('FAQ'));
			$this->getLayout()->getBlock('breadcrumbs')->addCrumb(
					'home',
					[
						'title' => __('Home'),
						'label' => __('Home'),
						'link' => $this->getUrl('')
					]
				);
			$parents = [];
			$this->getLayout()->getBlock('breadcrumbs')->addCrumb(
				'faq_category',
				[
					'title' => __('FAQ'),
					'label' => __('FAQ'),
					'link' => $this->getUrl('faq')
				]
			);
			$category = $this->getCategory();
			$parentId = $category->getData('parent_id');
			if($parentId != false && $parentId > 0){
				do {
					$parent = $this->_objectManager->create('\SY\FAQ\Model\Category')->load($parentId);
					$parents['faq_category_'.$parent->getId()] = [
						'title' => $parent->getTitle(),
						'label' => $parent->getTitle(),
						'link' => $parent->getUrl()
					];
					if($parent->getData('title')){
						$this->pageConfig->getTitle()->prepend($parent->getData('title'));
					}
					if($parent->getData('parent_id') > 0){
						$parentId = $parent->getData('parent_id');
					}
					else{
						$parentId = false;
					}
				} while ($parentId != false);
			}
			$this->pageConfig->getTitle()->prepend($category->getData('title'));
			if(count($parents)>0){
				$parents = array_reverse($parents);
				foreach ($parents as $key => $parent) {
					$this->getLayout()->getBlock('breadcrumbs')->addCrumb(
						$key,
						$parent
					);
				}
			}
		}
		parent::_prepareLayout();
	}
}