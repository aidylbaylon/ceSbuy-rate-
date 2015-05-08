<?php 
class Users{
 	
	private $db;

	public function __construct($database) {
	    $this->db = $database;
	}	
	 

	public function user_exists($username) {
	
		$query = $this->db->prepare("SELECT COUNT(`id`) FROM `users` WHERE `username`= ?");
		$query->bindValue(1, $username);
	
		try{

			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 1){
				return true;
			}else{
				return false;
			}

		} catch (PDOException $e){
			die($e->getMessage());
		}

	}
	 
	public function email_exists($email) {

		$query = $this->db->prepare("SELECT COUNT(`id`) FROM `users` WHERE `email`= ?");
		$query->bindValue(1, $email);
	
		try{

			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 1){
				return true;
			}else{
				return false;
			}

		} catch (PDOException $e){
			die($e->getMessage());
		}

	}

	public function register($username, $password, $email, $firstname, $middlename, $lastname){
		
		global $bcrypt; // making the $bcrypt variable global so we can use here
 
		$time = time();
		$ip = $_SERVER['REMOTE_ADDR'];
		$email_code = $email_code = uniqid('code_',true);
		$password = $bcrypt->genHash($password);// generating a hash using the $bcrypt object
		$query = $this->db->prepare("INSERT INTO `users` (`username`, `password`, `email`, `first_name`,`middle_name`,`last_name`, `ip`, `time`, `email_code`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ");
		 
		$query->bindValue(1, $username);
		$query->bindValue(2, $password);
		$query->bindValue(3, $email);
		$query->bindValue(4, $firstname);
		$query->bindValue(5, $middlename);
		$query->bindValue(6, $lastname);
		$query->bindValue(7, $ip);
		$query->bindValue(8, $time);
		$query->bindValue(9, $email_code);
		 
		try{
		$query->execute();
		 
		// mail($email, 'Please activate your account', "Hello " . $username. ",\r\nThank you for registering with us. Please visit the link below so we can activate your account:\r\n\r\nhttp://www.example.com/activate.php?email=" . $email . "&email_code=" . $email_code . "\r\n\r\n-- Example team");
		}catch(PDOException $e){
		die($e->getMessage());
		}		
	}

	public function login($username, $password) {

		global $bcrypt; // Again make the bcrypt variable global, which is defined in init.php, which is included in login.php where this function is called
 
		$query = $this->db->prepare("SELECT `password`, `id` FROM `users` WHERE `username` = ?");
		$query->bindValue(1, $username);
		 
		try{
		$query->execute();
		$data = $query->fetch();
		$stored_password = $data['password']; // stored hashed password
		$id = $data['id'];
		if($bcrypt->verify($password, $stored_password) === true){ // using the verify method to compare the password with the stored hashed password.
		return $id;	
		}else{
		return false;	
		}
		 
		}catch(PDOException $e){
		die($e->getMessage());
		}
		}

	public function userdata($id) {

		$query = $this->db->prepare("SELECT * FROM `users` WHERE `id`= ?");
		$query->bindValue(1, $id);

		try{

			$query->execute();

			return $query->fetch();

		} catch(PDOException $e){

			die($e->getMessage());
		}

	}
	  	  	 
	public function get_users() {

		$query = $this->db->prepare("SELECT * FROM `users` ORDER BY `time` DESC");
		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}

		return $query->fetchAll();

	}

	public function fetch_info($what, $field, $value){
 
		$allowed = array('id', 'username', 'firstname', 'lastname', 'gender', 'bio', 'email'); // I have only added few, but you can add more. However do not add 'password' even though the parameters will only be given by you and not the user, in our system.
		if (!in_array($what, $allowed, true) || !in_array($field, $allowed, true)) {
		throw new InvalidArgumentException;
		}else{
		$query = $this->db->prepare("SELECT $what FROM `users` WHERE $field = ?");
		 
		$query->bindValue(1, $value);
		 
		try{
		 
		$query->execute();
		} catch(PDOException $e){
		 
		die($e->getMessage());
		}
		 
		return $query->fetchColumn();
		}
	}
 
	public function change_password($user_id, $password) {
	 
		global $bcrypt;
		 
		/* Two create a Hash you do */
		$password_hash = $bcrypt->genHash($password);
		 
		$query = $this->db->prepare("UPDATE `users` SET `password` = ? WHERE `id` = ?");
		 
		$query->bindValue(1, $password_hash);
		$query->bindValue(2, $user_id);	
		 
		try{
		$query->execute();
		return true;
		} catch(PDOException $e){
		die($e->getMessage());
		}
	}

	public function update_user($firstname, $lastname, $gender, $bio, $image_location, $id){
 
		$query = $this->db->prepare("UPDATE `users` SET
		`firstname` = ?,
		`lastname` = ?,
		`gender` = ?,
		`bio` = ?,
		`image_location`= ?
		WHERE `id` = ?
		");
		 
		$query->bindValue(1, $firstname);
		$query->bindValue(2, $lastname);
		$query->bindValue(3, $gender);
		$query->bindValue(4, $bio);
		$query->bindValue(5, $image_location);
		$query->bindValue(6, $id);
		try{
		$query->execute();
		}catch(PDOException $e){
		die($e->getMessage());
		}	
	}

	public function fetch_info_posts($what, $field, $value){
 
		$allowed = array('post_id', 'name', 'category'); // I have only added few, but you can add more. However do not add 'password' even though the parameters will only be given by you and not the user, in our system.
		if (!in_array($what, $allowed, true) || !in_array($field, $allowed, true)) {
		throw new InvalidArgumentException;
		}else{
		$query = $this->db->prepare("SELECT $what FROM `posts` WHERE $field = ?");
		 
		$query->bindValue(1, $value);
		 
		try{
		 
		$query->execute();
		} catch(PDOException $e){
		 
		die($e->getMessage());
		}
		 
		return $query->fetchColumn();
		}
	}

	public function post_product($image_location, $name, $category, $price, $description,$id){
		$query = $this->db->prepare("INSERT INTO `posts`(`image_location`,`name`,`category`,`price`,`description`,`id`) VALUES(?, ?, ?, ?, ?, ?)");

		$query->bindValue(1, $image_location);
		$query->bindValue(2, $name);
		$query->bindValue(3, $category);
		$query->bindValue(4, $price);
		$query->bindValue(5, $description);
		$query->bindValue(6, $id);

		try
		{
			$query->execute();
		}
		catch(PDOException $e)
		{
			die($e->getMessage());
		}		
	}


	public function get_post($id)
	{

		$query = $this->db->prepare("SELECT * FROM `posts` WHERE `id` = ?");

		$query->bindValue(1, $id);
		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}

		return $query->fetchAll();
	}



	public function get_all_posts()
	{

		$query = $this->db->prepare("SELECT * FROM `posts` ORDER BY `date` DESC;");

		$query->bindValue(1, $id);
		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}

		return $query->fetchAll();
	}

	public function post_data($id) {

		$query = $this->db->prepare("SELECT * FROM `posts` WHERE `post_id`= ?");
		$query->bindValue(1, $id);

		try{

			$query->execute();

		} catch(PDOException $e){

			die($e->getMessage());
		}

		return $query->fetch();

	}

	public function update_post($name, $price, $category, $description, $post_id){
 
		$query = $this->db->prepare("UPDATE `posts` SET
		`name` = ?,
		`price` = ?,
		`category` = ?,
		`description` = ?
		WHERE `post_id` = ?
		");
		 
		$query->bindValue(1, $name);
		$query->bindValue(2, $price);
		$query->bindValue(3, $category);
		$query->bindValue(4, $description);
		$query->bindValue(5, $post_id);
		try{
		$query->execute();
		}catch(PDOException $e){
		die($e->getMessage());
		}	
	}

	public function getWhere($query) {
		$qresult = $this->db->query($query);
		$results = $qresult->fetchAll(PDO::FETCH_ASSOC);
		return $results;
	}

	public function add_comment($id, $post_id, $text)
	{

		$query = $this->db->prepare("INSERT INTO `comments` (`id`, `post_id`, `comment`,`time_added`) VALUES (?, ?, ?, NOW()) ");
		 
		$query->bindValue(1, $id);
		$query->bindValue(2, $post_id);
		$query->bindValue(3, $text);
		
		try{
		$query->execute();
		}catch(PDOException $e){
		die($e->getMessage());
		}		
	}

	public function get_comments($id) {

		$query = $this->db->prepare("SELECT `comment`,`time_added` FROM `comments` WHERE `post_id`= ?");
		$query->bindValue(1, $id);

		try{

			$query->execute();

		} catch(PDOException $e){

			die($e->getMessage());
		}

		return $query->fetchAll();

	}

	public function delete_post($id)
	{
			$query = $this->db->prepare("DELETE FROM posts WHERE post_id = ?");
			$query->bindValue(1, $id);

			try{

			$query->execute();

			} catch(PDOException $e){

				die($e->getMessage());
			}
	}

	// fetch post by category
	public function post_by_category($category) {

		$query = $this->db->prepare("SELECT * FROM `posts` WHERE `category`= ?");
		$query->bindValue(1, $category);

		try{

			$query->execute();

		} catch(PDOException $e){

			die($e->getMessage());
		}

		return $query->fetchAll();

	}

}