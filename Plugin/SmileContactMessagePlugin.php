<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 12/30/17
 * Time: 5:49 PM
 */
namespace Smile\ContactMessage\Plugin;

use Magento\Contact\Controller\Index\Post;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Exception\LocalizedException;
use Magento\Setup\Exception;
use Smile\ContactMessage\Api\MessageRepositoryInterface;
use Smile\ContactMessage\Api\Data\MessageInterfaceFactory;


class SmileContactMessagePlugin
{
    /**
     * Contact Message Factory
     *
     * @var MessageInterface
     */
    protected $messageFactory;

    /**
     * @var MessageRepositoryInterface
     */
    protected $messageRepository;

    /**
     * @var Request
     */
    protected $request;


    public function __construct(
        MessageInterfaceFactory $messageFactory,
        MessageRepositoryInterface $messageRepository,
        Http $request
    )
    {
        $this->messageFactory = $messageFactory;
        $this->messageRepository = $messageRepository;
        $this->request = $request;
    }

    public function beforeExecute(Post $subject) {
        //Create entity message
        $message = $this->messageFactory->create();

        try {
            if (!$this->validateParams()) {
            return[];
            }
            $data = ['user_name' => $subject->getRequest()->getParam('name'),
                'email' => $subject->getRequest()->getParam('email'),
                'phone_number' => $subject->getRequest()->getParam('telephone'),
                'text_message' => $subject->getRequest()->getParam('comment'),
                'is_active' => '0'
            ];
            //insert data to message
            $message->addData($data);
            //save message
            $this->messageRepository->save($message);
        }
        catch (\Exception $e) {
            echo $e;
        }
        return [];
    }

    public function validateParams() {

        if (trim($this->request->getParam('name')) === '') {
            throw new LocalizedException(__('Name is missing'));
        }
        if (trim($this->request->getParam('comment')) === '') {
            throw new LocalizedException(__('Comment is missing'));
        }
        if (false === \strpos($this->request->getParam('email'), '@')) {
            throw new LocalizedException(__('Invalid email address'));
        }
        return true;
    }
}