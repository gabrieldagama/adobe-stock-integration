<?php

namespace Magento\MediaGalleryUi\Model\SearchCriteria\CollectionProcessor\FilterProcessor\ContentStatus;

/**
 * Class GetAssetIdByContentStatusComposite
 */
class GetAssetIdByContentStatusComposite implements GetAssetIdByContentStatusInterface
{
    /**
     * @var GetAssetIdByContentStatus[]
     */
    private $getAssetIdByContentStatusArray;

    /**
     * GetAssetIdByContentStatusComposite constructor.
     * @param array $getAssetIdByContentStatusArray
     */
    public function __construct($getAssetIdByContentStatusArray = [])
    {
        $this->getAssetIdByContentStatusArray = $getAssetIdByContentStatusArray;
    }

    /**
     * @param string $value
     * @return array
     */
    public function execute(string $value): array
    {
        $ids = [];
        foreach ($this->getAssetIdByContentStatusArray as $getAssetIdByContentStatus) {
            $ids = array_merge($ids, $getAssetIdByContentStatus->execute($value));
        }
        return array_unique($ids);
    }
}
