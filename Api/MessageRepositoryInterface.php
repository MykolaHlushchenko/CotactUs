<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Smile\ContactMessage\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Smile\ContactMessage\Api\Data\MessageInterface;

/**
 * Contact message CRUD interface.
 * @api
 * @since 100.0.2
 */
interface MessageRepositoryInterface
{
    /**
     * Save message.
     *
     * @param \Smile\ContactMessage\Api\Data\MessageInterface $message
     * @return \Smile\ContactMessage\Api\Data\MessageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(MessageInterface $message);

    /**
     * Retrieve message.
     *
     * @param int $messageId
     * @return \Smile\ContactMessage\Api\Data\MessageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($messageId);

    /**
     * Retrieve messages matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Smile\ContactMessage\Api\Data\MessageSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete message.
     *
     * @param \Smile\ContactMessage\Api\Data\MessageInterface $message
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(MessageInterface $message);

    /**
     * Delete message by ID.
     *
     * @param int $messageId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($messageId);
}
