SELECT COUNT(`id_sub`) AS 'nb_susc', FLOOR(AVG(`price`)) AS 'av_sucs', MOD(SUM(`duration_sub`), 42) AS 'ft'
FROM subscription;
