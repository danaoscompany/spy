<?php

class Login extends CI_Controller {
	
	public function index() {
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$admins = $this->db->query("select * from admins where email='" . $email . "'")->result_array();
		if (sizeof($admins) > 0) {
			$admin = $admins[0];
			if ($admin['password'] == $password) {
				echo json_encode(array(
					'response_code' => 1,
					'admin_id' => $admin['id']
				));
			} else {
				echo json_encode(array(
					'response_code' => -1
				));
			}
		} else {
			echo json_encode(array(
				'response_code' => -2
			));
		}
	}
	
	public function test() {
		echo "hello world";
	}
}
