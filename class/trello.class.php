<?php 

class TTrello {
	
	static function getObjectId($table, $id) {
		global $db;
		
		$res = $db->query("SELECT trelloid FROM ".MAIN_DB_PREFIX.$table." WHERE rowid=".$id);
		if($res === false) {
			
			$db->query("ALTER TABLE ".MAIN_DB_PREFIX.$table." ADD trelloid integer NULL ");
			$db->query("ALTER TABLE ".MAIN_DB_PREFIX.$table." ADD INDEX trelloid (trelloid) ");
		
			return self::getObjectId($table, $id);
		}
		
		if($obj = $db->fetch_object($res)) {
			
			return $obj->trelloid;
			
		}
		
		return false;
		
	}
	
	static function setObjectId($table, $id) {
		
		
		
		
	}
	
}