<?php

session_start();

class DB{

    private $dsn="mysql:localhost;charset:utf8;dbname:db10";
    private $root="root";
    private $password="";
    private $table;
    private $pdo;

    public function __construct($table)
    {
        $this->table=$table;
        $this->pdo=new pdo($this->dsn,$this->root,$this->password);
    }

    public function all(...$arg){
        $sql="select * fron $this->table";

        if(!empty($arg[0]) && is_array($arg[0])){
            foreach($arg[0] as $key => $value){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            }
            $sql = $sql ."where" . implode(" && ",$tmp);
        }
            
        if(!empty($arg[1])){
            $sql=$sql.$arg[1];
        }
        return $this->pdo->query($sql)->fetchall();
    }

    public function find(...$arg){
        $sql="select * fron $this->table";
        if(is_array($arg)){
            foreach($arg[0] as $key => $value){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            }
            $sql = $sql ."where" . implode(" && ",$tmp);
        }else{
            $sql = $sql ."where `id` ='$arg'" ;
        }

        return $this->pdo->query($sql)->fetch(pdo::FETCH_ASSOC);
        
    }
    
    public function count(...$arg){
        $sql="select count(*) fron $this->table";

        if(!empty($arg[0]) && is_array($arg[0])){
            foreach($arg[0] as $key => $value){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            }
            $sql = $sql ."where" . implode(" && ",$tmp);
        }
            
        if(!empty($arg[1])){
            $sql=$sql.$arg[1];
        }
        return $this->pdo->query($sql)->fetchColumn();

    }
    
    public function save(...$arg){
        if(!empty($arg['id'])){
            foreach($arg as $key =>$value){
            if($key!='id'){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            }
            $sql="update $this->table set" . implode(",",$tmp)."where `id`='".$arg['id']."'";
        }else{
            $sql="insert into $this->table (`".implode("`,`",array_keys($arg))."`) value ('".implode("','",$arg)."')"; 
        }
        return $this->pdo->exec($sql);
        
    }

    public function del(...$arg){
        $sql="delete * fron $this->table";
        if(is_array($arg)){
            foreach($arg[0] as $key => $value){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            }
            $sql = $sql ."where" . implode(" && ",$tmp);
        }else{
            $sql = $sql ."where `id` ='$arg'" ;
        }

        return $this->pdo->exec($sql);
    }

    public function q($sql){
        return $this->pdo->query($sql)->fetchall();

    }

}

?>