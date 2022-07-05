<?php

/**
 * Statistics model. Used for retrieving some statistical data about the system.
 * Used by Statistics widget and Front Site Controller
 */
class Statistics extends CModel
{
	public function getTotalRoom()
	{
		return Yii::app()->db->createCommand("SELECT SUM(place_number) FROM tbl_nursery")->queryScalar();
	}
	
	public function countAcceptedRequests()
	{
		$command = Yii::app()->db->createCommand("SELECT COUNT(*) FROM tbl_request WHERE DATEDIFF(NOW(),filing_date)<=365 AND (status<>:STATUS_UNPROCESSED) AND (status<>:STATUS_NOTCOMPLETED)".
													"AND (has_privilege=0) AND (out_of_queue=0)");
		$rsu = Request::STATUS_UNPROCESSED;
		$rnc = Request::STATUS_NOTCOMPLETED;
		$command->bindParam(':STATUS_UNPROCESSED', $rsu);
		$command->bindParam(':STATUS_NOTCOMPLETED', $rnc);
		return $command->queryScalar();
	}
	
	public function countAcceptedPrivilegedRequests()
	{
		$command = Yii::app()->db->createCommand("SELECT COUNT(*) FROM tbl_request WHERE DATEDIFF(NOW(),filing_date)<=365 AND (status<>:STATUS_UNPROCESSED) AND (status<>:STATUS_NOTCOMPLETED)".
													"AND ((has_privilege>0) OR (out_of_queue=1))");
		$rsu = Request::STATUS_UNPROCESSED;
		$rnc = Request::STATUS_NOTCOMPLETED;
		$command->bindParam(':STATUS_UNPROCESSED', $rsu);
		$command->bindParam(':STATUS_NOTCOMPLETED', $rnc);
		return $command->queryScalar();
	}
	
	public function countAcceptedRequestsByMicrodistrict()
	{
		$command = Yii::app()->db->createCommand("SELECT microdistrict_id as mid, COUNT(*) as val FROM tbl_request".
													" WHERE DATEDIFF(NOW(),filing_date)<=365 AND (status<>:STATUS_UNPROCESSED) AND (status<>:STATUS_NOTCOMPLETED)".
													" GROUP BY microdistrict_id");
		$rsu = Request::STATUS_UNPROCESSED;
		$rnc = Request::STATUS_NOTCOMPLETED;
		$command->bindParam(':STATUS_UNPROCESSED', $rsu);
		$command->bindParam(':STATUS_NOTCOMPLETED', $rnc);
		$reader = $command->query();
		$result = array();
		foreach ($reader as $row)
		{
			$curm = Microdistrict::model()->findByPk($row['mid']);
			$mname = $curm ? $curm->name : "Другие";
			$result[$mname] = $row['val'];
		}
		ksort($result);
		return $result;
	}
	
	public function countTotalChildren()
	{
		$command = Yii::app()->db->createCommand("SELECT COUNT(DISTINCT(CONCAT(name, surname, patronymic, document_series, document_number))) as val FROM tbl_request".
													" WHERE (status<>:STATUS_UNPROCESSED) AND (status<>:STATUS_NOTCOMPLETED)".
													" AND is_archive=0 ");
		$rsu = Request::STATUS_UNPROCESSED;
		$rnc = Request::STATUS_NOTCOMPLETED;
		$command->bindParam(':STATUS_UNPROCESSED', $rsu);
		$command->bindParam(':STATUS_NOTCOMPLETED', $rnc);
		return $command->queryScalar();
	}
	
	public function countQueuedChildren()
	{
		$command = Yii::app()->db->createCommand("SELECT COUNT(DISTINCT(CONCAT(name, surname, patronymic, document_series, document_number))) as val FROM tbl_request".
													" WHERE (status<>:STATUS_UNPROCESSED) AND (status<>:STATUS_NOTCOMPLETED)".
													" AND is_archive=0 AND queue_number>=0 AND has_privilege=0 AND out_of_queue=0");
		$rsu = Request::STATUS_UNPROCESSED;
		$rnc = Request::STATUS_NOTCOMPLETED;
		$command->bindParam(':STATUS_UNPROCESSED', $rsu);
		$command->bindParam(':STATUS_NOTCOMPLETED', $rnc);
		return $command->queryScalar();
	}
	
	public function countPrivilegedChildren()
	{
		$command = Yii::app()->db->createCommand("SELECT COUNT(DISTINCT(CONCAT(name, surname, patronymic, document_series, document_number))) as val FROM tbl_request".
													" WHERE (status<>:STATUS_UNPROCESSED) AND (status<>:STATUS_NOTCOMPLETED)".
													" AND is_archive=0 AND queue_number>=0 AND has_privilege>0 AND out_of_queue=0");
		$rsu = Request::STATUS_UNPROCESSED;
		$rnc = Request::STATUS_NOTCOMPLETED;
		$command->bindParam(':STATUS_UNPROCESSED', $rsu);
		$command->bindParam(':STATUS_NOTCOMPLETED', $rnc);
		return $command->queryScalar();
	}
	
