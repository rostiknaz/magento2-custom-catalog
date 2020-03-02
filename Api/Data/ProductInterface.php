<?php

namespace Rnazy\CustomCatalog\Api\Data;

use Magento\Framework\Api\CustomAttributesDataInterface;

interface ProductInterface extends CustomAttributesDataInterface
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY_CODE = 'rnazy_product';

    const ID = 'entity_id';
    const COPYWRITE_INFO = 'copywrite_info';
    const VPN = 'vpn';
    const SKU = 'sku';

    /**
     * entity_type_id for save Entity Type ID value
     */
    const KEY_ENTITY_TYPE_ID = 'entity_type_id';

    /**
     * attribute_set_id for save Attribute Set ID value
     */
    const KEY_ATTR_TYPE_ID = 'attribute_set_id';

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id);

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
