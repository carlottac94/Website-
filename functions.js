function check_fields(){
user=document.getElementById("user").value;
pass=document.getElementById("pass").value;
str1=/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
str2=/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/;

if ((user == "") || (user == "undefined")) {
	document.getElementById("par").innerHTML="Il campo email è obbligatorio\n";
	}
else if ((pass == "") || (pass == "undefined")) {
	document.getElementById("par").innerHTML="Il campo password è obbligatorio\n";
}

else if(!(str1.test(user))){
document.getElementById("par").innerHTML="Attenzione: L'email fornita non è valida\n";
}

else if(!(str2.test(pass))){
document.getElementById("par").innerHTML="Attenzione: Password errata\n";
}

else{
	document.getElementById("log").submit();
}
return;
}

function verify_fields(){
name=document.getElementById("name").value;
surname=document.getElementById("surname").value;
user=document.getElementById("user").value;
pass=document.getElementById("pass").value;
str1=/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
str2=/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])([a-zA-Z0-9]+)$/;
str3=/^([a-zA-Z]+)$/;

if ((name == "") || (name == "undefined")) {
	document.getElementById("par2").innerHTML="Il campo nome è obbligatorio\n";
	}
	
else if(!(str3.test(name))){
	document.getElementById("par2").innerHTML="Il campo nome deve contenere solo lettere\n";
}

else if ((surname == "") || (surname == "undefined")) {
	document.getElementById("par2").innerHTML="Il campo cognome è obbligatorio\n";
}

else if(!(str3.test(surname))){
	document.getElementById("par2").innerHTML="Il campo cognome deve contenere solo lettere\n";
}

else if ((user == "") || (user == "undefined")) {
	document.getElementById("par2").innerHTML="Il campo email è obbligatorio\n";
	}
else if ((pass == "") || (pass == "undefined")) {
	document.getElementById("par2").innerHTML="Il campo password è obbligatorio\n";
}

else if(!(str1.test(user))){
document.getElementById("par2").innerHTML="Attenzione: L'email fornita non è valida\n";
}

else if(!(str2.test(pass))){
document.getElementById("par2").innerHTML="Attenzione: Password errata\n";
}

else{
	document.getElementById("reg").submit();
}
return;
}

function check_inputs(){
t=document.getElementById("durata").value;
rex=/^\d+$/;

if(!(rex.test(t))){
	document.getElementById("par3").innerHTML="Attenzione: il campo inserito deve essere un numero intero\n";
}
  

else{

	document.getElementById("num").submit();
}
  
return;
}
	
