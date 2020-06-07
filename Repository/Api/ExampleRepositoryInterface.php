<?php

/**
 *
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Unit5\Repository\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface ExampleRepositoryInterface
 * @package Unit6\Repository\Api
 */
interface ExampleRepositoryInterface
{
    /**
     * @return Data\ExampleSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
