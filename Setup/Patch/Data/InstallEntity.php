<?php

namespace Rnazy\CustomCatalog\Setup\Patch\Data;

use Rnazy\CustomCatalog\Setup\RnazyProductSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class InstallEntity implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var RnazyProductSetupFactory
     */
    private $productSetupFactory;


    /**
     * PatchInitial constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        RnazyProductSetupFactory $productSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->productSetupFactory = $productSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        /** @var \Rnazy\CustomCatalog\Setup\RnazyProductSetup $customCatalogSetup */
        $customCatalogSetup = $this->productSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $customCatalogSetup->installEntities();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
