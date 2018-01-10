<?php
namespace Smile\ContactMessage\Model\Message\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Smile\ContactMessage\Model\Message;

/**
 * Class Message Status
 */
class IsActive implements OptionSourceInterface
{
    /**
     * @var \Smile\ContactMessage\Model\Message
     */
    protected $message;
    protected $messageFactory;
    /**
     * Constructor
     *
     * @param \Smile\ContactMessage\Model\Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->message->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {

            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }

        return $options;
    }
}
