<?php

namespace Magento\MediaGalleryUi\Model\SearchCriteria\CollectionProcessor\FilterProcessor\ContentStatus;

use Magento\Framework\App\ResourceConnection;

/**
 * Class GetAssetIdByContentStatus
 */
class GetAssetIdByContentStatus implements GetAssetIdByContentStatusInterface
{
    private const TABLE_CONTENT_ASSET = 'media_content_asset';

    /**
     * @var ResourceConnection
     */
    private $connection;

    /**
     * @var string
     */
    private $entityType;

    /**
     * @var string
     */
    private $contentTable;

    /**
     * @var string
     */
    private $statusColumn;

    /**
     * @var string
     */
    private $idColumn;

    /**
     * @var array
     */
    private $valueMap;

    /**
     * GetContentIdByStatus constructor.
     * @param ResourceConnection $resource
     * @param string $entityType
     * @param string $contentTable
     * @param string $idColumn
     * @param string $statusColumn
     * @param array $valueMap
     */
    public function __construct(
        ResourceConnection $resource,
        string $entityType,
        string $contentTable,
        string $idColumn,
        string $statusColumn,
        array $valueMap = []
    ) {
        $this->connection = $resource;
        $this->entityType = $entityType;
        $this->contentTable = $contentTable;
        $this->idColumn = $idColumn;
        $this->statusColumn = $statusColumn;
        $this->valueMap = $valueMap;
    }

    /**
     * @param string $value
     * @return array
     */
    public function execute(string $value): array
    {
        $sql = $this->connection->getConnection()->select()->from(
            ['asset_content_table' => $this->connection->getTableName(self::TABLE_CONTENT_ASSET)],
            ['asset_id']
        )->where(
            'entity_type = ?',
            $this->entityType
        )->joinInner(
            ['content_table' => $this->connection->getTableName($this->contentTable)],
            'asset_content_table.entity_id = content_table.' . $this->idColumn,
            []
        )->where(
            'content_table.' . $this->statusColumn . ' = ?',
            $this->getValueFromMap($value)
        );

        $result = $this->connection->getConnection()->fetchAll($sql);

        return array_map(function ($item) {
            return $item['asset_id'];
        }, $result);
    }

    /**
     * @param string $value
     * @return string
     */
    private function getValueFromMap(string $value): string
    {
        if (count($this->valueMap) > 0 && array_key_exists($value, $this->valueMap)) {
            return $this->valueMap[$value];
        }
        return $value;
    }
}
