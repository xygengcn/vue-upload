<?php
// 允许上传的图片后缀
$allowedExts = $_POST['ext'] ? explode(",", $_POST['ext']) : array(".gif", ".jpeg", ".jpg", ".png", ".JPG");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);     // 获取文件后缀名
$ext = "." . $extension;
$folder = $_POST['folder'] ? $_POST['folder'] : 'upload2/';
//判断文件大小
if ($_FILES["file"]["size"] > 204800) {
	echo json_encode(array("code" => 404, "error" => '非法文件大小'));
	die;
}
//判断文件格式
if (!in_array($ext, $allowedExts)) {
	echo json_encode(array("code" => 404, "error" => "非法的文件格式" . $ext . "只允许格式如下" . json_encode($allowedExts)));
	die;
}

//判断文件错误
if ($_FILES["file"]["error"] > 0) {
	echo json_encode(array("code" => 404, "error" => $_FILES["file"]["error"]));
	die;
}
// 判断目录存在，如果不存在则创建
if (!is_dir($folder)) mkdir($folder);


//判断文件存在
if (file_exists($folder . $_FILES["file"]["name"])) {
	$msg = $_FILES["file"]["name"] . " 文件已经存在。 ";
} else {
	try {
		$result = move_uploaded_file($_FILES["file"]["tmp_name"], $folder . $_FILES["file"]["name"]);
		if (!$result) {
			throw new Exception("目录错误");
		}
		$msg = "文件存储在: " . $host . "/" . $folder . $_FILES["file"]["name"];
	} catch (Exception $e) {
		echo json_encode(array("code" => 404, "error" =>  $e->getMessage()));
		die;
	}
}
echo json_encode(array(
	"code" => 200,
	"name" => $_FILES["file"]["name"],
	"type" => $_FILES["file"]["type"],
	"ext" => $extension,
	"size" => $_FILES["file"]["size"],
	"cache" => $_FILES["file"]["tmp_name"],
	"url" => $folder . $_FILES["file"]["name"],
	"msg" => $msg
));
die;
