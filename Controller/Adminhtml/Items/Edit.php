<?php
/**
 * FAQ
 * 
 * @author Slava Yurthev
 */
namespace SY\FAQ\Controller\Adminhtml\Items;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action{
	protected $_coreRegistry = null;
	protected $resultPageFactory;
	public function __construct(
		Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Magento\Framework\Registry $registry
	) {
		$this->resultPageFactory = $resultPageFactory;
		$this->_coreRegistry = $registry;
		parent::__construct($context);
	}
	protected function _isAllowed(){
		return $this->_authorization->isAllowed('SY_FAQ::items');
	}
	protected function _initAction(){
		$resultPage = $this->resultPageFactory->create();
		$resultPage->setActiveMenu('SY_FAQ::items')
			->addBreadcrumb(__('FAQ'), __('FAQ'))
			->addBreadcrumb(__('Items'), __('Items'))
			->addBreadcrumb(__('Edit'), __('Edit'));
		return $resultPage;
	}
	public function execute(){
		$id = $this->getRequest()->getParam('id');
		$model = $this->_objectManager->create('SY\FAQ\Model\Item');
		if ($id) {
			$model->load($id);
			if (!$model->getId()) {
				$resultRedirect = $this->resultRedirectFactory->create();
				return $resultRedirect->setPath('*/*/');
			}
		}
		$data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}
		$this->_coreRegistry->register('item', $model);
		$resultPage = $this->_initAction();
		$resultPage->getConfig()->getTitle()->prepend(__('FAQ'));
		$resultPage->getConfig()->getTitle()->prepend(__('Items'));
		$resultPage->getConfig()->getTitle()->prepend(__('Edit'));
		return $resultPage;
	}
}