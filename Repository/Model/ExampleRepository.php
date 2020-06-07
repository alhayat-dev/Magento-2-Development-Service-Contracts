<?php
/**
 *
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Unit5\Repository\Model;

use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaInterface;
use Unit5\Repository\Api\Data\ExampleInterface;
use Unit5\Repository\Api\Data\ExampleInterfaceFactory as ExampleDataFactory;
use Unit5\Repository\Api\Data\ExampleSearchResultsInterface;
use Unit5\Repository\Api\Data\ExampleSearchResultsInterfaceFactory;
use Unit5\Repository\Api\ExampleRepositoryInterface;
use Unit5\Repository\Model\Example as ExampleModel;
use Unit5\Repository\Model\Resource\Example\Collection as ExampleCollection;
use Magento\Framework\Api\SortOrder;

/**
 * Class ExampleRepository
 * @package Unit5\Repository\Model
 */
class ExampleRepository implements ExampleRepositoryInterface
{
    /**
     * @var ExampleSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;
    /**
     * @var ExampleFactory
     */
    private $exampleFactory;
    /**
     * @var ExampleDataFactory
     */
    private $exampleDataFactory;

    /**
     * ExampleRepository constructor.
     * @param ExampleSearchResultsInterfaceFactory $searchResultsFactory
     * @param ExampleFactory $exampleFactory
     * @param ExampleDataFactory $exampleDataFactory
     */
    public function __construct(
        ExampleSearchResultsInterfaceFactory $searchResultsFactory,
        ExampleFactory $exampleFactory,
        ExampleDataFactory $exampleDataFactory
    ) {
        $this->searchResultsFactory = $searchResultsFactory;
        $this->exampleFactory = $exampleFactory;
        $this->exampleDataFactory = $exampleDataFactory;
    }
    /**
     * @return ExampleSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var ExampleCollection $collection */
        $collection = $this->exampleFactory->create()->getCollection();
        /** @var ExampleSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $this->applySearchCriteriaToCollection($searchCriteria, $collection);
        $examples = $this->convertCollectionToDataItemsArray($collection);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($examples);
        return $searchResults;
    }

    /**
     * @param FilterGroup $filterGroup
     * @param ExampleCollection $collection
     */
    private function addFilterGroupToCollection(
        FilterGroup $filterGroup,
        ExampleCollection $collection
    ) {
        $fields = [];
        $conditions = [];
        foreach ($filterGroup->getFilters() as $filters) {
            foreach ($filters as $filter){
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $fields[] = $filter->getField();
                $conditions[] = [$condition => $filter->getValue()];
            }
        }
        if ($fields) {
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * @param ExampleCollection $collection
     * @return array
     */
    private function convertCollectionToDataItemsArray(
        ExampleCollection $collection
    ) {
        $examples = array_map(function (ExampleModel $example) {
            /** @var ExampleInterface $dataObject */
            $dataObject = $this->exampleDataFactory->create();
            $dataObject->setId($example->getId());
            $dataObject->setName($example->getName());
            $dataObject->setCreatedAt($example->getCreatedAt());
            $dataObject->setModifiedAt($example->getModifiedAt());
            return $dataObject;
        }, $collection->getItems());
        return $examples;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param ExampleCollection $collection
     */
    private function applySearchCriteriaToCollection(
        SearchCriteriaInterface $searchCriteria,
        ExampleCollection $collection
    ) {
        $this->applySearchCriteriaFiltersToCollection(
            $searchCriteria,
            $collection
        );
        $this->applySearchCriteriaSortOrdersToCollection(
            $searchCriteria,
            $collection
        );
        $this->applySearchCriteriaPagingToCollection(
            $searchCriteria,
            $collection
        );
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param ExampleCollection $collection
     */
    private function applySearchCriteriaFiltersToCollection(
        SearchCriteriaInterface $searchCriteria,
        ExampleCollection $collection
    ) {
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param ExampleCollection $collection
     */
    private function applySearchCriteriaSortOrdersToCollection(
        SearchCriteriaInterface $searchCriteria,
        ExampleCollection $collection
    ) {
        $sortOrders = $searchCriteria->getSortOrders();

        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $isAscending = $sortOrder->getDirection() == SortOrder::SORT_ASC;
                $collection->addOrder(
                    $sortOrder->getField(),
                    $isAscending ? 'ASC' : 'DESC'
                );
            }
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param ExampleCollection $collection
     */
    private function applySearchCriteriaPagingToCollection(
        SearchCriteriaInterface $searchCriteria,
        ExampleCollection $collection
    ) {
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
    }
}
