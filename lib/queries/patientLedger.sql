/*
	This query will pull all ledger entires
	parms   startdate  enddate  patient
*/

declare @chart as varchar(32)
set @chart = ?
	
IF OBJECT_ID('tempdb..#DATA') IS NOT NULL DROP TABLE #DATA
IF OBJECT_ID('tempdb..#CLAIMS') IS NOT NULL DROP TABLE #CLAIMS

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
		WHEN pl.CHART_STATUS = 90 AND pl.CLASS = 1 THEN 'Payment'
		WHEN pl.CHART_STATUS = 90 AND pl.CLASS = 2 THEN 'Adjustment'
		WHEN pl.CHART_STATUS = 90 AND pl.CLASS = 3 THEN 'Dent Ins.'
		ELSE '--'
	END AS ADACODE,
	CASE
		WHEN pl.CHART_STATUS = 102 THEN pc.DESCRIPTION
		WHEN pl.CHART_STATUS = 90 AND pl.CLASS = 1 THEN
			(SELECT d.Description FROM DDB_Def_RO AS d WHERE pl.ORD = d.DefID AND d.Type = 6)
		WHEN pl.CHART_STATUS = 90 AND pl.CLASS = 2 THEN
			(SELECT d.Description FROM DDB_Def_RO AS d WHERE pl.ORD = d.DefID AND d.Type = 9)
		WHEN pl.CHART_STATUS = 90 AND pl.CLASS = 3 THEN 'Prim Dent Ins. Payment'
		ELSE '--'
	END AS description,
	clinic.RSCID AS clinic,
	clinic.PRACTITLE,
	pat.CHART,
	pat.LASTNAME,
	pat.FIRSTNAME,
	CAST(pat.BIRTHDATE AS DATE) AS birthdate,
	CASE
		WHEN pat.GENDER = 1 THEN 'M'
		ELSE 'F'
	END AS gender,
	CASE
		WHEN pl.TOOTH_RANGE_START = 0 AND pl.SURF_STRING <> '' THEN pl.SURF_STRING
		WHEN pl.TOOTH_RANGE_START = 0 AND pl.SURF_STRING = '' THEN ''
		ELSE CAST(pl.TOOTH_RANGE_START AS VARCHAR(2))
	END as tooth,
	CASE
		WHEN pl.CHART_STATUS = 102 THEN (SELECT RSCID FROM DDB_RSC AS r WHERE pl.PROVID = r.URSCID)
		ELSE ''
	END as provider,
	pl.SURF_STRING as test
INTO
	#DATA
FROM
	DDB_PROC_LOG AS pl
	JOIN DDB_PROC_CODE AS pc ON pl.PROC_CODEID = pc.PROC_CODEID
	JOIN DDB_RSC AS clinic ON pl.ClinicAppliedTo = clinic.URSCID
	JOIN DDB_PAT AS pat ON pl.PATID = pat.PATID
WHERE
	pl.CREATEDATE >= '2009-09-01'
	AND pat.CHART = @chart
	AND (
		(pl.CHART_STATUS = 102) OR
		(pl.CHART_STATUS = 90 AND pl.CLASS = 1) OR
		(pl.CHART_STATUS = 90 AND pl.CLASS = 2) OR
		(pl.CHART_STATUS = 90 AND pl.CLASS = 3)
	)

SELECT
	CASE
		WHEN cl.STATUS = 2 THEN CAST(cl.DATERECEIVED AS DATE)
		ELSE CAST(cl.DATEOFCLAIM AS DATE)
	END AS createDate,
	'                  ' AS tooth,
	'Dent Ins.       ' AS ADACODE,
	CASE
		WHEN cl.STATUS = 2 THEN 'Prim Claim' + '- Received         ' + CAST(cl.TOTALBILLED*.01 AS VARCHAR(16)) 
		ELSE 'Prim Claim' + '- Sent           ' + CAST(cl.TOTALBILLED*.01 AS VARCHAR(16))
	END AS DESCRIPTION,
	cl.TOTALBILLED*.01 AS amount,
	'                          ' AS provider,
	clinic.RSCID AS clinic,
	'Claim                   ' AS lineType
INTO #CLAIMS
FROM
	DDB_CLAIM AS cl
	JOIN DDB_PAT AS pat ON cl.PATID = pat.PATID
	JOIN DDB_RSC AS clinic on cl.ClinicAppliedTo = clinic.URSCID
WHERE
	pat.CHART = @chart

INSERT INTO #CLAIMS
SELECT
	createDate,
	tooth,
	ADACODE,
	DESCRIPTION,
	amount,
	provider,
	clinic,
	lineType
FROM #DATA

DELETE FROM #CLAIMS WHERE createDate < '2009-09-01'
UPDATE #CLAIMS SET amount = NULL WHERE lineType = 'Claim'

SELECT
	*
FROM
	#CLAIMS
ORDER BY
	createDate
