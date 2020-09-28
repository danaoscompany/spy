<?php

class User extends CI_Controller {
	
	public function get() {
		$userID = intval($this->input->post('id'));
		echo json_encode($this->db->query("select * from users where id=" . $userID)->row_array());
	}
	
	public function get_data_url() {
		$path = $this->input->post('filename');
		echo json_encode("http://192.168.43.182/spy/userdata/" . $path);
	}
	
	public function get_calls() {
		$userID = intval($this->input->post('user_id'));
		echo json_encode($this->db->query("select * from calls where user_id=" . $userID . " ORDER BY date DESC")->result_array());
	}
	
	public function get_calls_by_date() {
		$userID = intval($this->input->post('user_id'));
		$startDate = $this->input->post('start_date');
		$endDate = $this->input->post('end_date');
		echo json_encode($this->db->query("select * from calls where user_id=" . $userID . " AND DATE(date)>='" . $startDate . "' AND DATE(date)<'" . $endDate . "' ORDER BY date DESC")->result_array());
	}
	
	public function get_calls_in_week() {
		$userID = intval($this->input->post('user_id'));
		$calls = $this->db->query("select * from calls where user_id=" . $userID . " GROUP BY DATE(date) ORDER BY date DESC LIMIT 7")->result_array();
		for ($i=0; $i<sizeof($calls); $i++) {
			$call = $calls[$i];
			$date = substr($call['date'], 0, strpos($call['date'], " "));
			$totalIncoming = 0;
			$totalOutcoming = 0;
			$callsByDate = $this->db->query("select * from calls where user_id=" . $userID . " AND DATE(date)='" . $date . "'")->result_array();
			for ($j=0; $j<sizeof($callsByDate); $j++) {
				$callByDate = $callsByDate[$j];
				if ($callByDate['type'] == 'incoming') {
					$totalIncoming++;
				} else if ($callByDate['type'] == 'outcoming') {
					$totalOutcoming++;
				}
			}
			$calls[$i]['incoming'] = $totalIncoming;
			$calls[$i]['outcoming'] = $totalOutcoming;
		}
		echo json_encode($calls);
	}
	
	public function get_calls_in_month() {
		$userID = intval($this->input->post('user_id'));
		$calls = $this->db->query("select * from calls where user_id=" . $userID . " GROUP BY DATE(date) ORDER BY date DESC LIMIT 30")->result_array();
		for ($i=0; $i<sizeof($calls); $i++) {
			$call = $calls[$i];
			$date = substr($call['date'], 0, strpos($call['date'], " "));
			$totalIncoming = 0;
			$totalOutcoming = 0;
			$callsByDate = $this->db->query("select * from calls where user_id=" . $userID . " AND DATE(date)='" . $date . "'")->result_array();
			for ($j=0; $j<sizeof($callsByDate); $j++) {
				$callByDate = $callsByDate[$j];
				if ($callByDate['type'] == 'incoming') {
					$totalIncoming++;
				} else if ($callByDate['type'] == 'outcoming') {
					$totalOutcoming++;
				}
			}
			$call['incoming'] = $totalIncoming;
			$call['outcoming'] = $totalOutcoming;
		}
		echo json_encode($calls);
	}
}
