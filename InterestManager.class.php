<?php
class InterestManager {
	
	private $connection;
	private $user_id;
	
	function __construct($mysqli, $user_id) {
		$this->connection = $mysqli;
		$this->user_id = $user_id;
		
	}
	
	function addInterest($int_name) {
		
		$response = new StdClass();
		
		//Kontrollid, et sellist veel ei ole?
		$stmt = $this->connection->prepare("SELECT id FROM interests WHERE name = ?");
        $stmt->bind_param("s", $int_name);
        $stmt->bind_result($id);
        $stmt->execute();
		
		if($stmt->fetch()){
            $error = new StdClass();
            $error->id = 0;
            $error->message = "Selline huvi on juba olemas";
            $response->error = $error;
            return $response;
        }
		$stmt->close();
		
        $stmt = $this->connection->prepare("INSERT INTO interests (name) VALUES (?)");
        $stmt->bind_param("s", $int_name);
        if($stmt->execute()){
			
            $success = new StdClass();
            $success->message = "Huvi edukalt loodud";
            
            $response->success = $success;
			
            
        }else{
            $error = new StdClass();
            $error->id = 1;
            $error->message = "Midagi läks katki";
            
            $response->error = $error;
        }
		
		return $response;
		
		$stmt->close();
		
		

	}
	
	function createDropdown() {
		
		$html = '';
		//Liidan eelmisele juurde
		$html .= '<select name="dropdown_interest">';
		
		$stmt = $this->connection->prepare("SELECT id, name FROM interests");
		$stmt->bind_result($id, $name);
		$stmt->execute();
		//Iga rea kohta
		while($stmt->fetch()) {
			
			$html .= '<option>'.$name.'</option>';
			
		}
		
		$stmt->close();
		#$html .= '<option>Test 1</option>';
		#$html .= '<option selected>Test 2</option>';
		
		$html .= '</select>';
		
		return $html;
		
	}
	
	
	
	
	
	
}
?>