<?php if (!defined('CMS_VERSION')) {
    exit();
} ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap">
    <div class="table_list">
        <div style="padding: 10px 0px;">
            <a href="javascript:history.back(-1);" class="btn btn-default">返回</a>
            打印机编号：{$sn}
        </div>
        <table width="100%" style="text-align: center;">
            <thead>
            <tr>
                <td>打印机编号</td>
                <td>发送内容</td>
                <td>发送次数</td>
                <td>订单号</td>
                <td>打印状态</td>
                <td>打印时间</td>
                <td>操作</td>
            </tr>
            </thead>
            <volist name="data" id="r">
                <tr>
                    <td>{$r.sn}</td>
                    <td>{$r.content}</td>
                    <td>{$r.times}</td>
                    <td>{$r.orderid}</td>
                    <td>{$r.status}</td>
                    <td>{:date('Y-m-d H:i',$r['create_time'])}</td>
                    <td>
                        <a href="javascript:;" class="btn btn-primary test-btn" data-msgid="{$r['id']}">发送</a>
                        <a class="btn btn-danger J_ajax_del" href="{:U('FeiE/delMsg',array('sn'=>$r['sn']))}">删除</a>
                    </td>
                </tr>
            </volist>
        </table>
        <div class="p10">
            <div class="pages"> {$Page}</div>
        </div>
    </div>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
<script>
    $(function () {
        $('.test-btn').click(function () {
            $.ajax({
                url: "{:U('Printer/FeiE/test')}",
                data: {msgid: $(this).data('msgid')},
                type: 'post',
                dataType: 'json',
                success: function (res) {
                    console.log(res);
                    if(res.status){
                        location.reload();
                    }
                }
            })
        })
    });
</script>
</body>
</html>
