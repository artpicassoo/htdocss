<?php require_once 'init.php'; ?>
<?php



// Bar Chart for Signup Counts
function fetchAales()
	{
	// Example query
	$db = DB::getInstance();
	$stmt = $db->query("select * from sales order by id");
	$stmt->execute();
	$stmt->bind_result($month, $amount);
	while ($stmt->fetch())
		{
		$row[] = array('month' => $month, 'amount' => $amount);
		}
	$stmt->close();
	return ($row);
	}


?>