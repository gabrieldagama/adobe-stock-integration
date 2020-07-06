<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\MediaGalleryUi\Model\SearchCriteria\CollectionProcessor\JoinProcessor;

use Magento\Framework\Api\SearchCriteria\CollectionProcessor\JoinProcessor\CustomJoinInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Data\Collection\AbstractDb;

/**
 * Custom join for entity type
 */
class ContentStatus implements CustomJoinInterface
{
    private const MEDIA_CONTENT_ASSET_TABLE_NAME = 'media_content_asset';

    /**
     * @var ResourceConnection
     */
    private $connection;

    /**
     * EntityType constructor.
     *
     * @param ResourceConnection $connection
     */
    public function __construct(ResourceConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @inheritDoc
     */
    public function apply(AbstractDb $collection): bool
    {
        return true;
    }
}
