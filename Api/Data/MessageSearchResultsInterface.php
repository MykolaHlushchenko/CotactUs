<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Smile\ContactMessage\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for smile contact message search results.
 * @api
 * @since 100.0.2
 */
interface MessageSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get messages list.
     *
     * @return \Smile\ContactMessage\Api\Data\MessageInterface[]
     */
    public function getItems();

    /**
     * Set messages list.
     *
     * @param \Smile\ContactMessage\Api\Data\MessageInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
