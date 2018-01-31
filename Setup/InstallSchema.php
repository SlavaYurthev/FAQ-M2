<?php
/**
 * FAQ
 * 
 * @author Slava Yurthev
 */
namespace SY\FAQ\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface {
	public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) {
		$setup->startSetup();

		$tableCategory = $setup->getConnection()->newTable($setup->getTable('sy_faq_category'))
			->addColumn(
				'id',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				null,
				[
					'identity' => true, 
					'unsigned' => true, 
					'nullable' => false, 
					'primary' => true
				],
				'Id'
			)->addColumn(
				'parent_id',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				255,
				[
					'nullable' => false,
					'default' => '0'
				],
				'Parent Id'
			)->addColumn(
				'title',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				255,
				[
					'nullable' => true
				],
				'Title'
			)->addColumn(
				'description',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				null,
				[
					'nullable' => true
				],
				'Description'
			)->addColumn(
				'active',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				1,
				[
					'nullable' => false,
					'default' => '1'
				],
				'Active'
			)->addColumn(
				'sort',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				1,
				[
					'nullable' => false,
					'default' => '0'
				],
				'Sort'
			)->setComment(
				'FAQ Group Table'
			);
		$setup->getConnection()->createTable($tableCategory);

		$tableGroup = $setup->getConnection()->newTable($setup->getTable('sy_faq_group'))
			->addColumn(
				'id',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				null,
				[
					'identity' => true, 
					'unsigned' => true, 
					'nullable' => false, 
					'primary' => true
				],
				'Id'
			)->addColumn(
				'category_id',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				255,
				[
					'nullable' => false,
					'default' => '0'
				],
				'Category Id'
			)->addColumn(
				'title',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				255,
				[
					'nullable' => true
				],
				'Title'
			)->addColumn(
				'active',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				1,
				[
					'nullable' => false,
					'default' => '1'
				],
				'Active'
			)->addColumn(
				'sort',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				1,
				[
					'nullable' => false,
					'default' => '0'
				],
				'Sort'
			)->setComment(
				'FAQ Group Table'
			);
		$setup->getConnection()->createTable($tableGroup);

		$tableItem = $setup->getConnection()->newTable($setup->getTable('sy_faq_item'))
			->addColumn(
				'id',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				null,
				[
					'identity' => true, 
					'unsigned' => true, 
					'nullable' => false, 
					'primary' => true
				],
				'Id'
			)->addColumn(
				'group_id',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				255,
				[
					'nullable' => false,
					'default' => '0'
				],
				'Group Id'
			)->addColumn(
				'title',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				255,
				[
					'nullable' => true
				],
				'Title'
			)->addColumn(
				'question',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				null,
				[
					'nullable' => true
				],
				'Question'
			)->addColumn(
				'answer',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				null,
				[
					'nullable' => true
				],
				'Answer'
			)->addColumn(
				'active',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				1,
				[
					'nullable' => false,
					'default' => '1'
				],
				'Active'
			)->addColumn(
				'sort',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				1,
				[
					'nullable' => false,
					'default' => '0'
				],
				'Sort'
			)->setComment(
				'FAQ Item Table'
			);
		$setup->getConnection()->createTable($tableItem);

		$setup->endSetup();
	}
}