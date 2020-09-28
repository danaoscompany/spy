<?php

class Devices extends CI_Controller {
	
	public function get() {
		$adminID = intval($this->input->post('admin_id'));
		echo json_encode($this->db->query("SELECT * FROM devices WHERE admin_id=" . $adminID . " ORDER BY name ASC")->result_array());
	}
	
	public function add() {
		$adminID = intval($this->input->post('admin_id'));
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$users = $this->db->query("SELECT * FROM users WHERE email='" . $email . "'")->result_array();
		if (sizeof($users) > 0) {
			$user = $users[0];
			$userID = intval($user['id']);
			$this->db->query("INSERT INTO devices (admin_id, user_id, name) VALUES (" . $adminID . ", " . $userID . ", '" . $name . "')");
			echo json_encode(array(
				'response_code' => 1
			));
		} else {
			echo json_encode(array(
				'response_code' => -1
			));
		}
	}
}
