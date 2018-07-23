<?php
	include_once 'templates/header.php';
	require 'includes/dbh.php';

	if (isset($_POST['action'])){
		if(!empty($_POST["genreName"])) {
			$genreName = mysqli_real_escape_string($conn, $_POST['genreName']);

			$sql = "INSERT INTO genre (Genre)
				VALUES ('$genreName')";
			if ($conn->query($sql) === TRUE) {
				header("Location: genre.php?submit=successAdded");
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else {
			header("Location: genre.php?error=required");
		}

		?>
		<h2>There was meant to be something here... Ooops!<h2>
	<?php } else { ?>
		<section class="main-container">
			<div class="main-wrapper">
				<h2>Add Genre</h2>
				<?php if(isset($_GET["error"]) && ($_GET["error"]) == "required") {
					echo "Please fill required fields (*)";
				} else if(isset($_GET["submit"]) && ($_GET["submit"]) == "successAdded") {
					echo "Genre Added Successfully!<br><br>";
				} ?>
				<form action="genre.php" method="POST">
					<input name="action" type="hidden">
					<table>
						<tr>
							<td>Genre Name: </td><td><input name="genreName" id="genreName" placeholder="Genre *" type="text"></td>
						</tr>
						<tr>
							<td></td><td><input type="submit" value="Submit"></td>
						</tr>
					</table>
				</form><br><br>
				List of currently available Genres
				<ul>
				<?php
					$sql = "SELECT * FROM genre";
					$result = mysqli_query($conn, $sql)
						or die('Error querying the database');

					if (mysqli_num_rows($result) == 0) {
						echo("No results found");
					} else {
						while($row = mysqli_fetch_assoc($result)) {
							?><li><?php echo $row['Genre'];?></li>
							<?php
						}
					}
				?>
				</ul>
			</div>
		</section>
	<?php }
	mysqli_close($conn); ?>
<?php
	include_once 'templates/footer.php';
?>
