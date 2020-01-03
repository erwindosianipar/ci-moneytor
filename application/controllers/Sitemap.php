<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends CI_Controller {

	public function index()
	{
		$this->output->set_content_type('text/xml');
		$this->load->view('sitemap', $data);
	}
}