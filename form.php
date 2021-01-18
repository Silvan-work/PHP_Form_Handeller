<?php 

    define('SITE_ROOT',__DIR__);

    class Form{
        
        public function get_values($input_name_list){
            $input_value_list=array();
            for($i=0;$i<count($input_name_list);$i++){
                if(!isset($_POST[$input_name_list[$i]]) && strcasecmp($_POST[$input_name_list[$i]],"")!=0){
                    $input_value_list[$i]="Null";
                }else{
                    $input_value_list[$i]=$_POST[$input_name_list[$i]];
                }  
            }
            return $input_value_list;
        }

        public function get_files($file_name_list,$destination){
            $file_value_list=array();
            for($i=0;$i<count($file_name_list);$i++){
                if (!isset($_FILES[$file_name_list[$i]]) || !file_exists($_FILES[$file_name_list[$i]]['tmp_name']) || !is_uploaded_file($_FILES[$file_name_list[$i]]['tmp_name'])) 
                {
                    $file_value_list[$i]="Null";
                }
                else
                {
                    $file_name=$_FILES[$file_name_list[$i]]['name'];
                    $new_file_name=rand(0,1000)."_File_".rand(0,1000);
                    $file_type = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
                    $target_file = $destination."/".$new_file_name.".".$file_type;
                    if (move_uploaded_file($_FILES[$file_name_list[$i]]['tmp_name'], __DIR__.$target_file)) {
                        $file_value_list[$i]=$new_file_name.".".$file_type;
                    } else {
                        $file_value_list[$i]="Null";
                    }   
                }
            }
            return $file_value_list;
        }

        public function validate($columns,$values){
            $i=0;
            while($i<count($columns)){
                if(strcasecmp($values[$i],'Null')==0){
                    //removing null value
                    array_splice($columns,$i,1);
                    array_splice($values,$i,1);
                    //starting from 0
                    $i=0;
                    continue;
                }
                $i++;
            }
            return array($columns,$values);
        }
    }

?>