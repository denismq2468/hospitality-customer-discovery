<?php
/**
 * V2 template for quinland.online/cafe/
 * SAFE FOR PUBLIC SOURCE CONTROL: contains no live credentials.
 * On Hostinger, load credentials from a private config file outside the public repository.
 */
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['success'=>false,'message'=>'Method not allowed']); exit; }
if (!empty($_POST['website'])) { echo json_encode(['success'=>true]); exit; }
require_once __DIR__ . '/config.private.php'; // NOT committed to GitHub
function clean($v){ return trim((string)$v); }
$areas = $_POST['prompted_problem_areas'] ?? [];
if (!is_array($areas)) $areas = [$areas];
$fields=[
'business_name'=>clean($_POST['business_name']??''),
'biggest_problems'=>clean($_POST['biggest_problems']??''),
'eliminate_task'=>clean($_POST['eliminate_task']??''),
'unwanted_owner_work'=>clean($_POST['unwanted_owner_work']??''),
'impact_cost_time'=>clean($_POST['impact_cost_time']??''),
'current_approach'=>clean($_POST['current_approach']??''),
'current_paid_tools_services'=>clean($_POST['current_paid_tools_services']??''),
'prompted_problem_areas'=>implode(' | ',array_map('clean',$areas)),
'prompted_problem_areas_other'=>clean($_POST['prompted_problem_areas_other']??''),
'delivery_platforms'=>clean($_POST['delivery_platforms']??''),
'ai_usage'=>clean($_POST['ai_usage']??''),
'priority_problem'=>clean($_POST['priority_problem']??''),
'followup_name'=>clean($_POST['followup_name']??''),
'followup_email_phone'=>clean($_POST['followup_email_phone']??''),
'followup_permission'=>isset($_POST['followup_permission'])?'Yes':'No',
'survey_version'=>'hospitality-discovery-v2'
];
foreach(['business_name','biggest_problems','priority_problem'] as $k){if($fields[$k]===''){http_response_code(422);echo json_encode(['success'=>false,'message'=>"Required field $k is missing"]);exit;}}
try{$pdo=new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',DB_USER,DB_PASS,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES=>false]);}
catch(PDOException $e){http_response_code(500);error_log('Survey DB connect error: '.$e->getMessage());echo json_encode(['success'=>false,'message'=>'Database connection failed']);exit;}
$ip_hash=hash('sha256',$_SERVER['REMOTE_ADDR']??'');
$sql="INSERT INTO survey_responses_v2 (business_name,biggest_problems,eliminate_task,unwanted_owner_work,impact_cost_time,current_approach,current_paid_tools_services,prompted_problem_areas,prompted_problem_areas_other,delivery_platforms,ai_usage,priority_problem,followup_name,followup_email_phone,followup_permission,survey_version,submitted_at,ip_hash) VALUES (:business_name,:biggest_problems,:eliminate_task,:unwanted_owner_work,:impact_cost_time,:current_approach,:current_paid_tools_services,:prompted_problem_areas,:prompted_problem_areas_other,:delivery_platforms,:ai_usage,:priority_problem,:followup_name,:followup_email_phone,:followup_permission,:survey_version,NOW(),:ip_hash)";
try{$stmt=$pdo->prepare($sql);$stmt->execute(array_merge($fields,['ip_hash'=>$ip_hash]));echo json_encode(['success'=>true]);}
catch(PDOException $e){http_response_code(500);error_log('Survey insert error: '.$e->getMessage());echo json_encode(['success'=>false,'message'=>'Could not save response']);}
