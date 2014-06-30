<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Posts extends CI_Controller {

	public function index()
	// when user go to localhost -> form html page will be presented
	// index page is default page when user first see
	{
		$this->load->model('Post');
		$view_data['posts'] = $this->Post->get_all_posts();
		// var_dump($view_data);

		$this->load->view('ajax',$view_data);
		// echo json_encode($view_data);
	}
	public function ajax()
	{
		// grab user's input
		$this->load->library('form_validation');
		$this->form_validation->set_rules('note','Note','trim|required');
		
		if ($this->form_validation->run())  // pass 
		{
			$note = $this->input->post('note');
			
			$this->load->model('Post');
			$this->Post->add_post($note);

			// easy part -> just to pass $note to json
			// pass newly added note to HTML view - ajax
			// this line means show newly added stuff without refreshing!
			echo json_encode($note);
		}
		// $this->load->view('/Posts/index', $note);
// this is for ajax -> just to print out the NEWLY added note	
	}

// no need to pass anything through ajax -> cuz just simply delete, no need to return anything!
	public function delete_by_id($id)
	{		
		$this->load->model('Post');
		$this->Post->delete_by_id($id);	
// when user click delete icon on view -> event trigger will be sent to jquery on view
	}

	public function destroy()
	{
		// NOT using ajax here, just example shows how it works with normal way
		// need to call out model delete function!
		$this->load->model('Post');
		$this->Post->delete_all();

		// sometimes -> need this 
		$this->session->sess_destroy();
		redirect('/Posts/ajax');
	}

	public function update($id)
	{
		$new_note = $this->input->post('message');
		// echo ($new_note);

		$this->load->model('Post');
		$this->Post->updated_by_id($id, $new_note);

		// mistake: i made! -> json command is wrong!
		echo json_encode($new_note);
		// pass to function when .new_note is clicked
	}
}




















