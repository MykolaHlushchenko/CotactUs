<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Smile\ContactMessage\Model;

use Smile\ContactMessage\Api\Data\MessageInterface;
use Smile\ContactMessage\Model\ResourceModel\Message as ResourceSmileMessage;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Message model
 *
 * @method Message MessageId(array $messageId)
 * @method array getStoreId()
 */
class Message extends AbstractModel implements MessageInterface, IdentityInterface
{
    /**
     * Contact message cache tag
     */
    const CACHE_TAG = 'smile_message';

    /**#@+
     * Messages statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**#@-*/

    /**#@-*/
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'smile_messages';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceSmileMessage::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getMessageId()];
    }

    /**
     * Retrieve message id
     *
     * @return int
     */
    public function getMessageId()
    {
        return $this->getData(self::MESSAGE_ID);
    }

    /**
     * Retrieve user name
     *
     * @return string
     */
    public function getUserName()
    {
        return (string)$this->getData(self::USER_NAME);
    }

    /**
     * Retrieve email
     *
     * @return string
     */
    public function getEmail()
    {
        return (string)$this->getData(self::EMAIL);
    }

    /**
     * Retrieve phone number
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->getData(self::PHONE_NUMBER);
    }

    /**
     * Retrieve text message
     *
     * @return string
     */
    public function getTextMessage()
    {
        return $this->getData(self::TEXT_MESSAGE);
    }

    /**
     * Retrieve creation time
     *
     * @return string
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * Retrieve is message is active
     *
     * @return int|null
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * Set user name
     *
     * @param int $userName
     * @return MessageInterface
     */
    public function setUserName($userName)
    {
        return $this->setData(self::USER_NAME, $userName);
    }

    /**
     * Set email
     *
     * @param string $email
     * @return MessageInterface
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * Set phone number
     *
     * @param string $phoneNumber
     * @return MessageInterface
     */
    public function  setPhoneNumber($phoneNumber)
    {
        return $this->setData(self::PHONE_NUMBER, $phoneNumber);
    }

    /**
     * Set text message
     *
     * @param string $textMessage
     * @return MessageInterface
     */
    public function setTextMessage($textMessage)
    {
        return $this->setData(self::TEXT_MESSAGE, $textMessage);
    }

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return MessageInterface
     */
    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Set message is active
     *
     * @param string $isActive
     * @return MessageInterface
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

     /**
     * Prepare messages statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

}
