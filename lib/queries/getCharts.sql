/*
	Query to pull patient chart list
*/

SELECT
	pat.CHART
FROM
	DDB_PAT as pat
WHERE
	pat.CHART IS NOT NULL
	AND pat.CHART <> ''
ORDER BY
	pat.CHART DESC