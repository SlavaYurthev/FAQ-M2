<?php
/**
 * FAQ
 * 
 * @author Slava Yurthev
 */
namespace SY\FAQ\Controller\Adminhtml\Groups;

use \Magento\Backend\App\Action;
use \Magento\Backend\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;

class Index extends Action {
	protected $_resultPageFactory;
	protected $_resultPage;
	public function __construct(Context $context, PageFactory $resultPageFactory){
		parent::__construct($context);
		$this->_resultPageFactory = $resultPageFactory;
	}
	public function execute(){
		$this->_setPageData();
		return $this->getResultPage();
	}
	protected function _isAllowed(){
		return $this->_authorization->isAllowed('SY_FAQ::groups');
	}
	public function getResultPage(){
		if (is_null($this->_resultPage)){
			$this->_resultPage = $this->_resultPageFactory->create();
		}
		return $this->_resultPage;
	}
	protected function _setPageData(){
		$resultPage = $this->getResultPage();
		$resultPage->setActiveMenu('SY_FAQ::groups');
		$resultPage->getConfig()->getTitle()->prepend((__('Groups')));
		$resultPage->addBreadcrumb(__('FAQ'), __('FAQ'));
		return $this;
	}
}