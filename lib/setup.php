<?php
		$conf = array(
			'username' => 'root',
			'password' => 'dharma12345'
			);
		    $new = new PDO('mysql:host=localhost;dbname=jubile',$conf['username'],$conf['password']);
		    $stmt = $new->prepare("SELECT month,data,scadere FROM data");
		    $stmt->execute(array());
		    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    
		    for($i=0;$i<count($rows);$i++) {
		    	//array_push are acelasi efect
		    	$month[] = $rows[$i]['month'];
		    	$data[] = $rows[$i]['data'];
		    	$scadere[] = $rows[$i]['scadere'];
		    }

		    $month = json_encode($month);
		    $data = json_encode($data);
		    $data = preg_replace('/"/', '', $data);
			$scadere = json_encode($scadere);
			
?>
