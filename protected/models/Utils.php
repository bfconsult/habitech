<?php
class Utils { 
    public static function uniqueFile($file){
        if(isset($file)){
            $name = explode('.',$file);
            $name[0] = uniqid('');
            
            end($name);
            $key = key($name);
            $name[$key] = '.'.$name[$key];
            $result = implode($name);
            
            return $result;
        }
        return '';
    }

    public static function deleteFile($rootpath,$file){
        if(!empty($file) && isset($rootpath) && file_exists($rootpath.$file)){
            $path = $rootpath.$file;
            if(chmod($path, 0777)){
               if(unlink($path)){
                   return true; 
                }
                return false; 
            }
        }
        return true;
    }     
}
	