<?php

/**
 * Модель внутренней статистики. Используется AdminStatController для формирования
 * статистических отчетов
 */
class AdminStat extends CModel
{
	/**
	 * @var integer начало диапазона дат
	 */
	private $dateFrom = '';
	/**
	 * @var integer конец диапазона дат
	 */
	private $dateTo = '';
	
	function __construct()
	{
		$this->dateFrom = isset($_GET['Stat_dateFrom']) ? $_GET['Stat_dateFrom'] : "";
		$this->dateTo = isset($_GET['Stat_dateTo']) ? $_GET['Stat_dateTo'] : "";
	}
	
	/**
	 * Возвращает общее количество состоящих на учете детей
	 * @return integer 
	 */
 	public function getTotalRequestCount()
	{
		$command = Yii::app()->db->createCommand(
			"SELECT COUNT(DISTINCT(r.id)) as val FROM tbl_request r "
			." WHERE r.is_archive=0"
		);

		return $command->queryScalar();
	}

	/**
	 * Возвращает количество состоящих на учете детей, подавших заявления через интернет
	 * @return integer
	 */
 	public function getInternetRequestCount()
	{
		$command = Yii::app()->db->createCommand(
			"SELECT COUNT(DISTINCT(r.id)) as val FROM tbl_request r "
			." WHERE r.is_archive=0 AND r.is_internet=1"
		);

		return $command->queryScalar();
	}

	/**
	 * Возвращает количество состоящих на учете детей в заданном возрастном диапазоне
	 * @param integer начало диапазона возрастов в месяцах
	 * @param integer конец диапазона возрастов в месяцах
	 * @return integer 
	 */
	public function getRequestCountByAge($from, $to)
	{
		$command = Yii::app()->db->createCommand(
			"SELECT COUNT(DISTINCT(r.id)) as val FROM tbl_request r "
			." WHERE PERIOD_DIFF(date_format(now(), '%Y%m'), date_format(r.birth_date, '%Y%m')) >= $from "
			." AND PERIOD_DIFF(date_format(now(), '%Y%m'), date_format(r.birth_date, '%Y%m')) <= $to"
			." AND r.is_archive=0"
		);
		return $command->queryScalar();
	}

	/**
	 * Возвращает количество состоящих на учете детей, сгруппированных по годам
	 * @return array
	 */
	public function getRequestCountByYears()
	{
		$command = Yii::app()->db->createCommand(
			 " SELECT count(distinct(r.id)) as cnt, year(r.birth_date) as year FROM tbl_request r "
			." WHERE r.is_archive=0 group by year(r.birth_date) order by r.birth_date desc"
		);

		return $command->query();
	}

	/**
	 * Возвращает количество состоящих на учете детей, сгруппированных по микрорайонам
	 * @return array
	  */
	public function getRequestCountByMicrodistricts()
	{
		$command = Yii::app()->db->createCommand(
			 " SELECT count(distinct(r.id)) as cnt, m.name as microdistrict FROM tbl_request r, tbl_microdistrict m "
			." WHERE r.microdistrict_id=m.id AND r.is_archive=0 group by m.name order by m.name"
		);

		return $command->query();
	}

	/**
	 * Возвращает количество состоящих на учете детей-внеочередников
	 * @return integer 
	 */
	public function getRequestCountOutOfQueue()
	{
		$command = Yii::app()->db->createCommand(
			"SELECT COUNT(DISTINCT(r.id)) as val FROM tbl_request r "
			." WHERE r.out_of_queue=1 AND r.has_privilege=0 AND r.is_archive=0"
		);
		return $command->queryScalar();
	}
	
	/**
	 * Возвращает количество состоящих на учете детей со льготами
	 * @return integer 
	 */
	public function getRequestCountPrivilege()
	{
		$command = Yii::app()->db->createCommand(
			"SELECT COUNT(DISTINCT(r.id)) as val FROM tbl_request r "
			." WHERE r.has_privilege=1 AND r.out_of_queue=0 AND r.is_archive=0"
		);
		return $command->queryScalar();
	}
	
	/**
	 * Возвращает количество состоящих на учете детей со льготами и вне очереди
	 * @return integer 
	 */
	public function getTotalRequestCountPrivilege()
	{
		$command = Yii::app()->db->createCommand(
			"SELECT COUNT(DISTINCT(r.id)) as val FROM tbl_request r "
			." WHERE (r.has_privilege=1 OR r.out_of_queue=1) AND r.is_archive=0"
		);
		return $command->queryScalar();
	}

	/**
	 * Формирует условие фильтра по датам для статистики по принятым заявлениям
	 * @return string 
	 */
	private function getRegisteredDateFilter()
	{
		$where = "NOT r.register_date IS NULL";
		if ($this->dateFrom != "")
			$where .= " AND r.create_time >= '".$this->dateFrom."'";
		if ($this->dateTo != "")
			$where .= " AND r.create_time <= '".$this->dateTo."'";

		return $where;
	}
	
