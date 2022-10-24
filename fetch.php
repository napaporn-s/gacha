<?php

//fetch.php

$api_url = "http://localhost/gacha/user_api.php?action=fetch_all";

$client = curl_init($api_url);

curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($client);

$result = json_decode($response);

$output = "";

if(empty($result) > 0)
{
	$output .= "<tr>";
	$output .= "<td colspan=\"7\" align=\"center\">No Data Found</td>";
	$output .= "</tr>";
}
else
{
	
	foreach($result as $row)
	{
		$output .= "<tr>";
		$output .= "<td>".base64_decode($row->username)."</td>";
		$output .= "<td>".base64_decode($row->name)."</td>";
		$output .= "<td>".base64_decode($row->surname)."</td>";
		$output .= "<td>".base64_decode($row->email)."</td>";
		$output .= "<td><button type=\"button\" name=\"edit\" class=\"btn btn-warning btn-xs edit\" id=\"".$row->id."\">Edit</button></td>";
		$output .= "<td><button type=\"button\" name=\"delete\" class=\"btn btn-danger btn-xs delete\" id=\"".$row->id."\">Delete</button></td>";
		$output .= "</tr>";

		
	}
}

echo $output;

?>