# upload-demo

## 环境

需要安装axios

## 介绍

参数表：

| 参数   | 说明       | 类型   | 备注                            | 默认值   |
| ------ | ---------- | ------ | ------------------------------- | -------- |
| limit  | 上传数量   | number | -                               | 不限     |
| action | 上传地址   | string | -                               | 必填     |
| folder | 上传文件夹 | string | upload/                         | upload/  |
| ext    | 文件格式   | array  | array("gif", "jpeg", "jpg"....) | 图片格式 |

方法表：

| 方法名  | 说明         | 参数              |
| ------- | ------------ | ----------------- |
| getData | 获取上传列表 | （newVal，oldVal) |
|         |              |                   |

