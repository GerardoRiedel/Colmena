<?php

//function getConnection() {

//		$dbhost="www.cetep.cl";

//		$dbuser="cetepcl";

//                $dbpass="rootsecurity626";

//		$dbname="cetepcl_agendarest";

//		$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

//		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//		$dbh->exec("set names utf8");

//		return $dbh;

//	}

        

        function getConnection() {

		$dbhost="www.cetep.cl";

		$dbuser="cetepcl";

                $dbpass="rootsecurity626";

		$dbname="cetepcl_agenda";

		$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$dbh->exec("set names utf8");

		return $dbh;

	}

        

?>