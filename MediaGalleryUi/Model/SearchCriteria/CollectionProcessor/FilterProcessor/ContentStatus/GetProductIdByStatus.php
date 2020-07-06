<?php

namespace Magento\MediaGalleryUi\Model\SearchCriteria\CollectionProcessor\FilterProcessor\ContentStatus;

use Magento\Framework\App\ResourceConnection;

/**
 * Class GetProductIdByStatus
 * @todo move this class to MediaGalleryCatalogUi
 */
class GetProductIdByStatus implements GetContentIdByStatus
{
    private const TABLE_CONTENT_ASSET = 'media_content_asset';
    private const TABLE_PRODUCT_EAV_INT = 'catalog_product_entity_int';
    private const TABLE_EAV_ATTRIBUTE = 'eav_attribute';
    private const STATUS_EAV_ATTRIBUTE_CODE = 'status';
    private const ENTITY_TYPE_ID = 4;

    /**
     * @var ResourceConnection
     */
    private $connection;

    /**
     * ContentStatus constructor.
     * @param ResourceConnection $resource
     */
    public function __construct(
        ResourceConnection $resource
    ) {
        $this->connection = $resource;
    }

    /**
     * @param string $value
     * @return array
     */
    public function execute(string $value): array
    {
        $statusAttributeId = $this->getAttributeId();
        $sql = $this->connection->getConnection()->select()->from(
            ['mca' => $this->connection->getTableName(self::TABLE_CONTENT_ASSET)],
            ['asset_id']
        )->where(
            'entity_type = ?',
            'catalog_product'
        )->joinInner(
            ['cpei' => $this->connection->getTableName(self::TABLE_PRODUCT_EAV_INT)],
            'mca.entity_id = cpei.entity_id AND cpei.attribute_id = ' . $statusAttributeId,
            []
        )->where(
            'cpei.value = ?',
            $value
        );

        return $this->connection->getConnection()->fetchAll($sql);
    }

    /**
     * @return int
     */
    private function getAttributeId(): int
    {
        $sql = $this->connection->getConnection()->select()->from(
            ['eav' => $this->connection->getTableName(self::TABLE_EAV_ATTRIBUTE)],
            ['attribute_id']
        )->where(
            'entity_type_id = ?',
            self::ENTITY_TYPE_ID
        )->where(
            'attribute_code = ?',
            self::STATUS_EAV_ATTRIBUTE_CODE
        );

        return $this->connection->getConnection()->fetchOne($sql);
    }
}
