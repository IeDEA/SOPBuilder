<?php
include 'SOPBuilder-Functions.php';

// temporarilly assign variables
$study_projectID = 'XX';
$study_version = "XX";
$study_name = "XX";
$project_name = $_POST['projectname'];
$project_projectID = $_POST['projectid'];
$project_inclusioncriteria_description = $_POST['criteria'];
$project_inclusioncriteria_sql = $_POST['sql'];

// get all tables to include
$query = explode(",",$_POST['query']);
$tables = array();
foreach($query as $tableIvar){
    $tmp = explode("/",$tableIvar);
    $tables[$tmp[0]] = $tmp[0];
}
$tables = array_values($tables);

$study = new ExSimpleXMLElement('<Study></Study>');
$study->addAttribute('name', $study_name);
$study->addAttribute('version', $study_version);
$study->addAttribute('projectID', $study_projectID);
$study->addAttribute('xsi:noNamespaceSchemaLocation',"study.xsd",'xsi:noNamespaceSchemaLocation');
//$study->addAttribute("xmlns:ss:Type", "String");
$project = $study->addChild('Project');
$project->addAttribute('name',$project_name);
$project->addAttribute('projectID',$project_projectID);
$inclusionCriteria = $project->addChild('InclusionCriteria');
$inclusionCriteria->addChild('description',$project_inclusioncriteria_description);
$inclusionCriteria->addChildCData('SQL',$project_inclusioncriteria_sql);
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