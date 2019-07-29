<?php
/**
 * 路径处理系统
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Service\Update;

use Home\Service\Index\RestoreLogService as Log;
use Home\Common\Utility\DetectionUtility as Detection;

class RestoreFileService
{

	//初始化备份包文件 与 原有文件 的数组结构
	public $fileOperation = array(
		'backUp'=>array( 
			'root_dir'=>array(), 
			'log_path'=>array(), 
			'files'=>array(), 
			'add'=>array(), 
			'back'=>array()
		),

		'old'=>array( 'root_dir'=>array(), 'files'=>array(), 'dirs'=>array() )
	);

	//备份包根目录与程序根目录的路径 参数为 2 个, 第1个是备份包的路径, 第2个是需要替换的程序的路径
	public $dirArr = array();

	//初始化路径最终结果集
	public $lastResult = array( 
		'backUpLogPathList'=>array(),		//备份文件内的全部文件列表 (结束后会被垃圾回收清除)
		'backUpFilePathList'=>array(),		//需要恢复的文件路径 (不包括文件名 创建目录的时候用)
		'mustBackUpFileList'=>array(),		//必须备份的文件列表 (最后会被压缩成zip文件备份 并写到备份日志里面)
		'mustBackUpFilePathList'=>array(),	//必须备份的文件路径 (不包括文件名 创建目录的时候用)
		'deleteFileList'=>array()			//需要删除的文件列表 (写到删除日志里面)
	);

	//备份 - 追加文件列表的日志路径
	public $addLogFilePath = '';

	//备份 - 替换文件列表的备份日志路径
	public $backUpLogFilePath = '';

	//备份 - 
	//备份的zip压缩包路径 - 压缩包信息包含
	//1 需要替换的文件
	//2 追加日志
	//3 替换日志
	public $backUpPackFilePath = '';

	//构造
	public function __construct( $pArr ) {
		if ( false == empty( $pArr )) {
			$this->dirArr = $pArr;
			$this->readBackUpLogProcess();

			$pathName = array_keys( $this->fileOperation );
			$this->myReaddir( $this->dirArr[1], $pathName[1] );

			//匹配最终操作路径结果集
			$this->fileReplace(
				$this->fileOperation['backUp'],
				$this->fileOperation['old']['root_dir'][0]
			);

			//读取真实备份文件到 fileOperation['backUp']['files']
			$this->readAllFile( $this->dirArr[0] );

			//对比备份日志与备份文件是否相同
			$this->replaceLogAndBackUp();
		
			//对比备份日志和追加日志与要恢复的项目目录文件是否相同
			$bool = $this->replaceLogAndProject();
			dump( $bool );

		}
	}

	//读取备份日志信息流程
	public function readBackUpLogProcess() {
		$data = $this->searchBackUpAndAddLog( $this->dirArr[0] );
		$this->readPath( $data );
		$this->fileOperation['backUp']['root_dir'] = $this->dirArr[0];
	}

	//对比备份日志与备份文件是否相同
	public function replaceLogAndBackUp() {
		$countLogs = count( $this->fileOperation['backUp']['back'] );
		$countFiles = count( $this->fileOperation['backUp']['files'] );
		$result = array_intersect(
			$this->fileOperation['backUp']['back'],
			$this->fileOperation['backUp']['files']
		);

		$countResult = count($result);
		if ( $countResult != $countLogs || $countResult != $countFiles ) 
			return false;

		return true;
	}

	//对比备份日志和追加日志与要恢复的项目目录文件是否相同
	public function replaceLogAndProject() {
		$countLogs = count( $this->fileOperation['backUp']['log_path'] );
		$countFiles = count( $this->fileOperation['old']['files'] );
		$result = array_intersect(
			$this->fileOperation['backUp']['log_path'],
			$this->fileOperation['old']['files']
		);

		$countResult = count($result);
		if ( $countResult != $countLogs ) 
			return false;

		return true;
	}

	//打开文件并读取文件路径
	public function readPath( $pFileArr ) {
		foreach ( $pFileArr as $value ) {
			strstr( $value, 'add' )
				? $this->fileOperation['backUp']['add'] = $this->readFile( $value, $this->dirArr[1] )
				: $this->fileOperation['backUp']['back'] = $this->readFile( $value, $this->dirArr[1] );
			
			$allFile = array_merge_recursive( 
				$this->fileOperation['backUp']['add'], 
				$this->fileOperation['backUp']['back'] 
			);
			$this->fileOperation['backUp']['log_path'] = $allFile;
		}
	}

	//扫描备份日志与追加日志里面的文件路径
	public function searchBackUpAndAddLog( $pDir ) {
		$handle = opendir( $pDir );
        //循环资源文件
	    while ( false !== ( $file = readdir( $handle ))) {
	    	//跳过不需要检测的文件
	        if ( $file == '.' || $file == '..' )
	        	continue;
	        //递归检测目录
	        $path = rtrim( $pDir, '/' ).'/'.$file;

			$fileAttr = pathinfo( $file );
			if ( $fileAttr['extension'] == 'log' )
				$data[] = $path;
	    }
	    closedir( $handle ); 
	    return $data;
	}

	//设置追加文件列表日志路径
	public function setAddLogPath( $pAddLogPath ) {
		$this->addLogFilePath = $pAddLogPath;
	}

	//设置备份文件列表日志路径
	public function setBackUpLogPath( $pBackUpLogPath ) {
		$this->backUpLogFilePath = $pBackUpLogPath;
	}

	//设置备份压缩包路径
	public function setBackUpZipPath( $pBackUpPath ) {
		$this->backUpPackFilePath = $pBackUpPath;
	}	

	//添加文件到备份列表
	public function pushBackUpList( $pFilePath ) {
		$this->lastResult['backUpFileList'][] = $pFilePath;
	}

	/**
	 * 获取目录下所有文件的路径
	 * [myReaddir get path infor on files and dirs]
	 * @param  [string] $dir     [any path]
	 * @param  [array] $arrName [case: 'name'=>array( 'root_dir'=>array(), files'=>array(), 'dirs'=>aray() )]
	 * @return [array] $fileOperation [path infor the files and dirs]
	 */
	private function myReaddir( $dir, $arrName ) {
		
		static $i = 0;

		//将文件根目录提取出来添加到数组里
		if ( $i == 0 ) {
			$dir == './' ? $tmpDir = $dir : $tmpDir = rtrim( $dir, '/' ).'/';
			$this->fileOperation[$arrName]['root_dir'][] = $tmpDir;
		}

		if ( false == is_dir( $dir ))
			Log::inforReceive( __METHOD__.' '.__LINE__.' '.$dir.'|'.$arrName, 4 );	//错误报告

	    if ( false == ( $handle = opendir( $dir )))
        	Log::inforReceive( __METHOD__.' '.__LINE__.' '.$path.'|'.$arrName, 2 );

        //循环资源文件
	    while ( false !== ( $file = readdir( $handle ))) {
	    	//跳过不需要检测的文件
	        if (( $file == "." || $file == ".." || in_array( $file, $this->strConversionArr( IGNORE_FILES ) )))
	        	continue;
	        
	        //拼接地址
	        $path = rtrim( $dir, '/' ).'/'.$file;
	        //跳过不需要检测的目录
	        if ( $arrName == 'old' && in_array( $dir, $this->strConversionArr( IGNORE_DIRS ) ))
	        	continue;
	        //递归检测目录
	        if ( is_dir( $path )) {
	        	$i++;
	        	$this->myReaddir( $path, $arrName );
	        }

	        //分类文件与文件夹
	        is_dir( $path )
	        	? $this->fileOperation[$arrName]['dirs'][] = str_replace( $this->fileOperation[$arrName]['root_dir'][0], '', $path )
	        	: $this->fileOperation[$arrName]['files'][] = str_replace( $this->fileOperation[$arrName]['root_dir'][0], '', $path );

	    }

		$i = 0;
	    closedir( $handle ); 

	    return $this->fileOperation;	//虽然不用返回,这样写方便读和以后用

	}

	//设置需要替换的文件和目录,追加的文件和目录,还有需要更新的全部文件
	private function fileReplace( $pArr1, $pOldRootDir ) {
		$this->lastResult['backUpLogPathList']=$this->addPathToArr( $pArr1['log_path'], $pArr1['root_dir'] );
		$this->lastResult['backUpFilePathList']=$this->addPathToArr( $pArr1['back'], $pArr1['root_dir'] );
		$this->lastResult['mustBackUpFileList']=$this->addPathToArr( $pArr1['log_path'], $pOldRootDir );
		$backUpPath = $this->addPathToArr( $pArr1['log_path'], $pOldRootDir );
		$this->lastResult['mustBackUpFilePathList'] = $this->distinctPath( $backUpPath );
		$this->lastResult['deleteFileList']=$this->addPathToArr( $pArr1['log_path'], $pOldRootDir );
	}

	//去掉文件名,去掉重复的路径并返回
	private function distinctPath( $pFilePathArr ) {
		$tmpArr = array();
		foreach ( $pFilePathArr as $value )
			$tmpArr[] = dirname( $value );
		return array_unique( $tmpArr );
	}

	//字符串转换数组
	private function strConversionArr( $pStr, $pChar = ',' ) {
		return explode( $pChar, trim( $pStr ));
	}

	//读取文件内容 - 并清除备份路径 - 方便对比路径 - 只为本类用
	private function readFile( $pFile, $pPath ) {
		$handle = fopen( $pFile, "rb" );
        while ( !feof( $handle )){
            $tData = fgets( $handle );
            if ( $tData ) {
            	$data[] = trim( str_replace( $pPath, '', $tData ));
            }
        }
        fclose( $handle );
        return $data;
	}

	//添加路径信息到指定数组
	private function addPathToArr( $pFilePathArr, $pPath ) {
		foreach ( $pFilePathArr as $key=>$value )
			$pFilePathArr[$key] = $pPath.$value;
		return $pFilePathArr;
	}

	//读取所有备份文件到 $this->fileOperation['backUp']['files'] 数组中 并去除备份文件临时路径
	private function readAllFile( $pDir ) {
	    $handle = opendir( $pDir );
        //循环资源文件
	    while ( false !== ( $file = readdir( $handle ))) {
	    	//跳过不需要检测的文件
	        if ( $file == '.' || $file == '..' )
	        	continue;
	        //递归检测目录
	        $path = rtrim( $pDir, '/' ).'/'.$file;
	        if ( is_dir( $path ))
	        	$this->readAllFile( $path );

	        $fileAttr = pathinfo( $file );
	        if ( is_file( $path ) && $fileAttr['extension'] != 'log' )
				$this->fileOperation['backUp']['files'][] = str_replace( $this->dirArr[0], '', $path );
	    }
	    closedir( $handle ); 
	    return $data;
	}


}