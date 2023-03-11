
service mariadb start
mysql -u root < /root/install/sql/phpmyadmin.sql
mysql -u root < /usr/share/phpmyadmin/sql/create_tables.sql
mysql -u root < /root/install/sql/createdb.sql
mysql -u root --database="training2voice" < /root/install/sql/createdata.sql
