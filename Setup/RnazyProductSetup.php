<?php

namespace Rnazy\CustomCatalog\Setup;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Rnazy\CustomCatalog\Api\Data\ProductInterface;

class RnazyProductSetup extends EavSetup
{
    /**
     * @return array
     */
    public function getDefaultEntities(): array
    {
        return [
            ProductInterface::ENTITY_CODE => [
                'entity_model' => \Rnazy\CustomCatalog\Model\ResourceModel\Product::class,
                'attribute_model' => \Rnazy\CustomCatalog\Model\Product\Attribute::class,
                'table' => ProductInterface::ENTITY_CODE . '_entity',
                'increment_model' => null,
                'additional_attribute_table' => ProductInterface::ENTITY_CODE . '_eav_attribute',
                'entity_attribute_collection' => \Rnazy\CustomCatalog\Model\ResourceModel\Attribute\Collection::class,
                'attributes' => [
                    'sku' => [
                        'type' => 'static',
                        'label' => 'SKU',
                        'input' => 'text',
                        'frontend_class' => 'validate-length maximum-length-64',
                        'sort_order' => 1,
                    ],
                    'vpn' => [
                        'type' => 'static',
                        'label' => 'VPN',
                        'input' => 'text',
                        'frontend_class' => 'validate-length maximum-length-64',
                        'sort_order' => 2,
                    ],
                    'copywrite_info' => [
                        'type' => 'text',
                        'label' => 'CopyWrite Info',
                        'input' => 'textarea',
                        'sort_order' => 3,
                        'global' => ScopedAttributeInterface::SCOPE_STORE,
                        'wysiwyg_enabled' => true
                    ],
                ],
            ],
        ];
    }

}
