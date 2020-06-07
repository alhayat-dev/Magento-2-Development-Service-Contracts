<?php
/**
 *
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Unit5\Repository\Model\Resource;

/**
 * Class Example
 * @package Unit6\Repository\Model\Resource
 */
class Example extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init('training_repository_example', 'example_id');
    }
}
