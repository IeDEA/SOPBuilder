<?php
    
include 'SOPBuilder-Functions.php';
//print_r($_POST);

$query = explode(",",$_POST['query']);

$table_array = create_array_from_xml("xml_files/".$_POST['xml_path']);
$html_tables = create_html_tables($table_array,$selection=$query);
$selected_variables = queryToArray($query);
$sql = create_SQL($selected_variables);
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
                <tr><td valign="top"><b>Description:</b></td><td><?=$_POST['description']?></td></tr>
                <tr><td valign="top"><b>Query:</b></td><td><?=$_POST['query']?></td></tr>
                <tr><td valign="top"><b>SQL:</b></td><td><?=$sql?></td></tr>
             </table>
             
        </div>
        <div class="btn_div">
            <table>
                <tr>
                    <td><div id="submit" class="btn light-grey" onclick="create_file('create_pdf');">Create PDF Document</div></td>
                    <td><div id="submit" class="btn light-grey" onclick="create_file('create_xml');">Create XML Merger File</div></td>
                </tr>
            </table>
        </div>
        <!--Hidden PDF Creator Form-->
        <form method="POST" action="SOPBuilder-CreatePDF.php" id="create_pdf" target="_blank" style="display:none;">
            <b>Version:</b> <input id="version" style="width:188px;" name="xml_path" value="<?=$_POST['xml_path']?>"><br><br>  
            <b>Criteria:</b> <input style="width:188px;" id="criteria" name="criteria" value="<?=$_POST['criteria']?>"><br><br>   
            <b>Query:</b> <input style="width:188px;" id="query" name="query" value="<?=$_POST['query']?>"><br><br> 
            <b>Description:</b> <textarea style="width:395px;height:100px;" id="description" name="description"><?=$_POST['description']?></textarea>
        </form>
        <!--Hidden XML Creator Form-->
        <form method="POST" action="SOPBuilder-CreateXML.php" id="create_xml" target="_blank" style="display:none;">
            <b>Version:</b> <input id="version" style="width:188px;" name="xml_path" value="<?=$_POST['xml_path']?>"><br><br>  
            <b>Criteria:</b> <input style="width:188px;" id="criteria" name="criteria" value="<?=$_POST['criteria']?>"><br><br>   
            <b>Query:</b> <input style="width:188px;" id="query" name="query" value="<?=$_POST['query']?>"><br><br> 
            <b>SQL:</b> <input style="width:188px;" id="sql" name="sql" value="<?=$sql?>"><br><br> 
            
        </form>
        
        <?=$html_tables?>
        

<script type='text/javascript'>
(function ($) {

    create_file = function(which){
        $('#'+which).submit();
    }

})(jQuery);


</script>

        
    </body>
</html>
        
        