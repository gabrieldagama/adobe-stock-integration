<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\MediaGalleryUi\Model\SearchCriteria\CollectionProcessor\FilterProcessor;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor\FilterProcessor\CustomFilterInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\DB\Select;
use Magento\MediaGalleryUi\Model\SearchCriteria\CollectionProcessor\FilterProcessor\ContentStatus\GetContentIdByStatusComposite;

class ContentStatus implements CustomFilterInterface
{
    private const TABLE_ALIAS = 'main_table';

    /**
     * @var GetContentIdByStatusComposite
     */
    private $getContentIdByStatusComposite;

    /**
     * ContentStatus constructor.
     * @param GetContentIdByStatusComposite $getContentIdByStatusComposite
     */
    public function __construct(
        GetContentIdByStatusComposite $getContentIdByStatusComposite
    ) {
        $this->getContentIdByStatusComposite = $getContentIdByStatusComposite;
    }

    /**
     * @inheritDoc
     */
    public function apply(Filter $filter, AbstractDb $collection): bool
    {
        $value = $filter->getValue();
        $collection->addFieldToFilter(
            self::TABLE_ALIAS . '.id',
            ['in' => $this->getContentIdByStatusComposite->execute($value)]
        );

        return true;
    }

}
