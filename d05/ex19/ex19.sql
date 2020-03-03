SELECT DATEDIFF(max(`date`), min(`date`)) AS 'uptime'
FROM member_history;