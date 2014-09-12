/*
	This query will pull all ledger entires
	parms   startdate  enddate  patient
*/
IF OBJECT_ID('tempdb..#DATA') IS NOT NULL DROP TABLE #DATA

SELECT
	pl.PROC_LOGID,
	pl.CHART_STATUS,
	pl.CLASS,
	pl.ORD,
	CASE
		WHEN pl.CHART_STATUS = 102 THEN 'Procedure'
		WHEN pl.CHART_STATUS = 90 AND pl.CLASS = 1 THEN 'PatientPayment'
		WHEN pl.CHART_STATUS = 90 AND pl.CLASS = 2 THEN 'Adjustment'
		WHEN pl.CHART_STATUS = 90 AND pl.CLASS = 3 THEN 'InsurancePayment'
		ELSE 'ERROR'
	END AS lineType,
	CAST(pl.CREATEDATE AS DATE) AS createDate,
	pl.AMOUNT * .01 AS amount,
	CASE
		WHEN pl.CHART_STATUS = 102 THEN pc.ADACODE
		ELSE '--'
	END AS ADACODE,
	pc.DESCRIPTION,
	clinic.RSCID AS clinic,
	clinic.PRACTITLE,
	pat.CHART,
	pat.LASTNAME,
	pat.FIRSTNAME,
	CAST(pat.BIRTHDATE AS DATE) AS birthdate,
	CASE
		WHEN pat.GENDER = 1 THEN 'M'
		ELSE 'F'
	END AS gender
INTO
	#DATA
FROM
	DDB_PROC_LOG AS pl
	JOIN DDB_PROC_CODE AS pc ON pl.PROC_CODEID = pc.PROC_CODEID
	JOIN DDB_RSC AS clinic ON pl.ClinicAppliedTo = clinic.URSCID
	JOIN DDB_PAT AS pat ON pl.PATID = pat.PATID
WHERE
	pl.CREATEDATE >= '2009-09-01'
	AND pat.CHART = ?
	AND (
		(pl.CHART_STATUS = 102) OR
		(pl.CHART_STATUS = 90 AND pl.CLASS = 1) OR
		(pl.CHART_STATUS = 90 AND pl.CLASS = 2) OR
		(pl.CHART_STATUS = 90 AND pl.CLASS = 3)
	)

SELECT * FROM #DATA
