@echo off

echo backup_db.bat

FOR /F "tokens=2 skip=2 delims=," %%D IN ('WMIC Path Win32_LocalTime Get DayOfWeek /Format:csv') DO SET Today=%%D

C:\MySQL\bin\mysqldump.exe -u root -h localhost -p20sitanala15 db_inventorirs --routines > D:\backup\db_inventorirs _0%Today%.sql

exit