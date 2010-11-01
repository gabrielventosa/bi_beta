<?php
class HelloWorld extends Controller{

function HelloWorld(){
// load controller parent
	parent::Controller();
}

	function index(){
		$data['title']='My first application created with Code Igniter';
		$data['message']='Hello world!';
		// load 'helloworld' view
		$this->load->view('helloworld',$data);
	}
}
?>