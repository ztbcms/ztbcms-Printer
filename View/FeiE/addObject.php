<?php if (!defined('CMS_VERSION')) {
    exit();
} ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap">
    <!--添加计划任务-->

    <Admintemplate file="Common/Nav"/>
    <div class="h_a">添加计划任务</div>
    <form class="J_ajaxForm" action="{:U('FeiE/addObject')}" method="post">
        <div class="table_full">
            <table width="100%">
                <col class="th"/>
                <col width="400"/>
                <col/>
                <tr>
                    <th>打印机名称</th>
                    <td><input type="text" class="input length_5 mr5" name="remark" value=""></td>
                    <td>
                        <div class="fun_tips"></div>
                    </td>
                </tr>
                <tr>
                    <th>打印机编码</th>
                    <td><input type="text" class="input length_5 mr5" name="sn" value=""></td>
                    <td>
                        <div class="fun_tips"></div>
                    </td>
                </tr>
                <tr>
                    <th>打印机秘钥</th>
                    <td><input type="text" class="input length_5 mr5" name="key" value=""></td>
                    <td>
                        <div class="fun_tips"></div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="">
            <div class="btn_wrap_pd">
                <button class="btn btn_submit J_ajax_submit_btn" type="submit">提交</button>
            </div>
        </div>
    </form>
    <!--结束-->
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
<script>
    $(function () {

    });
</script>
</body>
</html>
