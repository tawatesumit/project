<?php 
namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
	protected $table = 'projects';
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'project_name',
		'project_title',
		'abbrevation',
		'project_description',
		'organization_id',
		'created_by',
		'created_at',
		'updated_by',
		'updated_at',
	];
}
