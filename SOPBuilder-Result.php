<?php
    
include 'SOPBuilder-Functions.php';
//print_r($_POST);

$query = explode(",",$_POST['query']);
//print_r($query);

$table_array = create_array_from_xml("xml_files/".$_POST['xml_path']);
$html_tables = create_html_tables($table_array,$selection=$query);
?>

<html>
    <body>
        <script language="javascript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" ></script>
        <style type="text/css">
            @import "css/jquery.dataTables.css";
        </style>        
        <center><h2>SOP Builder Result</h2></center>
         <div class="form_div" style="padding-bottom: 20px;">   
             <table>
                <tr><td><b>Version:</b></td><td><?=$_POST['xml_path']?></td></tr>
                <tr><td><b>Criteria:</b></td><td><?=$_POST['criteria']?></td></tr>
                <tr><td valign="top"><b>Query:</b></td><td><?=$_POST['query']?></td></tr>
             </table>
             
        </div>
        <?=$html_tables?>
        
    </body>
</html>
        
        