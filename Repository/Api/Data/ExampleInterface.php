<?php
/**
 *
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Unit5\Repository\Api\Data;

/**
 * Interface ExampleInterface
 * @package Unit6\Repository\Api\Data
 */
interface ExampleInterface
{
    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);
    /**
     * @return int
     */
    public function getId();
/**
 * @return string
 */
    public function getName();
    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);
    /**
     * @return string
     */
    public function getCreatedAt();
    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);
    /**
     * @return string
     */
    public function getModifiedAt();
    /**
     * @param string $modifiedAt
     * @return $this
     */
    public function setModifiedAt($modifiedAt);
}
