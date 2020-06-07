<?php
/**
 *
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Unit5\Repository\Api\Data;

/**
 * Interface ExampleSearchResultsInterface
 * @package Unit6\Repository\Api\Data
 */
interface ExampleSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @api
     * @return \Unit6\Repository\Api\Data\ExampleInterface[]
     */
    public function getItems();

    /**
     * @api
     * @param \Unit6\Repository\Api\Data\ExampleInterface[] $items
     * @return $this
     */
    public function setItems(array $items = null);
}
