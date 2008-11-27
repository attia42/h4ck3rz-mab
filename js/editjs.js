
	var errs = new Array();
	errs[0]= new Array("firstName",false);
	errs[1]= new Array("lastName",false);
	errs[2]= new Array("homePhone",false);
	errs[3]= new Array("mobilePhone",false);
	errs[4]= new Array("workPhone",false);
	errs[5]= new Array("website",false);
	errs[6]= new Array("msn",false);
	errs[7]= new Array("yahoo",false);
	errs[7]= new Array("gmail",false);
	errs[8]= new Array("aol",false);
	errs[9]= new Array("facebook",false);
	errs[10]= new Array("myspace",false);
	errs[11]= new Array("photo",false);	
	passError = true;

	function Validate (valType, field)
	{
		var flag;
		for(var j in errs)
		{
			if(errs[j][0]==field)
			{	
				flag =j;
				break;
			}
		}
		
		if(valType=="num")
		{
			if(isInteger(document.getElementById(field).value)||document.getElementById(field).value == "")
				errs[flag][1]=false;
			else
				errs[flag][1]=true;
		}
		else if(valType=="email")
		{
			if(isValidEmail(document.getElementById(field).value)||document.getElementById(field).value == "")
				errs[flag][1]=false;
			else
				errs[flag][1]=true;
		}
		
		else if(valType=="url")
		{
			if(isValidURL(document.getElementById(field).value)||document.getElementById(field).value == "")
				errs[flag][1]=false;
			else
				errs[flag][1]=true;
		}
		
		else if(valType=="empty")
		{
			if(document.getElementById(field).value == "")
				errs[flag][1]=true;
			else
				errs[flag][1]=false;
		}



	}
	function validateOnSubmit()
	{
		var allErrs = false;
		for(var i in errs)
		{
			if(errs[i][1]==true)
			{
				
				allErrs = true;
				break;
			}
		}
		if(allErrs)
		{
		    alert("Error(s) found in input, Please check them again.");
		    return false;
		}
	    return true;
	}
	
	    
    function isInteger ( s ) {
if (s == "") return false;
for (i = 0 ; i < s.length ; i++) {
if ((s.charAt(i) < '0') || (s.charAt(i) > '9')) return false
}
return true;
}

function isValidURL(url){
    var RegExp = /^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/;
    if(RegExp.test(url)){
        return true;
    }else{
        return false;
    }
}

function isValidEmail(email){
    var RegExp = /^((([a-z]|[0-9]|!|#|$|%|&|'|\*|\+|\-|\/|=|\?|\^|_|`|\{|\||\}|~)+(\.([a-z]|[0-9]|!|#|$|%|&|'|\*|\+|\-|\/|=|\?|\^|_|`|\{|\||\}|~)+)*)@((((([a-z]|[0-9])([a-z]|[0-9]|\-){0,61}([a-z]|[0-9])\.))*([a-z]|[0-9])([a-z]|[0-9]|\-){0,61}([a-z]|[0-9])\.)[\w]{2,4}|(((([0-9]){1,3}\.){3}([0-9]){1,3}))|(\[((([0-9]){1,3}\.){3}([0-9]){1,3})\])))$/
    if(RegExp.test(email)){
        return true;
    }else{
        return false;
    }
}