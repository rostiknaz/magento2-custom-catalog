<?php

namespace Rnazy\CustomCatalog\Api;

use Rnazy\CustomCatalog\Api\Data\ProductInterface;

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
     * @param string $vpn
     *
     * @return mixed
     */
    public function getByVpn(string $vpn);
}
