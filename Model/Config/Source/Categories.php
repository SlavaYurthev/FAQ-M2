<?php
/**
 * FAQ
 * 
 * @author Slava Yurthev
 */
namespace SY\FAQ\Model\Config\Source;

class Categories implements \Magento\Framework\Option\ArrayInterface {
	protected $_objectManager;
	public function __construct(
			\Magento\Framework\ObjectManagerInterface $objectManager
		){
		$this->_objectManager = $objectManager;
	}
	public function toOptionArray() {
		$array = [
			['value' => '0', 'label' => __('None')]
		];
		$collection = $this->_objectManager->get('\SY\FAQ\Model\Category')->getCollection();
		if($collection->count()>0){
			foreach ($collection as $category) {
				$title = $category->getTitle();
				$parentId = $category->getData('parent_id');
				if($parentId != false && $parentId > 0){
					do {
						$parent = $this->_objectManager->get('\SY\FAQ\Model\Category')->load($parentId);
						if($parent->getTitle()){
							$title = $parent->getTitle().' - '.$title;
						}
						if($parent->getParentId() > 0){
							$parentId = $parent->getParentId();
						}
						else{
							$parentId = false;
						}
					} while ($parentId != false);
				}
				$item = [
					'value' => $category->getId(),
					'label' => $title
				];
				$array[] = $item;
			}
		}
		return $array;
	}
}