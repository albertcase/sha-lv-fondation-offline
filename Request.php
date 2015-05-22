<?php
session_start();
include_once('./config/database.php');
include_once('./config/Pdb.php');
$_POST=$_REQUEST;
$db=Pdb::getDb();
if(isset($_POST['model'])){
	switch ($_POST['model']) {
		case 'upload':
			$tag=false;
			$files = isset($_POST['files']) ? $_POST['files'] : $tag = true;
			$code = isset($_POST['code']) ? $_POST['code'] : $tag = true;
			if($tag){
				print json_encode(array("code"=>0,"msg"=>'请填写必填项'));
				exit;
			}
			$sql="select id from same_photo where code=".$db->quote($code);
			if($db->getOne($sql)){
				print json_encode(array("code"=>0,"msg"=>'该code已经被使用了'));
				exit;
			}
			$sql="insert into same_photo set code=".$db->quote($code).",photo=".$db->quote($files);
			$db->execute($sql);
			$id=$db->lastInsertId;
			print json_encode(array("code"=>1,"msg"=>$id));
			exit;
			break;
		default:
			# code...
			print json_encode(array("code"=>9999,"msg"=>"No Model"));
			exit;
			break;
	}
}
print "error";
exit;

//getIpClass