<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller 
{

	//输出对话页面
	public function message() {
		$this->display( 'Common/message' );
	}


}
