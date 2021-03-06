<?php
/**
 * Intelive
 * @package Intelive Claro
 * @copyright Copyright (c) 2018 Intelive Metrics Srl
 * @author Adrian Roman
 */

namespace Intelive\Claro\Controller\Module;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Intelive\Claro\Helper\Data;
use Intelive\Claro\Model\Types\StocksFactory;

class Stocks extends \Intelive\Claro\Controller\Module
{
    protected $resultJsonFactory;
    protected $stocksFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param StocksFactory $stocksFactory
     * @param \Intelive\Claro\Helper\Data $helper
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        StocksFactory $stocksFactory,
        Data $helper
    ) {

        $this->resultJsonFactory = $resultJsonFactory;
        $this->stocksFactory = $stocksFactory;
        $this->helper = $helper;
        parent::__construct($context);
        parent::initParams();
    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();

        if ($this->isAuthorized() != true || $this->isEnabled() != true) {
            $content = $this->helper->prepareDefaultResult();
            $result->setHttpResponseCode($content['status']);
            $result->setData($content['data']);

            return $result;
        }
        $stocks = $this->stocksFactory->create();

        $data = $stocks->load();
        $encodedData = $this->helper->prepareResult($data, 'stock', Data::TYPE_STOCK);

        return $result->setData($encodedData);
    }
}