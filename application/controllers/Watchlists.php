<?php

class Watchlists extends CI_Controller {
	
	public function add() {
		$adminID = intval($this->input->post('admin_id'));
		$userID = intval($this->input->post('user_id'));
		$phone = $this->input->post('phone');
		$this->db->query("INSERT INTO contact_watchlists (admin_id, user_id, phone) VALUES (" . $adminID . ", " . $userID . ", '" . $phone . "')");
	}
}
