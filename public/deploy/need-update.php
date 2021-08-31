<?php

if(file_exists("need_update.txt")){
	echo "true";
	unlink("need_update.txt");
}else{
	echo "false";
}