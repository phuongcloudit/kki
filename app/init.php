<?php
	foreach (glob(dirname( __FILE__ ) . "/../config/*.php") as $filename){
	    require_once $filename;
	}
	require_once dirname( __FILE__ ) . '/helpers.php';