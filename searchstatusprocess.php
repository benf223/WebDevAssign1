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
				mysqli_query($conn, "CREATE DATABASE $dbnm;");
				mysqli_select_db($conn, $dbnm);

				echo '<h2>No records saved</h2>';
				echo "<p><a href=\"poststatusform.php\" class=\"btn btn-light\">Post a status</a></p>";
				echo "<p><a href=\"/assign1\" class=\"btn btn-light\">Home</a></p>";
			}
			else
			{
                $check = mysqli_query($conn, "SELECT status_code FROM posts;");

				if ($check->num_rows == 0)
				{
					//Creates the posts table in the database if it doesn't exist
					mysqli_query($conn, "CREATE TABLE posts (status_code VARCHAR(5) PRIMARY KEY, post_date DATE, status_message VARCHAR(500), share_type VARCHAR(8), permission_like VARCHAR(1), permission_share VARCHAR(1), permission_comment VARCHAR(1));");

					//Error message for the user as no records exist if the table was just created.
					echo '<h2>No records saved</h2>';
					echo '<br>';
					echo "<p><a href=\"poststatusform.php\" class=\"btn btn-light\">Post a status</a></p>";
					echo "<p><a href=\"/assign1\" class=\"btn btn-light\">Home</a></p>";
				}
				else
				{
				    //Checks if there is data to find
					if (isset($_GET["to_find"]))
					{
						$code = $_GET["to_find"];
                        $query = "SELECT status_code, status_message, share_type, permission_like, permission_share, permission_comment, post_date FROM posts WHERE status_message LIKE '%$code%';";
                        $ptr = mysqli_query($conn, $query);

                        if ($ptr->num_rows == 0)
                        {
                            //Error message if no data is found
                            echo '<h2>Status does not exist</h2>';
                            echo '<br>';
                            echo "<p><a href=\"searchstatusform.html\" class=\"btn btn-light\">Go Back</a></p>";
                            echo "<p><a href=\"/assign1\" class=\"btn btn-light\">Home</a></p>";
                        }
                        else
                        {
                            $row = mysqli_fetch_row($ptr);

                            while ($row)
                            {
                                //Prints as single status at a time in a bootstrap container
                                echo "<div class=\"container\">";
                                echo "<div class=\"row\">";
                                echo "<b><p>Status Code:</b> {$row[0]}</p>";
                                echo "<div class=\"col\">";
                                echo "<b><p>Status:</b> {$row[1]}</p>";
                                echo "<b><p>Shared With:</b> {$row[2]}</p>";
                                echo "<b><p>Permission Like:</b> {$row[3]}</p>";
                                echo "<b><p>Permission Share:</b> {$row[4]}</p>";
                                echo "<b><p>Permission Comment:</b> {$row[5]}</p>";
                                echo "<b><p>Date Posted:</b> {$row[6]}</p>";
                                echo "</div>";
								echo "</div>";
								echo "</div>";

                                $row = mysqli_fetch_row($ptr);
                            }

                            mysqli_free_result($ptr);

                            echo '<br>';
                            echo "<p><a href=\"searchstatusform.html\" class=\"btn btn-light\">Go Back</a></p>";
                            echo "<p><a href=\"/assign1\" class=\"btn btn-light\">Home</a></p>";
						}
					}
					else
					{
					    //Error message if no text is sent to the server
						echo "<h2>No text entered</h2>";
						echo '<br>';
						echo "<p><a href=\"searchstatusform.html\" class=\"btn btn-light\">Go Back</a></p>";
						echo "<p><a href=\"/assign1\" class=\"btn btn-light\">Home</a></p>";
					}
				}
			}
		}
		else
        {
			//Error message if cannot connect to the database
            echo "<h2>Error connecting to Database";
			echo "<p><a href=\"searchstatusform.html\" class=\"btn btn-light\">Go Back</a></p>";
			echo "<p><a href=\"/assign1\" class=\"btn btn-light\">Home</a></p>";
        }

	    echo "</div>";
	?>
</body>
</html>