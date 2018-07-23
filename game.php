<?php
	include_once 'templates/header.php';
	require 'includes/dbh.php';

	if (isset($_POST['action'])){
		if(!empty($_POST["publisherName"]) && !empty($_POST["gameName"]) && !empty($_POST["genre"]) && !empty($_POST["certificate"]) && !empty($_POST["date"])) {
			$gamePublisher = mysqli_real_escape_string($conn, $_POST['publisherName']);
			$gameName = mysqli_real_escape_string($conn, $_POST['gameName']);
			$gameGenre = mysqli_real_escape_string($conn, $_POST['genre']);
			$gameCertificate = mysqli_real_escape_string($conn, $_POST['certificate']);
			$gameDate = mysqli_real_escape_string($conn, date("Y-m-d", strtotime($_POST['date'])));

			$sql = "INSERT INTO game (Publisher_ID, Game_Name, Genre_ID, Release_Date, Certificate)
				VALUES ('$gamePublisher', '$gameName', '$gameGenre', '$gameDate', '$gameCertificate')";
			if ($conn->query($sql) === TRUE) {
				header("Location: game.php?submit=successAdded");
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else {
			header("Location: game.php?error=required");
		}

		?>
		<h2>There was meant to be something here... Ooops!<h2>
	<?php
	} else if (isset($_POST['versionAction'])){

		if(!empty($_POST["gameID"]) && !empty($_POST["versionNumber"]) && !empty($_POST["versionDate"])) {
			$versionGameID = mysqli_real_escape_string($conn, $_POST['gameID']);
			$versionNumber = mysqli_real_escape_string($conn, $_POST['versionNumber']);
			$versionDate = mysqli_real_escape_string($conn, date("Y-m-d", strtotime($_POST['versionDate'])));

			$sql = "INSERT INTO game_version (Game_ID, Version_Number, Version_Release_Date)
				VALUES ('$versionGameID', '$versionNumber', '$versionDate')";
			if ($conn->query($sql) === TRUE) {
				header("Location: game.php?submit=successAdded2");
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else {
			header("Location: game.php?error=required2");
		}
	} else if (isset($_POST['update'])) {
		if(!empty($_POST["publisherName"]) && !empty($_POST["gameName"]) && !empty($_POST["genre"]) && !empty($_POST["certificate"]) && !empty($_POST["date"])) {
			$gamePublisher = mysqli_real_escape_string($conn, $_POST['publisherName']);
			$gameName = mysqli_real_escape_string($conn, $_POST['gameName']);
			$gameGenre = mysqli_real_escape_string($conn, $_POST['genre']);
			$gameCertificate = mysqli_real_escape_string($conn, $_POST['certificate']);
			$gameDate = mysqli_real_escape_string($conn, date("Y-m-d", strtotime($_POST['date'])));
			$id = mysqli_real_escape_string($conn, $_POST['id']);

			$sql = "UPDATE game SET Publisher_ID='$gamePublisher', Game_Name='$gameName', Genre_ID='$gameGenre', Release_Date='$gameDate', Certificate='$gameCertificate' WHERE ID='$id'";
			if ($conn->query($sql) === TRUE) {
				header("Location: game.php?submit=successUpdated");
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else {
			header("Location: game.php?error=failed");
		}
	} else if (isset($_POST['edit'])) {
		$id = $_GET['id'];
		$sql = "SELECT * FROM game WHERE ID = $id";
		$query = mysqli_query($conn, $sql)
			or die('Error querying the database');

			if (mysqli_num_rows($query) == 0) {
				echo("No results found");
			} else {
				$rows = mysqli_fetch_assoc($query);
				?>
				<form action="game.php" method="POST">
					<input name="update" type="hidden">
					<input name="id" type="hidden" value="<?php echo $rows['ID'];?>">
					<table>
						<tr><td>Publisher: </td><td>
					<?php
						$sql = "SELECT ID, Publisher_Name FROM publisher";
						$result = mysqli_query($conn, $sql)
							or die('Error querying the database');

						if (mysqli_num_rows($result) == 0) {
							echo("No results found");
						} else {
							?><select name="publisherName"><?php
							while($row = mysqli_fetch_assoc($result)) {
								?>
									<option value="<?php echo $row['ID'];?>"
										<?php if ($row['ID'] == $rows['Publisher_ID']) {
											echo "selected";
										} ?> ><?php echo $row['Publisher_Name'];?></option>
								<?php
							}
							?></select></td></tr><?php
						}
					?>
					<tr>
						<td>Game Name: </td><td><input name="gameName" id="gameName" placeholder="Game Name *" type="text" value="<?php echo $rows['Game_Name'];?>"></td>
					</tr>
						<tr>
							<td>Genre:</td>
					<?php
						$sql = "SELECT * FROM genre";
						$result = mysqli_query($conn, $sql)
							or die('Error querying the database');

						if (mysqli_num_rows($result) == 0) {
							echo("No results found");
						} else {
							?><td><select name="genre"><?php
							while($row = mysqli_fetch_assoc($result)) {
								?>
									<option value="<?php echo $row['ID'];?>"
										<?php if ($row['ID'] == $rows['Genre_ID']) {
											echo "selected";
										} ?> ><?php echo $row['Genre'];?></option>
								<?php
							}
							?></select></td></tr><?php
						}
					?>
					<tr>
						<td>Certificate: </td><td><input name="certificate" id="certificate" placeholder="Certificate (U, PG, 15, 18) *" type="text" value="<?php echo $rows['Certificate'];?>" ></td>
					</td>
					<tr>
						<td>Release Date: </td><td><input name="date" id="date" placeholder="Release Date * (yyyy-mm-dd)" type="date" value="<?php echo $rows['Release_Date'];?>"></td>
					</td>
					<tr>
						<td></td><td><input type="submit" value="Submit"></td>
					</tr>
				</table>
				</form>
				<?php
			}
	} else { ?>
		<section class="main-container">
			<div class="main-wrapper">
				<?php if(isset($_GET["error"]) && ($_GET["error"]) == "required") {
					echo "Please fill required fields (*)";
				} else if(isset($_GET["submit"]) && ($_GET["submit"]) == "successAdded") {
					echo "Game Added Successfully!<br><br>";
				} else if(isset($_GET["submit"]) && ($_GET["submit"]) == "successUpdated") {
					echo "Game Updated Successfully!<br><br>";
				} ?>
				<form action="game.php" method="POST">
					<input name="action" type="hidden">
					<table>
						<tr><td style="width: 200px;"><h2>Add Game</h2></td><td></td><td></td></tr>
						<tr>
							<td>Publisher: </td>
					<?php
						$sql = "SELECT ID, Publisher_Name FROM publisher";
						$result = mysqli_query($conn, $sql)
							or die('Error querying the database');

						if (mysqli_num_rows($result) == 0) {
							echo("No results found");
						} else {
							?><td><select name="publisherName"><?php
							while($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo $row['ID'];?>"><?php echo $row['Publisher_Name'];?></option>
								<?php
							}
							?></select></td><?php
						}
					?>
					<td><a href="publisher.php">+ Add New Publisher</a></td>
				</tr>
				<tr>
					<td>Game Name: </td><td><input name="gameName" id="gameName" placeholder="Game Name *" type="text"></td><td></td>
				</tr>
				<tr>
					<td>Genre:</td>
					<?php
						$sql = "SELECT * FROM genre";
						$result = mysqli_query($conn, $sql)
							or die('Error querying the database');

						if (mysqli_num_rows($result) == 0) {
							echo("No results found");
						} else {
							?><td><select name="genre"><?php
							while($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo $row['ID'];?>"><?php echo $row['Genre'];?></option>
								<?php
							}
							?></select></td><?php
						}
					?>
					<td><a href="genre.php">+ Add New Genre</a></td>
				</tr>
				<tr>
					<td>Certificate: </td><td><input style="width:200px;" name="certificate" id="certificate" placeholder="Certificate (U, PG, 15, 18) *" type="text"></td><td></td>
				</tr>
				<tr>
					<td>Release Date: </td><td><input style="width:200px;" name="date" id="date" placeholder="Release Date * (yyyy-mm-dd)" type="date"></td><td></td>
				</td>
				<tr>
					<td></td><td><input type="submit" value="Submit"></td><td></td>
				</td>
				</form>

				<?php if(isset($_GET["error"]) && ($_GET["error"]) == "required") {
					echo "Please fill required fields (*)";
				} else if(isset($_GET["submit"]) && ($_GET["submit"]) == "successAdded2") {
					echo "Version Added Successfully!<br><br>";
				} ?>
				<form action="game.php" method="POST">
					<input name="versionAction" type="hidden">
					<table>
						<tr><td style="width: 200px;"><h2>Add Game Version</h2></td><td></td><td></td></tr>
						<tr>
							<td>Game: </td>
					<?php
						$sql = "SELECT ID, Game_Name FROM game";
						$result = mysqli_query($conn, $sql)
							or die('Error querying the database');

						if (mysqli_num_rows($result) == 0) {
							echo("No results found");
						} else {
							?><td><select name="gameID"><?php
							while($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo $row['ID'];?>"><?php echo $row['Game_Name'];?></option>
								<?php
							}
							?></select></td>
						</tr><?php
						}
					?>
					<tr>
						<td>Version Number: </td><td><input name="versionNumber" id="versionNumber" placeholder="Version Number" type="text"></td>
					</tr>
					<tr>
						<td>Version Date: </td><td><input style="width: 200px;" name="versionDate" id="versionDate" placeholder="Version Date * (yyyy-mm-dd)" type="date"></td>
					</tr>
					<tr>
						<td></td><td><input type="submit" value="Submit"></td>
					</tr>
				</table>
				</form>
			</div>
		</section>
	<?php
	}
	mysqli_close($conn); ?>
<?php
	include_once 'templates/footer.php';
?>
