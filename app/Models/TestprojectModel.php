<?php 
namespace App\Models;

use CodeIgniter\Model;

class TestprojectModel extends Model
{
	protected $table = 'router_details';
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'sapid',
		'hostname',
		'loopback',
		'macaddress',
		'created_at',
	];
}
