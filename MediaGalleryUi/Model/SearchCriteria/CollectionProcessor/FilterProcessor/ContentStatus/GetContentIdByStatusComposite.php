<?php

namespace Magento\MediaGalleryUi\Model\SearchCriteria\CollectionProcessor\FilterProcessor\ContentStatus;

/**
 * Class GetContentIdByStatusComposite
 * @package Magento\MediaGalleryUi\Model\SearchCriteria\CollectionProcessor\FilterProcessor\ContentStatus
 */
class GetContentIdByStatusComposite implements GetContentIdByStatus
{
    /**
     * @var GetContentIdByStatus[]
     */
    private $getContentIdByStatusArray;

    /**
     * GetIdByStatusComposite constructor.
     * @param GetContentIdByStatus[] $getContentIdByStatusArray
     */
    public function __construct($getContentIdByStatusArray = [])
    {
        $this->getContentIdByStatusArray = $getContentIdByStatusArray;
    }

    /**
     * @param string $value
     * @return array
     */
    public function execute(string $value): array
    {
        $ids = [];
        foreach ($this->getContentIdByStatusArray as $getContentIdByStatus) {
            $ids = array_merge($ids, $getContentIdByStatus->execute($value));
        }
        return $ids;
    }
}
