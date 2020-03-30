<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\MediaGalleryUi\Ui\Component;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Container;

/**
 * Directories tree component
 */
class ImageUploader extends Container
{
    const IMAGE_UPLOADER_COMPONENT = 'Magento_MediaGalleryUi/js/image-uploader';
    const ACCEPT_FILE_TYPES = '/(\.|\/)(gif|jpe?g|png)$/i';
    const ALLOWED_EXTENSIONS = 'jpg jpeg png gif';
    const MAX_FILE_SIZE = '2097152';

    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UrlInterface $url
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UrlInterface $url,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $components, $data);
        $this->url = $url;
    }

    /**
     * @inheritdoc
     */
    public function prepare(): void
    {
        parent::prepare();
        $this->setData(
            'config',
            array_replace_recursive(
                (array) $this->getData('config'),
                [
                    'imageUploadUrl' => $this->url->getUrl('media_gallery/image/upload', ['type' => 'image']),
                    'acceptFileTypes' => self::ACCEPT_FILE_TYPES,
                    'allowedExtensions' => self::ALLOWED_EXTENSIONS,
                    'maxFileSize' => self::MAX_FILE_SIZE
                ]
            )
        );
    }
}