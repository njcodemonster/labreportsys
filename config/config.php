<?php session_start();
define('SITE_NAME', '7c Report');

class db_connection{

			/** database name */
			protected $_db_name = "7c_report";    // local
//                        protected $_db_name = "jeftest_~";   //live
			/** username */
			protected $_db_user = "root";         // local
//                        protected $_db_user = "jeftest_labrepo";        //live
			/** password */
			protected $_db_password = "";         // local
//                        protected $_db_password = "ZLbXCTu2IzRFZimB";   //live
			/** host */
			protected $_host = "localhost";

			/** Basepath */
			//const BASEPATH = ''; //"http://ecofuel.ie/"; //http://5.10.105.46/~ecofueli/";

			/** Alert Messages */
			const RECORD_ADDED = "Record has been added successfully";
			const RECORD_MULTIPLE_ADDED = "Records have been added successfully";
			const RECORD_UPDATED = "Record has been updated successfully";
			const RECORD_DELETED = "Record has been deleted successfully";
			const RECORD_ERROR = "An error occurred, please try again later";
			const RECORD_SAME = "No Changes have Been Made";
		}

	?>