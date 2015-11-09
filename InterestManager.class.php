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
		#$stmt = $this->connection->prepare("SELECT interests.id, interests.name, user_interests.id FROM interests, user_interests WHERE user.interests.user_id != ? AND user_interests.interests_id != interests.id");
		$stmt->bind_result($id, $name);
		$stmt->execute();
		//Iga rea kohta
		while($stmt->fetch()) {
			
			$html .= '<option value="'.$id.'">'.$name.'</option>';
			
		}
		
		$stmt->close();
		#$html .= '<option>Test 1</option>';
		#$html .= '<option selected>Test 2</option>';
		
		$html .= '</select>';
		
		return $html;
		
	}
	
	function addUserInterests($user_id, $int_id) {
		
		$response = new StdClass();
		
		//Kontrollid, et sellist veel ei ole?
		$stmt = $this->connection->prepare("SELECT interests_id FROM user_interests WHERE interests_id = ?");
        $stmt->bind_param("i", $int_id);
        $stmt->bind_result($interests_id);
        $stmt->execute();
		
		if($stmt->fetch()){
            $error = new StdClass();
            $error->id = 0;
            $error->message = "Selline huvi on sul juba olemas";
            $response->error = $error;
            return $response;
        }
		$stmt->close();
		
        $stmt = $this->connection->prepare("INSERT INTO user_interests (user_id, interests_id) VALUES (?,?)");
        $stmt->bind_param("ss", $user_id, $int_id);
        if($stmt->execute()){
			
            $success = new StdClass();
            $success->message = "Huvi edukalt salvestatud";
            
            $response->success = $success;
			
            return "abs";
        }else{
            $error = new StdClass();
            $error->id = 1;
            $error->message = "Midagi läks katki";
            
            $response->error = $error;
        }
		
		
		
		$stmt->close();
		
		
		
		
		
	}
	
	function getUserInterests() {
		
		//Saada katte ja saata tagasi koik kasutaja huvialad
		//Kasutaja id $this->user_id;
		//Koik tema huvalade nimed!
		$stmt = $this->connection->prepare("SELECT interests.name FROM user_interests INNER JOIN interests on user_interests.interests_id = interests.id WHERE user_interests.user_id = ?");
		$stmt->bind_param("i", $this->user_id);
		$stmt->bind_result($name);
		$stmt->execute();
		
		while($stmt->fetch()) {
			echo $name."<br>";
			
		}
		
	}
	
}
?>