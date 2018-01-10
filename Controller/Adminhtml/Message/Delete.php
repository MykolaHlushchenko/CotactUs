<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Smile\ContactMessage\Controller\Adminhtml\Message;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Smile\ContactMessage\Api\MessageRepositoryInterface;

/**
 * Class Delete
 * @package Smile\ContactMessage\Controller\Adminhtml\Message
 */
class Delete extends Action
{
    /**
     * @var \Magento\Backend\App\Action\Context
     */
    protected $context;

    /**
     * @var MessageRepositoryInterface
     */
    protected $messageRepository;

    /**
     * Delete constructor.
     * @param Context $context
     * @param MessageRepositoryInterface $messageRepository
     */
    public function __construct(
        Context $context,
        MessageRepositoryInterface $messageRepository
    )
    {
        parent::__construct($context);
        $this->messageRepository = $messageRepository;
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('message_id');

        if ($id) {
            try {
                $this->messageRepository->deleteById($id);
                // display success message
                $this->messageManager->addSuccessMessage('You deleted the message.');
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['message_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a message to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
