<?php

class Videos extends CI_Controller {
	
	public function get() {
		$userID = intval($this->input->post('user_id'));
		echo json_encode($this->db->query("SELECT * FROM videos WHERE user_id=" . $userID . " ORDER BY date DESC")->result_array());
	}
}
