<?php
session_start();
if(!isset($_SESSION['login_user'])){
	Header('Location:./index.html');
	exit;
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimum-scale=1.0,maximum-scale=1.0,minimal-ui" />
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="Keywords" content="">
<meta name="Description" content="">
<link rel="apple-touch-icon" href="images/icon.png" />
<title>Louis Vuitton</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<link rel="stylesheet" type="text/css" href="css/reset.css" />
<link rel="stylesheet" type="text/css" href="css/main.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />

<script type="text/javascript"> 
$(document).ready(function() { 
//elements
var progressbox 		= $('#progressbox'); //progress bar wrapper
var progressbar 		= $('#progressbar'); //progress bar element
var statustxt 			= $('#statustxt'); //status text element
var submitbutton 		= $("#SubmitButton"); //submit button
var myform 				= $("#UploadForm"); //upload form
var output 				= $("#output"); //ajax result output element
var completed 			= '0%'; //initial progressbar value
var FileInputsHolder 	= $('#AddFileInputBox'); //Element where additional file inputs are appended
var MaxFileInputs		= 7; //Maximum number of file input boxs

// adding and removing file input box
var i = $("#AddFileInputBox div").size() + 1;
$("#AddMoreFileBox").click(function () {
		event.returnValue = false;
		if(i < MaxFileInputs)
		{
			$('<span><input type="file" id="fileInputBox" size="20" name="file[]" class="addedInput" value=""/><a href="#" class="removeclass small2"><img src="images/close_icon.gif" border="0" /></a></span>').appendTo(FileInputsHolder);
			i++;
		}
		return false;
});

$("body").on("click",".removeclass", function(e){
		event.returnValue = false;
		if( i > 1 ) {
				$(this).parents('span').remove();i--;
		}
		
}); 

$("#ShowForm").click(function () {
  $("#uploaderform").slideToggle(); //Slide Toggle upload form on click
});

$("#SubmitButton").click(function () {
	if($("#code").val()==''){
		alert("请填写code")
		return false
	}else{
		$(myform).ajaxForm({
			beforeSend: function() { //brfore sending form
				submitbutton.attr('disabled', ''); // disable upload button
				statustxt.empty();
				progressbox.show(); //show progressbar
				progressbar.width(completed); //initial value 0% of progressbar
				statustxt.html(completed); //set status text
				statustxt.css('color','#000'); //initial color of status text	
			},
			uploadProgress: function(event, position, total, percentComplete) { //on progress
				progressbar.width(percentComplete + '%') //update progressbar percent complete
				statustxt.html(percentComplete + '%'); //update status text
				if(percentComplete>50)
					{
						statustxt.css('color','#fff'); //change status text to white after 50%
					}else{
						statustxt.css('color','#000');
					}
					
				},
			complete: function(response) { // on complete
				$("#aaa").val(response.responseText); //update element with received data
				//myform.resetForm();  // reset form
				 //enable submit button
				 //submitbutton.removeAttr('disabled');
				//progressbox.hide(); // hide progressbar
				/*$("#uploaderform").slideUp();*/ // hide form after upload
				submitForm();
			}
		});
	}
})


}); 

function submitForm(){
	var code=$("#code").val();
	if(code==""){
		alert("Please enter the code!");
		return false;
	}
	$.ajax({
		url:"./Request.php?model=upload",
		type:"post",
		data:{"code":code,"files":$("#aaa").val()},
		dataType:"json",
		success:function(data){
			alert(data.code)
			$("#SubmitButton").removeAttr('disabled');
		}
	})
	
}
</script> 

</head>
<body>
	<!-- <div id="upload">
		<p class="title">上传图片</p>
		<div class="upload_con">
			<ul>
				<li>编<span style="margin-right:2em;"></span>号：<input type="text" name="code" class="code" />
				</li>
				<li class='fileli'>上传图片：
					<a href="javascript:;" class="file">选择文件<input type="file" name="file" ></a>
					<input type='button' value=' + ' onclick="addfile()" class="add">
				</li>
			</ul>
			<a href="javascript:;">
				<input type="submit"  value="提&nbsp;&nbsp;交" class="upload_btn"/>	
			</a>		
		</div>

	</div>	 -->
	<div id="uploaderform">
	<form action="upload.php" method="post" enctype="multipart/form-data" name="UploadForm" id="UploadForm">
		<h1>上传文件</h1>  
	    <label>Files
	    <span class="small"><a href="#" id="AddMoreFileBox">＋</a></span>
	    </label>
	    <div id="AddFileInputBox"><input id="fileInputBox" style="margin-bottom: 5px;" type="file"  name="file[]"/></div>
	    <div class="sep_s"></div>
	    
	    <label>Code
	    <span class="small">Enter your code</span>
	    </label>
	    <div><input name="code" type="text" id="code" value="" /></div>
	    
	    
	    <button type="submit" class="button" id="SubmitButton">Upload</button>
	    
	    <div id="progressbox"><div id="progressbar"></div ><div id="statustxt">0%</div ></div>
	</form>
	</div>
	<!-- <div id="uploadResults">
		<div align="center" style="margin:20px;"><a href="#" id="ShowForm">Toggle Form</a></div>
	    <div id="output"></div>
	</div>	 -->

<!--<script type="text/javascript">
function addfile(){
	$(".upload_con ul").append('<span class="choose"><a href="javascript:;" class="file">选择文件<input type="file" name="file" ></a></span><br/>')
}
</script>-->
<input type="hidden" value="" id="aaa">

<script type="text/javascript" src="js/main.js"></script>
</body>
</html>

