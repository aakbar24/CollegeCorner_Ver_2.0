<?php

// A customized data provider class to sort data without being case sensitive
// Can set $casei to false to enable normal case insesitive behaviour

class CommunityArrayDataProvider extends CArrayDataProvider{
    
    
     public $casei = true;
        
        protected function sortData($directions)
        {
                if(empty($directions))
                        return;
                $args=array();
                $dummy=array();
                foreach($directions as $name=>$descending)
                {
                        $column=array();
                        foreach($this->rawData as $index=>$data)
                                $column[$index]=is_object($data) ? $data->$name : $data[$name];
                        $args[]=&$column;
                        $dummy[]=&$column;
                        unset($column);
                        $direction=$descending ? SORT_DESC : SORT_ASC;
                        $args[]=&$direction;
                        $dummy[]=&$direction;
                        unset($direction);
                }
                
                if ($this->casei) { 
                        for ($i = 0; $i < count($args); $i++) {
                                $args[$i] = (is_array($args[$i])) ? array_map('strtolower', $args[$i]) : $args[$i];
                        }
                }
                
                $args[]=&$this->rawData;
                call_user_func_array('array_multisort', $args);
        }

    
}


?>
