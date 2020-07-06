<?php

namespace Magento\MediaGalleryUi\Model\SearchCriteria\CollectionProcessor\FilterProcessor\ContentStatus;

interface GetContentIdByStatus
{
    const TABLE_CONTENT_ASSET = 'media_content_asset';

    /**
     * @param string $value
     * @return array
     */
    public function execute(string $value): array;
}
