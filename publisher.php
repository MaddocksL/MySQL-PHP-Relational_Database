<?php
	include_once 'templates/header.php';
	require 'includes/dbh.php';

	if (isset($_POST['action'])){
		if(!empty($_POST["publisherName"]) && !empty($_POST["firstName"]) && !empty($_POST["lastName"]) && !empty($_POST["publisherEmail"])) {
			$publisherName = mysqli_real_escape_string($conn, $_POST['publisherName']);
			$publisherFirst = mysqli_real_escape_string($conn, $_POST['firstName']);
			$publisherLast = mysqli_real_escape_string($conn, $_POST['lastName']);
			$publisherEmail = mysqli_real_escape_string($conn, $_POST['publisherEmail']);

			$sql = "INSERT INTO publisher (Publisher_Name, Contact_Firstname, Contact_Surname, Publisher_Email)
				VALUES ('$publisherName', '$publisherFirst', '$publisherLast', '$publisherEmail')";
			if ($conn->query($sql) === TRUE) {
				header("Location: publisher.php?submit=successAdded");
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else {
			header("Location: publisher.php?error=required");
		}

		?>
		<h2>There was meant to be something here... Ooops!<h2>
		<?php
	} else if (isset($_POST['update'])) {
		if(!empty($_POST["publisherName"]) && !empty($_POST["firstName"]) && !empty($_POST["lastName"]) && !empty($_POST["publisherEmail"])) {
			$publisherName = mysqli_real_escape_string($conn, $_POST['publisherName']);
			$publisherFirst = mysqli_real_escape_string($conn, $_POST['firstName']);
			$publisherLast = mysqli_real_escape_string($conn, $_POST['lastName']);
			$publisherEmail = mysqli_real_escape_string($conn, $_POST['publisherEmail']);
			$id = mysqli_real_escape_string($conn, $_POST['id']);

			$sql = "UPDATE publisher SET Publisher_Name='$publisherName', Contact_Firstname='$publisherFirst', Contact_Surname='$publisherLast', Publisher_Email='$publisherEmail' WHERE ID='$id'";
			if ($conn->query($sql) === TRUE) {
				header("Location: publisher.php?submit=successUpdated");
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else {
			header("Location: publisher.php?error=failed");
		}
	} else if (isset($_POST['edit'])) {
		$id = $_GET['id'];
		$sql = "SELECT * FROM publisher WHERE ID = $id";
		$result = mysqli_query($conn, $sql)
			or die('Error querying the database');

		if (mysqli_num_rows($result) == 0) {
			echo("No results found");
		} else {
			while($row = mysqli_fetch_assoc($result)) {
				?>
				<section class="main-container">
					<div class="main-wrapper">
						<h2>Publisher</h2>
						<form action="publisher.php" method="POST">
							<input name="update" type="hidden">
							<input name="id" type="hidden" value="<?php echo $row['ID'];?>">
							<table>
								<tr>
									<td>Publisher Name: </td><td><input style="width:250px;" name="publisherName" id="publisherName" placeholder="Publisher Name *" value="<?php echo $row['Publisher_Name'];?>" type="text"></td>
								</tr>
								<tr>
									<td>First Name: </td><td><input style="width:200px;" name="firstName" id="firstName" placeholder="Contact First Name *" value="<?php echo $row['Contact_Firstname'];?>" type="text"></td>
								</tr>
								<tr>
									<td>Last Name: </td><td><input style="width:200px;" name="lastName" id="lastName" placeholder="Contact Surname *" value="<?php echo $row['Contact_Surname'];?>" type="text"></td>
								</tr>
								<tr>
									<td>Email Address: </td><td><input style="width:200px;" name="publisherEmail" id="publisherEmail" placeholder="Publisher Email *" value="<?php echo $row['Publisher_Email'];?>" type="email"></td>
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
		}
	} else { ?>
		<section class="main-container">
			<div class="main-wrapper">
				<h2>Publisher</h2>
				<?php if(isset($_GET["error"]) && ($_GET["error"]) == "required") {
					echo "Please fill required fields (*)";
				} else if(isset($_GET["submit"]) && ($_GET["submit"]) == "successAdded") {
					echo "Publisher Added Successfully!<br><br>";
				} else if(isset($_GET["submit"]) && ($_GET["submit"]) == "successUpdated") {
					echo "Publisher Updated Successfully!<br><br>";
				} ?>
				<form action="publisher.php" method="POST">
					<input name="action" type="hidden">
					<table>
						<tr>
							<td>Publisher Name: </td><td><input style="width:250px;" name="publisherName" id="publisherName" placeholder="Publisher Name *" type="text"></td>
						</tr>
						<tr>
							<td>First Name: </td><td><input style="width:200px;" name="firstName" id="firstName" placeholder="Contact First Name *" type="text"></td>
						</tr>
						<tr>
							<td>Last Name: </td><td><input style="width:200px;" name="lastName" id="lastName" placeholder="Contact Surname *" type="text"></td>
						</tr>
						<tr>
							<td>Email Address: </td><td><input style="width:200px;" name="publisherEmail" id="publisherEmail" placeholder="Publisher Email *" type="email"></td>
						</tr>
						<tr>
							<td></td><td><input type="submit" value="Submit"></td>
						</tr>
					</table>
				</form>
			</div>
		</section>
	<?php }
	mysqli_close($conn); ?>
<?php
	include_once 'templates/footer.php';
?>
