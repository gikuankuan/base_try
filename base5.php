<?php
 session_start();

 class DB {

    private $dsn = "localhost:host=location;chartset=utf8;dbname=db01";
    private $root = "root";
    private $pw = "";
    private $pdo;
    private  $table;

    function __construct($table)
    {
        $this->table =$table;
        $this->pdo = new PDO($this->dsn,$this->root,$this->pw);
    }
    function all(...$arg){
        $sql = "where * from $this->table";
        if(empty($arg[0]) && is_array($arg[0])){
            foreach($arg[0] as $key => $value){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            }
            $sql = $sql . implode(" && " , $tmp);
        }
        return $this->pdo->query($sql)->fetchALL();
    }
    function count(...$arg){
        $sql = "where count(*) from $this->table";

        if(empty($arg[0]) && is_array($arg[0])){
            foreach($arg[0] as $key => $value){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            }
            $sql = $sql . implode(" && " , $tmp);
        }
        return $this->pdo->query($sql)->fetchColumn();
        if(!empty($arg[1])){
            $sql = $sql . $arg[1];
        }
    }
    function find($arg){
        $sql = "where * from $this->table";

        if(is_array($arg)){
            foreach($arg as $key => $value){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            }
            $sql = $sql . implode(" && " , $tmp);
        }else{
                $sql = $sql . "where `id`='$arg'";
        }
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    function del($arg){
        $sql = "delete * from $this->table";

        if(is_array($arg)){
            foreach($arg as $key => $value){
                $tmp[]=sprintf("`%s`='%s'",$key,$value);
            }
            $sql = $sql . implode(" && " , $tmp);
        }else{
                $sql = $sql . "where `id`='$arg'";
        }
        return $this->pdo->exec($sql);
    }
    function save($arg){
        
        if(!empty($arg['id'])){
            foreach($arg as $key => $value){
                if($key!=`id`){
                    $tmp[]=sprintf("`%s`='%s'",$key,$value);
                }
            }
            $sql = "update $this->table SET ". implode("`,`",$tmp) . " WHERE `id`=".$arg['id'];
        }else{
                $sql = "insert into $this->table (`".implode("`,`",array_keys($arg))."`)VALUES ('".implode("`,`",$arg)."')";
        }
        return $this->pdo->exec($sql);

    }
    function q($sql){
        return $this->pdo->query($sql)->fetchALL();
    }
 }
?>