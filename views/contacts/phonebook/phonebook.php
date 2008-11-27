
<p><a href="../contacts/addcontact"  ><img align="right"  width="50" border="0" src="../views/images/contactadd.jpg" /></a></p>
<p><center>{{searchForm}}</center></p>

<form method="post" action="../contacts/action" onsubmit="return DoClick()">
<table>
	{{tableHeader}}
	{{rows}}
	<br /><br />
</table>
<center>Action to do with selection: 
	<select id="action" name="action"  onchange="ShowExtraOption()">
		<option>Share</option>
		<option>Delete</option>
		<option>Group</option>
	</select>
	<div id="extra-option"></div>
	
<input  value="Do" type="submit" />
<p>Pages : 
	{{pages}}
</p>

{{letters}}
</center>
<script type="text/javascript">
function DoClick()
{
	
	document.
	if(document.getElementById("action").value == "Delete")
	{
		var cResult = confirm("Do you really want to delete selected contacts?");
		return cResult;
	}
	
	
}

function ShowExtraOption()
{
	select = document.getElementById("action");
	extraSelect = document.getElementById("extra-option");
	
	if (select.options[select.selectedIndex].value == "Group")
	{
		
		extraSelect.innerHTML = "add to group <select name=\"group\">{{groupsOptions}}</select>";
	}
	else 
		{
			
			extraSelect .innerHTML = "";
		}
}


</script>
</form>
