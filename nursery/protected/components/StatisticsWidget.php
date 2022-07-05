<?php

/**
 *
 * Statistics widget. Displays some valuable (or may be not so valuable)
 * statistical information (amount of nurseries, room there and so on...)
 *
 * @author ftc
 */
class StatisticsWidget extends CWidget 
{
	public function run() 
	{
		$year = date("Y");
		$stat = new Statistics;
		$room = $stat->getTotalRoom();
		$totalreqs = $stat->countAcceptedRequests() + $stat->countAcceptedPrivilegedRequests();;
		$totaldirs = $stat->countIssuedDirections();
		// _assignment (request_id, nursery_id, priority) VALUES ({$this->id},{$nid},{$i})
		$this->render("statistics", array(
							'year' => $year,
							'room' => $room,
							'totalreqs' => $totalreqs,
							'totaldirs' => $totaldirs,
							));
    }
}
?>
