<?php
/**
 *  Message repository
 *
 */
namespace Smile\ContactMessage\Model;

use Smile\ContactMessage\Api\Data;
use Smile\ContactMessage\Api\Data\MessageInterface;
use Smile\ContactMessage\Api\MessageRepositoryInterface;
use Smile\ContactMessage\Model\ResourceModel\Message as ResourceMessage;
use Smile\ContactMessage\Model\ResourceModel\Message\CollectionFactory as MessageCollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class MessageRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */

class MessageRepository implements MessageRepositoryInterface
{
    /**
     * Message resource model
     *
     * @var MessageRepository
     */
    protected $resource;

    /**
     * Message resource factory
     *
     * @var ResourceMessage
     */
    protected $messageFactory;

    /**
     * Message collection factory
     *
     * @var MessageCollectionFactory
     */
    protected $messageCollectionFactory;

    /**
     * Category search results interface
     *
     * @var Data\MessageSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * Constructor
     *
     * @param ResourceMessage                            $resource                   Resource message model
     * @param MessageFactory                             $messageFactory             Message factory
     * @param MessageCollectionFactory                   $messageCollectionFactory   Message Collection factory
     * @param Data\MessageSearchResultsInterfaceFactory  $searchResultsFactory       Search results factory
     */

    public function __construct(
        ResourceMessage $resource,
        MessageFactory $messageFactory,
        MessageCollectionFactory $messageCollectionFactory,
        Data\MessageSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->resource = $resource;
        $this->messageFactory = $messageFactory;
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * Save Message
     *
     * @param MessageInterface $message
     * @return MessageInterface
     * @throws CouldNotSaveException
     */
    public function save(MessageInterface $message)
    {
        try {
            $this->resource->save($message);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $message;
    }

    /**
     * Load message data by given identity
     *
     * @param string $entityId
     * @return Message
     * @throws NoSuchEntityException
     */
    public function getById($entityId)
    {
        $message = $this->messageFactory->create();
        $this->resource->load($message, $entityId);
        if (!$message->getId()) {
            throw new NoSuchEntityException(__('Message with id "%1" does not exist.', $entityId));
        }
        return $message;
    }

    /**
     * Load message data collection by given search criteria
     *
     * @param SearchCriteriaInterface $criteria
     * @return \Smile\ContactMessage\Model\ResourceModel\Message\Collection
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->messageCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $messages = [];
        /** @var Data\MessageInterface $messageModel */
        foreach ($collection as $messageModel) {
            $messages[] = $messageModel;
        }
        $searchResults->setItems($messages);
        return $searchResults;
    }

    /**
     * Delete message
     *
     * @param Data\messageInterface $message
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(MessageInterface $message)
    {
        try {
            $this->resource->delete($message);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete message by given identity
     *
     * @param string $entityId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($entityId)
    {
        return $this->delete($this->getById($entityId));
    }
}
