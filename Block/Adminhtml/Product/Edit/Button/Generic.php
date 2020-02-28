<?php

namespace Rnazy\CustomCatalog\Block\Adminhtml\Product\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Framework\UrlInterface;


abstract class Generic implements ButtonProviderInterface
{
    /**
     * Url Builder
     *
     * @var Context
     */
    protected $context;

    /**
     * @var UrlInterface
     */
    protected $url;

    /**
     * @param Context $context
     * @param UrlInterface $url
     */
    public function __construct(
        Context $context,
        UrlInterface $url
    ) {
        $this->context = $context;
        $this->url = $url;
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrl($route, $params);
    }
}
