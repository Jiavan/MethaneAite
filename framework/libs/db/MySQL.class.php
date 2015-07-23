<?php
/**
 * Created by PhpStorm.
 * User: jiavan
 * Date: 15-7-21
 * Time: 下午11:44
 * Content: MySQL操作库
 */

class MySQL {

    /**
     * 报错函数
     * @param string $error 错误信息
     */
    function err($error){
        die("操作有误，错误原因为：".$error);//die有两种作用， 输出和终止相当于echo 和 exit的组合
    }

    /**
     * 数据库链接函数
     * @param array() $config
     */
    function connect($config){
        extract($config);

        if(!($con = mysql_connect($dbhost, $dbuser, $dbpsw))){//mysql链接数据库
            $this->err(mysql_error());//输出错误信息
        }

        if(!mysql_select_db($dbname, $con)){//选择数据库
            $this->err(mysql_error());
        }
        mysql_query("set names ".$dbcharset);//设置数据库查询字符集
    }

    /**
     * SQL语句执行函数
     * @param string $sql
     * @return bool resource
     */
    function query($sql){
        if(!($query = mysql_query($sql))){//使用mysql查询函数
            $this->err("sql: $sql<br />".mysql_error());//错误信息
        }else{
            return $query;
        }
    }

    /**
     * 查询全部结果
     * @param source $query 由mysql_query查询出来的结果集
     * @return array|null  返回二维数组或NULL
     */
    function findAll($query){
        while($rs = mysql_fetch_array($query, MSSQL_ASSOC)){//将结果集里面的资源转换成为数组
            $list[] = $rs;
        }

        return isset($list)?$list:NULL;//当结果集为空时返回NULL否则返回二维数组
    }

    /**
     * 查询一条记录
     * @param source $query 由mysql_query查询出来的结果集
     * @return array|null
     */
    function findOne($query){
        $rs = mysql_fetch_array($query, MYSQL_ASSOC);
        return isset($rs)?$rs:NULL;//当结果集为空时返回NULL否则返回一维数组
    }

    /**
     * 插入操作
     * @param string $table 表名
     * @param array() $arr 关联数组
     * @return bool
     */
    function insert($table, $arr){
        foreach($arr as $key=>$value){//将数组中的键值对遍历出来
            $value = mysql_real_escape_string($value);//处理mysql中特殊的字符
            $keyArr[] = "`".$key."`";//键名加上`符号区分sql关键字
            $valueArr[] = "'".$value."'";//值加上单引号，插入语句中多为字符串，不加''会出现错误
        }

        $keys = implode(',', $keyArr);//用逗号分割字段名称成字符串
        $values = implode(',', $valueArr);//用逗号分割成值字符串
        $sql = "insert into ".$table."(".$keys.") values (".$values.")";

        return $this->query($sql);
    }

    /**
     * 更新操作
     * @param string $table 表名
     * @param array() $arr 更改关联数组
     * @param string $where 条件
     * @return bool
     */
    function update($table, $arr, $where){
        foreach ($arr as $key=>$value) {
            $value = mysql_real_escape_string($value);
            $keyAndValueArr[] = "`".$key."`='".$value."'";//更改字段，值对应`key`='value'
        }

        $keyAndValues = implode(',', $keyAndValueArr);
        $sql = "update ".$table." set".$keyAndValues." where ".$where;

        return $this->query($sql);
    }

    /**
     * 删除数据操作
     * @param string $table 表名
     * @param string $where 删除位置
     * @return bool
     */
    function del($table, $where){
        $sql = "delete from ".$table." where ".$where;
        return $this->query($sql);
    }
}
?>