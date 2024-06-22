# Test tasks for SupportOne
Test for trying to gain a vacancy of PHP-developer

NOTE: *Tasks order present as its appears in the test file.*

---

1. REGEXP

Run ```testRegexp.php``` file

For online version use next links:

Matched case:
- https://regex101.com/r/4Q91pV/1
- https://regex101.com/r/u8fY6r/1
- https://regex101.com/r/4Kyw36/1

Unmatched case:

- https://regex101.com/r/V6OYY0/1
- https://regex101.com/r/7Vz7Ex/1
- https://regex101.com/r/WlGKMh/1
- https://regex101.com/r/qIqhoa/1

2. TRANSLITERATION

Run ```testTransliteration.php``` file

As output, it must show a transliterated string.

**NOTE:** Because of quite unclear problem conditions some
moments I'm added on my own. 

3. ARRAYS

Run ```testArrays.php``` file

As output the elements of the result array must be shown.

4. RENAME FILES

Run ```testRenameFiles.php``` file

At first all files inside ./TestFList directory will rename.
Second, show all files with '.jpg' extension.

**NOTE:** Full list of directories structure can be found at ```./Data/RenameFilesTaskList.txt```

5. CSV

Run ```testCSV.php``` file

The result file './Data/test.csv' must be created.

6. Parser

Run ```testParser.php``` file

NOTE: after run the file, another file ```./Data/raw_data_to_parse.txt``` 
will be crated for debug purpose.

7. MySQL. Query associated data

        DATABASE TYPE: MySQL
        DATABASE NAME: testdb

To fill the database use the ```test_associated.sql``` dump file;

**IMPORTANT!** Before run test file, please specify proper user and password
values for $user and #password variables!

Run ```testMySQL_associated.php``` file

If query succeed, the result will print to the stdout and the file
'./Data/data_db_associated.txt' will create at the same time.
