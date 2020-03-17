# vue-upload

### 介绍

vue自定义上传组件+php后端

### 链接

https://github.com/xygengcn/vue-upload

（麻烦给个小星星）

### 环境

1. 需要安装axios

```
$ npm install axios
```

2. 请把admin文件夹的upload.php地址放在服务器环境，并在参数action上填写地址



### 内容

参数表：

| 参数     | 说明       | 类型    | 备注                          | 默认值  |
| -------- | ---------- | ------- | ----------------------------- | ------- |
| id       | 文件id     | string  |                               | 必填    |
| action   | 上传地址   | string  | upload.php文件地址            | 必填    |
| data     | 列表初始值 | array   | 可填                          |         |
| limit    | 上传数量   | number  | -                             | 不限    |
| type     | 文件类型   | string  | image\|file                   | image   |
| folder   | 上传文件夹 | string  | upload/                       | upload/ |
| ext      | 文件格式   | array   | [".gif", ".jpeg", ".jpg"....] | 可填    |
| size     | 文件大小   | number  | mb                            | 2m      |
| autoName | 随机名     | boolean | 1或者0                        | 1       |



方法表：

| 方法名      | 说明             | 参数              | 返回值 |
| ----------- | ---------------- | ----------------- | ------ |
| getList     | 获取上传列表     | （newVal，oldVal) | array  |
| getProgress | 单个文件上传进度 | （newVal)         | number |

