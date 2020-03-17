<?php
header("Content-type:text/html;charset=utf-8");
// 允许上传的图片后缀
$allowedExts = explode(",", $_POST['ext']);
$temp = explode(".", $_FILES["file"]["name"]);
// 获取文件后缀名(没有点）
$extension = end($temp);
//获取文件后缀名(有点)
$ext = "." . $extension;
//文件夹
$folder = $_POST['folder'] ? $_POST['folder'] : 'upload/';
//文件大小
$size = $_POST['size'] ? $_POST['size'] * 1024000 : '2048000';
//新名字
$name = $_POST['autoName'] ? autoName(8) . $ext : $_FILES["file"]["name"];
$folder = $_POST['autoName'] ? $folder . date('Y') . '/' . date('m') . '/' : $folder;
//判断文件大小
if ($_FILES["file"]["size"] > $size) {
    echo json_encode(array("code" => 404, "error" => '非法的文件大小'));
    die;
}
//判断文件格式
if (!in_array($ext, $allowedExts)) {
    echo json_encode(array("code" => 404, "error" => "非法的文件格式[" . $ext . "]，只允许格式如下" . json_encode($allowedExts)));
    die;
}

//判断文件错误
if ($_FILES["file"]["error"] > 0) {
    echo json_encode(array("code" => 404, "error" => $_FILES["file"]["error"]));
    die;
}
// 判断目录存在，如果不存在则创建
if (!is_dir($folder)) {
    $res = mkdir(iconv("UTF-8", "GBK", $folder), 0777, true);
    if (!$res) {
        echo json_encode(array("code" => 404, "error" => "创建目录失败"));
        die;
    }
}

//判断文件存在
if (file_exists($folder . $_FILES["file"]["name"])) {
    $msg = $_FILES["file"]["name"] . " 文件已经存在。 ";
} else {
    try {
        $result = move_uploaded_file($_FILES["file"]["tmp_name"], $folder . $name);
        if (!$result) {
            throw new Exception("目录错误");
        }
        $msg = "文件存储在: " . $host . "/" . $folder . $_FILES["file"]["name"];
    } catch (Exception $e) {
        echo json_encode(array("code" => 404, "error" => $e->getMessage()));
        die;
    }
}
echo json_encode(array(
    "code" => 200,
    "name" => $name,
    "type" => $_FILES["file"]["type"],
    "ext" => $extension,
    "size" => $_FILES["file"]["size"],
    "cache" => $_FILES["file"]["tmp_name"],
    "url" => 'http://' . dirname($_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"]) . '/' . $folder . $name,
    "msg" => $msg,
));
die;

//随机命名函数
function autoName($length)
{
    $captchaSource = "0123456789abcdefghijklmnopqrstuvwxyz这是一个随机打印输出字符串的例子";
    $captchaResult = "";
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, 35);
        if ($n >= 36) {
            $n = 36 + ceil(($n - 36) / 3) * 3;
            $captchaResult .= substr($captchaSource, $n, 3);
        } else {
            $captchaResult .= substr($captchaSource, $n, 1);
        }
    }
    return $captchaResult;
}