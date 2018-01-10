<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Smile\ContactMessage\Controller\Adminhtml\Message;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Smile\ContactMessage\Api\MessageRepositoryInterface;

class Edit extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * @var \Smile\ContactMessage\Api\MessageRepositoryInterface
     */
    protected $messageRepository;

    /**
     * Edit constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Smile\ContactMessage\Api\MessageRepositoryInterface $messageRepository
     */

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        MessageRepositoryInterface $messageRepository

    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
        $this->messageRepository = $messageRepository;
        parent::__construct($context);
    }

    /**
     * Edit message
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // Get message ID
        $model = false;
        $id = $this->getRequest()->getParam('message_id');

        // Initial checking
        if ($id) {
            try {
                $model = $this->messageRepository->getById($id);
            } catch (NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage(__('This message no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->coreRegistry->register('smile_contact_message', $model);

        // Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Message') : __('New Message'),
            $id ? __('Edit Message') : __('New Message')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Messages'));
        $resultPage->getConfig()->getTitle()->prepend($model->getMessageId() ? $model->getUserName() : __('New Message'));
        return $resultPage;
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('Smile_ContactMessage::smile_contact_messages')
            ->addBreadcrumb(__('Message'), __('Message'))
            ->addBreadcrumb(__('Static Messages'), __('Static Messages'));
        return $resultPage;
    }
}
