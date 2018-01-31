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

class ItemGroup extends \Magento\Ui\Component\Listing\Columns\Column
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
				if($item && isset($item['group_id']) && $item['group_id'] > 0) {
					$group = $this->_objectManager->get('SY\FAQ\Model\Group')->load($item['group_id']);
					if($group->getId()){
						$title = $group->getData('title');
						$categoryId = $group->getData('category_id');
						if($categoryId != false && $categoryId > 0){
							do {
								$category = $this->_objectManager->get('SY\FAQ\Model\Category')->load($categoryId);
								if($category->getTitle()){
									$title = $category->getTitle().' - '.$title;
								}
								if($category->getParentId() > 0){
									$categoryId = $category->getParentId();
								}
								else{
									$categoryId = false;
								}
							} while ($categoryId != false);
						}
						$item['group_id'] = $title;
					}
					else{
						$item['group_id'] = NULL;
					}
				}
				else{
					$item['group_id'] = NULL;
				}
			}
		}
		return $dataSource;
	}
}