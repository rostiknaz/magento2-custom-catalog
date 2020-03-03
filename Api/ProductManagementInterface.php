<?php

namespace Rnazy\CustomCatalog\Api;

interface ProductManagementInterface
{
    /**
     * Used in Wep Api async update request.
     *
     * @param int $entityId
     * @param string $copywriteInfo
     * @param string $vpn
     *
     * @return \Rnazy\CustomCatalog\Api\Data\ProductInterface
     */
    public function asyncUpdate(int $entityId, string $copywriteInfo = '', string $vpn = '');

    /**
     * Get list of all products by vpn.
     *
     * @param string $vpn
     *
     * @return \Rnazy\CustomCatalog\Api\Data\ProductInterface[]
     */
    public function getByVpn(string $vpn);
}
