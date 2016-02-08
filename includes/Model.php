<?php 
    require_once('config.php');
    require_once('helpers.php');
    require_once('QueryBuilder.php');
    require_once(__DIR__.'/../loader.php');
    class Model
    {
        use QB;
        
        public function __construct()
        {
            try {
                $this->conn = new PDO("mysql:host=".HOST.";dbname=".DBNAME.";charset=utf8", USER, PWD, [PDO::ATTR_EMULATE_PREPARES=>false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            } catch (PDOException $e) {
                echo "Error: ". $e->getMessage();
            }
        }

        public function raw($sql, $data)
        {
            $q = $this->conn->prepare($sql);
            $q->execute($data);
            if ($q) {
                return $q;
            }
        }

         
        public function findRaw($sql)
        {
            $q = $this->conn->query($sql) or die("Failed!");
            while ($r = $q->fetch(PDO::FETCH_OBJ)) {
                $data[]=$r;
            }
            return $data;
        }
         
    
        public function findAll($table)
        {
            $sql="SELECT * FROM $table WHERE deleted_at IS NULL";
            $q = $this->conn->query($sql) or die("Failed!");
            while ($r = $q->fetch(PDO::FETCH_OBJ)) {
                $data[]=$r;
            }
            return $data;
        }
         
        public function findById($id, $table)
        {
            $sql="SELECT * FROM $table WHERE id = :id AND deleted_at IS NULL LIMIT 1";
            $q = $this->conn->prepare($sql);
            $q->execute(array(':id'=>$id));
            $data = $q->fetch(PDO::FETCH_OBJ);
            return $data;
        }

        public function getByField($field, $table)
        {
            $keys = array_keys($field);
            $sql = QB::selectOrQuery($table, $keys);
            $q = $this->conn->prepare($sql);
            $q->execute($field);
            $data = $q->fetch(PDO::FETCH_OBJ);
            return $data;
        }

        public function findByField($field, $table)
        {
            $keys = array_keys($field);
            $sql = QB::selectOrQuery($table, $keys);
            $q = $this->conn->prepare($sql);
            $q->execute($field);
            $data = array();
            while ($r = $q->fetch(PDO::FETCH_OBJ)) {
                $data[]=$r;
            }
            return $data;
        }
    
        public function findFewAnd($data, $table)
        {
            $keys = array_keys($data);
            $sql = QB::selectAndQuery($table, $keys);
            $q = $this->conn->prepare($sql);
            $sth = $q->execute($data);
            /*
            while ($sth = $q->fetch(PDO::FETCH_OBJ)) {
                $data[]=$r;
            }
            return $data;
            */
            return $q->fetch(PDO::FETCH_OBJ);
        }
         
        public function update($id, $data, $table)
        {
            $keys = array_keys($data);
            $sql = QB::updateQuery($table, $keys, $id);
            $data['id'] = $id;
            $q = $this->conn->prepare($sql);
            $sth = $q->execute($data);
            if ($sth) {
                return true;
            } else {
                return false;
            }
        }
         
        public function insert($data, $table)
        {
            $data['created_at'] = get_timestamp();
            $data['updated_at'] = $data['created_at'];
            $keys = array_keys($data);
            $sql = QB::insertQuery($table, $keys);
            $q = $this->conn->prepare($sql);
            $sth = $q->execute($data);
            if ($sth) {
                return true;
            } else {
                return false;
            }
        }

        public function replace($data, $table)
        {
            $keys = array_keys($data);
            $sql = QB::replaceQuery($table, $keys);
            $q = $this->conn->prepare($sql);
            $sth = $q->execute($data);
            
            if ($sth) {
                return true;
            } else {
                return false;
            }
        }
         
        public function softDelete($id, $table)
        {
            $sql = "UPDATE $table SET deleted_at=:time WHERE id=:id";
            $q = $this->conn->prepare($sql);
            $q->execute(array(':id'=>$id, ':time'=>get_timestamp()));
            $count = $q->rowCount();
            
            if ($count > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function delete($id, $table)
        {
            $sql = "DELETE FROM $table WHERE id=:id";
            $q = $this->conn->prepare($sql);
            $q->execute(array(':id'=>$id));
            $count = $q->rowCount();
            
            if ($count > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function save()
        {
            return isset($this->id) ? $this->update() : $this->create();
        }
    
        public function close()
        {
            $this->conn = null;
        }
        
        public function findWithPaginate($table, $page, $per_page)
        {
            $total = $this->countAll($table)->total;
            $p = new Pagination($page, $per_page, $total);
            
            $sql="SELECT * FROM $table WHERE deleted_at IS NULL ORDER BY created_at DESC LIMIT :per_page OFFSET :offset";//
            $q = $this->conn->prepare($sql);
            $q->execute(array(':per_page'=>$per_page, ':offset'=>$p->offset()));
            $count = $q->rowCount();
            
            if ($count > 0) {
                while ($r = $q->fetch(PDO::FETCH_OBJ)) {
                    $data[]=$r;
                }
                $data[] = $p;
                return $data;
            } else {
                return false;
            }
        }
        
        public function countAll($table)
        {
            $sql = "SELECT count(*) as total FROM $table";
            $q = $this->conn->query($sql) or die("Failed");
            return $q->fetch(PDO::FETCH_OBJ);
        }
    }
