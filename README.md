# CatClaw
CatClaw，是一款纯免费的typecho影视采集插件，适用于typecho影视1号,2号,3号，以及[Zevideo](https://github.com/jrotty/Zevideo)模板。自1.8.0版本开始从xml接口转为采集json接口。理论上支持typecho1.1.0版本及以上

**功能介绍**

- 采集视频资源默认同名自动略过，同名连载状态自动更新内容 

- 支持免登录采集【指无需登陆，实际是代码中做了临时登陆】

- 支持适配autoup插件 

- 支持手动采集与定时任务两种模式

## 插件安装注意事项
插件文件夹名为`CatClaw`。

## 插件升级方式
禁用删除旧版插件，上传启用配置新版插件

## 采集接口填写
一个是视频列表的接口，一个是视频详情的接口，一般资源站给的接口如下：
```
https://资源站域名/api.php/provide/vod/?ac=list
```
这个实际上就是视频列表的接口，视频详情的接口有时候这些资源站没写，实际上就是把上面网址末尾的`list`改为`detail`然后就得到如下网址了：
```
https://资源站域名/api.php/provide/vod/?ac=detail
```
