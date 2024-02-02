<?php
    function nameInvalid($name) {

        if((!preg_match("/^[a-zA-Z ,.'-]+$/i", $name))) {
            $result = true;  
        } else {
            $result = false;
        }
        return $result;
    }