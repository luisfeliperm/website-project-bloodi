<?php 
$project_details = (parse_ini_file($_SERVER['DOCUMENT_ROOT']."/php/config/project_details.ini"));
$project_details['defaultTags'] = str_replace([', ', ' ,'], ',', $project_details['defaultTags']);
$project_details = array_map('trim', $project_details);
if(substr($project_details['url'], -1) != "/"){
	$project_details['url'] = $project_details['url']."/";
}

