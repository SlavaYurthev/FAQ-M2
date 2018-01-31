<?php
/**
 * FAQ
 * 
 * @author Slava Yurthev
 */
namespace SY\FAQ\Controller\Category;

use Magento\Framework\App\Action\Action;

class View extends Action {
	protected $_coreRegistry = null;
	protected $resultPageFactory;
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Magento\Framework\Registry $registry
	) {
		$this->resultPageFactory = $resultPageFactory;
		$this->_coreRegistry = $registry;
		parent::__construct($context);
	}
	public function execute() {
		$helper = $this->_objectManager->get('SY\FAQ\Helper\Data');
		$storeManager = $this->_objectManager->get('Magento\Store\Model\StoreManagerInterface');
		if($helper->getConfigValue('general/active', $storeManager->getStore()->getData('store_id')) == "1"){
			if($this->getRequest()->getParam('id')){
				$category = $this->_objectManager->get('SY\FAQ\Model\Category')->load(
						$this->getRequest()->getParam('id')
					);
				if($category->getId()){
					if($category->getActive()){
						$this->_coreRegistry->register('category', $category);
					}
					else{
						$this->_forward('index', 'noroute', 'cms');
					}
				}
			}
			return $this->resultFactory->create(
				\Magento\Framework\Controller\ResultFactory::TYPE_PAGE
			);
		}
		else{
			$this->_forward('index', 'noroute', 'cms');
		}
	}
}