<?php 
namespace App\Models;

use CodeIgniter\Model;

class TestprojectModel extends Model
{
	protected $table = 'Test_project';
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'hostname',
		'xyz',
		'ipv4',
		'abc',
		'created_at',
	];
}
