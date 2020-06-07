<?php
/**
 *
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Unit5\Repository\Model;

use Magento\Framework\Model\AbstractModel;
use Unit5\Repository\Api\Data\ExampleInterface;

/**
 * Class Example
 * @package Unit6\Repository\Model
 */
class Example extends AbstractModel implements ExampleInterface
{
    /**
     *
     */
    protected function _construct()
    {
        $this->_init(Resource\Example::class);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_getData('name');
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->setData('name', $name);
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->_getData('created_at');
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->setData('modified_at', $createdAt);
    }

    /**
     * @return mixed
     */
    public function getModifiedAt()
    {
        return $this->_getData('modified_at');
    }

    /**
     * @param string $modifiedAt
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->setData('modified_at', $modifiedAt);
    }
}
