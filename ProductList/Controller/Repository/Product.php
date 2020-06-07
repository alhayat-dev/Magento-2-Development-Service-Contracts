<?php

/**
 *
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Unit5\ProductList\Controller\Repository;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable as ConfigurableProduct;

/**
 * Class Product
 * @package Unit6\ProductList\Controller\Repository
 */
class Product extends Action
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var SearchCriteriaBuilder
     */
    private $filterBuilder;

    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;

    /**
     * Product constructor.
     * @param Context $context
     * @param ProductRepositoryInterface $productRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     */
    public function __construct(
        Context $context,
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        SortOrderBuilder $sortOrderBuilder
    ) {
        parent::__construct($context);
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * @return string
     */
    public function execute()
    {
        $this->getResponse()->setHeader('Content-Type', 'text/plain');
        $products = $this->getProductsFromRepository();
        foreach ($products as $product) {
            $this->outputProduct($product);
        }
    }
    /**
     * @return ProductInterface[]
     */
    private function getProductsFromRepository()
    {
        $this->setProductTypeFilter();
        $this->setProductNameFilter();
        $this->setProductOrder();
        $this->setProductPaging();

        $criteria = $this->searchCriteriaBuilder->create();
        $products = $this->productRepository->getList($criteria);
        return $products->getItems();
    }

    /**
     * setProductTypeFilter
     */
    private function setProductTypeFilter()
    {
        $configProductFilter = $this->filterBuilder
            ->setField('type_id')
            ->setValue(ConfigurableProduct::TYPE_CODE)
            ->setConditionType('eq')
            ->create();
        $this->searchCriteriaBuilder->addFilters([$configProductFilter]);
    }

    /**
     * setProductNameFilter
     */
    private function setProductNameFilter()
    {
        $nameFilter[] = $this->filterBuilder
            ->setField('name')
            ->setValue('M%')
            ->setConditionType('like')
            ->create();
        $this->searchCriteriaBuilder->addFilters($nameFilter);
    }

    /**
     * setProductOrder
     */
    private function setProductOrder()
    {
        $sortOrder = $this->sortOrderBuilder
            ->setField('entity_id')
            ->setDirection(SortOrder::SORT_ASC)
            ->create();
        $this->searchCriteriaBuilder->addSortOrder($sortOrder);
    }

    /**
     * setProductPaging
     */
    private function setProductPaging()
    {
        $sortOrder = $this->sortOrderBuilder
            ->setField('entity_id')
            ->setDirection(SortOrder::SORT_ASC)
            ->create();
        $this->searchCriteriaBuilder->addSortOrder($sortOrder);
        $this->searchCriteriaBuilder->setPageSize(6);
        $this->searchCriteriaBuilder->setCurrentPage(1);
    }

    /**
     * @param ProductInterface $product
     */
    private function outputProduct(ProductInterface $product)
    {
        $this->getResponse()->appendBody(sprintf(
                "%s - %s (%d)\n",
                $product->getName(),
                $product->getSku(),
                $product->getId())
        );
    }
}
