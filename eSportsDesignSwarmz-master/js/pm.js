
function replyToPm(pmid,user,ta,btn,osender){
    var data = _(ta).value;
    if(data == ""){
    alert("Type something first");
    return false;
    }
    _(btn).disabled = true;
    var ajax = ajaxObj("POST", "php_includes/pm_system.php");
    ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {
    var datArray = ajax.responseText.split("|");
    if(datArray[0] == "reply_ok"){
    var rid = datArray[1];
    data = data.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\n/g,"<br />").replace(/\r/g,"<br />");
    _("pm_"+pmid).innerHTML += '<p><b>Your Reply:</b><br />'+data+'</p>';
    expand("pm_"+pmid);
    _(btn).disabled = false;
    _(ta).value = "";
    } else {
    alert(ajax.responseText);
    }
    }
    }
    ajax.send("action=pm_reply&pmid="+pmid+"&user="+user+"&data="+data+"&osender="+osender);
    }
function deletePm(pmid,wrapperid,originator){
    var conf = confirm(originator+"Press OK to confirm deletion of this message and its replies");
    if(conf != true){
    return false;
    }
    var ajax = ajaxObj("POST", "php_includes/pm_system.php");
    ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {
    if(ajax.responseText == "delete_ok"){
    _(wrapperid).style.display = 'none';
    } else {
    alert(ajax.responseText);
    }
    }
    }
    ajax.send("action=delete_pm&pmid="+pmid+"&originator="+originator);
    window.location.reload();
    }
function markRead(pmid,originator){
    var ajax = ajaxObj("POST", "php_includes/pm_system.php");
    ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {
    if(ajax.responseText == "read_ok"){
    alert("Message has been marked as read");
    } else {
    alert(ajax.responseText);
    }
    }
    }
    ajax.send("action=mark_as_read&pmid="+pmid+"&originator="+originator);
    window.location.reload();
    }
