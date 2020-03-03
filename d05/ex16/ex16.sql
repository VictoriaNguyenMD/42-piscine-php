SELECT COUNT(`date`) as 'movies'
FROM member_history
WHERE
	(DATE(`date`) BETWEEN DATE('10/30/2006') AND DATE('07/27/2007')) OR
	(MONTH(`date`) = 12 AND DAY(`date`) = 24);
