<?php if (!defined('CMS_VERSION')) {
    exit();
} ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap">
    <!--添加计划任务-->

    <Admintemplate file="Common/Nav"/>
    <div class="h_a">添加计划任务</div>
    <form class="J_ajaxForm" action="{:U('FeiE/editApp')}" method="post">
        <div class="table_full">
            <table width="100%">
                <col class="th"/>
                <col width="400"/>
                <col/>
                <input type="hidden" name="id" value="{$data.id}">
                <tr>
                    <th>用户账号</th>
                    <td><input type="text" class="input length_5 mr5" name="user" value="{$data.user}"></td>
                    <td>
                        <div class="fun_tips"></div>
                    </td>
                </tr>
                <tr>
                    <th>用户key</th>
                    <td><input type="text" class="input length_5 mr5" name="ukey" value="{$data.ukey}"></td>
                    <td>
                        <div class="fun_tips"></div>
                    </td>
                </tr>
                <tr>
                    <th>是否默认</th>
                    <td>
                        <ul class="switch_list cc">
                            <li style="width: 60px;">
                                <label>
                                    <input type="radio" name="is_default" value="1" <if condition="$data[is_default] eq 1">checked</if> >
                                    <span>是</span></label>
                            </li>
                            <li>
                                <label>
                                    <input type="radio" name="is_default" value="0" <if condition="$data[is_default] eq 0">checked</if>>
                                    <span>否</span></label>
                            </li>
                        </ul>
                    </td>
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
