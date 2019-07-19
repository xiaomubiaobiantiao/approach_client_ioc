<?php
/**
 * 文本转换数据模型类 - 此类未真正继承 Model 模型(只是模拟), 用法与普通类一致
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Model;

use Home\Common\Model\CommonModel;

class PackModel extends CommonModel
{

	//全部数据
	public $data = array();

	//每次创建一个此类(new)初始化一次数据库(将文本转换成数组赋值给$data)
	public function __construct() {
		$this->data = $this->textToData();
	}

	//生成系统类型列表
	public function systemTypeList() {
		$num = array();
		$data = array();
		foreach ( $this->data as $key=>$value ) {
			if ( $key == 0 ) {
				$num[] = $value['type'];
				$data[$key]['type'] = $value['type'];
				$data[$key]['type_name'] = $value['type_name'];
				continue;
			}

			if ( false == in_array( $value['type'], $num )) {
				$num[] = $value['type'];
				$data[$key]['type'] = $value['type'];
				$data[$key]['type_name'] = $value['type_name'];
			}
		}
		return $data;
	}

	//生成与系统类型相匹配的数据列表
	public function typeDataList() {
		foreach ( $this->data as $value )
			$data[$value['type']][] = $value;
		return $data;
	}

	//将文本转换成数据
	public function textToData() {
		$dataName = array( 'id','pack_name','type','type_name','download','status', 'add_time' );

		$data = array();
		$fopen = fopen( DATABASE_TEXT, "rb" );
        while ( !feof( $fopen )){
            $tData = fgets( $fopen );
            $dataValue = explode( '<|>', $tData );
            $data[] = array_combine( $dataName, $dataValue );
        }
        fclose( $fopen );
        return $data;
	}

	//------------------------------------------------------------------------------------------
	//获取单个更新包路径
	public function getPackPath( $pId ) {
		foreach ( $this->data as $key=>$value ) {
			if ( strcmp( $value['id'], $pId ) == 0 )
				return $dataFilePath = rtrim( $value['download'], '/' ).'/'.$value['pack_name'];
		}
	}

	//设置压缩包下载状态改为 1 已下载
	public function setStatusValue_1( $pId ) {
		foreach ( $this->data as $key=>$value ) {
			if ( strcmp( $pId, $value['id'] ) == 0 )
				$this->data[$key]['status'] = 1;
		}
		$this->dataToText();
	}

	//设置压缩包下载状态改为 0 未下载
	public function setStatusValue_0( $pId ) {
		foreach ( $this->data as $key=>$value ) {
			if ( strcmp( $pId, $value['id'] ) == 1 )
				$this->data[$key]['status'] = 0;
		}
		$this->dataToText();
	}

	//将数据写入到文本
	public function dataToText() {
		$fopen = fopen( DATABASE_TEXT, "w" );
        foreach( $this->data as $value ) {
        	$data = $this->arrToStr( $value );
			fwrite( $fopen, $data );
        }
        fclose( $fopen );
	}

	//删除本地更新包
	public function deletePack( $pPath ) {
		return unlink( $pFile );
	}

	//数组转换成字符串 - 
	public function arrToStr( $pArr, $pChar = '<|>' ) {
		$data = array_values( $pArr );
		return implode( $pChar, $data );
	}


	//------------------------------------------------------------------------------------------

	// protected $pk = 'id';

	// protected $autoinc = true;

	// protected $trueTableName = 'file_pack_infor';

	// protected $fields = array(
	// 	'id', 'pack_name', 'path', 'relative_path', 'download', 'user', 'type', 'type_name', 'add_time', 'update_time',

	// 	//提供类型, 以供某些验证用, 目前未用到
	// 	'_type'=>array(
	// 		'id'=>'int', 'pack_name'=>'varchar', 'path'=>'varchar',
	// 		'relative_path'=>'varchar', 'download'=>'varchar', 'user'=>'varchar',
	// 		'type'=>'tinyint', 'type_name'=>'varchar', 'add_time'=>'int', 'update_time'=>'int'
	// 	)

	// );




}
