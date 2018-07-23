<?php
	include_once 'templates/header.php';
	require 'includes/dbh.php';
?>

<section class="main-container">
	<div class="main-content">
		<h2>Home</h2>

		<table>
			<tr>
				<td><a href="publisher.php">Add&nbsp;Publisher</a></td>
				<td><a href="game.php">Add&nbsp;Game</a></td>
				<td><a href="genre.php">Add&nbsp;Genre</a></td>
				<td><a href="reviewer.php">Add&nbsp;Reviewer</a></td>
				<td><a href="system.php">Add&nbsp;Reviewer&nbsp;System</a></td>
				<td><a href="review.php">Add&nbsp;Review</a></td>
				<td><a href="comment.php">Add&nbsp;Comment</a></td>
			</tr>
		</table>
	</div>
</section>

<?php
	include_once 'templates/footer.php';
?>
