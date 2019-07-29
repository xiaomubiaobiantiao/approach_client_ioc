<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="/Public/css/style.css" rel="stylesheet" type="text/css" />
<link href="/Public/css/select.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/jquery.idTabs.min.js"></script>
<script type="text/javascript" src="/Public/js/select-ui.min.js"></script>

<script type="text/javascript">
$(document).ready(function(e) {
    $(".select1").uedSelect({
        width : 345           
    });
    $(".select2").uedSelect({
        width : 500  
    });
    $(".select3").uedSelect({
        width : 100
    });
});
</script>
</head>

<body>

    <div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">更新/还原</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    
    <div id="usual1" class="usual"> 
    
    <div class="itab">
    <ul> 
    <li><a href="#tab1" class="selected">更新</a></li> 
    <li><a href="#tab2">还原</a></li> 
    </ul>
    </div> 
    
    <div id="tab1" class="tabson">
    
    <div class="formtext">系统 <b>当前版本</b> <?php echo ($datalist[3]); ?></div>
    
    <ul class="forminfo">
    <!--
    <li><label>招聘企业<b>*</b></label><input name="" type="text" class="dfinput" value="请填写单位名称"  style="width:518px;"/></li>
    -->

        <form id="form_type" action="<?php echo U('Home/Update/index');?>" method="get" >
        <li>
        <label>选择类别<b>*</b></label>  
        <div class="vocation">
            <select id="type" name="type_id" class="select1">
                <?php if(is_array($datalist[0])): foreach($datalist[0] as $key=>$vo): if($vo["type"] == $datalist[2]): ?><option value="<?php echo ($vo["type"]); ?>" selected ><?php echo ($vo["type_name"]); ?></option>
                    <?php else: ?>
                        <option value="<?php echo ($vo["type"]); ?>" ><?php echo ($vo["type_name"]); ?></option><?php endif; endforeach; endif; ?>
            </select>
        </div>
        </li>
        </form>
        <form action="<?php echo U( 'Home/Update/update' );?>" method="get" >
        <li>
            <label>选择版本<b>*</b></label>
            <div class="vocation">
                <select id="version" name="version_id" class="select1">
                    <?php if(is_array($datalist[1])): foreach($datalist[1] as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["pack_name"]); ?></option><?php endforeach; endif; ?>
                </select>
            </div>
        </li>

        <li><label>选择版本<b>*</b></label>
            <div class="vocation">
                <input id="submit" type="submit" value="提交" >
            </div>
        </li>
        </form>

        </ul>
        
    </div> 
    
    <!-- ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝ 还原 ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝ -->

    <div id="tab2" class="tabson">
    
    <ul class="seachform">
    
  
        <form action="<?php echo U( 'Home/Update/restore' );?>" method="get" >
        <li>
            <label>选择版本<b>*</b></label>
            <div class="vocation">
                <!--
                <select id="backup_version" name="backup_version_id" class="select2" >
                    <?php if(is_array($backuplist)): foreach($backuplist as $key=>$vo): ?><option value="<?php echo ($vo); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; ?>
                </select>
                -->
                <select id="backupath" name="backupath" class="select2" >
                <?php foreach ( $backuplist as $value ) { ?>
                    <option value="<?php echo $value ?>"><?php echo basename($value)?></option>
                <?php } ?>
                </select>
            </div>
        </li>

        <li><label>选择版本<b>*</b></label>
            <div class="vocation">
                <input type="submit" value="提交" >
            </div>
        </li>
        </form>
    
    </ul>

    </div>

    <!-- ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝ -->

    </div>
 
    <script type="text/javascript"> 
        $("#usual1 ul").idTabs(); 
    </script>
    
    <script type="text/javascript">
        $('.tablelist tbody tr:odd').addClass('odd');
    </script>
    
    <script type="text/javascript">
        /*提交类别表单*/
        $('#type').change(function(){
            //jQuery 提交表单
            $("form[id='form_type']").submit();
            //js 提交表单
            //document.getElementById("form_type").submit()
        });

    </script>
    
    
    </div>


</body>

</html>