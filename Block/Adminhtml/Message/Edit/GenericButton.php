<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Smile\ContactMessage\Block\Adminhtml\Message\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Smile\ContactMessage\Api\MessageRepositoryInterface;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var MessageRepositoryInterface
     */
    protected $messageRepository;

    /**
     * @param Context $context
     * @param MessageRepositoryInterface $messageRepository
     */
    public function __construct(
        Context $context,
        MessageRepositoryInterface $messageRepository
    ) {
        $this->context = $context;
        $this->messageRepository = $messageRepository;
    }

    /**
     * Return Message id
     *
     * @return int|null
     */
    public function getMessageId()
    {
        try {
            return $this->messageRepository->getById(
                $this->context->getRequest()->getParam('message_id')
            )->getMessageId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
