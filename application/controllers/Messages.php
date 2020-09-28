<?php

class Messages extends CI_Controller {
	
	public function get() {
		$userID = intval($this->input->post('user_id'));
		$messages = $this->db->query("select * from messages where sender_id=" . $userID . " or receiver_id=" . $userID . " order by date desc")
			->result_array();
		for ($i=0; $i<sizeof($messages); $i++) {
			$message = $messages[$i];
			$sender = $this->db->query("select * from users where id=" . $message['sender_id'])->row_array();
			$receiver = $this->db->query("select * from users where id=" . $message['receiver_id'])->row_array();
			$messages[$i]['sender_name'] = $sender['first_name'] . " " . $sender['last_name'];
			$messages[$i]['receiver_name'] = $receiver['first_name'] . " " . $receiver['last_name'];
		}
		echo json_encode($messages);
	}
}
