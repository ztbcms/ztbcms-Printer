<?php
/**
 * Created by PhpStorm.
 * User: zhlhuang
 * Date: 22/05/2018
 * Time: 18:24
 */

namespace Printer\Service;

use Printer\Model\PrinterFeieMsgModel;
use System\Service\BaseService;

class FeiEService extends BaseService {
    const IP = 'api.feieyun.cn';
    const PORT = '80';
    const PATH = '/Api/Open/';

    public $sn = '';
    public $user = '';
    public $ukey = '';


    /**
     * FeiEService constructor.
     *
     * @param      $sn
     * @param null $app_id
     */
    function __construct($sn = null, $app_id = null) {
        if ($app_id) {
            $db = D('Printer/PrinterFeieApp');
            $app = $db->find($app_id);
        } else {
            $db = D('Printer/PrinterFeieApp');
            $app = $db->order('is_default DESC')->find($app_id);
        }
        $this->user = $app['user'];
        $this->ukey = $app['ukey'];
        $this->sn = $sn;
    }

    /**
     *  添加打印机
     *
     * @param        $key
     * @param string $remark
     * @return bool
     */
    function printerAdd($key, $remark = '') {
        $time = time();
        $data = [
            'user' => $this->user,
            'stime' => $time,
            'apiname' => 'Open_printerAddlist',
            'sig' => sha1($this->user . $this->ukey . $time),
            'printerContent' => $this->sn . '# ' . $key . '# ' . $remark
        ];
        $client = new HttpClientService(self::IP, self::PORT);
        $client->post(self::PATH, $data);
        $res = json_decode($client->getContent(), true);
        if ($res['data']['ok']) {
            $data = [
                'remark' => $remark,
                'sn' => $this->sn,
                'key' => $key,
                'create_time' => time(),
                'update_time' => time()
            ];
            $db = D('Printer/PrinterFeieObject');
            $res = $db->add($data);

            $status_res = $this->queryPrinterStatus();
            if ($status_res['status']) {
                $db->where(['id' => $res])->save(['status_msg' => $status_res['data']]);
            } else {
                $db->where(['id' => $res])->save(['status_msg' => '获取状态中……']);
            }

            return self::createReturn(true, $db->find($res), $res['data']['ok'][0]);
        } else {
            return self::createReturn(false, $res['data'], $res['data']['no'][0]);
        }
    }

    /**
     * 修改打印机
     *
     * @param $name
     * @return array
     */
    function printerEdit($name) {
        $time = time();
        $data = [
            'user' => $this->user,
            'stime' => $time,
            'apiname' => 'Open_printerEdit',
            'sig' => sha1($this->user . $this->ukey . $time),
            'sn' => $this->sn,
            'name' => $name
        ];
        $client = new HttpClientService(self::IP, self::PORT);
        $client->post(self::PATH, $data);
        $res = json_decode($client->getContent(), true);
        if ($res['ret'] == 0) {
            return self::createReturn(true, $res['data'], $res['msg']);
        } else {
            return self::createReturn(false, $res['data'], $res['msg']);
        }
    }

    /**删除打印机
     *
     * @return array
     */
    function printerDel() {
        $time = time();
        $data = [
            'user' => $this->user,
            'stime' => $time,
            'apiname' => 'Open_printerDelList',
            'sig' => sha1($this->user . $this->ukey . $time),
            'snlist' => $this->sn,
        ];
        $client = new HttpClientService(self::IP, self::PORT);
        $client->post(self::PATH, $data);
        $res = json_decode($client->getContent(), true);
        if ($res['data']['ok']) {
            return self::createReturn(true, $res['data'], $res['data']['ok'][0]);
        } else {
            return self::createReturn(false, $res['data'], $res['data']['no'][0]);
        }
    }

    /**
     * 打印信息
     *
     * @param     $content
     * @param int $times
     * @return array
     */
    function printMsg($content, $times = 1) {
        $time = time();
        $data = [
            'user' => $this->user,
            'stime' => $time,
            'apiname' => 'Open_printMsg',
            'sig' => sha1($this->user . $this->ukey . $time),
            'sn' => $this->sn,
            'content' => $content,
            'times' => $times
        ];
        $client = new HttpClientService(self::IP, self::PORT);
        $client->post(self::PATH, $data);
        $res = json_decode($client->getContent(), true);
        if ($res['ret'] == 0) {
            //添加成功
            $add_data = [
                'sn' => $this->sn,
                'content' => $content,
                'times' => $times,
                'return_data' => json_encode($res),
                'orderid' => $res['data'],
                'status' => PrinterFeieMsgModel::STATUS_YES,
                'create_time' => $time,
                'update_time' => $time,
            ];
            $db = D('Printer/PrinterFeieMsg');
            $db->add($add_data);

            return self::createReturn(true, $res['data'], $res['msg']);
        } else {
            $add_data = [
                'sn' => $this->sn,
                'content' => $content,
                'times' => $times,
                'return_data' => json_encode($res),
                'orderid' => $res['data'],
                'status' => PrinterFeieMsgModel::STATUS_NO,
                'create_time' => $time,
                'update_time' => $time,
            ];
            $db = D('Printer/PrinterFeieMsg');
            $db->add($add_data);

            return self::createReturn(false, $res['data'], $res['msg']);
        }
    }

