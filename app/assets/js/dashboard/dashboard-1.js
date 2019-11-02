(function($) {
    "use strict"
	
	getCatCount();
	getInvCount();
})(jQuery);


function getCatCount(){
	
	var c = document.getElementById("categoryCount");
	var xhr = new XMLHttpRequest();
	var url = '../php/json/dashboard/category_count.php';
	xhr.open('GET',url, true);
	xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && xhr.status == 200) {
			var s = JSON.parse(xhr.responseText);
			c.innerHTML = '<h2 class="text-white">'+ s.count +'</h2><p class="text-white mb-0"></p>';
		}
	};
	xhr.send();
	
}

function getInvCount(){
	
	var i = document.getElementById("inventoryCount");
	var xhr = new XMLHttpRequest();
	var url = '../php/json/dashboard/inventory_count.php';
	xhr.open('GET',url, true);
	xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && xhr.status == 200) {
			var s = JSON.parse(xhr.responseText);
			i.innerHTML = '<h2 class="text-white">'+ s.count +'</h2><p class="text-white mb-0"></p>';
		}
	};
	xhr.send();
	
}