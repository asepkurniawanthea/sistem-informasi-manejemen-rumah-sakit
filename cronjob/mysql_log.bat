@echo off

C:\MySQL\bin\mysqlbinlog.exe --database=db_simrs --start-datetime="2020-04-02 23:55:56" --verbose  C:\MySQLData\data\WIN-489C11HMRGF-bin.000228 > D:\backup\WIN-489C11HMRGF-bin.000228.txt

pause