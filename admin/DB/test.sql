INSERT INTO `activity_prize` (`id`, `activity_id`, `member_id`, `prize_id`, `createDate`)
VALUES
	(1, 1, 1, 4, '0000-00-00 00:00:00'),
	(2, 1, 2, 4, '0000-00-00 00:00:00'),
	(3, 2, 2, 3, '0000-00-00 00:00:00'),
	(4, 2, 2, 1, '0000-00-00 00:00:00');

INSERT INTO `activity` (`id`, `title`, `description`, `link_url`, `img_url`, `start_date`, `end_date`, `prize_start_date`, `prize_end_date`, `publish_start_date`, `publish_end_date`, `create_date`, `is_delete`)
VALUES
	(1, '亞瑟王全盤榜', 'bbb\n', '', 'activity1.jpg', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1000-10-10 00:00:00', '3000-10-10 00:00:00', '2017-01-10 00:00:00', '2017-01-13 23:00:00', '0000-00-00 00:00:00', 0),
	(2, '海神VS雷神連爆榜III', 'bbb\n', '', 'activity2.jpg', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1000-10-01 00:00:00', '3000-10-01 00:00:00', '2017-01-10 00:00:00', '2017-01-12 23:00:00', '0000-00-00 00:00:00', 0),
	(3, '馬戲團連開榜', 'bbb\n', '', 'activity3.jpg', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1000-10-01 00:00:00', '3000-10-01 00:00:00', '2017-01-10 00:00:00', '2017-01-10 23:00:00', '0000-00-00 00:00:00', 0),
	(4, '海神VS雷神連爆榜II', '', '', 'activity1.jpg', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
	(5, '秦皇單局倍率榜', '', '', 'activity1.jpg', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

INSERT INTO `prize` (`id`, `activity_id`, `prize_item`, `prize_desc`)
VALUES
	(1, 1, '安安', ''),
	(2, 1, '你好', ''),
	(3, 2, '確定', ''),
	(4, 3, '取消', '');
