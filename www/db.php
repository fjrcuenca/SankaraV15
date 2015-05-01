<?php
	include('config.php');

	/**  Switch Case to Get Action from controller  **/
	switch($_GET['action'])  {
		case 'sign_in' :
				sign_in();
				break;
        	case 'exists' :
                		exists();
                		break;
		// Remove: No more master screening site search
		case 'get_screening_sites' :
				get_screening_sites();
				break;
		// Remove
		case 'get_screening_site' :
				get_screening_site();
				break;
		case 'add_school' :
				add_school();
				break;
		case 'add_camp' :
				add_camp();
				break;
		case 'add_anganwadi' :
				add_anganwadi();
				break;
		case 'add_student' :
				add_student();
				break;
		case 'add_student_to_school' :
				add_student_to_school();
				break;
		case 'add_student_to_camp' :
				add_student_to_camp();
				break;
		case 'add_student_to_anganwadi' :
				add_student_to_anganwadi();
				break;
		case 'get_school' :
				get_school();
				break;
		case 'get_schools' :
				get_schools();
				break;
		case 'get_camp' :
				get_camp();
				break;
		case 'get_camps' :
				get_camps();
				break;
		case 'get_anganwadi' :
				get_anganwadi();
				break;
		case 'get_anganwadis' :
				get_anganwadis();
				break;
		case 'get_student_master' :
				get_student_master();
				break;
		case 'get_student' :
				get_student();
				break;
		//TODO: change to get_students_from_school
		case 'get_students' :
				get_students();
				break;
		case 'get_students_from_camp' :
				get_students_from_camp();
				break;
		case 'get_students_from_anganwadi' :
				get_students_from_anganwadi();
				break;
		case 'edit_school' :
				edit_school();
				break;
		case 'delete_school' :              
				delete_school();
				break;
		case 'delete_camp' :              
				delete_camp();
				break;
		case 'delete_anganwadi' :              
				delete_anganwadi();
				break;
		case 'update_product' :
				update_school();
				break;
	}
	/** Function to Sign In **/

	function sign_in() {
		$data = json_decode(file_get_contents("php://input"));
		if(!isset($data->username) || !isset($data->password) || strlen(trim($data->username)) == 0 || strlen(trim($data->password)) == 0) {
			$matchFound = "empty";
		} else {
			$username = $data->username;
			$password = $data->password;
			$query = mysql_query("SELECT * from login where username='$username' and password='$password'");
			$matchFound = mysql_num_rows($query) > 0 ? "yes" : "no";
		}
		echo $matchFound;
	}

	/** Function to Check if account exists **/
    
	function exists() {
		$data = json_decode(file_get_contents("php://input"));
        $username = $data->username;
        $query = mysql_query("SELECT * from login where username='$username'");
        $matchFound = mysql_num_rows($query) > 0 ? "yes" : "no";
        
        //If it does not exists in the database, insert, else don't
        if($matchFound == "no") {
            $password = $data->password;
            $qry = 'INSERT INTO login (username, password) values ("'. $username .'", "' . $password . '")';
            $qry_res = mysql_query($qry);
            if($qry_res) {
                $return = "Success";
            } else {
                $return = "Error inserting into database";
            }
        } else {
            $return = "Username already exists in the database. Please try again.";
        }
		echo $return;
	}


	/**  Function to Add Student  **/
	function add_student() {
		$data = json_decode(file_get_contents("php://input"));
		$firstname      			= $data->firstname;    
		$lastname      				= $data->lastname;
		$screening_site      		= $data->screening_site;
		$gender      				= $data->gender;    
		$birth_date      			= $data->birth_date;
		$role_no      				= $data->role_no;
		$class      				= $data->class;
		$section      				= $data->section;
		$teacher      				= $data->teacher;    
		$school      				= $data->school;
		$parent_name      			= $data->parent_name;
		$screen_date      			= $data->screen_date;    
		$screened_by      			= $data->screened_by;
		$diagnosis      			= $data->diagnosis;
		$secondary_date      		= $data->secondary_date;
		$depth_perception      		= $data->depth_perception;
		$muscle_imbalance      		= $data->muscle_imbalance;
		$colour_vision      		= $data->colour_vision;
		$squint      				= $data->squint;
		$va_r                       = $data->va_r;
		$as_r                       = $data->as_r;
		$om_r                       = $data->om_r;
		$fundux_r      				= $data->fundux_r;
		$iop_r      				= $data->iop_r;    
		$duct_r      				= $data->duct_r;
		$amblyopia_r      			= $data->amblyopia_r;
		$va_l                       = $data->va_l;
		$as_l                       = $data->as_l;
		$om_l                       = $data->om_l;
		$fundux_l      				= $data->fundux_l;
		$iop_l      				= $data->iop_l;    
		$duct_l      				= $data->duct_l;
		$amblyopia_l      			= $data->amblyopia_l;
		$notes      				= $data->notes;

		print_r($data);
		$qry = 'INSERT INTO students (firstname, lastname, screening_site, gender, birth_date,
			role_no, class, section, teacher, school, parent_name, screen_date,
			screened_by, diagnosis, secondary_date, depth_perception, muscle_imbalance, colour_vision,
			squint, va_r, as_r, om_r, fundux_r, iop_r, duct_r, amblyopia_r, va_l, as_l, om_l, 
			fundux_l, iop_l, duct_l, amblyopia_l, notes) values ("' . $firstname . '","' . $lastname . '","' . $screening_site . '"
			, "' . $gender . '", "' . $birth_date . '", "' . $role_no . '", "' . $class . '"
            , "' . $section . '", "' . $teacher . '", "' . $school . '", "' . $parent_name . '"
			, "' . $screen_date . '", "' . $screened_by . '", "' . $diagnosis . '", "' . $secondary_date . '"
			, "' . $depth_perception . '", "' . $muscle_imbalance . '", "' . $colour_vision . '", "' . $squint . '"
			, "' . $va_r . '", "' . $as_r . '", "' . $om_r . '", "' . $fundux_r . '", "' . $iop_r . '"
			, "' . $duct_r . '", "' . $amblyopia_r . '", "' . $va_l . '", "' . $as_l . '", "' . $om_l . '"
			, "' . $fundux_l . '", "' . $iop_l . '", "' . $duct_l . '", "' . $amblyopia_l . '", "' . $notes . '")';
	   
		$qry_res = mysql_query($qry);
		if ($qry_res) {
			$arr = array('msg' => "School Added Successfully!!!", 'error' => '');
			$jsn = json_encode($arr);
			// print_r($jsn);
		} 
		else {
			$arr = array('msg' => "", 'error' => 'Error In inserting school');
			$jsn = json_encode($arr);
			// print_r($jsn);
		}
	}

