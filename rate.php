<?php 

require_once 'core/connect/database.php';
 	
if (isset($_GET['article'], $_GET['rating'])) {
	
	$article = (int)$_GET['article'];
	$rating = (int)$_GET['rating'];

	if (in_array($rating, [1,2,3,4,5])) {
		
		$exists = $db->query("SELECT post_id FROM posts WHERE post_id = $article");
		$num_rows = $exists->fetchColumn();

		if($num_rows){

			$db->query("INSERT INTO article_rating (article, ratings) VALUES ($article, $rating)");

			header('Location: home.php');
			// header('Location: view_post.php?post_id=' . $article);
		}
		
	}

	
}

?>