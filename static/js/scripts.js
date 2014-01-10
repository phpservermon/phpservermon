function sm_delete(id, type) {
    var del = confirm("Are you sure you want to delete this record?");
    if (del == true) {
        var loc = 'index.php?delete=' + id + '&type=' + type;
        window.location = loc;
    }
}

function trim(str) {
    return str.replace(/^\s+|\s+$/g,"");
}
 
//left trim
function ltrim(str) {
	return str.replace(/^\s+/,"");
}

//right trim
function rtrim(str) {
	return str.replace(/\s+$/,"");
} 