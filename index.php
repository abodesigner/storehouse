<?php
	ob_start();
	session_start();
	$pageTitle = 'HomePage';
	include 'init.php';
	?>

	<div class="container">
			<div class="row">
			<?php
				$allItems = getAllRecords('items','WHERE Approve = 1','Item_ID');

				// $catid = str_replace('-',' ',$_GET['pageid']);
				// $listItems = getItems('Cat_ID',$catid);

				foreach ($allItems as $item) {
					echo "<div class='col-md-3 col-sm-6'>";
							echo "<div class='thumbnail item-box'>";
									echo "<span class='price-tag'>$" . $item['Price'] . "</span>";
									echo "<img class='img-responsive' src='https://via.placeholder.com/350x150' alt='testImg' />";
									echo "<div class='caption'>";
										echo "<h3><a href='item-details.php?itemid=". $item['Item_ID'] ."'>" . $item['Name'] . "</a></h3>";
										echo "<p>" . $item['Description'] . "</p>";
										echo "<div class='date'>Date: " . $item['Add_Date'] . "</div>";
									echo "</div>";
							echo "</div>";
					echo "</div>";
			}
			?>
		</div>
	</div>



<?php
	include $tpl . 'footer.inc.php';
	ob_end_flush();
?>
