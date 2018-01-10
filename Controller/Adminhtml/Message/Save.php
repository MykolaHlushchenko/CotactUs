<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Smile\ContactMessage\Controller\Adminhtml\Message;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Smile\ContactMessage\Api\MessageRepositoryInterface;
use Smile\ContactMessage\Api\Data\MessageInterfaceFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\App\Action;
use Magento\Store\Model\ScopeInterface;


/**
 * Class Save
 * @package Smile\ContactMessage\Controller\Adminhtml\Message
 */
class Save extends Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * Message Factory
     *
     * @var MessageInterface
     */
    protected $messageFactory;

    /**
     * @var MessageRepositoryInterface
     */
    protected $messageRepository;

    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $transportBuilder;

    /**
    * @var \Magento\Framework\App\Config\ScopeConfigInterface
    */
    protected $scopeConfig;

    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    protected $inlineTranslation;

     /**
     * Sender email config path
     */
    const XML_PATH_EMAIL_SENDER = 'contact/email/sender_email_identity';

    /**
     * Recipient email config path
     */
    const XML_PATH_EMAIL_RECIPIENT = 'contact/email/send_email';

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param MessageInterfaceFactory $messageFactory
     * @param MessageRepositoryInterface $messageRepository
     * @param TransportBuilder $transportBuilder
     * @param ScopeConfigInterface $scopeConfig
     * @param StateInterface $inlineTranslation
     */


    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        MessageInterfaceFactory $messageFactory,
        MessageRepositoryInterface $messageRepository,
        TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig,
        StateInterface $inlineTranslation

    ) {
        $this->dataPersistor = $dataPersistor;
        $this->messageFactory = $messageFactory;
        $this->messageRepository = $messageRepository;
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->inlineTranslation = $inlineTranslation;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // get data on method post
        $post = $this->getRequest()->getPostValue();

        $postObject = new \Magento\Framework\DataObject();
        $postObject->setData($post);

        if (!$post) {
            $this->_redirect('*/*/');
            return;
        }
        $this->inlineTranslation->suspend();
        // get message id
        $id = $this->getRequest()->getParam('message_id');

        /** @var \Smile\ContactMessage\Api\MessageRepositoryInterface $model */
        if ($id) {
            $model = $this->messageRepository->getById($id);
        } else {
            $model = $this->messageFactory->create();
        }

        $this->inlineTranslation->suspend();
        try {
            $storeScope = ScopeInterface::SCOPE_STORE;
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('contact_message_template')
                ->setTemplateOptions(
                    [
                    'area' => \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE,
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                ]
                )
                ->setTemplateVars(['data' => $postObject])
                ->setFrom($this->scopeConfig->getValue(self::XML_PATH_EMAIL_SENDER, $storeScope))
                ->addTo($post['email'])
                ->getTransport();

            $transport->sendMessage();
            $this->inlineTranslation->resume();

            $post['is_active'] = 1;
            $model->setData($post);
            $this->messageRepository->save($model);
            $this->messageManager->addSuccessMessage(__('You saved the message.'));
            $this->dataPersistor->clear('contact_message');

            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['message_id' => $model->getById($id)]);
            }
            return $resultRedirect->setPath('*/*/');

        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the message.'));
        }
        $this->dataPersistor->set('contact_message', $post);

        return $resultRedirect->setPath('*/*/edit', ['message_id' => $this->getRequest()->getParam('message_id')]);
    }
}
