<?php

include 'SOPBuilder-Functions.php';
$xml_files = array_diff(scandir('xml_files'), array('..', '.'));
//print_r($_POST);
$version = isset($_POST['version']) ? ($_POST['version']) : $xml_files[2];

$table_array = create_array_from_xml("xml_files/".$version);
$html_tables = create_html_tables($table_array,$selection=false);

//print_r($xml_files);
$xml_file_options = '';
foreach($xml_files as $xml_file){
    $xml_file_options.="<option id='$xml_file' name='$xml_file' value='$xml_file'>$xml_file</option>";
}



?>
<html>
    <body>
        <script language="javascript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" ></script>
        <script language="javascript" type="text/javascript" src="http://datatables.net/download/build/jquery.dataTables.nightly.js"></script>
        <style type="text/css">
            @import "css/jquery.dataTables.css";
        </style>
        
        <center><h2>SOP Builder Request</h2></center>
        <div class="form_div">
            <form method="POST" action="SOPBuilder-Result.php" id="submit_query">
                <b>Version:</b> <select id="version" style="width:188px;"><?=$xml_file_options?></select><br><br>  
                <b>Criteria:</b> <input style="width:188px;" id="criteria" name="criteria"><br><br>       
                <b>Description:</b> <textarea id="description" name="description" style="width:395px;height:100px;"></textarea>
                <input id="query" type="hidden" name="query">
                <input id="xml_path" type="hidden" name="xml_path" value=<?=$version?>>
                
            </form>
            <div id="submit" class="btn light-grey" onClick="submit_request()">Submit</div>
            <br>
        
        </div>
        <center><br><br><br><h2 style="margin:0px;">Tables</h2></center>
        <?=$html_tables?>
        
        
        
        
<script type='text/javascript'>


    $(document).ready(function(){
        var version = '<?=$version?>';
        // uncheck and enable all checkboxes on reload
        $('input:checkbox:checked').attr('checked',false);
        $('input:checkbox:disabled').removeAttr("disabled");
        $('#version').val(version);


        (function ($) {

            $(".whole_table").each(function(index,elem){
               $(elem).click(function(){
                   var table = elem.id.replace("/*","");
                   if($(elem).is(':checked')){
                        $('.'+table).each(function(index1,elem1){
                            $(elem1).attr("checked",false);
                            $(elem1).attr("disabled",true);
                        });
                   }else{
                       $('.'+table).each(function(index1,elem1){
                            $(elem1).removeAttr("disabled");
                        });

                   }

               });
            });

            submit_request = function(){
                var checked_checkboxes_list = "";
                $("input:checkbox:checked").each(function(index,elem){checked_checkboxes_list+=elem.id+","});
                checked_checkboxes_list = checked_checkboxes_list.slice(0,-1);
                if(checked_checkboxes_list=="")
                {
                    alert("Cannot submit an empty query!");
                }else{
                    $('#query').val(checked_checkboxes_list);
                    $('#submit_query').submit();
                }

            }
            
            $("#version").change(function(){
                var version = $("#version").val();
                var url = 'SOPBuilder-Request.php';
                var form = $('<form action="' + url + '" method="post">' +
                  '<input type="text" name="version" value="' + version + '" />' +
                  '</form>');
                $('body').append(form);
                $(form).submit();
            });

        })(jQuery);
    });

</script>
      
    </body>
</html>