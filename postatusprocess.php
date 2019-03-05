<!DOCTYPE html>
<html>
<head>
	<title>Post</title>
	<meta charset="utf-8">
    <!--Bootstrap requirements-->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
	<?php
		require_once ("../../conf/settings.php");       //File not provided but functionality can be tested at ppj1483.cmslamp14.aut.ac.nz/assign1

		$conn = mysqli_connect($host, $user, $password);

		echo "<div class='container'>";

		if ($conn)
		{
			if (!mysqli_select_db($conn, $dbnm))
			{
			    //Creates the database if it doesn't exist
				$ptr = mysqli_query($conn, "CREATE DATABASE $dbnm;");

				mysqli_free_result($ptr);
				mysqli_select_db($conn, $dbnm);
			}

			$ptr = mysqli_query($conn, 'SELECT status_code FROM posts;');

			if ($ptr->lengths == 0)
			{
			    //Creates the posts table in the database if it doesn't exist
				mysqli_query($conn, "CREATE TABLE posts (status_code VARCHAR(5) PRIMARY KEY, post_date DATE, status_message VARCHAR(500), share_type VARCHAR(8), permission_like VARCHAR(1), permission_share VARCHAR(1), permission_comment VARCHAR(1));");
			}

			//unsafely reads data from form submission
			$code = $_POST["status_code"];
			$status = $_POST["status"];
			$date = $_POST["date"];
			$share = $_POST["share"];

			//safely reads data from form submittion
			$permission_share = isSet($_POST["perm_share"]);
			$permission_comment = isSet($_POST["perm_comment"]);
			$permission_like = isSet($_POST["perm_like"]);

			if (preg_match('/([S])+[0-9]{4}/', $code) == 0)
			{
				//Error message if status code is invalid
				echo '<div class="row">';
				echo "<h2>Status code is invalid</h2>";
				echo '</div>';
				echo '<br>';
				echo '<div class="row">';
				echo ">Go Back</a></p>";
				echo "<p><a href=\"/assign1\" class=\"btn btn-light\">Home</a></p>";
				echo '</div>';
			}
			else
			{
				if (preg_match('/[^A-Za-z0-9\,\.\\?!\ ]/', $status) == 1)
				{
					//Error message if status message is invalid
					echo '<div class="row">';
					echo "<h2>Status is invalid</h2>";
					echo '</div>';
					echo '<br>';
					echo '<div class="row">';
					echo "<p><a href=\"poststatusform.php\" class=\"btn btn-light\">Go Back</a></p>";
					echo "<p><a href=\"/assign1\" class=\"btn btn-light\">Home</a></p>";
					echo '</div>';
				}
				else
				{
					$ptr = mysqli_query($conn, "SELECT status_code FROM posts WHERE status_code = '$code'");

					if ($ptr->lengths != 0)
					{
						//Error message if status code is already in the database
						echo '<div class="row">';
						echo "<h2>Status code already exists</h2>";
						echo '</div>';
						echo '<br>';
						echo '<div class="row">';
						echo "<p><a href=\"poststatusform.php\" class=\"btn btn-light\">Go Back</a></p>";
						echo "<p><a href=\"/assign1\" class=\"btn btn-light\">Home</a></p>";
						echo '</div>';
					}
					else
					{
					    //Formats data for the database
						$permission_like = $permission_like ? 'T' : 'F';
						$permission_comment = $permission_comment ? 'T' : 'F';
						$permission_share = $permission_share ? 'T' : 'F';

						mysqli_free_result($ptr);
						//Attempts to write to database
						$saved = mysqli_query($conn, "INSERT INTO posts (status_code, post_date, status_message, share_type, permission_like, permission_share, permission_comment) VALUES ('$code', '$date', '$status', '$share', '$permission_like', '$permission_share', '$permission_comment');");

						echo '<div class="row">';

						//Tells user status of saving
						if ($saved)
						{
							echo "<h2>Status saved.</h2>";
						}
						else
						{
							echo "<h2>Status not saved.</h2>";
						}

						echo '</div>';

						//Tells user what was submitted to the database/server
						echo '<div class="row">';
						echo '<div class="col">';
						echo "<p>Status code: ", $code, "</p>";
						echo "<p>Status: ", $status, "</p>";
						echo "<p>Date: ", $date, "</p>";
						echo "<p>Share:", $share, "</p>";
						echo "<p>Permissions:</p>";
						echo "<p>	Share: ", $permission_share, "</p>";
						echo "<p>	Comment: ", $permission_comment, "</p>";
						echo "<p>	Like: ", $permission_like, "</p>";
						echo '</div>';
						echo '</div>';

						echo '<div class="row">';
						echo "<p><a href=\"poststatusform.php\" class=\"btn btn-light\">Go Back</a></p>";
						echo "<p><a href=\"/assign1\" class=\"btn btn-light\">Home</a></p>";
						echo '</div>';
					}
				}
			}
		}
		else
		{
			//Error message if cannot connect to the database
			echo "<h1>Error Connecting to Database</h1>";
			echo '<br>';
			echo "<p><a href=\"poststatusform.php\" class=\"btn btn-light\">Go Back</a></p>";
			echo "<p><a href=\"/assign1\" class=\"btn btn-light\">Home</a></p>";
		}

		echo "</div>";
	?>
</body>
</html>