	public function countOutOfQueueChildren()
	{
		$command = Yii::app()->db->createCommand("SELECT COUNT(DISTINCT(CONCAT(name, surname, patronymic, document_series, document_number))) as val FROM tbl_request".
													" WHERE (status<>:STATUS_UNPROCESSED) AND (status<>:STATUS_NOTCOMPLETED)".
													" AND is_archive=0 AND queue_number>=0 AND out_of_queue=1");
		$rsu = Request::STATUS_UNPROCESSED;
		$rnc = Request::STATUS_NOTCOMPLETED;
		$command->bindParam(':STATUS_UNPROCESSED', $rsu);
		$command->bindParam(':STATUS_NOTCOMPLETED', $rnc);
		return $command->queryScalar();
	}
	
	public function countChildrenByYear()
	{
		$command = Yii::app()->db->createCommand("SELECT YEAR(birth_date) as year, COUNT(DISTINCT(CONCAT(name, surname, patronymic, document_series, document_number))) as val FROM tbl_request".
													" WHERE (status<>:STATUS_UNPROCESSED) AND (status<>:STATUS_NOTCOMPLETED)".
													" AND is_archive=0 GROUP BY YEAR(birth_date)");
		$rsu = Request::STATUS_UNPROCESSED;
		$rnc = Request::STATUS_NOTCOMPLETED;
		$command->bindParam(':STATUS_UNPROCESSED', $rsu);
		$command->bindParam(':STATUS_NOTCOMPLETED', $rnc);
		$reader = $command->query();
		$result = array();
		foreach ($reader as $row)
		{
			$result[$row['year']] = $row['val'];
		}
		ksort($result);
		return $result;
	}
	
	public function countChildrenByMicrodistrict()
	{
		$command = Yii::app()->db->createCommand("SELECT microdistrict_id as mid, COUNT(DISTINCT(CONCAT(name, surname, patronymic, document_series, document_number))) as val FROM tbl_request".
													" WHERE (status<>:STATUS_UNPROCESSED) AND (status<>:STATUS_NOTCOMPLETED)".
													" AND is_archive=0 GROUP BY microdistrict_id");
		$rsu = Request::STATUS_UNPROCESSED;
		$rnc = Request::STATUS_NOTCOMPLETED;
		$command->bindParam(':STATUS_UNPROCESSED', $rsu);
		$command->bindParam(':STATUS_NOTCOMPLETED', $rnc);
		$reader = $command->query();
		$result = array();
		foreach ($reader as $row)
		{
			$curm = Microdistrict::model()->findByPk($row['mid']);
			$mname = $curm ? $curm->name : "Другие";
			$result[$mname] = $row['val'];
		}
		ksort($result);
		return $result;
	}
	
	public function countIssuedDirections()
	{
		$command = Yii::app()->db->createCommand("SELECT COUNT(DISTINCT(request_id)) as val FROM tbl_request_nursery_direction, tbl_request WHERE (DATEDIFF(NOW(),tbl_request_nursery_direction.create_time)<=365) AND (tbl_request_nursery_direction.request_id=tbl_request.id)");
		return $command->queryScalar();
	}
	
	public function countIssuedOutOfQueueDirections()
	{
		$command = Yii::app()->db->createCommand("SELECT COUNT(DISTINCT(request_id)) as val FROM tbl_request_nursery_direction, tbl_request WHERE (DATEDIFF(NOW(),tbl_request_nursery_direction.create_time)<=365)  AND tbl_request_nursery_direction.request_id=tbl_request.id ".
													" AND tbl_request.out_of_queue=1");
		return $command->queryScalar();
	}
	
	public function countIssuedPrivilegedDirections()
	{
		$command = Yii::app()->db->createCommand("SELECT COUNT(DISTINCT(request_id)) as val FROM tbl_request_nursery_direction, tbl_request WHERE (DATEDIFF(NOW(),tbl_request_nursery_direction.create_time)<=365)  AND tbl_request_nursery_direction.request_id=tbl_request.id ".
													" AND tbl_request.out_of_queue=0 AND tbl_request.has_privilege=1");
		return $command->queryScalar();
	}
	
	public function countIssuedDirectionsByYear()
	{
		$command = Yii::app()->db->createCommand("SELECT YEAR(tbl_request.birth_date) as year, COUNT(DISTINCT(request_id)) as val FROM tbl_request_nursery_direction, tbl_request WHERE (DATEDIFF(NOW(),tbl_request_nursery_direction.create_time)<=365)  AND tbl_request_nursery_direction.request_id=tbl_request.id ".
													" GROUP BY YEAR(tbl_request.birth_date)");
		$reader = $command->query();
		$result = array();
		foreach ($reader as $row)
		{
			$result[$row['year']] = $row['val'];
		}
		ksort($result);
		return $result;
	}
	
	public function countIssuedDirectionsByMicrodistrict()
	{
		$command = Yii::app()->db->createCommand("SELECT tbl_request.microdistrict_id as mid, COUNT(DISTINCT(request_id)) as val FROM tbl_request_nursery_direction, tbl_request WHERE (DATEDIFF(NOW(),tbl_request_nursery_direction.create_time)<=365)  AND tbl_request_nursery_direction.request_id=tbl_request.id ".
													" GROUP BY tbl_request.microdistrict_id");
		$reader = $command->query();
		$result = array();
		foreach ($reader as $row)
		{
			$curm = Microdistrict::model()->findByPk($row['mid']);
			$mname = $curm ? $curm->name : "Другие";
			$result[$mname] = $row['val'];
		}
		ksort($result);
		return $result;
	}
	
	public function attributeNames()
	{
		return array();
	}
}
