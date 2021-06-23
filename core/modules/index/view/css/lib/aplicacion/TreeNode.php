<?php
class TreeNode {
	
	public $text = "";
	public $id = "";
	public $iconCls = "";
	public $leaf = true;
	public $draggable = false;
	public $href = "#";
	public $hrefTarget = "";

	function  __construct($id,$text,$iconCls,$leaf,$draggable,$href,$hrefTarget) {
	
		$this->id = $id;
		$this->text = $text;
		$this->iconCls = $iconCls;
		$this->leaf = $leaf;
		$this->draggable = $draggable;
		$this->href = $href;
		$this->hrefTarget = $hrefTarget;
	}	
}
?>