function displayTab(tab_id) {
    var tabs = document.getElementsByClassName('tab' );
    var tab_links = document.getElementsByClassName('tab-link' );
    for(var i=0; i< tabs.length; i++){
        if( tabs[i].dataset.tab_id == tab_id ) {
            tabs[i].style.display = "block";
            tab_links[i].className = "tab-links-active tab-link";
        } else {
            tabs[i].style.display = "none";
            tab_links[i].className = "tab-link";
        }
    }
}

function validateCustomerData() {
    var id_number = document.getElementById('id_number').value;
    var level_id = parseInt(document.getElementById('level_id').value);
    var suit_size_id = parseInt( document.getElementById('suit_size_id').value );

    if( id_number.length !== 9){
        alert('נא להזין ת.ז בעלת 9 ספרות');
        return false;
    }

    if( level_id === 0 ) {
        alert('נא לבחור את רמת הגלישה');
        return false;
    }

    if( suit_size_id === 0 ) {
        alert('נא לבחור את מידת חליפת הגלישה');
        return false;
    }
	return true;
}

function validateNewScheduleData() {
    var course_id =  parseInt(document.getElementById('course_id').value);
    var start_at = parseInt(document.getElementById('start_at').value );

    if( course_id === 0  ) {
        alert('נא לבחור את סוג הפעילות');
        return false;
    }

    if( start_at === 0  ) {
        alert(' נא לבחור שעה');
        return false;
    }
    return true;
}
function getNameSuggestions() {
    var name = document.getElementById('name').value;
    if( name.length > 0 ) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById('suggestion-list').innerHTML = this.responseText;
            }
        };
        // open request
        xhttp.open("GET", "ajax_get_name_suggestion.php?str=" + name, true);	// Clean the table from this talk
        //send the request
        xhttp.send();
    }
}

function setNameValue(id) {
    var value = document.getElementById('name_id_'+id).innerText;
    document.getElementById('name').value = value;
    document.getElementById('suggestion-list').innerHTML = "";
}

