<?php

namespace Rnazy\CustomCatalog\Block\Adminhtml\Product\Edit\Button;

use Magento\Framework\App\RequestInterface;
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
     * @var RequestInterface
     */
    protected $request;

    /**
     * @param Context $context
     * @param UrlInterface $url
     * @param RequestInterface $request
     */
    public function __construct(
        Context $context,
        UrlInterface $url,
        RequestInterface $request
    ) {
        $this->context = $context;
        $this->url = $url;
        $this->request = $request;
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     *
     * @return string
     */
    public function getUrl($route = '', $params = []): string
    {
        return $this->context->getUrl($route, $params);
    }
}
