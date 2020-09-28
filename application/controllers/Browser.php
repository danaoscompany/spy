<?php

class Browser extends CI_Controller {
	
	public function get_bookmarks() {
		$userID = intval($this->input->post('user_id'));
		$histories = $this->db->query("SELECT * FROM bookmarks WHERE user_id=" . $userID . " GROUP BY url ORDER BY date DESC")->result_array();
		for ($i=0; $i<sizeof($histories); $i++) {
			$history = $histories[$i];
			$histories[$i]['total_visits'] = sizeof($this->db->query("SELECT * FROM browsing_histories WHERE user_id=" . $userID . " AND url='" . $history['url'] . "'")->result_array());
		}
		echo json_encode($histories);
	}
	
	public function get_top_sites() {
		$userID = intval($this->input->post('user_id'));
		$startDate = $this->input->post('start_date');
		$endDate = $this->input->post('end_date');
		$histories = $this->db->query("SELECT * FROM browsing_histories WHERE user_id=" . $userID . " AND DATE(date)>='" . $startDate . "' AND DATE(date)<'" . $endDate . "' GROUP BY url")->result_array();
		for ($i=0; $i<sizeof($histories); $i++) {
			$history = $histories[$i];
			$histories[$i]['total_visits'] = sizeof($this->db->query("SELECT * FROM browsing_histories WHERE user_id=" . $userID . " AND url='" . $history['url'] . "'")->result_array());
		}
		echo json_encode($histories);
	}
	
	public function get_histories() {
		$userID = intval($this->input->post('user_id'));
		$histories = $this->db->query("SELECT * FROM browsing_histories WHERE user_id=" . $userID . " GROUP BY url ORDER BY date DESC")->result_array();
		for ($i=0; $i<sizeof($histories); $i++) {
			$history = $histories[$i];
			$histories[$i]['page_title'] = $this->db->query("SELECT * FROM browsing_histories WHERE user_id=" . $userID . " AND url='" . $history['url'] . "' ORDER BY date DESC LIMIT 1")->row_array()['page_title'];
			$histories[$i]['total_visits'] = sizeof($this->db->query("SELECT * FROM browsing_histories WHERE user_id=" . $userID . " AND url='" . $history['url'] . "'")->result_array());
		}
		echo json_encode($histories);
	}
}
