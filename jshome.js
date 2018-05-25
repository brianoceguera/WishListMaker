var regForm;
var logForm;

function formvalid(){
	var logusr = document.getElementsByClassName("usr")[0];
	var regusr = document.getElementsByClassName("usr")[1];
	var logpw = document.getElementsByClassName("pw")[0];
	var regpw = document.getElementsByClassName("pw")[1];
	
	var logusrerror = document.getElementById("logusr")
	var logpwerror = document.getElementById("logpw");
	var regusrerror = document.getElementById("regusr");
	var regpwerror = document.getElementById("regpw");
	
	var regfname = document.getElementById("fname");
	var reglname = document.getElementById("lname");
	var regfnerror = document.getElementById("regfn");
	var reglnerror = document.getElementById("regln");
	logForm = document.getElementsByTagName("form")[0];
	regForm = document.getElementsByTagName("form")[1];

	logusr.addEventListener("change", function (event){
		if(!logusr.validity.valid){
			logusrerror.style.display = "block";
		}
		else{
			logusrerror.style.display = "none";
		}
	}, true);
	
	regusr.addEventListener("change", function (event){
		if(!regusr.validity.valid){
			regusrerror.style.display = "block";
		}
		else{
			regusrerror.style.display = "none";
			ajaxUserReg("username=" + regusr.value);
		}
	}, true);
	
	logpw.addEventListener("change", function (event){
		if(!logpw.validity.valid){
			logpwerror.style.display = "block";
		}
		else{
			logpwerror.style.display = "none";
		}
	}, true);
	
	regpw.addEventListener("change", function (event){
		if(!regpw.validity.valid){
			regpwerror.style.display = "block";
		}
		else{
			regpwerror.style.display = "none";
		}
	}, true);
	
	regfname.addEventListener("change", function (event){
		if(!regfname.validity.valid){
			regfnerror.style.display = "block";
		}
		else{
			regfnerror.style.display = "none";
		}
	}, true);
	
	reglname.addEventListener("change", function (event){
		if(!reglname.validity.valid){
			reglnerror.style.display = "block";
		}
		else{
			reglnerror.style.display = "none";
		}
	}, true);
	
}

//functions to check if an entered username is valid
function ajaxUserReg(query_string){
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function () {
		if (xhr.readyState == 4 && xhr.status == 200) {
			var result = xhr.responseText;
			display_result(result);	
		}
	}	
	xhr.open("GET", "checkusr.php?" + query_string, true);
	xhr.send(null);
}

function display_result(res){
	if(res == "false"){
		document.getElementById("usrtaken").style.display = "block";
	}
	else{
		document.getElementById("usrtaken").style.display = "none";
	}
}

//functions for new user registration
function process_reg_form(){
	if(regForm.checkValidity()){
		ajaxRegFormCheck();
	}
}

//send reg data via post
function ajaxRegFormCheck(){
	var xhr = new XMLHttpRequest();
	var fn = document.getElementById("fname").value;
	var ln = document.getElementById("lname").value;
	var user = document.getElementsByClassName("usr")[1].value;
	var pw = document.getElementsByClassName("pw")[1].value;
	
	var data = "firstname=" + fn + "&lastname=" + ln + "&username=" + user + "&password=" + pw;
	xhr.onreadystatechange = function () {
		if (xhr.readyState == 4 && xhr.status == 200) {
			var result = xhr.responseText;
			display_reg(result);	
		}
	}
	
	xhr.open("POST", "registration.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(data);
}

//display registration success or error depending on response
function display_reg(result){
	if(result == "true"){
		document.getElementById("success").style.display = "block";
		document.getElementById("fail").style.display = "none";
	}
	
	else{
		document.getElementById("success").style.display = "none";
		document.getElementById("fail").style.display = "block";		
	}
}

//functions to handle login information
function process_log_form(){
	if(logForm.checkValidity()){
		ajaxLogFormCheck();
	}
}

function ajaxLogFormCheck(){
	var xhr = new XMLHttpRequest();
	var user = document.getElementsByClassName("usr")[0].value;
	var pw = document.getElementsByClassName("pw")[0].value;
	
	var data = "username=" + user + "&password=" + pw;
	xhr.onreadystatechange = function () {
		if (xhr.readyState == 4 && xhr.status == 200) {
			var result = xhr.responseText;
			display_log(result);	
		}
	}
	
	xhr.open("POST", "login.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(data);
}

//display the login error, or redirect to user's homepage
function display_log(result){
	if(result == "false"){
		document.getElementById("logfail").style.display = "block";
	}
	
	else{
		document.getElementById("logfail").style.display = "none";
		window.location.href = 'dashboard.php';
	}
}
