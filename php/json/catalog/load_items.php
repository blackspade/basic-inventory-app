<?php
require_once '../../core/init.php';
require_once '../../functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../../classes/'.$class.'.php';
});

if(is_ajax_request()){
	
	$category = strtoupper(hyper_escape($_GET['category']));
	$con = new mysqli(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
	$sql = "SELECT * FROM `master_inventory` WHERE `item_status` = 'ACTIVE' AND `item_category` = ?";	
	
	$arr = [];

	if (!($stmt = $con->prepare($sql))) {
		//TEST PURPOSES ONLY
		//echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		$arr["error"] = "PREPARE FAILED";
	}

	if (!$stmt->bind_param("s",$category)){
		//TEST PURPOSES ONLY
		//echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		$arr["error"] = "BINDING FAILED";
	}

	if (!$stmt->execute()) {
		//TEST PURPOSES ONLY
		//echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		$arr["error"] = "EXECUTE FAILED";
	}else{
		
		$stmt->bind_result($id, $item_number,$name,$clicks,$status,$image,$video,$cat, $price, $man, $model, $year,$desc,$created,$last,$date);
		echo "<table class='table'><thead><tr> <th></th> <th>Item #</th> <th>Item Name</th> <th>Image</th> <th>Item Price</th> <th>Manufacturer</th> <th>Model</th> <th>Year</th> <th>Action</th> </tr></thead><tbody>";
		
		
		
		while ($stmt->fetch()) {
			
			$img = json_decode($image);

			$img_url = $img->images[0];	
			
			$url = "<img src='../app/master-inventory/uploads/images/".$img_url."' width='50px'>";
			
			echo 	"<tr>".
					"<td><span data-toggle='tooltip' data-placement='bottom' data-html='true' title='{$desc}'><i class='fa fa-info-circle' aria-hidden='true'></i></span></td>".
					"<td>{$item_number}</td>".
					"<td>{$name}</td>".
					"<td>{$url}</td>".
					"<td>{$price}</td>".
					"<td>{$man}</td>".
					"<td>{$model}</td>".
					"<td>{$year}</td>".
					"<td><button onclick='loadQuote(event);' data-item-number='".$item_number."' class='btn btn-info'>View Details</button></td>".
					"</tr>";
		}
		
		echo "</tbody></table>";
		$con->close();
	}
}else{
	exit();
}
?>