<?php

session_start();

class DB{

    private $dsn="mysql:host=localhost,charset=utf8,dbname=db10"; 
    private $root="root";
    private $password="";
    private $pdo;
    private $table;

    public function __construct($table)
    {
        $this->table=$table;
        $this->dsn=new PDO($this->dsn,$this->root,$this->password);
    }


    public function all(...$arg){
        $sql = "select * from $this->this ";
        if(!empty($arg[0]) && is_array($arg[0])){
            foreach($arg[0] as $key=>$value){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            } 
            $sql = $sql . "where" . implode("&&",$tmp);
        }
        if(!empty($arg[1])){
            $sql = $sql . $arg[1];
        }
        return $this->pdo->query($sql)->fetchAll();
    }
    public function count(...$arg){
        $sql = "select count(*) from $this->this ";
        if(!empty($arg[0]) && is_array($arg[0])){
            foreach($arg[0] as $key=>$value){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            } 
            $sql = $sql . "where" . implode("&&",$tmp);
        }
        if(!empty($arg[1])){
            $sql = $sql . $arg[1];
        }
        return $this->pdo->query($sql)->fetchcolumn();
    }
    public function find($arg){
        $sql = "select * from $this->this ";
        if(is_array($arg)){
            foreach($arg as $key=>$value){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            } 
            $sql = $sql . "where" . implode("&&",$tmp);
        }else{
            $sql = $sql . "where `id`='$arg'";
        }
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    public function del($arg){
        $sql = "delete * from $this->this ";
        if(is_array($arg)){
            foreach($arg as $key=>$value){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            } 
            $sql = $sql . "where" . implode("&&",$tmp);
        }else{
            $sql = $sql . "where `id`='$arg'";
        }

        return $this->pdo->exec($sql);
    }
    public function save($arg){
        if(!empty($arg['id'])){
            foreach($arg as $key=>$value){
                if($key!=`id`){
                    $tmp[]=sprintf("`%s`='%s'",$key,$value);
                }
            }
        }else{
            $sql = "insert into $this->table set  (`".implode("','",array_keys($arg))."`) values  ('".implode("','",$arg)."') ";
        }
        return $this->pdo->exec($sql);
    }
    public function q($sql){
        return $this->pdo->query($sql)->fetchAll();
    }
}
