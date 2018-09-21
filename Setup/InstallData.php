<?php
/**
 * Intelive
 * @package Intelive Claro
 * @copyright Copyright (c) 2018 Intelive Metrics Srl
 * @author Adrian Roman
 */

namespace Intelive\Claro\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\UrlRewrite\Model\UrlRewrite;
use Magento\Store\Model\StoreManagerInterface;

class InstallData implements InstallDataInterface
{

    protected $urlRewrite;

    public static $fields = [
        'url_rewrite_id',
        'entity_type',
        'entity_id',
        'request_path',
        'target_path',
        'redirect_type',
        'store_id',
        'description',
        'is_autogenerated',
        'metadata'
    ];

    public static $table = 'url_rewrite';

    public function __construct(UrlRewrite $urlRewrite, StoreManagerInterface $storeManager)
    {
        $this->urlRewrite = $urlRewrite;
        $this->storeManager = $storeManager;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {

//        $hostname = version_compare(phpversion(), '5.3', '>=') ? gethostname() : php_uname('n');
//        $prefix = md5($hostname);
//        $token = sha1(uniqid($prefix, true) . rand() . microtime());
//        $data[] = array('path' => 'intelive/general/enabled', 'value' => $token);
//        $data[] = array('path' => 'intelive/general/enabled', 'value' => '1');
//        $setup->getConnection()->insertArray($setup->getTable('core_config_data'), ['path', 'value'], $data);

        if (!$this->urlRewrite->getCollection()->getItemByColumnValue('request_path', 'intelive/module/abandoned_carts')) {
            $urls[] = array(
                null,
                'custom',
                0,
                'intelive/module/abandoned_carts',
                'intelive/module/abandonedcarts',
                0,
                $this->storeManager->getStore()->getId(),
                null,
                0,
                null
            );
            $urls[] = array(
                null,
                'custom',
                0,
                'intelive/module/creditmemos',
                'intelive/module/creditmemos',
                0,
                $this->storeManager->getStore()->getId(),
                null,
                0,
                null
            );
            $urls[] = array(
                null,
                'custom',
                0,
                'intelive/module/customers',
                'intelive/module/customers',
                0,
                $this->storeManager->getStore()->getId(),
                null,
                0,
                null
            );
            $urls[] = array(
                null,
                'custom',
                0,
                'intelive/module/invoices',
                'intelive/module/invoices',
                0,
                $this->storeManager->getStore()->getId(),
                null,
                0,
                null
            );
            $urls[] = array(
                null,
                'custom',
                0,
                'intelive/module/order_items',
                'intelive/module/order_items',
                0,
                $this->storeManager->getStore()->getId(),
                null,
                0,
                null
            );
            $urls[] = array(
                null,
                'custom',
                0,
                'intelive/module/orders',
                'intelive/module/orders',
                0,
                $this->storeManager->getStore()->getId(),
                null,
                0,
                null
            );
            $urls[] = array(
                null,
                'custom',
                0,
                'intelive/module/products',
                'intelive/module/products',
                0,
                $this->storeManager->getStore()->getId(),
                null,
                0,
                null
            );
            $setup->getConnection()->insertArray($setup->getTable(self::$table), self::$fields, $urls);
        }
    }
}
