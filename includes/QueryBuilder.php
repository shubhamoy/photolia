<?php
    trait QB
    {
        public static function updateQuery($table, $keys, $id)
        {
            $count = 0;
            $q = "UPDATE ".$table." SET ";

            foreach ($keys as $key) {
                $count++;
                if (count($keys) == $count) {
                    $q .= $key."=:".$key." WHERE id=:id";
                } else {
                    $q .= $key."=:".$key.", ";
                }
            }
            return $q;
        }

        public static function insertQuery($table, $keys)
        {
            $count = 0;
            $q = "INSERT INTO ".$table." SET ";

            foreach ($keys as $key) {
                $count++;
                if (count($keys) == $count) {
                    $q .= $key."=:".$key;
                } else {
                    $q .= $key."=:".$key.", ";
                }
            }
            return $q;
        }

        public static function selectAndQuery($table, $keys)
        {
            $count = 0;
            $q = "SELECT * FROM ".$table." WHERE ";

            foreach ($keys as $key) {
                $count++;
                if (count($keys) == $count) {
                    $q .= $key."=:".$key." AND deleted_at IS NULL";
                } else {
                    $q .= $key."=:".$key." AND ";
                }
            }
            return $q;
        }

        public static function selectOrQuery($table, $keys)
        {
            $count = 0;
            $q = "SELECT * FROM ".$table." WHERE ";

            foreach ($keys as $key) {
                $count++;
                if (count($keys) == $count) {
                    $q .= $key."=:".$key." AND deleted_at IS NULL";
                } elseif (count($keys) > 1) {
                    $q .= $key."=:".$key." OR ";
                }
            }
            return $q;
        }

        public static function replaceQuery($table, $keys)
        {
            $count = 0;
            $q = "REPLACE INTO ".$table." SET ";

            foreach ($keys as $key) {
                $count++;
                if (count($keys) == $count) {
                    $q .= $key."=:".$key;
                } else {
                    $q .= $key."=:".$key.", ";
                }
            }
            return $q;
        }
    }
