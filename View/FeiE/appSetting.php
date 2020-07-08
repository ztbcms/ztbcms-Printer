<?php if (!defined('CMS_VERSION')) {
    exit();
} ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap">
    <div style="margin: 8px;">
        <a class="btn btn-primary" href="{:U('Printer/FeiE/addApp')}">添加</a>
    </div>
    <div class="table_list">
        <table width="100%" style="text-align: center;">
            <thead>
            <tr>
                <td>用户名</td>
                <td>用户key</td>
                <td>创建时间</td>
                <td>更新时间</td>
                <td>是否默认</td>
                <td>操作</td>
            </tr>
            </thead>
            <volist name="data" id="r">
                <tr>
                    <td>{$r.user}</td>
                    <td>{$r.ukey}</td>
                    <td>{:date('Y-m-d H:i',$r['create_time'])}</td>
                    <td>{:date('Y-m-d H:i',$r['update_time'])}</td>
                    <td>{$r.is_default}</td>
                    <td>
                        <a href="{:U('Printer/FeiE/editApp',['id'=>$r['id']])}" class="btn btn-info">编辑</a>
                        <a class="btn btn-danger J_ajax_del" href="{:U('FeiE/delApp',array('id'=>$r['id']))}">删除</a>
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

    });
</script>
</body>
</html>
