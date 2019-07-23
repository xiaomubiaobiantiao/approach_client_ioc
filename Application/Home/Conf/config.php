<?php
//UPDATE_PATH 常量值 路径后面必须加 / 符号	********
//UPLOAD_PATH  常量值 路径后面必须加 / 符号	********
//BACKUP_PACK 常量值 路径后面必须加 / 符号	********
//BACKUP_TMP_PACK 常量值 路径后面必须加 / 符号	********
//UNPACK_TMP_PATH 常量值 路径后面必须加 / 符号	********
//LOG_PATH 常量值 路径后面必须加 / 符号	********

//文件更新的路径
//define( 'UPDATE_PATH', './' );
define( 'UPDATE_PATH', 'D:/phpStudy/PHPTutorial/WWW/approach_test/' );

//压缩包文件下载路径
define( 'UPLOAD_PATH', 'Public/files/uploads_pack/' );

//文件压缩包备份的路径 里面包含需要备份的文件和更新时追加的文件的记录文档
define( 'BACKUP_PATH', 'Public/files/backup_pack/' );

//文件备份的临时路径 最后会被自动删除
define( 'BACKUP_TMP_PATH', 'Public/files/backup_tmp_pack/' );

//文件解压缩的临时路径 最后会被自动删除
define( 'UNPACK_TMP_PATH', 'Public/files/update_tmp_pack/' );

//文件日志的路径
define( 'LOCAL_LOG_PATH', 'Public/files/logs/' );



//排除检测的目录  常值值字符串 ,号中间不能有空格, 路径末尾不能有 / 符号
define( 'IGNORE_DIRS', 'Public/files,ThinkPHP,Public/Ueditor,Application/Runtime' );

//排除检测的文件  常值值字符串 ,号中间不能有空格
define( 'IGNORE_FILES', '.git' );


//数据文本存放位置
define( 'DATABASE_TEXT', 'Public/data/database.txt' );

//当前版本位置信息
define( 'VERSION_PATH', 'Public/version.txt' );



