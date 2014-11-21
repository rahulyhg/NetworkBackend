<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report extends CI_Controller 
{
    public function dailysalesdayreport()
	{
        $zone=$this->input->get_post('zone');
        $date=$this->input->get_post('date');
		$this->report_model->exportdailysalesdayreport($zone,$date);
	}
    public function dailyitemwisesalesreport()
	{
//        $item=$this->input->get('item');
        $date=$this->input->get_post('date');
		$this->report_model->exportdailyitemwisereport($date);
	}
    public function dailyordersummaryreport()
	{
        $distributor=$this->input->get_post('distributor');
        $date=$this->input->get_post('date');
		$this->report_model->exportdailyordersummaryreport($distributor,$date);
	}
    
    public function weeklyitemwisesalesreport()
	{
//        $item=$this->input->get('item');
        $date=$this->input->get_post('date');
		$this->report_model->exportweeklyitemwisereport($date);
	}
    public function weeklydistributorsalesreport()
	{
//        $distributor=$this->input->get('distributor');
        $zone=$this->input->get_post('zone');
        $date=$this->input->get_post('date');
		$this->report_model->exportweeklydistributorsalesreport($date,$zone);
	}
    
    
	public function createmonthlyreport()
	{
		$data['reporttype']=$this->report_model->getmonthlyreporttypes();
		$data[ 'page' ] = 'createmonthlyreport';
		$data[ 'title' ] = 'Create Monthly Report';
		$this->load->view( 'template', $data );	
	}
    
    public function submitmonthlysalesreport()
	{
       // print_r($_POST);
        $reporttype=$this->input->get_post('reporttype');
        $fromdate=$this->input->get_post('fromdate');
        $todate=$this->input->get_post('todate');
        if($fromdate != "")
			{
				$fromdate = date("Y-m-d",strtotime($fromdate));
			}
        if($todate != "")
			{
				$todate = date("Y-m-d",strtotime($todate));
			}
//        echo $reporttype;
       if($reporttype==1)
       {
		  $this->report_model->exportmonthlyitemwisesalesreport($reporttype,$fromdate,$todate);
       }
       else if($reporttype==2)
       {
		  $this->report_model->exportmonthlydistributorreport($reporttype,$fromdate,$todate);
       }
       else if($reporttype==3)
       {
		  $this->report_model->exportmonthlyzerodistributorretailerreport($reporttype,$fromdate,$todate);
       }
       else if($reporttype==4)
       {
		  $this->report_model->exportmonthlynewproductplacementreport($reporttype,$fromdate,$todate);
       }
       else if($reporttype==5)
       {
		  $this->report_model->exportmonthlyschemeproductplacement($reporttype,$fromdate,$todate);
       }
       else if($reporttype==6)
       {
		  $this->report_model->exportmonthlyorderreport($reporttype,$fromdate,$todate);
       }
       else
       {
           echo "Wrong Choise";
       }
	}
    
     public function dailysalesdayreporttozone()
	{
//        $zone=$this->input->get_post('zone');
		$this->report_model->exportdailysalesdayreporttozone();
	}
    
    public function dailyordersummaryreportdistributor()
	{
//        $distributor=$this->input->get_post('distributor');
//        $date=$this->input->get_post('date');
		$this->report_model->exportdailyordersummaryreportdistributor();
	}
    
    public function weeklydistributorsalesreporttozone()
	{
//        $zone=$this->input->get_post('zone');
//        $date=$this->input->get_post('date');
		$this->report_model->exportweeklydistributorsalesreporttozone();
	}
    

    
    
}
?>