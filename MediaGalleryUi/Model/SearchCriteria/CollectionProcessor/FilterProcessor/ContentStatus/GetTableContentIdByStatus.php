<?php

namespace Magento\MediaGalleryUi\Model\SearchCriteria\CollectionProcessor\FilterProcessor\ContentStatus;

use Magento\Framework\App\ResourceConnection;

/**
 * Class GetTableContentIdByStatus
 */
class GetTableContentIdByStatus implements GetContentIdByStatus
{
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
     * GetTableContentIdByStatus constructor.
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
            ['mca' => $this->connection->getTableName(self::TABLE_CONTENT_ASSET)],
            ['asset_id']
        )->where(
            'entity_type = ?',
            $this->entityType
        )->joinInner(
            ['content_table' => $this->connection->getTableName($this->contentTable)],
            'asset_content_table.entity_id = content_table.' . $this->idColumn,
            []
        )->where(
            $this->statusColumn . ' = ?',
            $this->getValueFromMap($value)
        );

        return $this->connection->getConnection()->fetchAll($sql);
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