	/**
	 * Возвращает общее количество принятых заявлений
	 * @param integer начало диапазона возрастов в месяцах
	 * @param integer конец диапазона возрастов в месяцах
	 * @return integer 
	 */
	public function getTotalRegisteredCount()
	{
		$command = Yii::app()->db->createCommand(
			"SELECT COUNT(DISTINCT(r.id)) as val FROM tbl_request r "
			." WHERE ".$this->getRegisteredDateFilter()
		);

		return $command->queryScalar();
	}

	public function getInternetRegisteredCount()
	{
		$command = Yii::app()->db->createCommand(
			"SELECT COUNT(DISTINCT(r.id)) as val FROM tbl_request r "
			." WHERE ".$this->getRegisteredDateFilter()
			." AND is_internet=1"
		);

		return $command->queryScalar();
	}

	/**
	 * Возвращает количество принятых заявлений, сгруппированных по годам рождения
	 * @return array 
	 */
	public function getRegisteredCountByYears()
	{
		$command = Yii::app()->db->createCommand(
			 " SELECT count(distinct(r.id)) as cnt, year(r.birth_date) as year FROM tbl_request r "
			." WHERE ".$this->getRegisteredDateFilter()
			." GROUP BY year(r.birth_date) order by r.birth_date desc"
		);

		return $command->query();
	}

	/**
	 * Возвращает количество принятых заявлений, сгруппированных по микрорайонам
	 * @return array 
	  */
	public function getRegisteredCountByMicrodistricts()
	{
		$command = Yii::app()->db->createCommand(
			 " SELECT count(distinct(r.id)) as cnt, m.name as microdistrict FROM tbl_request r, tbl_microdistrict m "
			." WHERE ".$this->getRegisteredDateFilter()
			." AND r.microdistrict_id=m.id"
			." GROUP BY m.name order by m.name"
		);

		return $command->query();
	}

	/**
	 * Возвращает количество принятых заявлений внеочередников
	 * @return integer 
	 */
	public function getRegisteredCountOutOfQueue()
	{
		$command = Yii::app()->db->createCommand(
			"SELECT COUNT(DISTINCT(r.id)) as val FROM tbl_request r "
			." WHERE ".$this->getRegisteredDateFilter()
			." AND r.out_of_queue=1 AND r.has_privilege=0"
		);
		return $command->queryScalar();
	}

	/**
	 * Возвращает количество принятых заявлений от льготников
	 * @return integer 
	 */
	public function getRegisteredCountPrivilege()
	{
		$command = Yii::app()->db->createCommand(
			"SELECT COUNT(DISTINCT(r.id)) as val FROM tbl_request r "
			." WHERE ".$this->getRegisteredDateFilter()
			." AND r.has_privilege=1 AND r.out_of_queue=0"
		);
		return $command->queryScalar();
	}

	/**
	 * Возвращает количество принятых заявлений со льготами и вне очереди
	 * @return integer 
	 */
	public function getTotalRegisteredCountPrivilege()
	{
		$command = Yii::app()->db->createCommand(
			"SELECT COUNT(DISTINCT(r.id)) as val FROM tbl_request r "
			." WHERE ".$this->getRegisteredDateFilter()
			." AND (r.has_privilege=1 OR r.out_of_queue=1)"
		);
		return $command->queryScalar();
	}

	/**
	 * Возвращает количество освободившихся мест, сгруппированных по возрастным группам
	 * @return array 
	 */
	public function getPlaceCountByAge()
	{
		$command = Yii::app()->db->createCommand(
			"  SELECT sum(free_places) as cnt, g.name as age FROM tbl_nursery_group ng, tbl_group_type g "
			." WHERE ng.group_id=g.id AND g.is_different_ages=0 GROUP BY g.id ORDER BY g.name"
		);

		return $command->query();
	}

	/**
	 * Возвращает количество освободившихся мест, сгруппированных по МДОУ
	 * @return array 
	 */
	public function getPlaceCountByNursery()
	{
		$command = Yii::app()->db->createCommand(
			"  SELECT sum(free_places) as cnt, n.short_name as nursery FROM tbl_nursery_group ng, tbl_nursery n "
			." WHERE ng.nursery_id=n.id GROUP BY n.id ORDER BY n.short_number"
		);

		return $command->query();
	}

	/**
	 * Возвращает количество освободившихся мест в заданной возрастной группе МДОУ
	 * @param integer id МДОУ
	 * @param integer id возрастной группы
	 * @return integer 
	 */
	public function getPlaceCountByNurseryAge($nursery, $group)
	{
		$command = Yii::app()->db->createCommand(
			"  SELECT sum(free_places) as cnt FROM tbl_nursery_group ng "
			." WHERE ng.nursery_id=".$nursery->id." AND ng.group_id=".$group->id
		);

		return $command->queryScalar();
	}

	/**
	 * Формирует условие фильтра по датам для статистики по выданным направлениям
	 * @return string 
	 */
	private function getDirectionDateFilter()
	{
		$where = "d.request_id=r.id";
		if ($this->dateFrom != "")
			$where .= " AND d.create_time >= '".$this->dateFrom."'";
		if ($this->dateTo != "")
			$where .= " AND d.create_time <= '".$this->dateTo."'";
		
		return $where;		
	}
	
