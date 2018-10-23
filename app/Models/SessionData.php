<?php

namespace App\Models;

use App\Models\Model;
use Carbon\Carbon;

class SessionData extends Model{
	protected $table = 'sessions';

	public function getLastactivityAttribute($value) {
		return $this->attributes['last_activity'] = date("Y-M-d H:i:s", $value);
	}
	public function getIdAttribute($value) {
		return $this->attributes['id'];
	}


}
