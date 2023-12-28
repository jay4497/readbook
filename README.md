# FastaAmin Startup

### Start

1. 确保 `php` 命令可执行的情况下，根目录下执行 `php composer.phar update`。

2. 复制 `/.env.sample` 到 `/.env`，在 `/.env` 根据情况修改配置参数

    复制 `/application/extra/site.example.php` 到 `/application/extra/site.php`。

3. 保证以下文件或文件夹的可读写权限：

    > `/runtime` 运行时文件夹
    >
    > `/addons` FastAdmin 插件文件夹
    > 
    > `/application/extra` 附加配置文件夹，包括插件配置、队列配置、站点配置及上传配置
    > 
    > `/public/assets/js/addons.js` 刷新插件缓存会更新此文件

4. 初始数据库文件位于 `/resources/database`，后台入口文件 `/public/KYJFMHeRNc.php`，初始管理员 `admin`， 密码 `qweasd123`。

开发文档可参考 [FastAdmin 框架文档](https://doc.fastadmin.net/doc)

### 实用技巧文章参考

1. [一张图解析 FastAdmin 中表格列表的功能](https://ask.fastadmin.net/article/323.html)

2. [常见问题处理](https://doc.fastadmin.net/doc/faq.html)