    /**
     * 打印信息
     *
     * @param     $content
     * @param int $times
     * @return array
     */
    function printMsgV2(
        $user,$ukey,$sn,
        $content, $times = 1
    ) {
        $time = time();
        $data = [
            'user' => $user,
            'stime' => $time,
            'apiname' => 'Open_printMsg',
            'sig' => sha1($user . $ukey . $time),
            'sn' => $sn,
            'content' => $content,
            'times' => $times
        ];
        $client = new HttpClientService(self::IP, self::PORT);
        $client->post(self::PATH, $data);
        $res = json_decode($client->getContent(), true);
        if ($res['ret'] == 0) {
            //添加成功
            $add_data = [
                'sn' => $this->sn,
                'content' => $content,
                'times' => $times,
                'return_data' => json_encode($res),
                'orderid' => $res['data'],
                'status' => PrinterFeieMsgModel::STATUS_YES,
                'create_time' => $time,
                'update_time' => $time,
            ];
            $db = D('Printer/PrinterFeieMsg');
            $db->add($add_data);

            return self::createReturn(true, $res['data'], $res['msg']);
        } else {
            $add_data = [
                'sn' => $this->sn,
                'content' => $content,
                'times' => $times,
                'return_data' => json_encode($res),
                'orderid' => $res['data'],
                'status' => PrinterFeieMsgModel::STATUS_NO,
                'create_time' => $time,
                'update_time' => $time,
            ];
            $db = D('Printer/PrinterFeieMsg');
            $db->add($add_data);

            return self::createReturn(false, $res['data'], $res['msg']);
        }
    }

    /**
     * 删除打印队列
     *
     * @return array
     */
    function delPrinterSqs() {
        $time = time();
        $data = [
            'user' => $this->user,
            'stime' => $time,
            'apiname' => 'Open_delPrinterSqs',
            'sig' => sha1($this->user . $this->ukey . $time),
            'sn' => $this->sn,
        ];
        $client = new HttpClientService(self::IP, self::PORT);
        $client->post(self::PATH, $data);
        $res = json_decode($client->getContent(), true);
        if ($res['ret'] == 0) {
            return self::createReturn(true, $res['data'], $res['msg']);
        } else {
            return self::createReturn(false, $res['data'], $res['msg']);
        }
    }

    /**
     * 查询订单打印状态
     *
     * @param $orderid
     * @return array
     */
    function queryOrderState($orderid) {
        $time = time();
        $data = [
            'user' => $this->user,
            'stime' => $time,
            'apiname' => 'Open_queryOrderState',
            'sig' => sha1($this->user . $this->ukey . $time),
            'orderid' => $orderid,
        ];
        $client = new HttpClientService(self::IP, self::PORT);
        $client->post(self::PATH, $data);
        $res = json_decode($client->getContent(), true);
        if ($res['ret'] == 0) {
            return self::createReturn(true, $res['data'], $res['msg']);
        } else {
            return self::createReturn(false, $res['data'], $res['msg']);
        }
    }

    function queryOrderInfoByDate($date) {
        $time = time();
        $data = [
            'user' => $this->user,
            'stime' => $time,
            'apiname' => 'Open_queryOrderState',
            'sig' => sha1($this->user . $this->ukey . $time),
            'sn' => $this->sn,
            'date' => $date
        ];
        $client = new HttpClientService(self::IP, self::PORT);
        $client->post(self::PATH, $data);
        $res = json_decode($client->getContent(), true);
        if ($res['ret'] == 0) {
            return self::createReturn(true, $res['data'], $res['msg']);
        } else {
            return self::createReturn(false, $res['data'], $res['msg']);
        }
    }

    function queryPrinterStatus() {
        $time = time();
        $data = [
            'user' => $this->user,
            'stime' => $time,
            'apiname' => 'Open_queryPrinterStatus',
            'sig' => sha1($this->user . $this->ukey . $time),
            'sn' => $this->sn,
        ];
        $client = new HttpClientService(self::IP, self::PORT);
        $client->post(self::PATH, $data);
        $res = json_decode($client->getContent(), true);
        if ($res['ret'] == 0) {
            return self::createReturn(true, $res['data'], $res['msg']);
        } else {
            return self::createReturn(false, $res['data'], $res['msg']);
        }
    }
}