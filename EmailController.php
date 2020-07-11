<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EmailController extends CI_Controller {

    public function __construct() {
        parent:: __construct();
		$this->load->model('Emailmodel'); 
		$this->load->helper(array('url', 'form', 'array'));
		$this->load->helper('xml');
		$this->load->database();
    }

    public function index() {
        $this->load->view('contact');
    }
	
function getmydata(){
	
$path = 'uploads/myfile.xml';

//read entire file into string
$xmlfile = file_get_contents($path);

//convert xml string into an object
$xml = simplexml_load_string($xmlfile);

//convert into json
$json  = json_encode($xml);

//convert into associative array
$xmlArr['data'] = json_decode($json, true);
echo "<pre>";
print_r($xmlArr);
echo "</pre>";
 // $xml = new SimpleXMLElement('<download/>');
 // array_walk_recursive($xmlArr, array ($xml,'addChild'));
 // print $xml->asXML();
   
   
   //$xml = $this->dbutil->xml_from_result($query, $config);
   //$this->load->helper('download');
   //force_download('myfile.xml', $xml);
}
function showxmldata(){
	
$path = 'uploads/myfile.xml';

//read entire file into string
$xmlfile = file_get_contents($path);


//convert xml string into an object
$xml['data'] = simplexml_load_string($xmlfile);

//convert into json
$json = json_encode($xml);

//convert into associative array
$xmlArr['data'] = json_decode($json,true);
// echo"<pre>";
// print_r($xml);
// echo"</pre>";die();

$this->load->view('array_show',$xmlArr);

}

function arr_helper()
{
	
	
	$this->load->helper("array");
	
	 $data['seo']=array(
	 "meta_dese" => "this is my description",
	 "meta_key" => "this is my key",
	 "meta_dtitle" => "this is my title");
	 
	 $ex['sso']=array (
	 "contry_name" => "AUSTRALIA",
	 "location" => "Location: Australia is a continent between the Indian and South Pacific Oceans.",
	 "capital" => "Capital: Canberra",
	 "climate" => "Climate: Favorable climate exists only in the eastern and south western coasts. The North and Central areas are hot and humid.",
	 "currency" => "Currency: Australian Dollar",
	 "majar_cities" => "Major Cities: Canberra, Sydney, Melbourne, Adelaid, Perth, Brisbane, Hobart",
	 "visa_info" => "Visa information: There is a High commission of Australia in New Delhi and one consulate of Australia in Mumbai.VFS locations: Mumbai, Delhi, Chennai, Kolkata, Ahmedabad, Hyderabad, Bangalore, Chandigarh, Cochin and Kathmandu. Australian High commission New Delhi accepts the visa applications from all over India and Nepal in Delhi. Applicants can apply through nearest VFS centre. Main visa categories are: visitor, Business, Transit, Study permit." );
	
	
	$xml = new SimpleXMLElement('<download/>');
    array_walk_recursive($ex, array ($xml,'addChild'));
    print $xml->asXML();
	//$this->load->view('array_show',$ex);
	
}

function manual_edit()
{

$path = 'uploads/sample.xml';
$xmlfile = file_get_contents($path);
$xml= simplexml_load_string($xmlfile);
$i=-1;
foreach($xml->children() as $list)
{
	$i=$i+1;
	$name=$list->name;
	if($name=="Gowtham")
	{
		$list->code[$i]="004";
	}
}
file_put_contents($path,$xml->saveXML());
echo "successfully edited";
}


function edit_xml_data()
{
$path = 'uploads/sample.xml';

//read entire file into string
$xmlfile = file_get_contents($path);


//convert xml string into an object
$xml= simplexml_load_string($xmlfile);

//convert into json
$json = json_encode($xml);

//convert into associative array
$xmlArr['data'] = json_decode($json,true);
// echo"<pre>";
// print_r($xmlArr);die();
// echo"</pre>";
$this->load->view('view_array',$xmlArr);
}


function edit_sample()
{
$name['value']=$this->uri->segment(3, 0);

$this->load->view('update',$name);

}
function user_edit()
{
$this->load->helper('xml');
$this->load->helper("array");
$name1=$this->input->post('name');
$code=$this->input->post('code');
//$phone=$this->input->post('phone');
//print_r($name1);print_r($code);die();
$path = 'uploads/sample.xml';
$xmlfile = file_get_contents($path);
$xml= simplexml_load_string($xmlfile);
$i=-1;
foreach($xml->children() as $list)
{
	$i=$i+1;
	$name=$list->name;
	if($name==$name1)
	{
		$list->code[$i]=$code;
		//$list->phone[$i]=$phone;
	}
}
file_put_contents($path,$xml->saveXML());
}
function inerst_xml_data()
{
$path = 'uploads/myfile.xml';
//read entire file into string
$xmlfile = file_get_contents($path);
//convert xml string into an object
$xml= simplexml_load_string($xmlfile);
//convert into json
$json = json_encode($xml);
//convert into associative array
$xmlArr['data'] = json_decode($json,true);
// echo"<pre>";
// print_r($xmlArr);
// echo"</pre>";die();

foreach($xmlArr as $key => $val)
{
$country_det['contry_name']=$val ['contry_name'];
$country_det['location']=$val  ['location'];
$country_det['capital']=$val ['capital'];
$country_det['climate']=$val ['climate'];
$country_det['currency']=$val ['currency'];
$country_det['majar_cities']=$val ['majar_cities']; 
$country_det['visa_info']=$val ['visa_info'];

$query = $this->Emailmodel->insert_country_det($country_det);

 
foreach($val['visa_types']['visa_type'] as $key => $table)
{
$visa_type['visa_type_name']=$table['visa_type_name'];
$visa_type['embassy_fee']=$table['embassy_fee'];
$visa_type['vfs_fee']=$table['vfs_fee'];
$visa_type['processing_time']=$table['processing_time'];
	if(!is_array($table['download_form_url'])){$visa_type['download_form_url']=$table['download_form_url'];}
	if(!is_array($table['download_form'])){ $visa_type['download_form']=$table['download_form'];}
	if(!is_array($table['download_check_list_url'])){ $visa_type['download_check_list_url']=$table['download_check_list_url'];}
	if(!is_array($table['download_check_list'])){$visa_type['download_check_list']= $table['download_check_list']; }

$query = $this->Emailmodel->insert_visa_type($visa_type);
}
foreach($val['diplomatic_representations']['diplomatic_representation'] as $key => $dip)
{
$diplomatic_representations['city']=$dip['city']; 
$diplomatic_representations['address_line1']=$dip['address_line1'];
$diplomatic_representations['address_line2']=$dip['address_line2'];
$diplomatic_representations['address_line3']=$dip['address_line3'];
$diplomatic_representations['mail']=$dip['mail'];
$diplomatic_representations['alt_mail']=$dip['alt_mail'];
$diplomatic_representations['phone']=$dip['phone'];
$diplomatic_representations['fax']=$dip['fax'];
$diplomatic_representations['wesite']=$dip['wesite'];
$diplomatic_representations['jurisdiction']=$dip['jurisdiction'];
$diplomatic_representations['submission_days']=$dip['submission_days']; 
$diplomatic_representations['submission_timing']=$dip['submission_timing'];
$diplomatic_representations['holiday']=$dip['holiday'];
$diplomatic_representations['holiday_file_url']=$dip['holiday_file_url'];

$query = $this->Emailmodel->insert_diplomatic_representations($diplomatic_representations);
}
foreach($val['application_centers']['application_center'] as $key => $app)
{ 
$application_centers['city']=$app['city'];
$application_centers['address_line1']=$app['address_line1'];
$application_centers['address_line2']=$app['address_line2'];
$application_centers['address_line3']=$app['address_line3'];
$application_centers['zipcode']=$app['zipcode'];
$application_centers['mail']=$app['mail'];
$application_centers['phone']=$app['phone'];
$application_centers['fax']=$app['fax'];

$query = $this->Emailmodel->insert_application_centers($application_centers);
}
 } 
}
function show_xml_data_db()
{
	$query['data'] = $this->Emailmodel->get_country_det();
	$query['visa'] = $this->Emailmodel->get_visa_type();
	$query['application'] = $this->Emailmodel->get_app_center();
	$query['dip'] = $this->Emailmodel->get_dip_rep();
	$this->load->view('Show_from_db',$query);
}
function update_contry()
{
	$id = $this->uri->segment(3, 0);
    $result['data']=$this->Emailmodel->display_country($id);
	$this->load->view('display_country',$result);
}
function update_visa_type()
{
	$id = $this->uri->segment(3, 0);
    $result['data']=$this->Emailmodel->display_visa_type($id);
	$this->load->view('display_visa_type',$result);
}
function update_dip_rep()
{
	$id = $this->uri->segment(3, 0);
    $result['data']=$this->Emailmodel->display_dip_rep($id);
	$this->load->view('display_dip_rep',$result);
}
function update_app_center()
{
	$id = $this->uri->segment(3, 0);
    $result['data']=$this->Emailmodel->display_app_center($id);
	$this->load->view('display_app_center',$result);
}


function update_contry_details() 
   {
	  

      $id= $this->input->post('id');
      $data = array( 'contry_name' => $this->input->post('contry_name'),
                    'location' => $this->input->post('location'),
                    'capital' => $this->input->post('capital'),
                    'climate' => $this->input->post('climate'),
					'currency' => $this->input->post('currency'),
					'majar_cities' => $this->input->post('majar_cities'),
					'visa_info' => $this->input->post('visa_info'));
	  $this->Emailmodel->update_contry_records($id,$data);
	  $this->get_xml_from_db_data();
      $this->show_xml_data_db();
   }
function update_visatype_details() 
   {
	  

      $id= $this->input->post('id');
      $data = array( 'visa_type_name' => $this->input->post('visa_type_name'),
                    'embassy_fee' => $this->input->post('embassy_fee'),
                    'vfs_fee' => $this->input->post('vfs_fee'),
                    'processing_time' => $this->input->post('processing_time'),
					'download_form' => $this->input->post('download_form'),
					'download_form_url' => $this->input->post('download_form_url'),
					'download_check_list' => $this->input->post('download_check_list'),
					'download_check_list_url' => $this->input->post('download_check_list_url'));
	  $this->Emailmodel->update_visatype_records($id,$data);
	  $this->get_xml_from_db_data();
      $this->show_xml_data_db();
   }
function update_appcenter_details() 
   {
	  

      $id= $this->input->post('id');
      $data = array( 'city' => $this->input->post('city'),
                    'address_line1' => $this->input->post('address_line1'),
					'address_line2' => $this->input->post('address_line2'),
					'address_line3' => $this->input->post('address_line3'),
                    'zipcode' => $this->input->post('zipcode'),
                    'mail' => $this->input->post('mail'),
					'phone' => $this->input->post('phone'),
					'fax' => $this->input->post('fax'));
	  $this->Emailmodel->update_appcenter_records($id,$data);
	  $this->get_xml_from_db_data();
      $this->show_xml_data_db();
   }
function update_diprep_details() 
   {
	  

      $id= $this->input->post('id');
      $data = array( 'city' => $this->input->post('city'),
                    'address_line1' => $this->input->post('address_line1'),
					'address_line2' => $this->input->post('address_line2'),
					'address_line3' => $this->input->post('address_line3'),
                    'mail' => $this->input->post('mail'),
					'alt_mail' => $this->input->post('alt_mail'),
					'phone' => $this->input->post('phone'),
					'fax' => $this->input->post('fax'),
					'wesite' => $this->input->post('wesite'),
					'jurisdiction' => $this->input->post('jurisdiction'),
					'submission_days' => $this->input->post('submission_days'),
					'submission_timing' => $this->input->post('submission_timing'),
					'holiday' => $this->input->post('holiday'),
					'holiday_file_url' => $this->input->post('holiday_file_url'));
	  $this->Emailmodel->update_diprep_records($id,$data);
	  $this->get_xml_from_db_data();
      $this->show_xml_data_db();
   }
function get_xml_from_db_data()
{
	$query = $this->Emailmodel->get_country_det();
	$query1 = $this->Emailmodel->get_visa_type();
	$query2 = $this->Emailmodel->get_dip_rep();
	$query3= $this->Emailmodel->get_app_center();
	


$doc = new DOMDocument();
$doc->formatOutput = true;
foreach($query as $key)
	{
		
		$contry_name= $key['contry_name'];
		$location= $key['location'];
		$capital= $key['capital'];
		$climate= $key['climate'];
		$currency= $key['currency'];
		$majar_cities= $key['majar_cities'];
		$visa_info= $key['visa_info'];
		
		
	}
$root = $doc->createElement('data');
$root = $doc->appendChild($root);

$ele1 = $doc->createElement('contry_name');
$ele1->nodeValue=$contry_name;
$root->appendChild($ele1);

$ele2 = $doc->createElement('location');
$ele2->nodeValue=$location;
$root->appendChild($ele2);

$ele3 = $doc->createElement('capital');
$ele3->nodeValue=$capital;
$root->appendChild($ele3);

$ele4 = $doc->createElement('climate');
$ele4->nodeValue=$climate;
$root->appendChild($ele4);

$ele5 = $doc->createElement('currency');
$ele5->nodeValue=$currency;
$root->appendChild($ele5);

$ele6 = $doc->createElement('majar_cities');
$ele6->nodeValue=$majar_cities;
$root->appendChild($ele6);

$ele7 = $doc->createElement('visa_info');
$ele7->nodeValue=$visa_info;
$root->appendChild($ele7);


        foreach($query1 as $table)
	{
		
		$visa_type_name= $table['visa_type_name'];
		$embassy_fee= $table['embassy_fee'];
		$vfs_fee= $table['vfs_fee'];
		$processing_time= $table['processing_time'];
		$download_form= $table['download_form'];
		$download_form_url= $table['download_form_url'];
		$download_check_list= $table['download_check_list'];
		$download_check_list_url= $table['download_check_list_url'];
		
		$visatype = $doc->createElement('visa_type');
        $visatype = $doc->appendChild($visatype);
		
		$visa_data1 = $doc->createElement('visa_type_name');
        $visa_data1->nodeValue=$visa_type_name;
        $visatype->appendChild($visa_data1);
		
		$visa_data2 = $doc->createElement('embassy_fee');
        $visa_data2->nodeValue=$embassy_fee;
        $visatype->appendChild($visa_data2);
		
		$visa_data3 = $doc->createElement('vfs_fee');
        $visa_data3->nodeValue=$vfs_fee;
        $visatype->appendChild($visa_data3);
		
		$visa_data4 = $doc->createElement('processing_time');
        $visa_data4->nodeValue=$processing_time;
        $visatype->appendChild($visa_data4);
		
		$visa_data5 = $doc->createElement('download_form');
        $visa_data5->nodeValue=$download_form;
        $visatype->appendChild($visa_data5);
		
		$visa_data6 = $doc->createElement('download_form_url');
        $visa_data6->nodeValue=$download_form_url;
        $visatype->appendChild($visa_data6);
		
		$visa_data7 = $doc->createElement('download_check_list');
        $visa_data7->nodeValue=$download_check_list;
        $visatype->appendChild($visa_data7);
		
		$visa_data8 = $doc->createElement('download_check_list_url');
        $visa_data8->nodeValue=$download_check_list_url;
        $visatype->appendChild($visa_data8);
		
		
	}
	
	foreach($query2 as $dip)
	{
		
		$diplomatic_city= $dip['city'];
		$diplomatic_address_line1= $dip['address_line1'];
		$diplomatic_address_line2= $dip['address_line2'];
		$diplomatic_address_line3= $dip['address_line3'];
		$diplomatic_mail= $dip['mail'];
		$diplomatic_alt_mail= $dip['alt_mail'];
		$diplomatic_phone= $dip['phone'];
		$diplomatic_fax= $dip['fax'];
		$diplomatic_wesite= $dip['wesite'];
		$diplomatic_jurisdiction= $dip['jurisdiction'];
		$diplomatic_submission_days= $dip['submission_days'];
		$diplomatic_submission_timing= $dip['submission_timing'];
		$diplomatic_holiday= $dip['holiday'];
		$diplomatic_holiday_file_url= $dip['holiday_file_url'];
		
		$dip_rep = $doc->createElement('diplomatic_representation');
        $dip_rep = $doc->appendChild($dip_rep);
		
		
		$dip_data1 = $doc->createElement('city');
        $dip_data1->nodeValue=$diplomatic_city;
        $dip_rep->appendChild($dip_data1);
		
		$dip_data2 = $doc->createElement('address_line1');
        $dip_data2->nodeValue=$diplomatic_address_line1;
        $dip_rep->appendChild($dip_data2);
		
		$dip_data3 = $doc->createElement('address_line2');
        $dip_data3->nodeValue=$diplomatic_address_line2;
        $dip_rep->appendChild($dip_data3);
		
		$dip_data4 = $doc->createElement('address_line3');
        $dip_data4->nodeValue=$diplomatic_address_line3;
        $dip_rep->appendChild($dip_data4);
		
		$dip_data5 = $doc->createElement('mail');
        $dip_data5->nodeValue=$diplomatic_mail;
        $dip_rep->appendChild($dip_data5);
		
		$dip_data6 = $doc->createElement('alt_mail');
        $dip_data6->nodeValue=$diplomatic_alt_mail;
        $dip_rep->appendChild($dip_data6);
		
		$dip_data7 = $doc->createElement('phone');
        $dip_data7->nodeValue=$diplomatic_phone;
        $dip_rep->appendChild($dip_data7);
		
		$dip_data8= $doc->createElement('fax');
        $dip_data8->nodeValue=$diplomatic_fax;
        $dip_rep->appendChild($dip_data8);
		
		$dip_data9 = $doc->createElement('wesite');
        $dip_data9->nodeValue=$diplomatic_wesite;
        $dip_rep->appendChild($dip_data9);
		
		$dip_data10 = $doc->createElement('jurisdiction');
        $dip_data10->nodeValue=$diplomatic_jurisdiction;
        $dip_rep->appendChild($dip_data10);
		
		$dip_data11 = $doc->createElement('submission_days');
        $dip_data11->nodeValue=$diplomatic_submission_days;
        $dip_rep->appendChild($dip_data11);
		
		$dip_data12 = $doc->createElement('submission_timing');
        $dip_data12->nodeValue=$diplomatic_submission_timing;
        $dip_rep->appendChild($dip_data12);
		
		$dip_data13 = $doc->createElement('holiday');
        $dip_data13->nodeValue=$diplomatic_holiday;
        $dip_rep->appendChild($dip_data13);
		
		$dip_data14= $doc->createElement('holiday_file_url');
        $dip_data14->nodeValue=$diplomatic_holiday_file_url;
        $dip_rep->appendChild($dip_data14);
		
	}
	
	foreach($query3 as $app)
	{
		
		$application_city= $app['city'];
		$application_address_line1= $app['address_line1'];
		$application_address_line2= $app['address_line2'];
		$application_address_line3= $app['address_line3'];
		$application_zipcode= $app['zipcode'];
		$application_mail= $app['mail'];
		$application_phone= $app['phone'];
		$application_fax= $app['fax'];
		
		$app_center = $doc->createElement('application_center');
        $app_center = $doc->appendChild($app_center);
		
		$app_data1 = $doc->createElement('city');
        $app_data1->nodeValue=$application_city;
        $app_center->appendChild($app_data1);
		
		$app_data2 = $doc->createElement('address_line1');
        $app_data2->nodeValue=$application_address_line1;
        $app_center->appendChild($app_data2);
		
		$app_data3 = $doc->createElement('address_line2');
        $app_data3->nodeValue=$application_address_line2;
        $app_center->appendChild($app_data3);
		
		$app_data4 = $doc->createElement('address_line3');
        $app_data4->nodeValue=$application_address_line3;
        $app_center->appendChild($app_data4);
		
		$app_data5 = $doc->createElement('zipcode');
        $app_data5->nodeValue=$application_zipcode;
        $app_center->appendChild($app_data5);
		
		$app_data6 = $doc->createElement('mail');
        $app_data6->nodeValue=$application_mail;
        $app_center->appendChild($app_data6);
		
		$app_data7 = $doc->createElement('phone');
        $app_data7->nodeValue=$application_phone;
        $app_center->appendChild($app_data7);
		
		$app_data8 = $doc->createElement('fax');
        $app_data8->nodeValue=$application_fax;
        $app_center->appendChild($app_data8);
	}
	
$doc->save('uploads/MyXmlFile007.xml');
	
}

}
?>