<?php
	if (isset($_POST['addevent'])){
		$title = $_POST["title"];
		$author = $_POST['author'];
		$date = $_POST["date"];
		$time = $_POST['time'];
		$description = $_POST["description"];
		$category = $_POST["category"];
		
		$image_name = $_FILES['image']['name'];
		$image_tmp_name = $_FILES['image']['tmp_name'];
		$image_tmp_name = file_get_contents($image_tmp_name);
		$image_type = pathinfo($image_name, PATHINFO_EXTENSION);
		
		$allowed_filetypes = ["jpg", "jpeg", "png", "gif"];

		if ($image_type === $allowed_filetypes[0])
		{
			$image_tmp_name = "data:image/jpg;base64," . base64_encode($image_tmp_name);
		}
		else if ($image_type === $allowed_filetypes[1])
		{
			$image_tmp_name = "data:image/jpeg;base64," . base64_encode($image_tmp_name);
		}
		else if ($image_type === $allowed_filetypes[2])
		{
			$image_tmp_name = "data:image/png;base64," . base64_encode($image_tmp_name);
		}
		else if ($image_type === $allowed_filetypes[3])
		{
			$image_tmp_name = "data:image/gif;base64," . base64_encode($image_tmp_name);
		}
		else
		{
			echo 'Please enter a picture of ".jpg", ".jpeg", ".png" or ".gif" type.';
		}
		
		$bdd = new PDO("mysql:host=localhost;dbname=jepsen-brite","root","");
		$request = $bdd -> prepare("INSERT INTO event(title, author, date, time, description, category, image, image_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		$request -> execute(array($title, $author, $date, $time, $description, $category, $image_tmp_name, $image_type));
	}
?>

<html>
	<head>
		<meta charset="utf-8" />
		<title>add event</title>
	</head>
	<body>
		<main>
			<h1>Add Event</h1>
			<form  method="post" action="addevent.php" enctype="multipart/form-data">
				<div>
					<label for="title">Title</label>
					<input type="text" name="title" required>
				</div>
				<div>
					<label for="title">Author</label>
					<input type="text" name="author" required>
				</div>
				<div>
					<label for="datehour">Date</label>
					<input type="date" name="date" required>
				</div>
				<div>
					<label for="time">Time</label>
					<input type="time" name="time" required>
				</div>
				<div>
					<label for="image">Image</label>
					<input type="file" required name="image">
				</div>
				<div>
					<label for="description">Description</label>
					<input type="text" name="description" required>
				</div>
				<div>
					<label for="category">category</label>
					<select name="category">
						<option value="party">party</option>
						<option value="concert">concert</option>
						<option value="meeting">meeting</option>
						<option value="festival">festival</option>
					</select>
				</div>
				<button type="submit" name="addevent">Add Event</button>
			</form>
		</main>
	</body>
</html>