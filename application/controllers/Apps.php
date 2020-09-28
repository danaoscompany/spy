<?php

class Apps extends CI_Controller {
	
	public function get() {
		$adminID = intval($this->input->post('admin_id'));
		$userID = intval($this->input->post('user_id'));
		$apps = $this->db->query("SELECT * FROM apps WHERE user_id=" . $userID . " ORDER BY name")->result_array();
		for ($i=0; $i<sizeof($apps); $i++) {
			$app = $apps[$i];
			$blockedApps = $this->db->query("SELECT * FROM blocked_apps WHERE user_id=" . $userID . " AND admin_id=" . $adminID . " AND package_name='" . $app['package_name'] . "'")->result_array();
			if (sizeof($blockedApps) > 0) {
				$apps[$i]['blocked'] = true;
			} else {
				$apps[$i]['blocked'] = false;
			}
		}
		echo json_encode($apps);
	}
	
	public function block() {
		$adminID = intval($this->input->post('admin_id'));
		$userID = intval($this->input->post('user_id'));
		$packageName = $this->input->post('package_name');
		$blockedApps = $this->db->query("SELECT * FROM blocked_apps WHERE admin_id=" . $adminID . " AND user_id=" . $userID . " AND package_name='" . $packageName . "'")->result_array();
		if (sizeof($blockedApps) <= 0) {
			$this->db->query("INSERT INTO blocked_apps (admin_id, user_id, package_name) VALUES (" . $adminID . ", " . $userID . ", '" . $packageName . "')");
		}
	}
	
	public function unblock() {
		$adminID = intval($this->input->post('admin_id'));
		$userID = intval($this->input->post('user_id'));
		$packageName = $this->input->post('package_name');
		$this->db->query("DELETE FROM blocked_apps WHERE admin_id=" . $adminID . " AND user_id=" . $userID . " AND package_name='" . $packageName . "'");
	}
}
