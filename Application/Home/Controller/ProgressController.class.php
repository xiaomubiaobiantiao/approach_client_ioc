<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Controller;

use Think\Controller;

class ProgressController extends Controller
{

	//进度条首页
	public function index() {
		$this->display( 'Progress/index' );
	}




}