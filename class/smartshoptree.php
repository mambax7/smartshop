<?php
class SmartshopTree extends XoopsTree
{

 function makeMySelBox($title,$order="",$preset_id=0, $none=0, $sel_name="", $onchange="", $forSearch, $grantedCats)
	{
		if ( $sel_name == "" ) {
			$sel_name = $this->id;
		}
		$myts =& MyTextSanitizer::getInstance();
		echo "<select name='".$sel_name."'";
		if ( $onchange != "" ) {
			echo " onchange='".$onchange."'";
		}
		echo ">\n";

		$sql = "SELECT ".$this->id.", ".$title." FROM ".$this->table." WHERE ".$this->pid."=0";

		if($forSearch){
			$sql .= " AND searchable = 1";
		}

		$sql .= " AND categoryid IN (".implode(', ',$grantedCats).")";

		if ( $order != "" ) {
			$sql .= " ORDER BY $order";
		}
		$result = $this->db->query($sql);
		if ( $none ) {
			echo "<option value='0'>----</option>\n";
		}
		while ( list($catid, $name) = $this->db->fetchRow($result) ) {

			if ( $catid == $preset_id ) {
				$sel = " selected='selected'";
			}
			// MT hack added by hsalazar //
			if(method_exists($myts, 'formatForML')){
				$name = $myts->formatForML($name);
			}
			// MT hack added by hsalazar //
			echo "<option value='$catid'$sel>$name</option>\n";
			$sel = "";
			$arr = $this->getChildTreeArray($catid, $order, array(), '', 1, $grantedCats);
			foreach ( $arr as $option ) {
				$option['prefix'] = str_replace(".","--",$option['prefix']);
				$catpath = $option['prefix']."&nbsp;".$myts->makeTboxData4Show($option[$title]);
				if ( $option[$this->id] == $preset_id ) {
					$sel = " selected='selected'";
				}
				echo "<option value='".$option[$this->id]."'$sel>$catpath</option>\n";
				$sel = "";
			}
		}
		echo "</select>\n";
	}

	function getChildTreeArray($sel_id=0,$order="",$parray = array(),$r_prefix="", $forSearch, $grantedCats)
	{
		$sql = "SELECT * FROM ".$this->table." WHERE ".$this->pid."=".$sel_id."";

		if($forSearch){
			$sql .= " AND searchable = 1";
		}
		$sql .= " AND categoryid IN (".implode(', ',$grantedCats).")";

		if ( $order != "" ) {
			$sql .= " ORDER BY $order";
		}
		$result = $this->db->query($sql);
		$count = $this->db->getRowsNum($result);
		if ( $count == 0 ) {
			return $parray;
		}
		while ( $row = $this->db->fetchArray($result) ) {
			$row['prefix'] = $r_prefix.".";
			array_push($parray, $row);
			$parray = $this->getChildTreeArray($row[$this->id],$order,$parray,$row['prefix'], 1, $grantedCats);
		}
		return $parray;
	}
}
?>
