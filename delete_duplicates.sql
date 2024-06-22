CREATE TABLE tmp_table SELECT max(id) AS d_id FROM test_table GROUP BY `key` HAVING count(id) > 1;
DELETE FROM test_table WHERE id IN (SELECT d_id FROM tmp_table);
DROP TABLE tmp_table;
