<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\MediaGalleryUi\Model\SearchCriteria\CollectionProcessor\FilterProcessor;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor\FilterProcessor\CustomFilterInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\DB\Select;

class ContentStatus implements CustomFilterInterface
{
    private const TABLE_ALIAS = 'main_table';
    private const TABLE_CONTENT_ASSET = 'media_content_asset';

    /**
     * @var ResourceConnection
     */
    private $connection;

    /**
     * @param ResourceConnection $resource
     */
    public function __construct(ResourceConnection $resource)
    {
        $this->connection = $resource;
    }

    /**
     * @inheritDoc
     */
    public function apply(Filter $filter, AbstractDb $collection): bool
    {
        $value = $filter->getValue();
        $test = $this->getEnabledIds($value);
//        $collection->addFieldToFilter('cpei.value', $value);

        return true;
    }

    /**
     * Return select asset ids by keyword
     *
     * @param string $value
     * @return Select
     */
    private function getEnabledIds(string $value): Select
    {
        return $this->connection->getConnection()->select()->from(
            ['mca' => $this->connection->getTableName(self::TABLE_CONTENT_ASSET)],
            ['asset_id']
        )->where(
            'entity_type = ?',
            'catalog_product'
        )->joinInner(
            ['cpei' => $this->connection->getTableName('catalog_product_entity_int')],
            'mca.entity_id = cpei.entity_id AND cpei.attribute_id = 97',
            []
        )->where(
            'cpei.value = ?',
            $value
        );
    }
}
