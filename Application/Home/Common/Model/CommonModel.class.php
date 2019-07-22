<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CommonModel 
 * @基本模型(公共模型) - 目前未用
 * @author Michael
 * DateTime: 19-6-27 14:34:00
 */

namespace Home\Common\Model;

//use Think\Model;
//use Think\Model\RelationModel;

class CommonModel {
    
    /**
     * Description of getDataOne
     * @ 查找指定条件一条记录
     * @ 参数 $pCondition 条件数组 ( Array )
     */
    public function getDataOne ( $pCondition )
    {
        return $this->where( $pCondition )->find();
    }
    
    /**
     * Description of getSpecifiedConditionData
     * @ 查找指定条件全部数据 并排序
     * @ 参数 $pCondition 条件数组 ( Array )
     * @ 参数 $pField 排序字段名称和序列( 如 'name ASC' )
     */
    public function getSpecifiedConditionData ( $pCondition, $pField )
    {
        return $this->where( $pCondition )->order( $pField )->select();
    }
    
    /**
     * Description of getFieldConditionData
     * @ 查找指定条件-指定字段-全部数据
     * @ 参数 $pFields 要查询的字段( String )
     * @ 参数 $pCondition 条件数组 ( Array )
     */
    public function getFieldConditionData ( $pFields, $pCondition )
    {
        return $this->field( $pFields )->where( $pCondition )->select();
    }

    /**
     * Description of getFieldData
     * @ 查找指定字段-全部数据
     * @ 参数 $pFields 要查询的字段( String )
     */
    public function getFieldData ( $pFields )
    {
        return $this->field( $pFields )->select();
    }

    /**
     * Description of getDataList
     * @ 获取当前模型全部数据
     */
    public function getDataList ()
    {
        return $this->select();
    }
    
    /**
     * Description of setFieldAction
     * @ 更改指定条件字段值
     * @ 参数 $pCondition 条件数组 ( Array )
     * @ 参数 $pField 要更改的字段名-字符串 ( String )
     * @ 参数 $pValue 要更改的字段值-字符串 ( String )
     */
    public function setFieldAction ( $pCondition, $pField, $pValue )
    {
        return $this->where( $pCondition )->setField( $pField, $pValue );
    }

    /**
     * Description of getPageData
     * @ 按字段读取分页数据
     * @ 参数 $pField 要读取的字段-字符串 ( String )
     * @ 参数 $pLimitStat 分页起始位置-数值 ( Integer )
     * @ 参数 $pLimitNum 要读取的记录行数-数值 ( Integer )
     * @ 参数 $pOrderStr 排序规则-字符串 ( String )
     */
    public function getPageData ( $pField, $pLimitStat, $pLimitNum, $pOrderStr )
    {
        return $this->field( $pField )->limit( $pLimitStat, $pLimitNum )->order( $pOrderStr )->select();
    }

    /**
     * Description of getPageDataType
     * @ 按条件和字段读取分页数据
     * @ 参数 $pField 要读取的字段-字符串 ( String )
     * @ 参数 $pCondition 要读取的条件-数组 ( Array )
     * @ 参数 $pLimitStat 分页起始位置-数值 ( Integer )
     * @ 参数 $pLimitNum 要读取的记录行数-数值 ( Integer )
     * @ 参数 $pOrderStr 排序规则-字符串 ( String )
     */
    public function getPageDataType ( $pField, $pCondition, $pLimitStat, $pLimitNum, $pOrderStr )
    {
        return $this->field( $pField )->where( $pCondition )->limit( $pLimitStat, $pLimitNum )->order( $pOrderStr )->select();
    }

    /**
     * Description of getPageCount
     * @ 按条件读取数据总数
     * @ 参数 $pCondition 要读取的字段-数组 ( Array )
     */
    public function getPageCount ( $pCondition )
    {
        return $this->where( $pCondition )->count();
    }

    /**
     * Description of insertAction
     * @ 添加一条数据
     */
    public function insertAction ()
    {
        return $this->add();
    }
    
    /**
     * Description of insertData
     * @ 添加一条数据
     * @ 参数 $pData 数组 ( Array );
     */
    public function insertData ( $pData )
    {
        return $this->add( $pData );
    }

    /**
     * Description of updateAction
     * @ 更新一条数据
     */
    public function updateAction ()
    {
        return $this->save();
    }
    
    /**
     * Description of updateAction
     * @ 更新一条数据
     * @ 参数 $pData 数组 ( Array );
     */
    public function updateData ( $pData )
    {
        return $this->save( $pData );
    }

    /**
     * Description of updateConditionData
     * @ 按条件更新一条数据
     * @ 参数 $pCondition 数组 ( Array )
     * @ 参数 $pData 数组 ( Array );
     */
    public function updateConditionData ( $pCondition, $pData )
    {
        return $this->where( $pCondition )->save( $pData );
    }

    /**
     * Description of deleteAction
     * @ 删除指定条件的一条数据
     * @ 参数 $pCondition 条件数组 ( Array )
     */
    public function deleteAction ( $pCondition )
    {
        return $this->where( $pCondition )->delete();
    }
    
}

