<?php

class Locations extends CI_Controller {
	
	public function get() {
		$userID = intval($this->input->post('user_id'));
		$date = $this->input->post('date');
		echo json_encode($this->db->query("SELECT * FROM locations WHERE user_id=" . $userID . " AND DATE(date)='" . $date . "'")->result_array());
	}
	
	public function get_all() {
		$userID = intval($this->input->post('user_id'));
		echo json_encode($this->db->query("SELECT * FROM locations WHERE user_id=" . $userID . " ORDER BY date DESC")->result_array());
	}
}
