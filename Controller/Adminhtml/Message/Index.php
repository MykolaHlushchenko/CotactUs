<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Smile\ContactMessage\Controller\Adminhtml\Message;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Smile\ContactMessage\Api\Data\MessageInterfaceFactory;
use Smile\ContactMessage\Api\MessageRepositoryInterface;

/**
 * Class Index
 * @package Smile\ContactMessage\Controller\Adminhtml\Message
 */

class Index extends Action
{
    /**
     * @var MessageInterfaceFactory
     */
    protected $messageFactory;

    /**
     * @var MessageRepositoryInterface
     */
    protected $repository;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param MessageInterfaceFactory $messageFactory
     * @param MessageRepositoryInterface $repository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        MessageInterfaceFactory $messageFactory,
        MessageRepositoryInterface $repository
    ) {
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
		$this->messageFactory = $messageFactory;
		$this->repository = $repository;
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        return $resultPage = $this->resultPageFactory->create();
    }
}
