<?php 

namespace App\Controllers\Admin;
ini_set('max_execution_time', 500);
use App\Controllers\BaseController;
use App\Models\PatientModel;
use App\Models\ProjectModel;
use App\Models\StateModel;
use App\Models\OrganizationModel;
use App\Models\DistrictModel;
use App\Models\PincodeModel;
use App\Models\HabitModel;
use App\Models\EducationModel;
use App\Models\OccupationModel;
use App\Models\MedicationModel;
use App\Models\DiseaseModel;
use App\Models\RelationModel;
use App\Models\CancerTypeModel;
use App\Models\HistologyModel;
use App\Models\CommonModel;
use App\Models\EncDecModel;
use CodeIgniter\I18n\Time;
use App\Libraries\MY_Encrypt;
use App\Models\PatientHabitModel;
use App\Models\PatientFamilyHisModel;
use App\Models\DiagnosisModel;
use App\Models\TestprojectModel;
use DateTime;
use CodeIgniter\HTTP\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class ProjectInfo extends BaseController
{
	public $db;

	public function __construct() {

		$this->db = \Config\Database::connect();
  	}

///////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// Display Imported Records //////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
  	public function index()
	{
		return view('admin/project_details');
	}

///////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// Display Imported Records Table//////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
    public function projectdata_ajax()
	{
		// print_r($_REQUEST); die;
		$params['draw'] = $_REQUEST['draw'];
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
        /* If we pass any extra data in request from ajax */

        /* Value we will get from typing in search */
        $search_value = $_REQUEST['search']['value'];
        $data = array();

        // count all data
        $total_count = $this->db->query("SELECT * FROM Test_project")->getResult();

        // get per page data
        $sql="SELECT * FROM Test_project ";
        if(!empty($search_value)){
        	$sql.=" AND (hostname like '%".$search_value."%' OR ipv4 like '%".$search_value."%' OR xyz like '%".$search_value."%' OR abc like '%".$search_value."%')";
        }
        $sql.=" limit $start, $length";
        // echo $sql;
        $result = $this->db->query($sql)->getResult();
        $i=1;
        foreach($result as $row){
        	
        	$data_row = array();
            $data_row[]=$i;
            $data_row[]=$row->hostname;
            $data_row[]=$row->xyz;
            $data_row[]=$row->ipv4;
            $data_row[]=$row->abc;
            
            $data[]=$data_row;
            $i++;
        }
        
        $json_data = array(
            "draw" => intval($params['draw']),
            "recordsTotal" => count($total_count),
            "recordsFiltered" => count($total_count),
            "data" => $data   // total data array
        );

        echo json_encode($json_data);
    }

	public function store()
	{ 
		
	}

	public function edit($patient_id = null, $project_id=null)
	{

	}

///////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// Preview file Records //////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////

	public function previewfile(){
		$inputFileType = 'xlsx';
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		//$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		//$reader->setReadDataOnly(true);
	    $spreadsheet = $reader->load($_FILES["csv"]["tmp_name"]);
	    $spreadsheet->getActiveSheet()->getProtection()->setSheet(false);
	    $sheetData = $spreadsheet->getActiveSheet()->toArray();
    
	    $data_row = array();
	    $data = array();
	    // echo count($sheetData); die;
	    // print_r($sheetData); die;
	    for($i=1;$i<count($sheetData);$i++){
		    	$data_row = [
		    			'sr_no' 				=> $i,
						  'hostname' 				=> !empty($sheetData[$i][0]) ? $sheetData[$i][0] : '',
						  'xyz' 						=> !empty($sheetData[$i][1]) ? $sheetData[$i][1] : '',
						  'ipv4' 	=> !empty($sheetData[$i][2]) ? $sheetData[$i][2] : '',
						  'abc' 						=> !empty($sheetData[$i][3]) ? $sheetData[$i][3] : '',
						  'action' => '<a href="#" class="btn btn-danger deleterow" at="'.$i.'" id="delete_record'.$i.'">Delete</a>'
					];
				

				$data[]=$data_row;
	    	
	    }
				/*echo '<pre>'; print_r($data); die;*/
	    $json_data = array(
	        "data" => $data 
	    );
	    
	    echo json_encode($json_data);
	}

///////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// Validate Domain Name //////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
	public function is_valid_domain_name($domain_name)
	{
	    return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) //valid chars check
	            && preg_match("/^.{1,253}$/", $domain_name) //overall length check
	            && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)   ); //length of each label
	}

///////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// Imported Records //////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
	public function importfile(){
		// print_r($_POST); die;
		$created_at=date('Y-m-d H:i:s');
		$inputFileType = 'xlsx';
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($_FILES["csv"]["tmp_name"]);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        // print_r($sheetData); die

        /*print_r($sheetData); die;*/
        $TestprojectModel = new TestprojectModel();
        $y=1;

        for($i=1;$i<count($sheetData);$i++){
        	if (!empty($sheetData[$i][0])) {
						
				$hostname = $sheetData[$i][0];
				$xyz = $sheetData[$i][1];
				$ipv4 = $sheetData[$i][2];
				$abc = $sheetData[$i][3];

				if(filter_var($ipv4, FILTER_VALIDATE_IP) && $hostname !="" && $xyz!="" && $ipv4!="" && $abc!=""){
					if ($this->request->getPost('availability'.$i) != "") {
						$data = [
						  'hostname' => !empty($hostname) ? $hostname: '',
						  'xyz' => !empty($xyz) ? $xyz: '',
						  'ipv4' => !empty($ipv4) ? $ipv4: '',
						  'abc' => !empty($abc) ? $abc: ''
						];
						// print_r($data); die;
						$TestprojectModel->save($data);		
		        	}
		        }				
        	}
        }
        
        $json_data = array(
                "status" => "success",
                "message" => "Imported Successfully",
            );
		echo json_encode($json_data);
	}

}
