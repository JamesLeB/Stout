where
	lineTime like '%:00:00'
	and lineDate >= '2014-02-15'
	and ltc is not null
/*
	lineDate = '2014-02-22'
	or lineTime = '12:00:00'
	or lineTime = '06:00:00'
	or lineTime = '18:00:00'
*/
order by
	lineDate,lineTime
