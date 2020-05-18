<?php

header('Content-type: css') ;

// Colors //
$color[0]="#FFFFFF";
$color[1]="#000000";
////////////

echo <<< END


body,td,th {
    font-size: 14px;
    color: $color[1];
}

body {
    margin: 5px;
    padding-left: 15px;
    padding-right: 15px;
    background-color: $color[0];
}

table {
    padding : 2px;
}

table.game {
    width : 80%;
    border : 1px solid $color[1];
}

td {
    align:left;
}

h1 {
    width : 200px;  
    font-size : 20px;
    border-bottom : 1px solid $color[1]; 
    margin-bottom : 15px;
    text-align : left;   
}

h2 {
    font-size : 18px;
    color : $color[1];
    text-align : left;   
}

h3 {
    width : 100%;	
    text-align:center;	
    font-size : 60px;
    color : $color[1];
}



a {
   text-decoration : none;
}

a:link {
    color: $color[1];
}
a:visited {
    color: $color[1];
}
a:active {
    color: $color[1];
}
a:hover {
    color: $color[1];
}

ul.foot { 
    display : none; 
}

.content {
}

td {
    border : 0px solid $color[1];
    margin : 0px;
    text-align : left;
}

table.teamresult {
    border : 0px;
    padding : 0px;
    margin : 0px;
    width : 600px;    
    vertical-align : top;
    background-color : $color[0];
}

div.teamresult:hover {
    background-color : $color[0];
}

td.teamresult {
    width : 150px;
    border : 0px;
}

td#results {
    margin : 0px;
    background-color : $color[0];
    padding-left : 10px;
}

tr.teamresult {
    margin : 0px;
    vertical-align : top;
}


table.score {
    border : 1px;
    width : 100%;
}

td.scoreA {
    width:15%;
    padding : 0px;
    text-align : center;
}

td.scoreB {
    width:35%;
    padding : 0px;
    text-align : left;
}

td.scoreC {
    width:35%;
    padding : 0px;
    text-align : left;
}

td.scoreD {
    width:15%;
    padding : 0px;
    text-align : center;
}

td.lieu {
    border-bottom:1px solid $color[1];
}

END;

?>
