<?php
/**
 * FAQ
 * 
 * @author Slava Yurthev
 */
namespace SY\FAQ\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;

class ParentCategory extends \Magento\Ui\Component\Listing\Columns\Column
{
	protected $_objectManager;
	protected $storeManager;
	public function __construct(
		ContextInterface $context,
		UiComponentFactory $uiComponentFactory,
		StoreManagerInterface $storeManager,
		\Magento\Framework\ObjectManagerInterface $objectmanager,
		array $components = [],
		array $data = []
	) {
		$this->_objectManager = $objectmanager;
		$this->storeManager = $storeManager;
		parent::__construct($context, $uiComponentFactory, $components, $data);
	}
	public function prepareDataSource(array $dataSource) {
		if(isset($dataSource['data']['items'])) {
			foreach($dataSource['data']['items'] as & $item) {
				if($item && isset($item['parent_id']) && $item['parent_id'] > 0) {
					$category = $this->_objectManager->get('SY\FAQ\Model\Category')->load($item['parent_id']);
					if($category->getId()){
						$title = $category->getTitle();
						$parentId = $category->getData('parent_id');
						if($parentId != false && $parentId > 0){
							do {
								$parent = $this->_objectManager->get('SY\FAQ\Model\Category')->load($parentId);
								if($parent->getTitle()){
									$title = $parent->getTitle().' - '.$title;
								}
								if($parent->getParentId() > 0){
									$parentId = $parent->getParentId();
								}
								else{
									$parentId = false;
								}
							} while ($parentId != false && $parentId > 0);
						}
						$item['parent_id'] = $title;
					}
					else{
						$item['parent_id'] = NULL;
					}
				}
				else{
					$item['parent_id'] = NULL;
				}
			}
		}
		return $dataSource;
	}
}