/*************** ADDED **************/

	/**  Function to Add Student to a school  **/
	function add_student_to_school() {
		$data = json_decode(file_get_contents("php://input"));
		$firstname      			= $data->firstname;    
		$lastname      				= $data->lastname;
		$screening_site      			= $data->screening_site;
		$gender      				= $data->gender;    
		$birth_date      			= $data->birth_date;
		$role_no      				= $data->role_no;
		$class      				= $data->class;
		$section      				= $data->section;
		$teacher      				= $data->teacher;    
		$school      				= $_GET['school'];
		$parent_name      			= $data->parent_name;
		$screen_date      			= $data->screen_date;    
		$screened_by      			= $data->screened_by;
		$diagnosis      			= $data->diagnosis;
		$secondary_date      			= $data->secondary_date;
		$depth_perception      			= $data->depth_perception;
		$muscle_imbalance      			= $data->muscle_imbalance;
		$colour_vision      			= $data->colour_vision;
		$squint      				= $data->squint;
		$va_r                       		= $data->va_r;
		$as_r                       		= $data->as_r;
		$om_r                       		= $data->om_r;
		$fundux_r      				= $data->fundux_r;
		$iop_r      				= $data->iop_r;    
		$duct_r      				= $data->duct_r;
		$amblyopia_r      			= $data->amblyopia_r;
		$va_l                       		= $data->va_l;
		$as_l                       		= $data->as_l;
		$om_l                      	 	= $data->om_l;
		$fundux_l      				= $data->fundux_l;
		$iop_l      				= $data->iop_l;    
		$duct_l      				= $data->duct_l;
		$amblyopia_l      			= $data->amblyopia_l;
		$notes      				= $data->notes;

		print_r($data);
		$qry = 'INSERT INTO students (firstname, lastname, screening_site, gender, birth_date,
			role_no, class, section, teacher, school, parent_name, screen_date,
			screened_by, diagnosis, secondary_date, depth_perception, muscle_imbalance, colour_vision,
			squint, va_r, as_r, om_r, fundux_r, iop_r, duct_r, amblyopia_r, va_l, as_l, om_l, 
			fundux_l, iop_l, duct_l, amblyopia_l, notes) values ("' . $firstname . '","' . $lastname . '","' . $screening_site . '"
			, "' . $gender . '", "' . $birth_date . '", "' . $role_no . '", "' . $class . '"
            , "' . $section . '", "' . $teacher . '", "' . $school . '", "' . $parent_name . '"
			, "' . $screen_date . '", "' . $screened_by . '", "' . $diagnosis . '", "' . $secondary_date . '"
			, "' . $depth_perception . '", "' . $muscle_imbalance . '", "' . $colour_vision . '", "' . $squint . '"
			, "' . $va_r . '", "' . $as_r . '", "' . $om_r . '", "' . $fundux_r . '", "' . $iop_r . '"
			, "' . $duct_r . '", "' . $amblyopia_r . '", "' . $va_l . '", "' . $as_l . '", "' . $om_l . '"
			, "' . $fundux_l . '", "' . $iop_l . '", "' . $duct_l . '", "' . $amblyopia_l . '", "' . $notes . '")';
	   
		$qry_res = mysql_query($qry);
		if ($qry_res) {
			$arr = array('msg' => "Student Added Successfully!!!", 
					'error' => '',
					'school' => $school,
					'firstname' => $firstname,
					'lastname' => $lastname,
					'parent_name' => $parent_name);
			return json_encode($arr);
			// print_r($jsn);
		} 
		else {
			$arr = array('msg' => "", 'error' => 'Error In inserting student');
			$jsn = json_encode($arr);
			// print_r($jsn);
		}
	}

	/**  Function to Add Student to a camp  **/
	function add_student_to_camp() {
		$data = json_decode(file_get_contents("php://input"));
		$firstname      			= $data->firstname;    
		$lastname      				= $data->lastname;
		$screening_site      			= $data->screening_site;
		$gender      				= $data->gender;    
		$birth_date      			= $data->birth_date;
		$role_no      				= $data->role_no;
		$class      				= $data->class;
		$section      				= $data->section;
		$teacher      				= $data->teacher;    
		$camp      				= $_GET['camp'];
		$parent_name      			= $data->parent_name;
		$screen_date      			= $data->screen_date;    
		$screened_by      			= $data->screened_by;
		$diagnosis      			= $data->diagnosis;
		$secondary_date      			= $data->secondary_date;
		$depth_perception      			= $data->depth_perception;
		$muscle_imbalance      			= $data->muscle_imbalance;
		$colour_vision      			= $data->colour_vision;
		$squint      				= $data->squint;
		$va_r                       		= $data->va_r;
		$as_r                       		= $data->as_r;
		$om_r                       		= $data->om_r;
		$fundux_r      				= $data->fundux_r;
		$iop_r      				= $data->iop_r;    
		$duct_r      				= $data->duct_r;
		$amblyopia_r      			= $data->amblyopia_r;
		$va_l                       		= $data->va_l;
		$as_l                       		= $data->as_l;
		$om_l                      	 	= $data->om_l;
		$fundux_l      				= $data->fundux_l;
		$iop_l      				= $data->iop_l;    
		$duct_l      				= $data->duct_l;
		$amblyopia_l      			= $data->amblyopia_l;
		$notes      				= $data->notes;

		print_r($data);
		$qry = 'INSERT INTO students (firstname, lastname, screening_site, gender, birth_date,
			role_no, class, section, teacher, camp, parent_name, screen_date,
			screened_by, diagnosis, secondary_date, depth_perception, muscle_imbalance, colour_vision,
			squint, va_r, as_r, om_r, fundux_r, iop_r, duct_r, amblyopia_r, va_l, as_l, om_l, 
			fundux_l, iop_l, duct_l, amblyopia_l, notes) values ("' . $firstname . '","' . $lastname . '","' . $screening_site . '"
			, "' . $gender . '", "' . $birth_date . '", "' . $role_no . '", "' . $class . '"
            , "' . $section . '", "' . $teacher . '", "' . $camp . '", "' . $parent_name . '"
			, "' . $screen_date . '", "' . $screened_by . '", "' . $diagnosis . '", "' . $secondary_date . '"
			, "' . $depth_perception . '", "' . $muscle_imbalance . '", "' . $colour_vision . '", "' . $squint . '"
			, "' . $va_r . '", "' . $as_r . '", "' . $om_r . '", "' . $fundux_r . '", "' . $iop_r . '"
			, "' . $duct_r . '", "' . $amblyopia_r . '", "' . $va_l . '", "' . $as_l . '", "' . $om_l . '"
			, "' . $fundux_l . '", "' . $iop_l . '", "' . $duct_l . '", "' . $amblyopia_l . '", "' . $notes . '")';
	   
		$qry_res = mysql_query($qry);
		if ($qry_res) {
			$arr = array('msg' => "Student Added Successfully!!!", 
					'error' => '',
					'camp' => $camp,
					'firstname' => $firstname,
					'lastname' => $lastname,
					'parent_name' => $parent_name);
			return json_encode($arr);
			// print_r($jsn);
		} 
		else {
			$arr = array('msg' => "", 'error' => 'Error In inserting student');
			$jsn = json_encode($arr);
			// print_r($jsn);
		}
	}

	/**  Function to Add Student to a anganwadi  **/
	function add_student_to_anganwadi() {
		$data = json_decode(file_get_contents("php://input"));
		$firstname      			= $data->firstname;    
		$lastname      				= $data->lastname;
		$screening_site      			= $data->screening_site;
		$gender      				= $data->gender;    
		$birth_date      			= $data->birth_date;
		$role_no      				= $data->role_no;
		$class      				= $data->class;
		$section      				= $data->section;
		$teacher      				= $data->teacher;    
		$anganwadi      			= $_GET['anganwadi'];
		$parent_name      			= $data->parent_name;
		$screen_date      			= $data->screen_date;    
		$screened_by      			= $data->screened_by;
		$diagnosis      			= $data->diagnosis;
		$secondary_date      			= $data->secondary_date;
		$depth_perception      			= $data->depth_perception;
		$muscle_imbalance      			= $data->muscle_imbalance;
		$colour_vision      			= $data->colour_vision;
		$squint      				= $data->squint;
		$va_r                       		= $data->va_r;
		$as_r                       		= $data->as_r;
		$om_r                       		= $data->om_r;
		$fundux_r      				= $data->fundux_r;
		$iop_r      				= $data->iop_r;    
		$duct_r      				= $data->duct_r;
		$amblyopia_r      			= $data->amblyopia_r;
		$va_l                       		= $data->va_l;
		$as_l                       		= $data->as_l;
		$om_l                      	 	= $data->om_l;
		$fundux_l      				= $data->fundux_l;
		$iop_l      				= $data->iop_l;    
		$duct_l      				= $data->duct_l;
		$amblyopia_l      			= $data->amblyopia_l;
		$notes      				= $data->notes;

		print_r($data);
		$qry = 'INSERT INTO students (firstname, lastname, screening_site, gender, birth_date,
			role_no, class, section, teacher, anganwadi, parent_name, screen_date,
			screened_by, diagnosis, secondary_date, depth_perception, muscle_imbalance, colour_vision,
			squint, va_r, as_r, om_r, fundux_r, iop_r, duct_r, amblyopia_r, va_l, as_l, om_l, 
			fundux_l, iop_l, duct_l, amblyopia_l, notes) values ("' . $firstname . '","' . $lastname . '","' . $screening_site . '"
			, "' . $gender . '", "' . $birth_date . '", "' . $role_no . '", "' . $class . '"
            , "' . $section . '", "' . $teacher . '", "' . $anganwadi . '", "' . $parent_name . '"
			, "' . $screen_date . '", "' . $screened_by . '", "' . $diagnosis . '", "' . $secondary_date . '"
			, "' . $depth_perception . '", "' . $muscle_imbalance . '", "' . $colour_vision . '", "' . $squint . '"
			, "' . $va_r . '", "' . $as_r . '", "' . $om_r . '", "' . $fundux_r . '", "' . $iop_r . '"
			, "' . $duct_r . '", "' . $amblyopia_r . '", "' . $va_l . '", "' . $as_l . '", "' . $om_l . '"
			, "' . $fundux_l . '", "' . $iop_l . '", "' . $duct_l . '", "' . $amblyopia_l . '", "' . $notes . '")';
	   
		$qry_res = mysql_query($qry);
		if ($qry_res) {
			$arr = array('msg' => "Student Added Successfully!!!", 
					'error' => '',
					'anganwadi' => $anganwadi,
					'firstname' => $firstname,
					'lastname' => $lastname,
					'parent_name' => $parent_name);
			return json_encode($arr);
			// print_r($jsn);
		} 
		else {
			$arr = array('msg' => "", 'error' => 'Error In inserting student');
			$jsn = json_encode($arr);
			// print_r($jsn);
		}
	}

	/** Could possibly remove school/camp/anganwadi name!! **/
	function get_screening_sites() {
		$qry = mysql_query('SELECT * from screening_sites');
		$data = array();
		while($rows = mysql_fetch_array($qry))
		{
			if ($rows['school_name'] != NULL ) {
				$data[] = array(
					"school_name"	=>	$rows['school_name'],
					"camp_name" => $rows['camp_name'],
					"anganwadi_name" => $rows['anganwadi_name'],
					"screening_date"     => $rows['screening_date'],
					"headmaster"     => $rows['headmaster'],
					"name"	=>	$rows['school_name'],
					"kind" => 'School'
				);
			} else if ($rows['camp_name'] != NULL ) {
				$data[] = array(
					"school_name"	=>	$rows['school_name'],
					"camp_name" => $rows['camp_name'],
					"anganwadi_name" => $rows['anganwadi_name'],
					"screening_date"     => $rows['screening_date'],
					"headmaster"     => $rows['headmaster'],
					"name"	=>	$rows['camp_name'],
					"kind" => 'Camp'
				);
			} else if ($rows['anganwadi_name'] != NULL ) {
				$data[] = array(
					"school_name"	=>	$rows['school_name'],
					"camp_name" => $rows['camp_name'],
					"anganwadi_name" => $rows['anganwadi_name'],
					"screening_date"     => $rows['screening_date'],
					"headmaster"     => $rows['headmaster'],
					"name"	=>	$rows['anganwadi_name'],
					"kind" => 'Anganwadi'
				);
			} else {
				$data[] = array(
					"school_name"	=>	$rows['school_name'],
					"camp_name" => $rows['camp_name'],
					"anganwadi_name" => $rows['anganwadi_name'],
					"screening_date"     => $rows['screening_date'],
					"headmaster"     => $rows['headmaster'],
					"name"	=>	$rows['school_name'],
					"kind" => 'Undefined'
				);
			}
		}
		print_r(json_encode($data));
		return json_encode($data);  
	}

