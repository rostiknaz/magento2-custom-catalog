<?php

namespace Rnazy\CustomCatalog\Api\Data;

use Magento\Framework\Api\CustomAttributesDataInterface;

interface ProductInterface extends CustomAttributesDataInterface
{
    const ID = 'entity_id';
    const COPYWRITE_INFO = 'copywrite_info';
    const VPN = 'vpn';
    const SKU = 'sku';

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id): self;

    /**
     * @return string
     */
    public function getSku(): string;

    /**
     * @param string $sku
     *
     * @return ProductInterface
     */
    public function setSku(string $sku): self;

    /**
     * @return string
     */
    public function getCopywriteInfo(): string;

    /**
     * @param string $info
     *
     * @return $this
     */
    public function setCopywriteInfo(string $info): self;

    /**
     * @return string
     */
    public function getVpn(): string;

    /**
     * @param string $vpn
     *
     * @return $this
     */
    public function setVpn(string $vpn): self;
}
