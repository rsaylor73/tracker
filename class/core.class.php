<?php

/* This is the last class in the chain */

class core {

        public function new_mysql($sql) {
                $result = $this->linkID->query($sql) or die($this->linkID->error);
                return $result;
        }

        // converts an StdObject to an Array
        public function objectToArray($d) {
                if (is_object($d)) {
                        // Gets the properties of the given object
                        // with get_object_vars function
                        $d = get_object_vars($d);
                }

                if (is_array($d)) {
                        /*
                        * Return array converted to object
                        * Using __FUNCTION__ (Magic constant)
                        * for recursive call
                        */
                        //return array_map(__FUNCTION__, $d);
                        return array_map(array($this, 'objectToArray'), $d);
                } else {
                        // Return array
                        return $d;
                }
        } // public function objectToArray($d)

} // class core
?>
