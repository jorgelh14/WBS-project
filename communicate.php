<?php
require_once('template.php');
require_once('model/post_model.php');


class Communicate extends Template
{
	protected function render_body() 
	{

		$posts = new Post();
		$post_model = new Post_model();
		echo "<h1>Communicate</h1> 
		<h2> What's in your mind!!</h2>
		<form action='alumni.php?page=communicate' method='post'>
		<textarea cols ='70' rows='4' name='content' placeholder='write what you are thinking........'></textarea><br/>
		<input type='submit' name='sub' value='Post to Timeline'>
		</form>
		<h3> Most Recent Discussions!</h3>";

	
		$posts = $post_model->get_posts();
		$post = array();

		
		if(isset($_POST['sub'])){
			$post['username'] = "tata";//$_SESSION['username'];
			$post['post'] = $_POST['content'];
			
			$post_model = new Post_model();
			$post_model->store_post($post);

			$posts = $post_model->get_posts(6);
			foreach($posts as $post) {
			print_r($post->get_username() . "\n"); echo "<br>";
			print_r($post->get_insert_time() . "\n"); echo "<br>";
			print_r($post->get_post() . "\n"); echo "<br>";
			}
			//print_r($posts);
				
        }
	}

}

?>
