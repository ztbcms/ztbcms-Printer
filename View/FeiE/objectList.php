<?php if (!defined('CMS_VERSION')) {
    exit();
} ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap">
    <div style="margin: 8px;">
        <a class="btn btn-primary" href="{:U('Printer/FeiE/addObject')}">添加</a>
    </div>
    <div class="table_list">
        <table width="100%" style="text-align: center;">
            <thead>
            <tr>
                <td>名称</td>
                <td>打印机编号</td>
                <td>秘钥</td>
                <td>打印机状态</td>
                <td>添加时间</td>
                <td>更新时间</td>
                <td>操作</td>
            </tr>
            </thead>
            <volist name="data" id="r">
                <tr>
                    <td>{$r.remark}</td>
                    <td>{$r.sn}</td>
                    <td>{$r.key}</td>
                    <td>{$r.status_msg}</td>
                    <td>{:date('Y-m-d H:i',$r['create_time'])}</td>
                    <td>{:date('Y-m-d H:i',$r['update_time'])}</td>
                    <td>
                        <a href="javascript:;" class="btn btn-primary test-btn" data-sn="{$r['sn']}">测试</a>
                        <a href="{:U('Printer/FeiE/msgList',['sn'=>$r['sn']])}" class="btn btn-default">发送列表</a>
                        <a href="{:U('Printer/FeiE/editObject',['id'=>$r['id']])}" class="btn btn-info">编辑</a>
                        <a class="btn btn-danger J_ajax_del" href="{:U('FeiE/delObject',array('sn'=>$r['sn']))}">删除</a>
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
                data: {sn: $(this).data('sn')},
                type: 'post',
                dataType: 'json',
                success: function (res) {
                    console.log(res);
                    if (res.status) {
                        alert('发送成功')
                    }
                }
            })
        })
    });
</script>
</body>
</html>
