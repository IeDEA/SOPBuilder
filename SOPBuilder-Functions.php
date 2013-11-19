<?php

function create_array_from_xml($file_path){
    $table_array = array();
    if ($xml = (object) simplexml_load_file($file_path)) {
        foreach ($xml->Tablelist->Table as $table_object) {
            $tmp_array = $table_object->attributes();
            $table_name = (string) $tmp_array['TableName'];
            $table_array[$table_name]['Table Name'] = $table_name;        
            $table_array[$table_name]['Title'] = (string) $table_object->Title;
            $table_array[$table_name]['Description'] = (string) $table_object->Description;

            foreach($table_object->Variables->Variable as $variable_object){
                $variable_object_attr = $variable_object->attributes();
                $variable_name = (string) $variable_object_attr['VariableName'];
                $table_array[$table_name]['Variables'][$variable_name] = array(
                    'Variable' => $variable_name,
                    'Description' => (string) $variable_object->Description,
                    'Data Type' => (string) $variable_object_attr['DataType'],
                    'Coding' => (string) $variable_object_attr['Coding'],
                    'Optional' => (string) $variable_object_attr['Optional']);
            }
        }
    }
    return $table_array;
}

function create_html_tables($table_array,$selection=false){
    if($selection==false){
        $table_headers = array('','Variable',"Description","Data Type","Coding","Optional");
        $html_tables = "";

        foreach($table_array as $table_name => $table){
            $html_tables .= "<div class='dataTables_wrapper'>";
            $html_tables .= "<h3><input type='checkbox' id='$table_name/*' name='$table_name/*' class='whole_table'> ".$table['Title']."</h3>";
            $html_tables .= "<div class='dataTables_header'>";
            $html_tables .= "<p>".$table['Description']."</p></div>";
            $html_tables .= "<table id='$table_name' class='dataTable'><thead><th>".implode("</th><th>",$table_headers)."</th></thead><tbody>";
            $odd_even = 'odd';
            foreach($table['Variables'] as $variable_name => $variable){        
                $id = $table_name."/".$variable_name;
                $check_box = "<input type='checkbox' id='$id' name='$id' class='$table_name'>";
                $table_row_values = array_merge(array($check_box),$variable);
                $html_tables.="<tr id='row_".$id."' class='$odd_even'><td>".implode("</td><td>",$table_row_values)."</td></tr>";
                $odd_even = ($odd_even == 'odd') ? 'even' : 'odd'; 
            }
            $html_tables .= "</tbody></table>";
            $html_tables .= "</div><hr>";
        }
    }else{
        $selected = array();
        foreach($selection as $tableIvar){
            $tmp = explode('/',$tableIvar);
            $selected[$tmp[0]][] = $tmp[1];
        }
        
        $table_headers = array('Variable',"Description","Data Type","Coding","Optional");
        $html_tables = "";
        foreach($selected as $table_name => $variables){
            $table = $table_array[$table_name];
            $html_tables .= "<div class='dataTables_wrapper'>";
            $html_tables .= "<h3>".$table['Title']."</h3>";
            $html_tables .= "<div class='dataTables_header'>";
            $html_tables .= "<p>".$table['Description']."</p></div>";
            $html_tables .= "<table id='$table_name' class='dataTable'><thead><th>".implode("</th><th>",$table_headers)."</th></thead><tbody>";
            $odd_even = 'odd';
            if($variables[0]=="*"){
                foreach($table_array[$table_name]['Variables'] as $variable_name => $variable){        
                    $id = $table_name."/".$variable_name;
                    $table_row_values = $variable;
                    $html_tables.="<tr id='row_".$id."' class='$odd_even'><td>".implode("</td><td>",$table_row_values)."</td></tr>";
                    $odd_even = ($odd_even == 'odd') ? 'even' : 'odd'; 
                }
            }else{
                foreach($variables as $variable_name){
                    $variable = $table_array[$table_name]['Variables'][$variable_name];
                    $id = $table_name."/".$variable_name;
                    $table_row_values = $variable;
                    $html_tables.="<tr id='row_".$id."' class='$odd_even'><td>".implode("</td><td>",$table_row_values)."</td></tr>";
                    $odd_even = ($odd_even == 'odd') ? 'even' : 'odd'; 
                }
            }
            $html_tables .= "</tbody></table>";
            $html_tables .= "</div><hr>";

        }
    }
    return $html_tables;
    
}

?>