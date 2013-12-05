<?php
include 'SOPBuilder-Functions.php';

// temporarilly assign variables
$study_projectID = $_POST['projectid'];
$study_version = "1.60";
$project_name = "All HICDEP tables";
$project_projectID = "ALL_HICDEP";


// get all tables to include
$query = explode(",",$_POST['query']);
$sql = $_POST['sql'];
$tables = array();
foreach($query as $tableIvar){
    $tmp = explode("/",$tableIvar);
    $tables[$tmp[0]] = $tmp[0];
}
$tables = array_values($tables);

$study = new ExSimpleXMLElement('<Study></Study>');
$study->addAttribute('name', $study_projectID." ".$study_version);
$study->addAttribute('version', $study_version);
$study->addAttribute('projectID', $study_projectID);
$study->addAttribute('xsi:noNamespaceSchemaLocation',"study.xsd",'xsi:noNamespaceSchemaLocation');
//$study->addAttribute("xmlns:ss:Type", "String");
$project = $study->addChild('Project');
$project->addAttribute('name',$project_name);
$project->addAttribute('projectID',$project_projectID);
$inclusionCriteria = $project->addChild('InclusionCriteria');
$inclusionCriteria->addChild('description');
$inclusionCriteria->addChildCData('SQL',$sql);
$tableList = $project->addChild('Tablelist');
foreach($tables as $table_name){
    $table = $tableList->addChild('Table');
    $table->addAttribute('TableName',$table_name);
}


$file_name = "study_".$study_projectID.$study_version.".xml";
header('Content-type: text/xml');
header('Content-Disposition: inline; filename="'.$file_name.'"');
$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($study->asXML());
echo $dom->saveXML();