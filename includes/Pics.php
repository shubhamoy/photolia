<?php

    require_once('helpers.php');
    require_once(__DIR__.'/../loader.php');

    class Pics
    {
        private $table = 'pics';
        private $db;
        public $id;
        public $filename;
        public $size;
        public $type;
        public $caption;
        public $slug;
        private $tempPath;
        protected $uploads_dir;
        public $errors=array();
        public $finalPath;
        protected $upload_errors = array(
            UPLOAD_ERR_OK   => "File Uploaded Successfully",
            UPLOAD_ERR_INI_SIZE => "File Size Exceeded the Limit",
            UPLOAD_ERR_FORM_SIZE => "File Size Exceeded the Limit",
            UPLOAD_ERR_PARTIAL => "Incomplete File Upload. Try Again",
            UPLOAD_ERR_NO_FILE => "File Upload Failed",
            UPLOAD_ERR_NO_TMP_DIR => "No Temporary Directory",
            UPLOAD_ERR_CANT_WRITE => "Disk Error",
            UPLOAD_ERR_EXTENSION => "File Upload Failed"
        );
        private $fileType = array(
            'image/jpeg',
            'image/jpg',
            'image/gif',
            'image/png'
        );
        
        public function __construct()
        {
            $this->uploads_dir = __DIR__.'/../public/images';
            $this->db = new Model;
        }
        
        public function start($file)
        {
            if ($this->validate($file)) {
                $this->tempPath = $file['tmp_name'];
                $this->filename = basename($file['name']);
                $this->type = $file['type'];
                $this->size = $file['size'];
                $this->finalPath = $this->uploads_dir."/".$this->filename;
                $this->upload();
                $this->insert();
                return true;
            } else {
                return false;
            }
        }
        
        private function validate($file)
        {
            if (!$file || empty($file) || !is_array($file)) {
                $this->errors[] = "No file uploaded";
                return false;
            } elseif ($file['error'] != 0) {
                $this->errors[] = $this->$upload_errors[$file['error']];
                return false;
            } elseif (!$this->fileTypeCheck($file['type'])) {
                $this->errors[] = "Invalid File Uploaded";
                return false;
            } elseif (strlen($this->caption) >= 255) {
                $this->errors[] = "The caption can only be 255 characters long.";
                return false;
            } elseif (file_exists($this->finalPath)) {
                $this->errors[] = "The file {$this->filename} already exists";
                return false;
            } else {
                return true;
            }
        }
        
        private function fileTypeCheck($mime)
        {
            foreach ($this->fileType as $ftype) {
                if ($ftype == $mime) {
                    return true;
                } else {
                    return false;
                }
            }
        }
        
        public function upload()
        {
            if (!empty($this->errors)) {
                return false;
            }
                        
            if (move_uploaded_file($this->tempPath, $this->finalPath)) {
                unset($this->tempPath);
                return true;
            } else {
                $this->errors[] = "The file upload failed";
                return false;
            }
        }
        
        private function insert()
        {
            $data = array(
                        'filename'=>$this->filename,
                        'type'=>$this->type,
                        'size'=>$this->size,
                        'caption'=>$this->caption,
                        'slug'=>$this->uniqueSlug()
            );
            $p = $this->db->insert($data, $this->table);
            if ($p) {
                return true;
            } else {
                return false;
            }
        }
        
        private function uniqueSlug()
        {
            $check = $this->db->getByField(["slug"=>$this->slug], 'pics');
            if ($check) {
                $this->slug = $this->slug.mt_rand(0, 9);
                return $this->slug;
            } else {
                return $this->slug;
            }
        }
        
        public static function getAllPics()
        {
            $db = new Model;
            $pics = $db->findAll("pics");
            return $pics;
        }
        
        public static function delete($id)
        {
            $db = new Model;
            $p = $db->softDelete($id, 'pics');
            if ($p) {
                return true;
            } else {
                return false;
            }
        }
        
        public static function getPic($id)
        {
            $db = new Model;
            $pic = $db->findById($id, 'pics');
            return $pic;
        }
        
        public static function getbySlug($slug)
        {
            $db = new Model;
            $pic = $db->getByField(["slug"=>$slug], 'pics');
            return $pic;
        }

        
        public static function findPaginate($page, $per_page)
        {
            $db = new Model;
            $pics = $db->findWithPaginate("pics", $page, $per_page);
            return $pics;
        }
        
        public static function count()
        {
            $db = new Model;
            $c = $db->countAll('pics');
            return $c;
        }
    }
