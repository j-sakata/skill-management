-- local_infile の設定に応じて、サーバーはローカルデータロードをリクエストするクライアントによるローカルデータロードを拒否または許可する。
SET PERSIST local_infile= 1;
SHOW VARIABLES LIKE 'local_infile';

load data local infile '/tmp/dml/skill_list.csv' into table skill_masters fields terminated by ',' ENCLOSED BY '"' LINES TERMINATED BY '\n' IGNORE 1 LINES;
select * from skill_masters;