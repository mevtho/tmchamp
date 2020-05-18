<?php

header('Content-type: css') ;

// Colors //
$color[0]="#FFFFFF";
$color[1]="#000000";
$color[2]="#000079";
$color[3]="#0000FF";
$color[4]="#0381FF";
$color[5]="#333333";
$color[6]="#0381FF";
$color[7]="#D7EBFF";
$color[8]="#ABD5FE";
$color[9]="#0990FF";
////////////

$titlepic="images/blank banner.jpg";
$logo="images/logo.gif";

$im=getimagesize($logo);
$logowidth=$im[0];
$logoheight=$im[1];

echo <<< END

body,td,th {
    font-size: 14px;
    color: $color[2];
}

body {
    margin: 0px;
    background-color: $color[0];
}

h1 {
    width : 250px;  
    font-size : 20px;
    color : $color[2];
    border-bottom : 1px solid $color[2]; 
    margin-bottom : 15px;
    text-align : left;   
}

h2 {
    font-size : 18px;
    color : $color[2];
    text-align : left;   
}

a {
   text-decoration : none;
}

a:link {
    color: $color[2];
}
a:visited {
    color: $color[2];
}
a:active {
    color: $color[2];
}
a:hover {
   color: $color[1];
   text-decoration : underline overline;
}


.formcss {
    font-size: 14px;
}
form.formcss {
    padding-left : 200px;
}

input.formcss {
}
input[type="text"].formcss, input[type="password"].formcss {
    margin-top: 4px;
    margin-left: 20px;
    width: 200px;
    height: 18px;
    background-color: $color[0];
    color : $color[2];
    padding : 0px 0px 0px 0px;
}

input[type="submit"].formcss, a.cancel {
    background-color : $color[7];
    color : $color[2];
    border : 0px;
    padding : 1px;
    margin-top : 4px;
    margin-left : 200px;
}

input[type="submit"].formcss:hover, a.cancel:hover {
    background-color : $color[7];
    color : $color[2];
    border : 1px $color[3] solid;
    padding : 0px;
    margin-top : 4px;
    margin-left : 200px;
}

a.cancel, a.cancel:hover {
    margin-left : 10px;
    padding : 1px;
}

textarea.formcss {
    display : block;
    width : 300px;
    margin-bottom : 0px;
}
select.formcss {
    margin-top: 4px;
    margin-left : 20px;
    margin-right : 10px;
}


td.titlebar {
    background-color: $color[4];
    background-image: url("$titlepic");
    background-repeat: repeat-y;
    border-bottom: 1px solid $color[5];
    height:114px; 
    text-align:left;
    vertical-align:top ;
    font-size : 60px;
}

span.titlebar {

}

td.menubar {
    border : 0px;
    text-align:left;
    vertical-align:bottom;
    background-color:$color[6];
    border-bottom: 1px solid $color[5];
    font-size:14px; 
    color:$color[2];
    font-weight : bold;
}

ul.menubar { 
    display : inline 
}
li.menubar { 
    display : inline ;
    margin-left: 5px ;
    margin-right :5px;
}

td.foot {
    font-size : 16px;
    text-align:left;
    vertical-align:bottom;
    background-color:$color[7];
    font-size:14px; 
    color:$color[2];
    border-top : 1px solid $color[8];
}

ul.foot { 
    display : inline 
}
li.foot { 
    display : inline ;
    margin-left: 5px ;
    margin-right :5px;
}

.content {
    background-color:$color[7];
}

tr.content {
    margin-bottom:200px;
}

img {
    border:0px;
}

div.logo {
    background-image: url("$logo");
    background-repeat: no-repeat;
    width : $logowidth\px;
    height : $logoheight\px;
}


ul.listadd {
    list-style : none;
    width : 600px;
}

li.listadd {
    width : 600px;
}

p.listadd {
    padding-left : 20px;
    display : inline;
}

td.listadd {
    text-align:center;
}

a.listadd:before {
}

a.listadd:after {
}

a.listadd {
}

a.listadd:hover {
    text-decoration :underline;
}

.formcsspu {
    font-size: 12px;
}

form.formcsspu {
    padding-left : 20px;
}

input.formcsspu {
}

input[type="text"].formcsspu, input[type="password"].formcsspu {
    margin-top: 4px;
    margin-left: 20px;
    width: 200px;
    height: 18px;
    background-color: $color[0];
    color : $color[2];
    padding : 0px 0px 0px 0px;
}

input[type="submit"].formcsspu {
    background-color : $color[7];
    color : $color[2];
    border : 0px;
    padding : 1px;
    margin-top : 4px;
    margin-left : 200px;
}
input[type="submit"].formcsspu:hover {
    background-color : $color[7];
    color : $color[2];
    border : 1px $color[3] solid;
    padding : 0px;
    margin-top : 4px;
    margin-left : 200px;
}

textarea.formcsspu {
    display : block;
    width : 300px;
    margin-bottom : 0px;
}
select.formcsspu {
    margin-top: 4px;
    margin-left : 20px;
    margin-right : 10px;
}

table.dispedit {
    margin-left : 30px;
    width : 600px;
}

td.dispedit {
    width : 560px;
}

tr.dispedit {
  
}

td.dispeditfct {
    width : 20px;
}

span.dispedit {
    width : 500px;
    text-align : center;
    font-weight : bold;
    padding-left : 20px;
}

table.teamresult {
    border : 0px;
    padding : 0px;
    margin : 0px;
    width : 600px;    
    vertical-align : top;
    background-color : $color[8];
}

div.teamresult:hover {
    background-color : $color[7];
}

td.teamresult {
    width : 150px;
    border : 0px;
}

td#results {
    margin : 0px;
    background-color : $color[7];
    padding-left : 10px;
}

tr.teamresult {
    margin : 0px;
    vertical-align : top;
}


table.score {
    border : 0px;
    width : 100%;
}

td.scoreA {
    width:10%;
    padding : 0px;
    text-align : center;
}

td.scoreB {
    width:38%;
    padding : 0px;
    padding-left : 20px;
    text-align : left;
}

td.scoreC {
    width:38%;
    padding : 0px;
    padding-left : 20px;
    text-align : left;
}

td.scoreD {
    width:8%;
    text-align : center;
    padding : 0px;
}

tr:hover.selRow {
    background-color:$color[4];
    color:$color[0];
}

td:hover.selRow {
    background-color:$color[7];
    color:$color[9];
}

END;

?>
