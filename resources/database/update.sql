create table `fa_book` (
    `id` int not null auto_increment,
    `title` varchar(150) not null comment '标题',
    `author` varchar(150) null default '' comment '作者',
    `cover` text null comment '封面',
    `publishing` varchar(150) null default '' comment '出版社',
    `published_at` date null comment '出版日期',
    `description` text null comment '简介',
    `status` tinyint(1) null default 1 comment '状态',
    `weigh` int null default 0 comment '权重',
    `created_at` datetime null comment '创建时间',
    `updated_at` datetime null comment '更新时间',
    primary key (`id`)
) engine = innodb default charset = utf8mb4 comment '书籍';

create table `fa_catalog` (
    `id` int not null auto_increment,
    `book_id` int not null comment '书籍',
    `title` varchar(150) not null comment '标题',
    `description` text null comment '描述',
    `parent_id` int null default 0 comment '父级',
    `status` tinyint(1) null default 1 comment '状态',
    `weigh` int null default 0 comment '权重',
    `created_at` datetime null comment '创建时间',
    `updated_at` datetime null comment '更新时间',
    primary key (`id`)
) engine = innodb default charset = utf8mb4 comment '目录';

create table `fa_content` (
    `id` int not null auto_increment,
    `book_id` int not null comment '书籍',
    `catalog_id` int not null comment '目录',
    `title` varchar(150) not null comment '标题',
    `cover` text null comment '封面',
    `description` text null comment '概要',
    `content` text null comment '内容',
    `views` int null default 0 comment '阅览数',
    `status` tinyint(1) null default 1 comment '状态',
    `weigh` int null default 0 comment '权重',
    `created_at` datetime null comment '创建时间',
    `updated_at` datetime null comment '更新时间',
    primary key (`id`)
) engine = innodb default charset = utf8mb4 comment '内容';

create table `fa_record` (
    `id` int not null auto_increment,
    `content_id` int not null comment '内容',
    `text` text null comment '文本',
    `audio` text null comment '音频',
    `mime` varchar(100) not null comment 'MIME类型',
    `flag` tinyint(1) null default 0 comment '标识',
    `weigh` int null default 0 comment '权重',
    `code` varchar(50) not null comment '编号',
    primary key (`id`),
    unique (`code`)
) engine = innodb default charset = utf8mb4 comment '音频';

create table `fa_book_user` (
    `id` int not null auto_increment,
    `book_id` int not null comment '书籍',
    `admin_id` int not null comment '用户',
    `status` tinyint(1) null default 1 comment '状态',
    `created_at` datetime null comment '创建时间',
    `updated_at` datetime null comment '更新时间',
    primary key (`id`)
) engine = innodb default charset = utf8mb4;

create table `fa_log` (
    `id` bigint not null auto_increment,
    primary key (`id`)
) engine = myisam default charset = utf8mb4;
