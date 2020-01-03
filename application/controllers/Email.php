<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {

	function _index($to_email='cicacodecom@gmail.com')
	{
		$this->load->library('email');

		$subject = 'Send email test';
		$message = '<p>This message has been sent for testing purposes.</p>';

		$result = $this->email
		->from('erwindoq@gmail.com', 'Erwindo Sianipar')
    	->reply_to('erwindosianipar@gmail.com')
    	->to($to_email)
    	->subject($subject)
    	->message($message)
    	->send();

	    var_dump($result);
    	echo $this->email->print_debugger();
   		exit;		
	}
}

/* End of file email.php */
/* Location: ./application/controllers/email.php */