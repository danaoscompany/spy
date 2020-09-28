<?php

class Texts extends CI_Controller {
	
	public function get_conversations() {
		$userID = intval($this->input->post('user_id'));
		$texts = $this->db->query("SELECT * FROM texts WHERE id IN ( SELECT MAX(id) FROM texts GROUP BY phone ) AND user_id=" . $userID)->result_array();
		echo json_encode($texts);
	}
	
	public function get_contacts() {
		$adminID = intval($this->input->post('admin_id'));
		$userID = intval($this->input->post('user_id'));
		$contacts = $this->db->query("SELECT * FROM contacts WHERE user_id=" . $userID . " ORDER BY name")->result_array();
		for ($i=0; $i<sizeof($contacts); $i++) {
			$contact = $contacts[$i];
			$phone = "";
			if ($contact['phone'] != NULL && $contact['phone'] != "") {
				$phone = $contact['phone'];
			} else if ($contact['office'] != NULL && $contact['office'] != "") {
				$phone = $contact['office'];
			}
			$watchlists = $this->db->query("SELECT * FROM contact_watchlists WHERE admin_id=" . $adminID . " AND user_id=" . $userID
				. " AND phone='" . $phone . "'")->result_array();
			if (sizeof($watchlists) > 0) {
				$contact['watchlisted'] = true;
			} else {
				$contact['watchlisted'] = false;
			}
		}
		echo json_encode($contacts);
	}
	
	public function get_mails() {
		$userID = intval($this->input->post('user_id'));
		$texts = $this->db->query("SELECT * FROM mails WHERE user_id=" . $userID . " ORDER BY date")->result_array();
		echo json_encode($texts);
	}
	
	public function get_calendars() {
		$userID = intval($this->input->post('user_id'));
		$texts = $this->db->query("SELECT * FROM calendars WHERE user_id=" . $userID . " ORDER BY date")->result_array();
		echo json_encode($texts);
	}
	
	public function get_messages() {
		$userID = intval($this->input->post('user_id'));
		$phone = $this->input->post('phone');
		$texts = $this->db->query("SELECT * FROM texts WHERE user_id=" . $userID . " AND shown=1 ORDER BY date DESC")->result_array();
		echo json_encode($texts);
	}
	
	public function delete_message() {
		$id = intval($this->input->post('id'));
		$texts = $this->db->query("DELETE FROM texts WHERE id=" . $id);
	}
	
	public function delete_mail() {
		$id = intval($this->input->post('id'));
		$this->db->query("DELETE FROM mails WHERE id=" . $id);
	}
	
	public function hide_message() {
		$id = intval($this->input->post('id'));
		$this->db->query("UPDATE texts SET shown=0 WHERE id=" . $id);
	}
	
	public function delete_conversation() {
		$userID = intval($this->input->post('user_id'));
		$phone = $this->input->post('phone');
		$this->db->query("DELETE FROM texts WHERE user_id=" . $userID . " AND phone='" . $phone . "'");
	}
	
	public function get_in_week() {
		$userID = intval($this->input->post('user_id'));
		$texts = $this->db->query("select * from texts where user_id=" . $userID . " GROUP BY DATE(date) ORDER BY date DESC LIMIT 7")->result_array();
		for ($i=0; $i<sizeof($texts); $i++) {
			$text = $texts[$i];
			$date = substr($text['date'], 0, strpos($text['date'], " "));
			$totalIncoming = 0;
			$totalOutcoming = 0;
			$textsByDate = $this->db->query("select * from texts where user_id=" . $userID . " AND DATE(date)='" . $date . "'")->result_array();
			for ($j=0; $j<sizeof($textsByDate); $j++) {
				$textByDate = $textsByDate[$j];
				if ($textByDate['type'] == 'incoming') {
					$totalIncoming++;
				} else if ($textByDate['type'] == 'outcoming') {
					$totalOutcoming++;
				}
			}
			$texts[$i]['incoming'] = $totalIncoming;
			$texts[$i]['outcoming'] = $totalOutcoming;
		}
		echo json_encode($texts);
	}
	
	public function get_in_month() {
		$userID = intval($this->input->post('user_id'));
		$texts = DB::select("select * from texts where user_id=" . $userID . " GROUP BY DATE(date) ORDER BY date DESC LIMIT 30");
		for ($i=0; $i<sizeof($texts); $i++) {
			$text = $texts[$i];
			$date = substr($text['date'], 0, strpos($text['date'], " "));
			$totalIncoming = 0;
			$totalOutcoming = 0;
			$textsByDate = DB::select("select * from texts where user_id=" . $userID . " AND DATE(date)='" . $date . "'");
			for ($j=0; $j<sizeof($textsByDate); $j++) {
				$textByDate = $textsByDate[$j];
				if ($textByDate['type'] == 'incoming') {
					$totalIncoming++;
				} else if ($textByDate['type'] == 'outcoming') {
					$totalOutcoming++;
				}
			}
			$text['incoming'] = $totalIncoming;
			$text['outcoming'] = $totalOutcoming;
		}
		echo json_encode($texts);
	}
}
