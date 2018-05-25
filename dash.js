var tablerows = 0;
function log_out(){
	window.location.href = 'logout.php';
}

function process_dash_form(){
	var dashForm = document.getElementsByTagName("form")[0];
	if(dashForm.checkValidity()){
		ajaxDashFormCheck();
	}
}

function ajaxDashFormCheck(){
	var xhr = new XMLHttpRequest();
	var item = document.getElementsByClassName("dashinput")[0].value;
	var dlink = document.getElementsByClassName("dashinput")[1].value;
	var price = document.getElementById("price").value;
	if(dlink.length > 0){
		//check to make sure link is valid, and build a valid URL otherwise
		if(dlink.substr(dlink.length-1, dlink.lenth) != "/"){
			dlink += "/";
		}
		if(dlink.substr(0,7)!="http://" && dlink.substr(0,8)!="https://"){
			dlink = "http://" + dlink;
		}
	}
	var query_string = "item=" + item + "&link=" + dlink + "&price=" + price;
	xhr.onreadystatechange = function () {
		if (xhr.readyState == 4 && xhr.status == 200) {
			var result = xhr.responseText;
			drawDash(result, item, dlink, price);	
		}
	}	
	xhr.open("GET", "updatelist.php?" + query_string, true);
	xhr.send(null);
}

function drawDash(result, item, dlink, price){
	if(result == "true"){
		//see if table exists, and count number of rows
		if(document.getElementsByTagName("table") != null){
			var dtable = document.getElementsByTagName("table")[0];
			tablerows = document.getElementsByTagName("tr").length;
		}
		
		//if there is no table, create table and the first row and add it to dashtable as a childnode
		else{
			var dtable = document.createElement("TABLE");
			var frow = dtable.insertRow(tablerows);
			var th1 = document.createElement("TH");
			var th2 = document.createElement("TH");
			th1.innerHTML = "Item";
			th2.innerHTML = "Cost"
			frow.appendChild(th1);
			frow.appendChild(th2);
			tablerows = 1;
		}
		// Create an empty <tr> element and add it to the table:
		var row = dtable.insertRow(tablerows);

		// Insert new <td> elements to the new <tr> element
		var td1 = row.insertCell(0);
		var td2 = row.insertCell(1);
		var td3 = row.insertCell(2);
		
		td1.className = "titem";
		td2.className = "tprice";
		
		//replace any tags "<" or ">" by their html equivalent using a regular expression
		//the regular expression is of the form: /pattern/flags where in this case, the flag "g" (global) means to find all instances
		item = item.replace(/</g, "&lt;");
		item = item.replace(/>/g, "&gt;");
		
		//create a valid absolute link, if user submitted a link
		if(dlink.length > 0){
			//create anchor
			var a = document.createElement("A");
			a.text = item;
			if(!dlink.includes("http")){
				dlink = "http://" + dlink;
			}
			a.href = dlink;
			a.target = "_blank";
			td1.appendChild(a);
		}
		else{
			td1.innerHTML = item;
		}
		
		//create erase button
		//add event listener
		var erasebutton = document.createElement("INPUT");
		erasebutton.type = "button";
		erasebutton.className = "del";
		erasebutton.value = "Delete";
		erasebutton.addEventListener("click", function(objref){
			return function(){
				ajaxDel(objref);
				var parentRow = objref.parentNode.parentNode;
				var theTable = parentRow.parentNode;
				theTable.removeChild(parentRow);
			};
		}(erasebutton));
		
		if(!price){
			price = 0;
		}
		
		//add elements to the cells:
		td2.innerHTML = "$" + price;
		td3.appendChild(erasebutton);
		
		//clear input area
		document.getElementsByTagName("form")[0].reset();
	}
}

//to run once body finishes loading
function addListeners(){
	addDelListeners();
}

function addDelListeners(){
	var delArray = document.getElementsByClassName("del");
	//closures
	for(var i = 0; i < delArray.length; i++){
		delArray[i].addEventListener("click", function(objref){
			return function(){
				ajaxDel(objref);
				//delete row once it's deleted from database. prevents this listener from ever firing again.
				var parentRow = objref.parentNode.parentNode;
				var theTable = parentRow.parentNode;
				theTable.removeChild(parentRow);
			};
		}(delArray[i]));
	}
}

function ajaxDel(objref){
	var xhr = new XMLHttpRequest();
	var parentRow = objref.parentNode.parentNode;
	var item = "";
	var rlink = "";
	//if anchor found, use anchor to query database. this allows same item names, but different links
	if(parentRow.getElementsByTagName("a")[0]){
		rlink = parentRow.getElementsByTagName("a")[0].href;
	}
	else{
		item = parentRow.getElementsByClassName("titem")[0].innerHTML;
	}
	var query_string = "item=" + item + "&link=" + rlink;
	xhr.onreadystatechange = function () {
		if (xhr.readyState == 4 && xhr.status == 200) {
			var result = xhr.responseText;
		}
	}	
	xhr.open("GET", "delete.php?" + query_string, true);
	xhr.send(null);
}
