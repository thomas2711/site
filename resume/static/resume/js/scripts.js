function toggle_courses() {
	var x = document.getElementById('courses');
	var y = document.getElementById('showhide');
	if (x.style.display === 'none') {
		x.style.display = 'inline';
		y.innerText = "Hide Courses";
	}
	else {
		x.style.display = 'none';
		y.innerText = "Show Courses";
	}
}

function toggle_contact() {
	var x = document.getElementById('contact_form');
	var y = document.getElementById('showhidec');
	if (x.style.display === 'none') {
		x.style.display = 'inline';
		y.style.display = 'none';
	}
}