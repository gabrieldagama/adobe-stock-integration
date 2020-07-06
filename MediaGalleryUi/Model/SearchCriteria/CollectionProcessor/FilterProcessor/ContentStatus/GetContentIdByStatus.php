<?php

namespace Magento\MediaGalleryUi\Model\SearchCriteria\CollectionProcessor\FilterProcessor\ContentStatus;

interface GetContentIdByStatus
{
    /**
     * @param string $value
     * @return array
     */
    public function execute(string $value): array;
}
