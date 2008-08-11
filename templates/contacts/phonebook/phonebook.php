<table border="1" style =" border : 2px dashed;">
	<tr>
		<th>Contact name</th>
		<th>City</th>
		<th>Home phone</th>
		<th>E-Mail</th>
	</tr>
	<?php
		foreach($contacts as $contact)
		{
			echo "<tr>
							<td>{$contact['firstName']}</td>
							<td>{$contact['homeAddress']}</td>
							<td>{$contact['homePhone']}</td>
							<td>{$contact['eMail']}</td>
						</tr>";
		}	
		
	?>
	<br /><br />
</table>
<p>Pages : 
	<?php
	for($i=1 ; $i <$pagesNum ;$i++)
	{
		if($thisPagenum == $i)
		{
			echo " ".$i . " ";
		}
		else
		{
			echo "<a href=\"{$site_path}contacts/phonebook?page={$i}\"> {$i}</a>";
		}
			
	}
	?>
</p>