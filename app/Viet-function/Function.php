<?php 
	function MenuMulti($data,$parent_id ,$str='---| ',$select)
	{
		foreach ($data as $val) {
			$id = $val["id"];
			$ten= $val["name"];
			if ($val['parentID'] == $parent_id) {
				if ($select!=0 && $id == $select) 
				{
					echo '<option value="'.$id.'" selected >'.$str." ".$ten.'</option>';
				}	
				else 
				{
					echo '<option value="'.$id.'">'.$str." ".$ten.'</option>';
				}			
				MenuMulti($data,$id,$str.'---|',$select);
			}			
		}
	}
?>