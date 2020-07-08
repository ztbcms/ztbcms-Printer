<?php
/**
 * Created by PhpStorm.
 * User: zhlhuang
 * Date: 22/05/2018
 * Time: 18:43
 */
namespace Printer\Controller;

use Common\Controller\AdminBase;
use Printer\Service\FeiEService;

class FeiEController extends AdminBase {
    protected function _initialize() {
        parent::_initialize();
    }

    function msgList() {
        $where = I('sn') ? ['sn' => I('sn')] : [];
        $page = I('page', 1);
        $db = D('Printer/PrinterFeieMsg');
        $count = $db->count();
        $pageObject = $this->page($count, 20, $page);
        $data = $db->where($where)->limit($pageObject->firstRow . ',' . $pageObject->listRows)->order(array("id" => "DESC"))->select();
        $this->assign('data', $data);
        $this->assign('Page', $pageObject->show());
        $this->assign('sn', I('sn'));
        $this->display('msgList');
    }

    /**
     * 删除打印机
     */
    function delObject() {
        $sn = I('sn');
        if (!$sn) {
            $this->error('请选择sn');
        }
        $printer = new FeiEService($sn);
        $printer->printerDel();
        $db = D('Printer/PrinterFeieObject');
        $res = $db->where(['sn' => $sn])->delete();
        if ($res) {
            $this->success('删除成功');
        } else {
            $this->error('没有删除记录');
        }
    }

    /**
     * 编辑打印机
     */
    function editObject() {
        $id = I('id');
        if (IS_POST) {
            $remark = I('post.remark');
            $sn = I('post.sn');
            $printer = new FeiEService($sn);
            $res = $printer->printerEdit($remark);
            if (!$res['status']) {
                $this->error($res['msg']);
            }
            $data = [
                'remark' => $remark,
                'sn' => $sn,
                'update_time' => time()
            ];
            $db = D('Printer/PrinterFeieObject');
            $res = $db->where(['id' => $id])->save($data);
            if ($res) {
                //获取打印机状态
                $status_res = $printer->queryPrinterStatus();
                if ($status_res['status']) {
                    $db->where(['id' => $res])->save(['status_msg' => $status_res['data']]);
                } else {
                    $db->where(['id' => $res])->save(['status_msg' => $status_res['msg']]);
                }
                $this->success('添加成功');
            } else {
                $this->error('添加失败');
            }
        } else {
            $db = D('Printer/PrinterFeieObject');
            $res = $db->find($id);
            $this->assign('data', $res);
            $this->display('editObject');
        }
    }

    /**
     * 添加打印机
     */
    function addObject() {
        if (IS_POST) {
            $remark = I('post.remark');
            $sn = I('post.sn');
            $key = I('post.key');
            $printer = new FeiEService($sn);
            $res = $printer->printerAdd($key, $remark);
            if (!$res['status']) {
                $this->error($res['msg']);
            }
            if ($res['status']) {
                $this->success('添加成功');
            } else {
                $this->error('添加失败');
            }
        } else {
            $this->display('addObject');
        }
    }

    function objectList() {
        $page = I('page', 1);
        $db = D('Printer/PrinterFeieObject');
        $count = $db->count();
        $pageObject = $this->page($count, 20, $page);
        $data = $db->limit($pageObject->firstRow . ',' . $pageObject->listRows)->order(array("id" => "DESC"))->select();
        foreach ($data as &$val) {
            $printer = new FeiEService($val['sn']);
            $status_res = $printer->queryPrinterStatus();
            if ($status_res['status']) {
                $db->where(['id' => $val['id']])->save(['status_msg' => $status_res['data']]);
            } else {
                $db->where(['id' => $val['id']])->save(['status_msg' => $status_res['msg']]);
            }
            $val['status_msg'] = $status_res['data'];
        }
        $this->assign('data', $data);
        $this->assign('Page', $pageObject->show());
        $this->display('objectList');
    }

    function delApp() {
        $id = I('id');
        if (!$id) {
            $this->error('请选择id');
        }
        $db = D('Printer/PrinterFeieApp');
        $res = $db->where(['id' => $id])->delete();
        if ($res) {
            $this->success('删除成功');
        } else {
            $this->error('没有删除记录');
        }
    }

    function editApp() {
        $id = I('id');
        if (!$id) {
            $this->error('请选择编辑id');
        }
        if (IS_POST) {
            $user = I('post.user');
            $ukey = I('post.ukey');
            $is_default = I('post.is_default');
            $data = [
                'user' => $user,
                'ukey' => $ukey,
                'is_default' => $is_default,
                'update_time' => time()
            ];
            $db = D('Printer/PrinterFeieApp');
            $res = $db->where(['id' => $id])->save($data);
            if ($res) {
                if ($is_default) {
                    D('Printer/PrinterFeieApp')->where(['id' => ['neq', $id]])->save(['is_default' => 0]);
                }
                $this->success('更新成功');
            } else {
                $this->error('没有更新');
            }
        } else {
            $res = D('Printer/PrinterFeieApp')->find($id);
            $this->assign('data', $res);
            $this->display('editApp');
        }
    }

    function addApp() {
        if (IS_POST) {
            $user = I('post.user');
            $ukey = I('post.ukey');
            $is_default = I('post.is_default');
            $data = [
                'user' => $user,
                'ukey' => $ukey,
                'is_default' => $is_default,
                'create_time' => time(),
                'update_time' => time()
            ];
            $db = D('Printer/PrinterFeieApp');
            $res = $db->add($data);
            if ($res) {
                if ($is_default) {
                    D('Printer/PrinterFeieApp')->where(['id' => ['neq', $res]])->save(['is_default' => 0]);
                }
                $this->success('添加成功');
            } else {
                $this->error('添加失败');
            }
        } else {
            $this->display('addApp');
        }
    }

    function appSetting() {
        $page = I('page', 1);
        $db = D('Printer/PrinterFeieApp');
        $count = $db->count();
        $pageObject = $this->page($count, 20, $page);
        $data = $db->limit($pageObject->firstRow . ',' . $pageObject->listRows)->order(array("id" => "DESC"))->select();
        $this->assign('data', $data);
        $this->assign('Page', $pageObject->show());
        $this->display('appSetting');
    }

    function test() {
        $sn = I('sn');
        if (I('msgid')) {
            $db = D('Printer/PrinterFeieMsg');
            $msg = $db->find(I('msgid'));
            $sn = $msg['sn'];
            $orderInfo = $msg['content'];
            $times = $msg['times'];
        } else {
            $times = 1;
            $orderInfo = '<CB>主题邦外卖</CB><BR>';
            $orderInfo .= '名称　　　　　 单价  数量 金额<BR>';
            $orderInfo .= '--------------------------------<BR>';
            $orderInfo .= '饭　　　　　 　10.0   10  10.0<BR>';
            $orderInfo .= '备注：加辣<BR>';
            $orderInfo .= '--------------------------------<BR>';
            $orderInfo .= '合计：100.0元<BR>';
            $orderInfo .= '送货地点：广州市海珠区中洲交易中心1610<BR>';
            $orderInfo .= '联系电话：13800138000<BR>';
            $orderInfo .= '订餐时间：' . date('Y-m-d H:i:s') . '<BR>';
            $orderInfo .= '<QR>http://imgs.ztbopen.cn/qrcode/151678386284.png</QR>';//把二维码字符串用标签套上即可自动生成二维码
        }

        $fei = new FeiEService($sn);
        $res = $fei->printMsg($orderInfo, $times);
        $this->ajaxReturn($res);
    }
}