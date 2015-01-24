<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Agency extends Eloquent {
	use SoftDeletingTrait;

	protected $table      = 'agencies';

	protected $softDelete = true;

	public $timestamps    = true;

	public static $rules = array(
		'id' => 'unique:agencies'
	);

	public function employees() {
		return $this->belongsTo('Employee', 'emp_id');
	}

}
