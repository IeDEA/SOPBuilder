<?php

$xml = new SimpleXMLElement('<xml/>');
$study = $xml->addChild('Study');
$study->addAttribute('name', "HICDEP 1.60");
$study->addAttribute('version', "1.60");
$study->addAttribute('projectID', "HICDEP");
$study->addAttribute('xsi:noNamespaceSchemaLocation', "study.xsd");
$project = $study->addChild('Project');
$project->addAttribute('name','All HICPEP tables');
$project->addAttribute('projectID','ALL_HICDEP');
$inclusionCriteria = $project->addChild('InclusionCriteria');
$inclusionCriteria->addChild('description');
$inclusionCriteria->addChild('SQL','<![CDATA[
      Select Patient from tblBAS
      ]]>');


Header('Content-type: text/xml');
print($xml->asXML());