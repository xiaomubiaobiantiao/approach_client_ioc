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
        width : 167  
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
    
    <div class="formtext">系统 <b>当前版本</b> 欢迎您试用信息发布功能！</div>
    
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
    
    <div id="tab2" class="tabson">
    
    <ul class="seachform">
    
    <li><label>综合查询</label><input name="" type="text" class="scinput" /></li>
    <li><label>指派</label>  
    <div class="vocation">
    <select class="select3">
    <option>全部</option>
    <option>其他</option>
    </select>
    </div>
    </li>
    
    <li><label>重点客户</label>  
    <div class="vocation">
    <select class="select3">
    <option>全部</option>
    <option>其他</option>
    </select>
    </div>
    </li>
    
    <li><label>客户状态</label>  
    <div class="vocation">
    <select class="select3">
    <option>全部</option>
    <option>其他</option>
    </select>
    </div>
    </li>
    
    <li><label>&nbsp;</label><input name="" type="button" class="scbtn" value="查询"/></li>
    
    </ul>
    
    
    <table class="tablelist">
        <thead>
        <tr>
        <th><input name="" type="checkbox" value="" checked="checked"/></th>
        <th>编号<i class="sort"><img src="/Public/images/px.gif" /></i></th>
        <th>标题</th>
        <th>用户</th>
        <th>籍贯</th>
        <th>发布时间</th>
        <th>是否审核</th>
        <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <tr>
        <td><input name="" type="checkbox" value="" /></td>
        <td>20130908</td>
        <td>王金平幕僚：马英九声明字字见血 人活着没意思</td>
        <td>admin</td>
        <td>江苏南京</td>
        <td>2013-09-09 15:05</td>
        <td>已审核</td>
        <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink"> 删除</a></td>
        </tr> 
        
        <tr>
        <td><input name="" type="checkbox" value="" /></td>
        <td>20130907</td>
        <td>温州19名小学生中毒流鼻血续：周边部分企业关停</td>
        <td>uimaker</td>
        <td>山东济南</td>
        <td>2013-09-08 14:02</td>
        <td>未审核</td>
        <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink">删除</a></td>
        </tr>
        
        <tr>
        <td><input name="" type="checkbox" value="" /></td>
        <td>20130906</td>
        <td>社科院:电子商务促进了农村经济结构和社会转型</td>
        <td>user</td>
        <td>江苏无锡</td>
        <td>2013-09-07 13:16</td>
        <td>未审核</td>
        <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink">删除</a></td>
        </tr>
        
        <tr>
        <td><input name="" type="checkbox" value="" /></td>
        <td>20130905</td>
        <td>江西&quot;局长违规建豪宅&quot;：局长检讨</td>
        <td>admin</td>
        <td>北京市</td>
        <td>2013-09-06 10:36</td>
        <td>已审核</td>
        <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink">删除</a></td>
        </tr>
        
        <tr>
        <td><input name="" type="checkbox" value="" /></td>
        <td>20130907</td>
        <td>温州19名小学生中毒流鼻血续：周边部分企业关停</td>
        <td>uimaker</td>
        <td>山东济南</td>
        <td>2013-09-08 14:02</td>
        <td>未审核</td>
        <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink">删除</a></td>
        </tr>
    
        </tbody>
    </table>
    
   
  
    
    </div>  
       
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