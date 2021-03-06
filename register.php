<?php

require_once('template.php');
require_once('model/connection.php');
require_once('model/user_model.php');

class Register extends Template
{
	protected function render_body() 
	{
		if (! empty($_POST)) 
		{
			$errors =  $this->validate_first_name(isset($_POST['first-name']) ? $_POST['first-name'] : "");
			$errors .= $this->validate_last_name(isset($_POST['last-name']) ? $_POST['last-name'] : "");
			$errors .= $this->validate_username(isset($_POST['username']) ? $_POST['username'] : "");
			$errors .= $this->validate_password(isset($_POST['password']) ? $_POST['password'] : "");
			$errors .= $this->validate_academic_year(isset($_POST['academic-year']) ? $_POST['academic-year'] : "");

			if ($errors)
			{
				$this->render_register_form($errors);
			}
			else 
			{
				$user = new User();
				$user->set_first_name($_POST['first-name']);
				$user->set_last_name($_POST['last-name']);
				$user->set_username($_POST['username']);
				$user->set_password($_POST['password']);
				$user->set_academic_year($_POST['academic-year']);
			
				$user_model = new User_model();

				if ($user_model->store_user($user, false, false, true) == false)
				{
					$this->render_register_form('Username already exists.');
				}
				else
				{
					$this->redirect_to_main_page();
				}
			}
		}
		else
		{
			$this->render_register_form();
		}
	}

	protected function get_js_files() 
	{
		$js_files = parent::get_js_files();
		array_push($js_files, "validation.js");
		return $js_files;
	}

	private function render_register_form($error_message = null) 
	{
		echo "<p id='error-message'>$error_message</p>
			  <form action='alumni.php?page=register' method='post' onsubmit='return validateRegisterForm(this);'>
			    <label>First name</label>
			    <input type='text' name='first-name' class='form-control' placeholder='First name'>
				
			    <label>Last name</label>
			    <input type='text' name='last-name' class='form-control' placeholder='Last name'>

			    <label>Graduation year</label>
			    <input type='text' name='academic-year' class='form-control' placeholder='academic-year'>
				
			    <label>Username</label>
			    <input type='text' name='username' class='form-control' placeholder='username'>

			    <label>Password</label>
			    <input type='password' name='password' class='form-control' placeholder='password'>

				<button type='submit' class='btn btn-default'>Register</button>
			  </form>";
	}

	private function validate_first_name($first_name)
	{
		return ($first_name == "") ? "First name cannot be empty!<br />" : null;
	}

	private function validate_last_name($last_name)
	{
		return ($last_name == "") ? "Last name cannot be empty!<br />" : null;
	}

	private function validate_username($username)
	{
		return ($username == "") ? "Username cannot be empty!<br />" : null;
	}

	private function validate_password($password)
	{
		return ($password == "") ? "Password cannot be empty!<br />" : null;
	}

	// TODO CHECK!!
	private function validate_academic_year($academic_year)
	{
		if ($academic_year == "") 
		{
			return "Gradudation year input cannot be empty!<br />";
		}
	
		if (! preg_match("/^[0-9]{4}-[0-9]{2}$/", $academic_year)) 
		{
			return "Academic year wrong format! Correct input i.e. 2003-04";
		}
		$years = explode("-", $academic_year);
		$next_year = $years[0] + 1;
		//echo $years[0] . " " . $years[1] . " " . date("Y") . " " . $academic_year; die;
		if ($years[0] < 1900 || $years[1] > date("Y") || $years[1] != substr($next_year, 2)) {
			return "Academic year must be between 1900 and " . date("Y") . "<br />";
		} 

		return null;
	
	}

}
?>