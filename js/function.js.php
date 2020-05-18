function popup(item,act) {
    window.open('index.php?EX='+item+'&DO='+act+'&p=1',<?php echo getdate(); ?>, config='height=300, width=400, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
}

function printPopUp(item,act,po) {
    window.open('index.php?EX='+item+'&DO='+act+'&p=1&i=1'+po,<?php echo getdate(); ?>, config='height=600, width=800,toolbar=no, menubar=yes, scrollbars=no, resizable=yes, location=no, directories=no, status=no');
}

function sendData(param, page, div) { 
    if(document.all) {
        //Internet Explorer 
        var XhrObj = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else { 
        //Autres navigateurs 
        var XhrObj = new XMLHttpRequest();
    }
    var content = document.getElementById(div);
    XhrObj.open("POST", page);
    XhrObj.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    XhrObj.send(param);
    XhrObj.onreadystatechange = function() { 
                                    if (XhrObj.readyState == 4 && XhrObj.status == 200)
                                        content.innerHTML = XhrObj.responseText ;
                                }
}

function sendDataInput(param, page, input) { 
    if(document.all) {
        //Internet Explorer 
        var XhrObj = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else { 
        //Autres navigateurs 
        var XhrObj = new XMLHttpRequest();
    }
    var content = document.getElementById(input);
    XhrObj.open("POST", page);
    XhrObj.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    XhrObj.send(param);
    XhrObj.onreadystatechange = function() { 
                                    if (XhrObj.readyState == 4 && XhrObj.status == 200)
                                        content.value = XhrObj.responseText ;
                                }
}


