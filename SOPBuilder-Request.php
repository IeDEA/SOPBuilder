<?php

include 'SOPBuilder-Functions.php';
$xml_files = array_diff(scandir('xml_files'), array('..', '.'));

if(count($_GET)>0){
    extract($_GET);
}else if(count($_POST)){
    extract($_POST);
}

// default sql value
if(!isset($sql))
    $sql = "SELECT Patient from tblBAS";

$table_array = create_array_from_xml("xml_files/".$version);
$html_tables = create_html_tables($table_array,$selection=false);

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
        <div class="description_div">
            <p>
                Welcome to the SOPBuilder prototype. This website is a prototype under active development by the IeDEA Network Coordinating Center personnel with feedback from collaborators in other cohorts. The SOP Builder is intended to provide an automatic way to generate data requests in the HIV clinical research domain, reducing the complexity associated with communication, version control, and data element specification when using data exchange standards. You can use the point-and-click interface below to select study variables and enter the selection criteria. This will take you to a summary page with all the study details and the options to download the request as PDF (human readable SOP for sharing with colleagues) or XML (machine readable) files. The XML representations of the standards and the downloadable merger files rely on the XML representation developed for use in the HIV DDM tool by Copenhagen Hiv Programme Chip.  (http://www.hiv-ddm.net)
            </p>
            <p>
                Current development is focused on the underlying technical aspects of the base functionality. In the next step we will include additional standards besides HICDEP 1.61. This can be done by uploading the corresponding formal XML definitions to the server. Please contact firas.wehbe@vanderbilt.edu if you would like to be involved or if you are interested in the use of this platform to share your cohort's data exchange standard. The code to run a copy of this application is freely available (requires PHP and web server) but at this current stage of development, please run at your own risk. 
            </p>
        </div>
        <br><br>
        <center><h2>SOP Builder Request</h2></center>
        <div class="form_div">
            <form method="POST" action="SOPBuilder-Result.php" id="submit_query">
                <b>Project ID:</b> <input style="width:188px;" id="projectid" name="projectid" value="<?=$projectid?>"><br><br>
                <b>Project Name:</b> <input style="width:188px;" id="projectname" name="projectname" value="<?=$projectname?>"><br><br>
                <b>Selection Scheme:</b> <select id="version" style="width:188px;"><?=$xml_file_options?></select><br><br>  
                <b>Criteria:</b> <textarea style="width:395px;height:100px;" id="criteria" name="criteria"><?=$criteria?></textarea><br><br>       
                <b>Description:</b> <textarea id="description" name="description" style="width:395px;height:100px;"><?=$description?></textarea><br><br>  
                <a id='advanced_toggle' onclick='advanced_toggle();' style='cursor:pointer;color:blue;'>Advanced &raquo;</a><br><br>
                <span id="advanced_sql_div" style="display:none;"><b>SQL:</b> <textarea id="sql" name="sql" style="width:395px;height:100px;"><?=$sql?></textarea><br><br></span> 
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
                var projectid = $("#projectid").val();
                var projectname = $("#projectname").val();
                var criteria = $("#criteria").val();
                var description = $("#description").val();
                var sql = $("#sql").val();
                var url = 'SOPBuilder-Request.php';
                var form = $('<form action="' + url + '" method="post">' +
                  '<input type="text" name="version" value="' + version + '" />' +
                  '<input type="text" name="projectid" value="' + projectid + '" />' +
                  '<input type="text" name="projectname" value="' + projectname + '" />' +
                  '<input type="text" name="description" value="' + description + '" />' +
                  '<input type="text" name="criteria" value="' + criteria + '" />' +
                  '<input type="text" name="sql" value="' + sql + '" />' +
                  '</form>');
                $('body').append(form);
                $(form).submit();
            });
            
            advanced_toggle = function(){
                if($('#advanced_toggle').html()=="Advanced &laquo;" || encodeURI($('#advanced_toggle').html())== "Advanced%20%C2%AB")
                {
                    $('#advanced_sql_div').hide();
                    $('#advanced_toggle').html("Advanced &raquo;");
                }
                else
                {
                    $('#advanced_sql_div').show();
                    $('#advanced_toggle').html("Advanced &laquo;");
                }
            }

        })(jQuery);
    });

</script>
      
    </body>
</html>