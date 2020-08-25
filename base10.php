<?php

session_start();

class DB{

    private $dsn="mysql:host=location;charset=utf8;dbname=db10";
    private $root="root";
    private $password="";
    private $table;
    private $pdo;

    public function __construct($table)
    {
        $this->table=$table;
        $this->pdo=new PDO($this->dsn,$this->root,$this->password);
    }

    public function all(...$arg){
        $sql = "select * from $this->table";
        if((!empty($arg[0])) && is_array($arg[0])){
            foreach($arg[0] as $key=>$value){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            }
            $sql = $sql . "where" . implode("&&",$tmp);
        }

        if($arg[1]){
            $sql = $sql . "where" . $arg[1];
        }
        return $this->pdo->query($sql)->fetchALL();
    }

    public function count(...$arg){
        $sql = "select count(*) from $this->table";
        if((!empty($arg[0])) && is_array($arg[0])){
            foreach($arg[0] as $key=>$value){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            }
            $sql = $sql . "where" . implode("&&",$tmp);
        }

        if($arg[1]){
            $sql = $sql . "where" . $arg[1];
        }
        return $this->pdo->query($sql)->fetchcolumn();
    }

    public function find($arg){
        $sql = "select * from $this->table";
        if(is_array($arg)){
            foreach($arg as $key=>$value){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            }
            $sql = $sql . "where" . implode("&&",$tmp);
        }else{
            $sql =$sql ."where `id`='$arg'";

        }
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    public function del($arg){
        $sql = "delete * from $this->table";
        if(is_array($arg)){
            foreach($arg as $key=>$value){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            }
            $sql = $sql . "where" . implode("&&",$tmp);
        }else{
            $sql =$sql ."where `id`='$arg'";

        }
        return $this->pdo->exec($sql);
    }
    public function save($arg){
        if(!empty($arg['id'])){
            //update
            foreach($arg as $key=>$value){
                if($key !='id'){
                    $tmp[]=sprintf("`%s`='%s'",$key,$value);
                }  
            }
            $sql ="update $this->table set".implode("`,`",$tmp)."where `id`='".$arg['id'] ."'";
        }else{
            //insert
            $sql = "insert into $this->table (`".implode("`,`",array_keys($arg))."`) values ('".implode("`,`",$arg)."')  ";
        }
        return $this->pdo->exec($sql);
        
    }
    public function q($sql){
        return $this->pdo->query($sql)->fetchALL();
    }
}

?>