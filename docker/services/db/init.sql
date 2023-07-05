create user 'tester'@'%' identified by 'monalisa123';

create database if not exists test;

grant all privileges on `test`.* to 'tester'@'%' identified by 'monalisa123';

flush privileges;