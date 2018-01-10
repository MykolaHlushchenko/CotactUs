<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 11/27/17
 * Time: 4:43 PM
 */
namespace Smile\ContactMessage\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Message extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('smile_contact_message','message_id');
    }
}