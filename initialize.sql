create database `bookstore_system` default character set utf8mb4 default collate utf8mb4_0900_ai_ci;

create table `bookstore_system`.`user` (
	`id` int not null auto_increment primary key,
	`username` varchar(35) character set utf8mb4 collate utf8mb4_0900_ai_ci not null unique,
	`password` varchar(35) character set utf8mb4 collate utf8mb4_0900_ai_ci not null,
	`email` varchar(35) character set utf8mb4 collate utf8mb4_0900_ai_ci not null
) engine = innodb auto_increment = 1 default character set = utf8mb4 default collate = utf8mb4_0900_ai_ci;

create table `bookstore_system`.`book` (
	`id` int not null auto_increment primary key,
	`name` varchar(60) character set utf8mb4 collate utf8mb4_0900_ai_ci not null unique,
	`price` int not null,
	`quantity` int not null
) engine = innodb auto_increment = 1 default character set = utf8mb4 default collate = utf8mb4_0900_ai_ci;

create table `bookstore_system`.`suggestion` (
	`id` int not null auto_increment primary key,
	`user_id` int not null,
	`content` tinytext character set utf8mb4 collate utf8mb4_0900_ai_ci not null,
	`post_time` timestamp not null default current_timestamp,
	foreign key (`user_id`) references `bookstore_system`.`user`(`id`)
) engine = innodb auto_increment = 1 default character set = utf8mb4 default collate = utf8mb4_0900_ai_ci;

insert into `bookstore_system`.`user`(`username`, `password`, `email`) values
	('admin', 'nimda', 'admin@book.net'),
	('elephant', '123321', 'bbb@ccc.com'),
	('cat', 'ccccc', 'www@qaz.com'),
	('清风', 'qingfeng', 'eee@kkk.ddd');

insert into `bookstore_system`.`book`(`name`, `price`, `quantity`) values
	('老人与海', 22, 301),
	('骆驼祥子', 20, 107),
	('假如给我三天光明', 29, 89),
	('改变世界的航海', 30, 22),
	('海洋与文明', 17, 55),
	('时间简史', 26, 209),
	('宇宙的琴弦', 37, 50);

insert into `bookstore_system`.`suggestion`(`user_id`, `content`) values
	(2, '11111111111'),
	(3, '22222222222222222222222');

