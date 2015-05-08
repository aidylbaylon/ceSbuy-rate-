<?php 
require_once 'core/connect/database.php';
 	

 // $sth = $db->query("SELECT `article.id`, `article.title`, `AVG(article_rating.ratings)` AS rating
 // 		FROM `article`
 // 		LEFT JOIN
 // 		ON `article.id` = `article_rating.article` 
 // 		GROUP BY `article.id`");

  $sth = $db->query("SELECT * FROM posts");

$articles = [];
 while($row = $sth->fetch(PDO::FETCH_ASSOC)){
 		$articles[] = $row;


 }

?>

<html>
<head>
	<meta charset="utf-8">
	<title>Articles</title>
</head>
<body>
	<?php foreach($articles as $article): ?>
	<div class="article">
		<h3><a href="article.php?id=<?php echo $article['post_id'];?>"><?php echo $article['name'];?></a></h3>
	</div>
	<div class="article_ratings">Rating x/5	</div>

	<?php endforeach; ?>



</body>
</html>