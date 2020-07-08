<?php
/**
 * Created by PhpStorm.
 * User: zhlhuang
 * Date: 2018/5/23
 * Time: 10:37
 */

namespace Printer\Model;

use Common\Model\RelationModel;

class PrinterFeieMsgModel extends RelationModel {
    const STATUS_YES = 1;
    const STATUS_NO = 0;

    protected $tableName = 'printer_feie_msg';

    /**
     * 关联表
     *
     * @var array
     */
    protected $_link = array();
}