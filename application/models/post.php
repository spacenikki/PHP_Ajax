<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// model give command to database , work on data
class Post extends CI_Model {

	function get_all_posts()
	{
		// fetch all data
		return $this->db->query('SELECT * FROM posts')->result_array();
	}

// add newly input user's info , name, email, password, etc ->
// need to add $user_details as associated array $users['user_details'] -> and call $user_details as below!!!!!
	function add_post($note)
	{
		$query = 'INSERT INTO posts (description, created_at, updated_at) 
		VALUES (?,?,?)';
		$values = array($note, date("Y-m-d, H:i:s"), date("Y-m-d, H:i:s"));
		return $this->db->query($query, $values);
	}

	function delete_all()
	{
		$delete = 'DELETE FROM posts';
		$this->db->query($delete);
	}

	function delete_by_id($id)
	{
		$delete_by_id = "DELETE FROM posts WHERE id='$id'";
		$this->db->query($delete_by_id);
	}

	function updated_by_id($id, $new_note)
	{
		$updated_by_id = "UPDATE posts SET description = '{$new_note}' WHERE id='{$id}'";
		// var_dump($updated_by_id);
		$this->db->query($updated_by_id);
	}

}
















