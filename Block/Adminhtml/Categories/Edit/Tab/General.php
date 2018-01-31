<?php
/**
 * FAQ
 * 
 * @author Slava Yurthev
 */
namespace SY\FAQ\Block\Adminhtml\Categories\Edit\Tab;
 
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;
 
class General extends Generic implements TabInterface {
	protected $_wysiwygConfig;
	protected $_objectManager;
	public function __construct(
		Context $context,
		Registry $registry,
		FormFactory $formFactory,
		Config $wysiwygConfig,
		\Magento\Framework\ObjectManagerInterface $objectManager,
		array $data = []
	) {
		$this->_objectManager = $objectManager;
		$this->_wysiwygConfig = $wysiwygConfig;
		parent::__construct($context, $registry, $formFactory, $data);
	}
	protected function _prepareForm(){
		$model = $this->_coreRegistry->registry('category');
		$form = $this->_formFactory->create();
 
		$fieldset = $form->addFieldset(
			'base_fieldset',
			['legend' => __('General')]
		);
 
		if ($model->getId()) {
			$fieldset->addField(
				'id',
				'hidden',
				['name' => 'id']
			);
		}
		$fieldset->addField(
			'title',
			'text',
			[
				'name' => 'title',
				'label'	=> __('Title'),
				'required' => true
			]
		);
		$fieldset->addField(
			'description',
			'editor',
			[
				'name' => 'description',
				'label' => __('Description'),
				'required' => false,
				'style' => 'height: 15em; width: 100%;',
				'config' => $this->_wysiwygConfig->getConfig()
			]
		);
		$categoriesTree = [
			['value'=>"0",'label'=>__('None')]
		];
		$categories = $this->_objectManager->get('\SY\FAQ\Model\Category')->getCollection();
		$categories->addFieldToFilter('id', ['neq'=>$model->getData('id')]);
		if($categories->count()>0){
			foreach ($categories as $category) {
				$title = $category->getTitle();
				$parentId = $category->getParentId();
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
				$categoryItem = [
					'value' => $category->getId(),
					'label' => $title
				];
				$categoriesTree[] = $categoryItem;
			}
		}
		$fieldset->addField(
			'parent_id',
			'select',
			[
				'name' => 'parent_id',
				'label'	=> __('Parent'),
				'required' => true,
				'values' => $categoriesTree
			]
		);
		$fieldset->addField(
			'active',
			'select',
			[
				'name' => 'active',
				'label'	=> __('Active'),
				'required' => true,
				'values' => [
					['value'=>"1",'label'=>__('Yes')],
					['value'=>"0",'label'=>__('No')]
				]
			]
		);
		if(!$model->getData('sort')){
			$model->setData('sort', '0');
		}
		$fieldset->addField(
			'sort',
			'text',
			[
				'name' => 'sort',
				'label'	=> __('Sort'),
				'required' => true
			]
		);
		$data = $model->getData();
		$form->setValues($data);
		$this->setForm($form);
 
		return parent::_prepareForm();
	}
	public function getTabLabel(){
		return __('Review');
	}
	public function getTabTitle(){
		return __('Review');
	}
	public function canShowTab(){
		return true;
	}
	public function isHidden(){
		return false;
	}
}