const _set_user = getCookie('username');
if (_set_user != null) { 
   $.get('./inc/online.inc.php?user='+_set_user, function(data) {
    });  
}