<?php
/**
 * FAQ
 * 
 * @author Slava Yurthev
 */
namespace SY\FAQ\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Category extends AbstractDb {
	protected function _construct() {
		$this->_init('sy_faq_category', 'id');
	}
}