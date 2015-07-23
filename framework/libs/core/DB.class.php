<?php
/**
 * Created by PhpStorm.
 * User: jiavan
 * Date: 15-7-22
 * Time: 下午10:56
 * Content: 数据库工厂类, 规定了统一的数据库操作函数接口
 */

class DB {
    public static $db;

    /**
     * 数据库引擎初始化函数
     * @param string $dbtype 数据库类型如MySQL
     * @param array() $dbconfig 数据库配置数组
     */
    public static function init($dbtype, $dbconfig){
        self::$db = new $dbtype;
        self::$db->connect($dbconfig);
    }

    /**
     * 数据库引擎查询函数
     * @param string $sql
     * @return mixed
     */
    public static function query($sql){
        return self::$db->query($sql);
    }

    /**
     * 查询全部数据函数
     * @param string $sql
     * @return mixed
     */
    public static function findAll($sql){
        $query = self::$db->query($sql);//执行查询函数并返回到查询结果集
        return self::$db->findAll($query);//通过db类中的方法返回
    }

    /**
     * 查询一条记录
     * @param string $sql
     * @return mixed
     */
    public static function findOne($sql){
        $query = self::$db->query($sql);
        return self::$db->findOne($query);
    }

    /**
     * 插入操作
     * @param string $table 表名
     * @param array() $arr 插入关联数组
     * @return mixed
     */
    public static function insert($table, $arr){
        return self::$db->insert($table, $arr);
    }

    /**
     * 更新操作
     * @param string $table
     * @param array() $arr
     * @param string $where 更新条件
     * @return mixed
     */
    public static function update($table, $arr, $where){
        return self::$db->update($table, $arr, $where);
    }

    /**
     * 删除操作
     * @param string $table
     * @param string $where 删除条件
     * @return mixed
     */
    public static function del($table, $where){
        return self::$db->del($table, $where);
    }
}