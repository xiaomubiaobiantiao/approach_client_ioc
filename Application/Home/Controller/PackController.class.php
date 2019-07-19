<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Controller;

use Think\Controller;
use Home\Service\Pack\PackService;

class PackController extends Controller  //\Home\Controller\IndexController 获得权限用
{

	private $packService; //压缩包服务类

	public function __construct() {
		//为了加载权限管理
		parent::__construct();
		//初始化压缩包服务类
		$this->PackService = new PackService();
	}

	//判断数据列表
	public function dataList() {
		$str = '__CLASS__';
		$str_a = trim( $str, "'" );
		$a = '$str';
		$str_c = trim( $str, "'" );
		dump( $str_c );
		$str_b = __CLASS__;
		echo gettype(__METHOD__);
		echo __METHOD__;
		dump( $str_b );
		die();
		$typeId = I( 'type_id' );
		empty( $typeId )
			? $this->index()
			: $this->typeDataList();
	}

	//分类数据
	public function typeDataList() {
		$typeId = I( 'type_id' );
		$typeDataList = $this->PackService->dataCollection( $typeId );
		$this->assign( 'datalist', $typeDataList );
		$this->display( 'Pack/index' );
	}

	//主页面 - 视图
	public function index() {
		//下面赋值依次为类别,当前类别相关数据
		$datalist[] = $this->PackService->getSystemTypeList();
		$datalist[] = $this->PackService->getDataList();
		$this->assign( 'datalist', $datalist );
		$this->display( 'Pack/index' );
	}

	//下载压缩包
	public function downloadPack() {
		$data = I( 'get.' );
		$this->PackService->download( $data['id'] );
		$typeDataList = $this->PackService->dataCollection( $data['type_id'] );
		$this->assign( 'datalist', $typeDataList );
		$this->display( 'Pack/index' );
	}

	//刪除
	public function del() {
		$id = I( 'id' );
		$result = $this->PackService->deleteData( $id );
	}

	//跳转提示 - 暂时未写
	public function tips( $pTips, $pStr='' ) {
		FALSE == $pTips
			? $this->error( $pStr.'失败' )
			: $this->success( $pStr.'成功' );
	}

	//查看
	public function check() {
		echo '页面未开放';
		//$this->display();
	}



}