/** NEED TO FIX **/	
	/**
	 * Get_Screening_Site:
	 *	Get a specific screening site's information based on the site name
	 *	and the screening site kind (school, camp, and anganwadi).
	 */
	function get_screening_site() {
		$kind = $_GET['kind'];
		$name = $_GET['site_name'];
		$data = array();
		if ($kind == 'School') {
			$qry = mysql_query("SELECT * from screening_sites where school_name = '$name'");
			while($rows = mysql_fetch_array($qry))
			{
				$data[] = array(
					"school_name"	=>	$rows['school_name'],
					"screening_date"     => $rows['screening_date'],
					"headmaster"     => $rows['headmaster'],
					"address"    => $rows['address'],
					"phone" => $rows['phone'],
					"cosponsor" => $rows['cosponsor'],
					"cosponsor_phone" => $rows['cosponsor_phone'],
					"person_in_charge" => $rows['person_in_charge'],
					"person_in_charge_phone" => $rows['person_in_charge_phone']
				);
			}
		} else if ($kind == 'Camp') {
			$qry = mysql_query("SELECT * from screening_sites where camp_name = '$name'");
			while($rows = mysql_fetch_array($qry))
			{
				$data[] = array(
					"camp_name"	=>	$rows['camp_name'],
					"screening_date"     => $rows['screening_date'],
					"address"    => $rows['address'],
					"phone" => $rows['phone'],
					"cosponsor" => $rows['cosponsor'],
					"cosponsor_phone" => $rows['cosponsor_phone'],
					"person_in_charge" => $rows['person_in_charge'],
					"person_in_charge_phone" => $rows['person_in_charge_phone']
				);
			}
		} else if ($kind == 'Anganwadi') {
			$qry = mysql_query("SELECT * from screening_sites where anganwadi_name = '$name'");
			while($rows = mysql_fetch_array($qry))
			{
				$data[] = array(
					"anganwadi_name"	=>	$rows['anganwadi_name'],
					"screening_date"     => $rows['screening_date'],
					"headmaster"     => $rows['headmaster'],
					"address"    => $rows['address'],
					"phone" => $rows['phone'],
					"cosponsor" => $rows['cosponsor'],
					"cosponsor_phone" => $rows['cosponsor_phone'],
					"person_in_charge" => $rows['person_in_charge'],
					"person_in_charge_phone" => $rows['person_in_charge_phone']
				);
			}
		} else {
			$qry = mysql_query("SELECT * from screening_sites where school_name = '$name'");
			while($rows = mysql_fetch_array($qry))
			{
				$data[] = array(
					"school_name"	=>	$rows['school_name'],
					"screening_date"     => $rows['screening_date'],
					"headmaster"     => $rows['headmaster'],
					"address"    => $rows['address'],
					"phone" => $rows['phone'],
					"cosponsor" => $rows['cosponsor'],
					"cosponsor_phone" => $rows['cosponsor_phone'],
					"person_in_charge" => $rows['person_in_charge'],
					"person_in_charge_phone" => $rows['person_in_charge_phone']
				);
			}
		}
		print_r(json_encode($data));
		return json_encode($data);  
	}
	
	/**  Function to Add School  **/
	function add_school() {
		$data = json_decode(file_get_contents("php://input"));
		$school_name      			= $data->school_name;    
		$screening_date      		= $data->screening_date;
		$headmaster     			= $data->headmaster;
		$address  					= $data->address;
		$phone  					= $data->phone;
		$cosponsor  				= $data->cosponsor;
		$cosponsor_phone  			= $data->cosponsor_phone;
		$person_in_charge           = $data->person_in_charge;
		$person_in_charge_phone  	= $data->person_in_charge_phone;
	 
		print_r($data);
		$qry = 'INSERT INTO screening_sites 
		(school_name, screening_date, headmaster, address, phone, cosponsor, cosponsor_phone, person_in_charge, person_in_charge_phone) 
		values 
		("' . $school_name . '","' . $screening_date . '","' . $headmaster . '","' . $address . '","' . $phone . '",
		"' . $cosponsor . '", "' . $cosponsor_phone . '", "' . $person_in_charge . '", "' . $person_in_charge_phone . '")';
	   
		$qry_res = mysql_query($qry);
		if ($qry_res) {
			$arr = array('msg' => "School Added Successfully!!!", 'error' => '');
			$jsn = json_encode($arr);
			// print_r($jsn);
		} 
		else {
			$arr = array('msg' => "", 'error' => 'Error In inserting school');
			$jsn = json_encode($arr);
			// print_r($jsn);
		}
	}

	/**  Function to Add Camp  **/
	function add_camp() {
		$data = json_decode(file_get_contents("php://input"));
		$camp_name      			= $data->camp_name;    
		$screening_date      		= $data->screening_date;
		$address  					= $data->address;
		$phone  					= $data->phone;
		$cosponsor  				= $data->cosponsor;
		$cosponsor_phone  			= $data->cosponsor_phone;
		$person_in_charge           = $data->person_in_charge;
		$person_in_charge_phone  	= $data->person_in_charge_phone;
	 
		print_r($data);
		$qry = 'INSERT INTO screening_sites 
		(camp_name, screening_date, headmaster, address, phone, cosponsor, cosponsor_phone, person_in_charge, person_in_charge_phone) 
		values 
		("' . $camp_name . '","' . $screening_date . '","' . $headmaster . '","' . $address . '","' . $phone . '",
		"' . $cosponsor . '", "' . $cosponsor_phone . '", "' . $person_in_charge . '", "' . $person_in_charge_phone . '")';
	   
		$qry_res = mysql_query($qry);
		if ($qry_res) {
			$arr = array('msg' => "Camp Added Successfully!!!", 'error' => '');
			$jsn = json_encode($arr);
			// print_r($jsn);
		} 
		else {
			$arr = array('msg' => "", 'error' => 'Error In inserting camp');
			$jsn = json_encode($arr);
			// print_r($jsn);
		}
	}
	
	/**  Function to Add Anganwadi  **/
	function add_anganwadi() {
		$data = json_decode(file_get_contents("php://input"));
		$anganwadi_name      		= $data->anganwadi_name;    
		$screening_date      		= $data->screening_date;
		$headmaster     			= $data->headmaster;
		$address  					= $data->address;
		$phone  					= $data->phone;
		$cosponsor  				= $data->cosponsor;
		$cosponsor_phone  			= $data->cosponsor_phone;
		$person_in_charge           = $data->person_in_charge;
		$person_in_charge_phone  	= $data->person_in_charge_phone;
	 
		print_r($data);
		$qry = 'INSERT INTO screening_sites 
		(anganwadi_name, screening_date, headmaster, address, phone, cosponsor, cosponsor_phone, person_in_charge, person_in_charge_phone) 
		values 
		("' . $anganwadi_name . '","' . $screening_date . '","' . $headmaster . '","' . $address . '","' . $phone . '",
		"' . $cosponsor . '", "' . $cosponsor_phone . '", "' . $person_in_charge . '", "' . $person_in_charge_phone . '")';
	   
		$qry_res = mysql_query($qry);
		if ($qry_res) {
			$arr = array('msg' => "Anganwadi Added Successfully!!!", 'error' => '');
			$jsn = json_encode($arr);
			// print_r($jsn);
		} 
		else {
			$arr = array('msg' => "", 'error' => 'Error In inserting Anganwadi');
			$jsn = json_encode($arr);
			// print_r($jsn);
		}
	}
	
	/** Funciton to get list of all schools **/

	function get_schools() {
		 
		$qry = mysql_query('SELECT * from screening_sites where school_name is not NULL');
		$data = array();
		while($rows = mysql_fetch_array($qry))
		{
			$data[] = array(
				"school_name"	=>	$rows['school_name'],
				"screening_date"     => $rows['screening_date'],
				"headmaster"     => $rows['headmaster'],
				"address"    => $rows['address'],
				"phone" => $rows['phone'],
				"cosponsor" => $rows['cosponsor'],
				"cosponsor_phone" => $rows['cosponsor_phone'],
                "person_in_charge" => $rows['person_in_charge'],
				"person_in_charge_phone" => $rows['person_in_charge_phone']
			);
		}
		print_r(json_encode($data));
		return json_encode($data);  

		//echo $json_response = json_encode($data);  
	}

	/** Function to get list of all camps **/

	function get_camps() {
		 
		$qry = mysql_query('SELECT * from screening_sites where camp_name is not NULL');
		$data = array();
		while($rows = mysql_fetch_array($qry))
		{
			$data[] = array(
				"camp_name"	=>	$rows['camp_name'],
				"screening_date"     => $rows['screening_date'],
				"address"    => $rows['address'],
				"phone" => $rows['phone'],
				"cosponsor" => $rows['cosponsor'],
				"cosponsor_phone" => $rows['cosponsor_phone'],
                		"person_in_charge" => $rows['person_in_charge'],
				"person_in_charge_phone" => $rows['person_in_charge_phone']
			);
		}
		print_r(json_encode($data));
		return json_encode($data);  

		//echo $json_response = json_encode($data);  
	}

	/** Function to get list of all anganwadis **/

	function get_anganwadis() {
		 
		$qry = mysql_query('SELECT * from screening_sites where anganwadi_name is not NULL');
		$data = array();
		while($rows = mysql_fetch_array($qry))
		{
			$data[] = array(
				"anganwadi_name"	=>	$rows['anganwadi_name'],
				"screening_date"     => $rows['screening_date'],
				"headmaster"     => $rows['headmaster'],
				"address"    => $rows['address'],
				"phone" => $rows['phone'],
				"cosponsor" => $rows['cosponsor'],
				"cosponsor_phone" => $rows['cosponsor_phone'],
                "person_in_charge" => $rows['person_in_charge'],
				"person_in_charge_phone" => $rows['person_in_charge_phone']
			);
		}
		print_r(json_encode($data));
		return json_encode($data);  

		//echo $json_response = json_encode($data);  
	}


	/**  Function to Get a specific School  **/   
	function get_school() {
		$name = $_GET['school_name'];
		$qry = mysql_query("SELECT * from screening_sites where school_name = '$name'");
		$data = array();
		while($rows = mysql_fetch_array($qry))
		{
			$data[] = array(
						"school_name"            => $rows['school_name'],
						"screening_date"     => $rows['screening_date'],
						"headmaster"     => $rows['headmaster'],
						"address"    => $rows['address'],
						"phone" => $rows['phone'],
						"cosponsor" => $rows['cosponsor'],
						"cosponsor_phone" => $rows['cosponsor_phone'],
                        "person_in_charge" => $rows['person_in_charge'],
						"person_in_charge_phone" => $rows['person_in_charge_phone']
						);
		}
		print_r(json_encode($data));
		return json_encode($data);  
	}

	function get_camp() {
		$name = $_GET['camp_name'];
		$qry = mysql_query("SELECT * from screening_sites where camp_name = '$name'");
		$data = array();
		while($rows = mysql_fetch_array($qry))
		{
			$data[] = array(
						"camp_name"            => $rows['camp_name'],
						"screening_date"     => $rows['screening_date'],
						"address"    => $rows['address'],
						"phone" => $rows['phone'],
						"cosponsor" => $rows['cosponsor'],
						"cosponsor_phone" => $rows['cosponsor_phone'],
                        			"person_in_charge" => $rows['person_in_charge'],
						"person_in_charge_phone" => $rows['person_in_charge_phone']
			);
		}
		print_r(json_encode($data));
		return json_encode($data);  
	}

	/**  Function to Get a specific Anganwadi  **/   
	function get_anganwadi() {
		$name = $_GET['anganwadi_name'];
		$qry = mysql_query("SELECT * from screening_sites where anganwadi_name = '$name'");
		$data = array();
		while($rows = mysql_fetch_array($qry))
		{
			$data[] = array(
						"anganwadi_name"            => $rows['anganwadi_name'],
						"screening_date"     => $rows['screening_date'],
						"headmaster"     => $rows['headmaster'],
						"address"    => $rows['address'],
						"phone" => $rows['phone'],
						"cosponsor" => $rows['cosponsor'],
						"cosponsor_phone" => $rows['cosponsor_phone'],
                        "person_in_charge" => $rows['person_in_charge'],
						"person_in_charge_phone" => $rows['person_in_charge_phone']
						);
		}
		print_r(json_encode($data));
		return json_encode($data);  
	}

	/** Function to get list of all students **/

	function get_student_master() {
		 
		$qry = mysql_query('SELECT * from students');
		$data = array();
		while($rows = mysql_fetch_array($qry))
		{
			if($rows['school'] != null) {
				$data[] = array(
					"lastname"	=>	$rows['lastname'],
					"firstname"	=>	$rows['firstname'],
					"role_no"            => $rows['role_no'],
					"site_name"            => $rows['school'],
					"parent_name"	=> $rows['parent_name'],
					"site" => "school"
				);
			} else if ($rows['camp'] != null) {
				$data[] = array(
					"lastname"	=>	$rows['lastname'],
					"firstname"	=>	$rows['firstname'],
					"role_no"            => $rows['role_no'],
					"site_name"            => $rows['camp'],
					"parent_name"	=> $rows['parent_name'],
					"site" => "camp"
				);
			} else {
				$data[] = array(
					"lastname"	=>	$rows['lastname'],
					"firstname"	=>	$rows['firstname'],
					"role_no"            => $rows['role_no'],
					"site_name"            => $rows['anganwadi'],
					"parent_name"	=> $rows['parent_name'],
					"site" => "anganwadi"
				);
			}
		}
		print_r(json_encode($data));
		return json_encode($data);  

		//echo $json_response = json_encode($data);  
	}

	/** Function to get list of all students from a selected school**/

	function get_students() {
		$name = $_GET['school'];
		$qry = mysql_query("SELECT * from students where school = '$name'");
		$data = array();
		while($rows = mysql_fetch_array($qry))
		{
			$data[] = array(
				"school"	=>	$rows['school'],
				"lastname"	=>	$rows['lastname'],
				"firstname"	=>	$rows['firstname'],
				"parent_name"            => $rows['parent_name'],
				"role_no"            => $rows['role_no'],
				"class"            => $rows['class']
			);
		}
		print_r(json_encode($data));
		return json_encode($data);  

		//echo $json_response = json_encode($data);  
	}

	/** Function to get list of all students from a selected camp**/

	function get_students_from_camp() {
		$name = $_GET['camp'];
		$qry = mysql_query("SELECT * from students where camp = '$name'");
		$data = array();
		while($rows = mysql_fetch_array($qry))
		{
			$data[] = array(
				"camp"	=>	$rows['camp'],
				"lastname"	=>	$rows['lastname'],
				"firstname"	=>	$rows['firstname'],
				"parent_name"            => $rows['parent_name'],
				"role_no"            => $rows['role_no'],
				"class"            => $rows['class']
			);
		}
		print_r(json_encode($data));
		return json_encode($data);  

		//echo $json_response = json_encode($data);  
	}

	/** Function to get list of all students from a selected anganwadi**/

	function get_students_from_anganwadi() {
		$name = $_GET['anganwadi'];
		$qry = mysql_query("SELECT * from students where anganwadi = '$name'");
		$data = array();
		while($rows = mysql_fetch_array($qry))
		{
			$data[] = array(
				"anganwadi"	=>	$rows['anganwadi'],
				"lastname"	=>	$rows['lastname'],
				"firstname"	=>	$rows['firstname'],
				"parent_name"            => $rows['parent_name'],
				"role_no"            => $rows['role_no'],
				"class"            => $rows['class']
			);
		}
		print_r(json_encode($data));
		return json_encode($data);  

		//echo $json_response = json_encode($data);  
	}

	/**  Function to get a specific student's information  **/
	function get_student() { 
		$site = $_GET['site'];   
		$data = array();
		$firstname = $_GET['firstname'];
		$lastname = $_GET['lastname'];
		$parent_name = $_GET['parent_name'];
		if($site == "school") {
			$school = $_GET['site_name'];
			$qry = mysql_query("SELECT * from students where school = '$school' AND firstname = '$firstname' AND lastname = '$lastname' AND parent_name = '$parent_name'");
			while($rows = mysql_fetch_array($qry))
			{
				$data[] = array(
						"role_no"            => $rows['role_no'],
						"lastname"            => $rows['lastname'],
						"firstname"            => $rows['firstname'],
						"age"            => $rows['age'],
						"birth_month"            => $rows['birth_month'],
						"birth_date"            => $rows['birth_date'],
						"birth_year"            => $rows['birth_year'],
						"class"            => $rows['class'],
						"section"            => $rows['section'],
						"teacher"            => $rows['teacher'],
						"site_name"            => $rows['school'],
						"demographic"            => $rows['demographic'],
						"parent_name"            => $rows['parent_name'],
						"street"            => $rows['street'],
						"locality"            => $rows['locality'],
						"town"            => $rows['town'],
						"postcode"            => $rows['postcode'],
						"phone"            => $rows['phone'],
						"accompanied_by"            => $rows['accompanied_by'],
						"screen_date"            => $rows['screen_date'],
						"screen_month"            => $rows['screen_month'],
						"screen_year"            => $rows['screen_year'],
						"screened_by"            => $rows['screened_by'],
						"diagnosis"            => $rows['diagnosis'],
						"secondary_date"            => $rows['secondary_date'],
						"secondary_month"            => $rows['secondary_month'],
						"secondary_year"            => $rows['secondary_year'],
						"depth_perception"            => $rows['depth_perception'],
						"muscle_imbalance"            => $rows['muscle_imbalance'],
						"colour_vision"            => $rows['colour_vision'],
						"squint"            => $rows['squint'],
						"va_r"            => $rows['va_r'],
						"va_l"            => $rows['va_l'],
						"as_r"            => $rows['as_r'],
						"as_l"            => $rows['as_l'],
						"om_r"            => $rows['om_r'],
						"om_l"            => $rows['om_l'],
						"fundux_r"            => $rows['fundux_r'],
						"fundux_l"            => $rows['fundux_l'],
						"iop_r"            => $rows['iop_r'],
						"iop_l"            => $rows['iop_l'],
						"duct_r"            => $rows['duct_r'],
						"duct_l"            => $rows['duct_l'],
						"amblyopia_r"            => $rows['amblyopia_r'],
						"amblyopia_l"            => $rows['amblyopia_l'],
						"notes"            => $rows['notes']
				);
			}
		} else if ($site == 'camp') {
			$camp = $_GET['site_name'];
			$qry = mysql_query("SELECT * from students where camp = '$camp' AND firstname = '$firstname' AND lastname = '$lastname' AND parent_name = '$parent_name'");
			while($rows = mysql_fetch_array($qry))
			{
				$data[] = array(
						"role_no"            => $rows['role_no'],
						"lastname"            => $rows['lastname'],
						"firstname"            => $rows['firstname'],
						"age"            => $rows['age'],
						"birth_month"            => $rows['birth_month'],
						"birth_date"            => $rows['birth_date'],
						"birth_year"            => $rows['birth_year'],
						"class"            => $rows['class'],
						"section"            => $rows['section'],
						"teacher"            => $rows['teacher'],
						"site_name"            => $rows['camp'],
						"demographic"            => $rows['demographic'],
						"parent_name"            => $rows['parent_name'],
						"street"            => $rows['street'],
						"locality"            => $rows['locality'],
						"town"            => $rows['town'],
						"postcode"            => $rows['postcode'],
						"phone"            => $rows['phone'],
						"accompanied_by"            => $rows['accompanied_by'],
						"screen_date"            => $rows['screen_date'],
						"screen_month"            => $rows['screen_month'],
						"screen_year"            => $rows['screen_year'],
						"screened_by"            => $rows['screened_by'],
						"diagnosis"            => $rows['diagnosis'],
						"secondary_date"            => $rows['secondary_date'],
						"secondary_month"            => $rows['secondary_month'],
						"secondary_year"            => $rows['secondary_year'],
						"depth_perception"            => $rows['depth_perception'],
						"muscle_imbalance"            => $rows['muscle_imbalance'],
						"colour_vision"            => $rows['colour_vision'],
						"squint"            => $rows['squint'],
						"va_r"            => $rows['va_r'],
						"va_l"            => $rows['va_l'],
						"as_r"            => $rows['as_r'],
						"as_l"            => $rows['as_l'],
						"om_r"            => $rows['om_r'],
						"om_l"            => $rows['om_l'],
						"fundux_r"            => $rows['fundux_r'],
						"fundux_l"            => $rows['fundux_l'],
						"iop_r"            => $rows['iop_r'],
						"iop_l"            => $rows['iop_l'],
						"duct_r"            => $rows['duct_r'],
						"duct_l"            => $rows['duct_l'],
						"amblyopia_r"            => $rows['amblyopia_r'],
						"amblyopia_l"            => $rows['amblyopia_l'],
						"notes"            => $rows['notes']
				);
			}
		} else {
			$anganwadi = $_GET['site_name'];
			$qry = mysql_query("SELECT * from students where anganwadi = '$anganwadi' AND firstname = '$firstname' AND lastname = '$lastname' AND parent_name = '$parent_name'");
			while($rows = mysql_fetch_array($qry))
			{
				$data[] = array(
						"role_no"            => $rows['role_no'],
						"lastname"            => $rows['lastname'],
						"firstname"            => $rows['firstname'],
						"age"            => $rows['age'],
						"birth_month"            => $rows['birth_month'],
						"birth_date"            => $rows['birth_date'],
						"birth_year"            => $rows['birth_year'],
						"class"            => $rows['class'],
						"section"            => $rows['section'],
						"teacher"            => $rows['teacher'],
						"site_name"            => $rows['anganwadi'],
						"demographic"            => $rows['demographic'],
						"parent_name"            => $rows['parent_name'],
						"street"            => $rows['street'],
						"locality"            => $rows['locality'],
						"town"            => $rows['town'],
						"postcode"            => $rows['postcode'],
						"phone"            => $rows['phone'],
						"accompanied_by"            => $rows['accompanied_by'],
						"screen_date"            => $rows['screen_date'],
						"screen_month"            => $rows['screen_month'],
						"screen_year"            => $rows['screen_year'],
						"screened_by"            => $rows['screened_by'],
						"diagnosis"            => $rows['diagnosis'],
						"secondary_date"            => $rows['secondary_date'],
						"secondary_month"            => $rows['secondary_month'],
						"secondary_year"            => $rows['secondary_year'],
						"depth_perception"            => $rows['depth_perception'],
						"muscle_imbalance"            => $rows['muscle_imbalance'],
						"colour_vision"            => $rows['colour_vision'],
						"squint"            => $rows['squint'],
						"va_r"            => $rows['va_r'],
						"va_l"            => $rows['va_l'],
						"as_r"            => $rows['as_r'],
						"as_l"            => $rows['as_l'],
						"om_r"            => $rows['om_r'],
						"om_l"            => $rows['om_l'],
						"fundux_r"            => $rows['fundux_r'],
						"fundux_l"            => $rows['fundux_l'],
						"iop_r"            => $rows['iop_r'],
						"iop_l"            => $rows['iop_l'],
						"duct_r"            => $rows['duct_r'],
						"duct_l"            => $rows['duct_l'],
						"amblyopia_r"            => $rows['amblyopia_r'],
						"amblyopia_l"            => $rows['amblyopia_l'],
						"notes"            => $rows['notes']
				);
			}
		}
		print_r(json_encode($data));
		return json_encode($data);  
	}

	/** Function to Edit School Info **/
	function edit_school() {
		$data = json_decode(file_get_contents("php://input")); 
		$school_name             	=   $_GET['school_name'];
		$screening_date      		=   $data->screening_date;    
		$headmaster      		=   $data->headmaster;
		$address     			=   $data->address;
		$phone 	 			=   $data->phone;
		$cosponsor  			=   $data->cosponsor;
		$cosponsor_phone  		=   $data->cosponsor_phone;
		$person_in_charge  		=   $data->person_in_charge;
		$person_in_charge_phone  	=   $data->person_in_charge_phone;
		
		$qry = 'UPDATE screening_sites set screening_date = "' .$screening_date.'" , headmaster="'.$headmaster.'",address="'.$address.'",phone="'.$phone.'" , cosponsor="'.$cosponsor.'", cosponsor_phone="'.$cosponsor_phone.'", person_in_charge="'.$person_in_charge.'", person_in_charge_phone="'.$person_in_charge_phone.'" WHERE school_name="'.$schoolname;
	  
		$qry_res = mysql_query($qry);
		if ($qry_res) {
			$arr = array('msg' => "School Edited Successfully", 'error' => '');
			$jsn = json_encode($arr);
			// print_r($jsn);
		} else {
			$arr = array('msg' => "", 'error' => 'Error In Editting SChool');
			$jsn = json_encode($arr);
			// print_r($jsn);
		}
	}

	/**  Function to delete a school  **/
	function delete_school() {
		$school_name = $_GET['school_name'];  
		$del = mysql_query('DELETE FROM screening_sites WHERE school_name = "'.$school_name.'"');
		if($del)
			return true;
		return false;     
	}

	/**  Function to delete a camp  **/
	function delete_camp() {
		$camp_name = $_GET['camp_name'];  
		$del = mysql_query('DELETE FROM screening_sites WHERE camp_name = "'.$camp_name.'"');
		if($del)
			return true;
		return false;     
	}

	/**  Function to delete an anganwadi  **/
	function delete_anganwadi() {
		$anganwadi_name = $_GET['anganwadi_name'];  
		$del = mysql_query('DELETE FROM screening_sites WHERE anganwadi_name = "'.$anganwadi_name.'"');
		if($del)
			return true;
		return false;     
	}
?>
