//dob validation
function fnValidateDOB(val)
{ 
   if(val != "")
   {
	   var day = 12;
		var month = 12;
		var year = 1996;
		var dateAr = val.split('-');
		var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0];
		var someDate = new Date(newDate);
		//					alert(someDate);
		var age = 18;
		var mydate = new Date();
		//mydate.setFullYear(year, month-1, day);
		mydate.setFullYear(dateAr[2], dateAr[1]-1, dateAr[0]);
	
		var currdate = new Date();
	    var setDate = new Date();        
	   //setDate.setFullYear(mydate.getFullYear() + age, month-1, day);
	   currdate.setFullYear(currdate.getFullYear() - age);
		if (currdate < mydate)
		{
		// you are above 18
			alert("Age should be 18 or above");
			val.focus(); 
			return false;
		}
		else
		{
			return true;
		}
   }
}