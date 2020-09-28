<?php

class Screentimes extends CI_Controller {
	
	public function get_launches() {
		$adminID = intval($this->input->post('admin_id'));
		$userID = intval($this->input->post('user_id'));
		$apps = $this->db->query("SELECT * FROM apps WHERE user_id=" . $userID . " GROUP BY package_name")->result_array();
		for ($i=0; $i<sizeof($apps); $i++) {
			$app = $apps[$i];
			$blockedApps = $this->db->query("SELECT * FROM blocked_apps WHERE user_id=" . $userID . " AND admin_id=" . $adminID . " AND package_name='" . $app['package_name'] . "'")->result_array();
			if (sizeof($blockedApps) > 0) {
				$apps[$i]['blocked'] = true;
			} else {
				$apps[$i]['blocked'] = false;
			}
			$apps[$i]['launches'] = sizeof($this->db->query("SELECT * FROM app_launches WHERE user_id=" . $userID . " AND package_name='" . $app['package_name'] . "'")->result_array());
		}
		echo json_encode($apps);
	}
}
