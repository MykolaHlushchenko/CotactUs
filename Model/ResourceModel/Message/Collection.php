<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 11/27/17
 * Time: 4:51 PM
 */
namespace Smile\ContactMessage\Model\ResourceModel\Message;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            'Smile\ContactMessage\Model\Message',
            'Smile\ContactMessage\Model\ResourceModel\Message'
        );
    }
}