	/**
	 * Возвращает общее количество выданных направлений
	 * @return integer 
	 */
	public function getTotalDirectionCount()
	{
		$command = Yii::app()->db->createCommand(
			"SELECT COUNT(DISTINCT(request_id)) as val FROM tbl_request_nursery_direction d, tbl_request r "
			." WHERE ".$this->getDirectionDateFilter()
		);

		return $command->queryScalar();
	}

	/**
	 * Возвращает количество выданных направлений для заявлений, поданных через интернет
	 * @return integer
	 */
	public function getInternetDirectionCount()
	{
		$command = Yii::app()->db->createCommand(
			"SELECT COUNT(DISTINCT(request_id)) as val FROM tbl_request_nursery_direction d, tbl_request r "
			." WHERE ".$this->getDirectionDateFilter()
			." AND is_internet=1"
		);

		return $command->queryScalar();
	}

	/**
	 * Возвращает количество выданных направлений в заданном интервале возрастов
	 * @param integer начало диапазона возрастов в месяцах
	 * @param integer конец диапазона возрастов в месяцах
	 * @return integer 
	 */
	public function getDirectionCountByAge($from, $to)
	{
		$command = Yii::app()->db->createCommand(
			"SELECT COUNT(DISTINCT(request_id)) as val FROM tbl_request_nursery_direction d, tbl_request r "
			." WHERE PERIOD_DIFF(date_format(d.create_time, '%Y%m'), date_format(r.birth_date, '%Y%m')) >= $from "
			." AND PERIOD_DIFF(date_format(d.create_time, '%Y%m'), date_format(r.birth_date, '%Y%m')) <= $to"
			." AND ".$this->getDirectionDateFilter()
		);
		return $command->queryScalar();
	}

	/**
	 * Возвращает количество выданных направлений внеочередникам
	 * @return integer 
	 */
	public function getDirectionCountOutOfQueue()
	{
		$command = Yii::app()->db->createCommand(
			"SELECT COUNT(DISTINCT(request_id)) as val FROM tbl_request_nursery_direction d, tbl_request r "
			." WHERE r.out_of_queue=1 AND r.has_privilege=0 AND ".$this->getDirectionDateFilter()
		);
		return $command->queryScalar();
	}
	
	/**
	 * Возвращает количество выданных направлений со льготами
	 * @return integer 
	 */
	public function getDirectionCountPrivilege()
	{
		$command = Yii::app()->db->createCommand(
			"SELECT COUNT(DISTINCT(request_id)) as val FROM tbl_request_nursery_direction d, tbl_request r "
			." WHERE r.has_privilege=1 AND r.out_of_queue=0 AND ".$this->getDirectionDateFilter()
		);
		return $command->queryScalar();
	}
	
	/**
	 * Возвращает количество выданных направлений со льготами и внеочередникам
	 * @return integer 
	 */
	public function getTotalDirectionCountPrivilege()
	{
		$command = Yii::app()->db->createCommand(
			"SELECT COUNT(DISTINCT(request_id)) as val FROM tbl_request_nursery_direction d, tbl_request r "
			." WHERE (r.has_privilege=1 OR r.out_of_queue=1) AND ".$this->getDirectionDateFilter()
		);
		return $command->queryScalar();
	}
	
	/**
	 * Возвращает количество выданных направлений, сгруппированных по годам
	 * @return array 
	 */
	public function getDirectionCountByYears()
	{
		$command = Yii::app()->db->createCommand(
			 " SELECT count(distinct(r.id)) as cnt, year(r.birth_date) as year FROM tbl_request r, tbl_request_nursery_direction d "
			." WHERE ".$this->getDirectionDateFilter()." group by year(r.birth_date) order by r.birth_date desc"
		);

		return $command->query();
	}

	/**
	 * Возвращает количество выданных направлений, сгруппированных по микрорайонам
	 * @return array 
	 */
	public function getDirectionCountByMicrodistricts()
	{
		$command = Yii::app()->db->createCommand(
			 " SELECT count(distinct(r.id)) as cnt, m.name as microdistrict FROM tbl_request r, tbl_request_nursery_direction d, tbl_microdistrict m "
			." WHERE r.microdistrict_id=m.id AND ".$this->getDirectionDateFilter()." group by m.name order by m.name"
		);

		return $command->query();
	}

	/**
	 * Возвращает количество детей, выбывших из очереди, сгруппированных по причинам
	 * @return array
	 */
	public function getExcludedRequestCountByReason()
	{
		$command = Yii::app()->db->createCommand(
			"SELECT count(distinct(r.id)) as cnt, reason.name as reason "
			." FROM tbl_request r, tbl_operation_log l, tbl_operation_reason reason "
			." WHERE r.id=l.request_id AND reason.id=l.reason_id "
			." GROUP BY reason.id ORDER BY reason.name"
		);

		return $command->query();
	}

	public function attributeNames()
	{
		return array();
	}
}
