<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Smile\ContactMessage\Api\Data;

/**
 * Contact message interface.
 * @api
 * @since 100.0.2
 */
interface MessageInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const MESSAGE_ID         = 'message_id';
    const USER_NAME          = 'user_name';
    const EMAIL              = 'email';
    const PHONE_NUMBER       = 'phone_number';
    const TEXT_MESSAGE       = 'text_message';
    const CREATION_TIME      = 'creation_time';
    const IS_ACTIVE          = 'is_active';
    /**#@-*/


    /**
     * Get message id
     *
     * @return int|null
     */
    public function getMessageId();

    /**
     * Get user name
     *
     * @return string
     */
    public function getUserName();

    /**
     * Get email
     *
     * @return string|null
     */
    public function getEmail();

    /**
     * Get phone number
     *
     * @return string|null
     */
    public function getPhoneNumber();

    /**
     * Get text message
     *
     * @return string|null
     */
    public function getTextMessage();

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Get is message is active
     *
     * @return int|null
     */
    public function getIsActive();

     /**
     * Set user name
     *
     * @param string $userName
     * @return MessageInterface
     */
    public function setUserName($userName);

    /**
     * Set user email
     *
     * @param string $email
     * @return MessageInterface
     */
    public function setEmail($email);

    /**
     * Set phone number
     *
     * @param string $phoneNumber
     * @return MessageInterface
     */
    public function setPhoneNumber($phoneNumber);

    /**
     * Set text message
     *
     * @param string $textMessage
     * @return MessageInterface
     */
    public function setTextMessage($textMessage);

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return MessageInterface
     */
    public function setCreationTime($creationTime);

    /**
     * Set is active
     *
     * @param bool|int $isActive
     * @return MessageInterface
     */
    public function setIsActive($isActive);
}
