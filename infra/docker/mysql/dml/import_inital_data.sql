-- local_infile の設定に応じて、サーバーはローカルデータロードをリクエストするクライアントによるローカルデータロードを拒否または許可する。
SHOW VARIABLES LIKE 'local_infile';

load data local infile '/tmp/dml/skill_list.csv' into table skill_masters fields terminated by ',' LINES TERMINATED BY '\n' IGNORE 1 LINES;
select * from skill_masters;