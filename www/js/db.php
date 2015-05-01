<?php
	include('config.php');

	/**  Switch Case to Get Action from controller  **/
	switch($_GET['action'])  {
		case 'add_school' :
				add_school();
				break;
		case 'get_school' :
				get_school();
				break;
		case 'edit_product' :
				edit_school();
				break;
		case 'delete_product' :              
				delete_school();
				break;
		case 'update_product' :
				update_school();
				break;
	}
	/**  Function to Add Product  **/
	function add_school() {
		$json = file_get_contents('php://input');
		$data = json_decode($json); 
		$schoolname      			= 'taco';    
		$date      					= $data->date;
		$headmaster     			= $data->headmaster;
		$address  					= $data->address;
		$phone  					= $data->phone;
		$cosponsor  				= $data->cosponsor;
		$cosponsor_phone  			= $data->cosponsor_phone;
		$person_in_charge_phone  	= $data->person_in_charge_phone;
	 
		//print_r($data);
		$qry = 'INSERT INTO schools (schoolname, date, headmaster, address, phone, cosponsor, cosponsor_phone, person_in_charge_phone) values ("' . $schoolname . '","' . $date . '","' . $headmaster . '","' . $address . '","' . $phone . '","' . $cosponsor . '","' . $cosponsor_phone . '","' . $person_in_charge_phone . '")';
	   
		$qry_res = mysql_query($qry);
		if ($qry_res) {
			$arr = array('msg' => "School Added Successfully!!!", 'error' => '');
			$jsn = json_encode($arr);
			 print_r($jsn);
		} 
		else {
			$arr = array('msg' => "", 'error' => 'Error In inserting school');
			$jsn = json_encode($arr);
			 print_r($jsn);
		}
	}
	/**  Function to Get School  **/
	function get_school() {    
		$qry = mysql_query('SELECT * from schools');
		$data = array();
		while($rows = mysql_fetch_array($qry))
		{
			$data[] = array(
						"schoolname"            => $rows['schoolname'],
						"date"     => $rows['date'],
						"headmaster"     => $rows['headmaster'],
						"address"    => $rows['address'],
						"phone" => $rows['phone'],
						"cosponsor" => $rows['cosponsor'],
						"cosponsor_phone" => $rows['cosponsor_phone'],
						"person_in_charge_phone" => $rows['person_in_charge_phone']
						);
		}
		print_r(json_encode($data));
		return json_encode($data);  
	}
	/**  Function to Delete Product  **/
	function delete_product() {
		$data = json_decode(file_get_contents("php://input"));     
		$index = $data->prod_index;     
		//print_r($data)   ;
		$del = mysql_query("DELETE FROM product WHERE id = ".$index);
		if($del)
		return true;
		return false;     
	}
	/**  Function to Edit Product  **/
	function edit_product() {
		$data = json_decode(file_get_contents("php://input"));     
		$index = $data->prod_index; 
		$qry = mysql_query('SELECT * from product WHERE id='.$index);
		$data = array();
		while($rows = mysql_fetch_array($qry))
		{
			$data[] = array(
						"id"            =>  $rows['id'],
						"prod_name"     =>  $rows['prod_name'],
						"prod_desc"     =>  $rows['prod_desc'],
						"prod_price"    =>  $rows['prod_price'],
						"prod_quantity" =>  $rows['prod_quantity']
						);
		}
		print_r(json_encode($data));
		return json_encode($data);  
	}
	/** Function to Update Product **/
	function update_product() {
		$data = json_decode(file_get_contents("php://input")); 
		$id             =   $data->id;
		$prod_name      =   $data->prod_name;    
		$prod_desc      =   $data->prod_desc;
		$prod_price     =   $data->prod_price;
		$prod_quantity  =   $data->prod_quantity;
	   // print_r($data);
		
		$qry = "UPDATE product set prod_name='".$prod_name."' , prod_desc='".$prod_desc."',prod_price='.$prod_price.',prod_quantity='.$prod_quantity.' WHERE id=".$id;
	  
		$qry_res = mysql_query($qry);
		if ($qry_res) {
			$arr = array('msg' => "Product Updated Successfully!!!", 'error' => '');
			$jsn = json_encode($arr);
			// print_r($jsn);
		} else {
			$arr = array('msg' => "", 'error' => 'Error In Updating record');
			$jsn = json_encode($arr);
			// print_r($jsn);
		}
	}
?>