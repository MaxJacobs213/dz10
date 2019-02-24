<?php
Class Connect{

    public $host = 'localhost';
    public $db = 'test';
    public $user = 'root';
    public $password = '';
    public $charset = 'utf8';

    public $pdo;

    public function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $this->pdo = new PDO($dsn, $this->user, $this->password, $opt);
    }
}



Class db extends Connect{

    public $table_name = '';

    /**
     * сохранение данных в таблицу
     * @param $save ассоц массив для сохранения, ключ - название поля
     * @return bool
     */
    public function insert($save)
    {
        $save['create_at'] = Date('Y-m-d H:i:s');
        $fields = $this->set_fields($save);

        $sql = "INSERT INTO {$this->table_name} SET {$fields}";
        $rows = $this->pdo->prepare($sql);

        return $rows->execute($save);
    }


    public function update($data, $where = [])
    {
        $fields = $this->set_fields($data);
        $sql = "UPDATE `{$this->table_name}` SET ".$fields;
        if(!empty($where)){
            $fields = $this->set_fields($where, " AND ");

            $sql .= " WHERE ".$fields;
        }
        $stmt = $this->pdo->prepare( $sql );
        return $stmt->execute($data);
    }

    
    public function get_all($order = "id asc")
    {
        $sql = "SELECT * FROM {$this->table_name} ORDER BY {$order}";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function get_one($where, $order = "id asc")
    {
        $sql = "SELECT * FROM `{$this->table_name}`";
        if( count( $where) > 0 ){
            $fields = $this->set_fields($where, " AND ");

            $sql .= " WHERE ".$fields;
        }
        $sql .= " ORDER BY $order";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($where);
        $result = $stmt->fetch();

        return $result;
    }

    public function set_fields( $items, $delimiter = "," ){
        $str = array();
        if(empty($items)) return "";
        foreach ($items as $key=>$item){
            $str[] = "`".$key."`=:".$key;
        }
        return implode($delimiter, $str );
    }

    public function delete ($where)
    {
        $sql = "DELETE FROM `{$this->table_name}`";
        if (count($where) > 0) {
            $fields = $this->set_fields($where, " AND ");
            $sql .= " WHERE ".$fields;
        }
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($where);
    }
}
?>