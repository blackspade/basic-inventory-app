<?php
require_once '../../core/init.php';
require_once '../../functions/sanitize.php';

spl_autoload_register(function($class){
    require_once '../../classes/'.$class.'.php';
});

if(is_ajax_request()){
	
	$item_num = hyper_escape($_GET['item']);
	$con = mysqli_connect(config::get('mysql|host'), config::get('mysql|user'), config::get('mysql|pass'), config::get('mysql|db'), 3306);
	$sql = "SELECT * FROM `master_inventory_advance` WHERE `item_number` = '{$item_num}'";
	$result = mysqli_query($con, $sql);

	$item  = [];

	while ($row = mysqli_fetch_row($result)){
		$item['hp'] = $row[2];
		$item['cfm'] = $row[3];
		$item['design'] = $row[4];
		$item['psi'] = $row[5];
		$item['series'] = $row[6];
		$item['cnc'] = $row[7];
		$item['longDescription'] = $row[8];
		$item['rpm'] = $row[9];
		$item['type'] = $row[10];
		$item['features'] = $row[11];
		$item['qty'] = $row[12];
		$item['dataJson'] = $row[14];
	}

	if(strlen($item['dataJson']) != 0){
		$pdf = json_decode($item['dataJson']);
		$pdf_url = $pdf->pdf[0];
		$item['dataJson']= $pdf_url;
		$item['link'] = "../../app/master-inventory/attachment/uploads/files/".$item['dataJson'];
		
		
	}else{
		$item['link'] = "#";
		$item['dataJson'] = "None";
	}
	
	echo "<hr><div>
			<table class='table table-bordered table-sm'>
				<thead>
					<tr>
						<th>HP</th>
						<th>CFM</th>
						<th>Design</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>".$item['hp']."</td>
						<td>".$item['cfm']."</td>
						<td>".$item['design']."</td>
					</tr>
				</tbody>
			</table>
			
			<table class='table table-bordered table-sm'>
				<thead>
					<tr>
						<th>PSI</th>
						<th>Series</th>
						<th>CNC</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>".$item['psi']."</td>
						<td>".$item['series']."</td>
						<td>".$item['cnc']."</td>
					</tr>
				</tbody>
			</table>
			
			<table class='table table-bordered table-sm'>
				<thead>
					<tr>
						<th>RPM</th>
						<th>Type</th>
						<th>Features</th>
						<th>Qty</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>".$item['rpm']."</td>
						<td>".$item['type']."</td>
						<td>".$item['features']."</td>
						<td>".$item['qty']."</td>
					</tr>
				</tbody>
			</table>
			
			<table class='table table-bordered table-sm'>
				<thead>
					<tr>
						<th>Long Description</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>".$item['longDescription']."</td>
					</tr>
				</tbody>
			</table>
			
			<label><i class='fa fa-file-pdf-o' aria-hidden='true'></i> PDF: </label>
			<a href='".$item['link']."' download>".$item['dataJson']."</a>	
		</div>
	";
	  
	mysqli_close($con);
	
}else{
	exit();
}
?>