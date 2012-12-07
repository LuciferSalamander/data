<?php
include '../php_funcs/funcs.php';
include 'rest.inc.php';
class API extends REST 
{
    private $pnode ='';
	private $cnode ='';
	private $thumburl = '';// for the issue tracker xml

    function __construct(){
			parent::__construct();			// Init parent contructor
		
    }	

	//Public method for access api.
    //This method dynmically call the method based on the query string
	public function processApi()
	{
	
		$func = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));
		if((int)method_exists($this,$func) > 0)
			$this->$func();
		else
			$this->response('',404);				// If the method not exist with in this class, response would be "Page not found".
    }
	private function getWaterpointSummary()
	{
	   // Cross validation if the request method is GET else it will return "Not Acceptable" status
		if($this->get_request_method() != "GET"){
			$this->response('',406);
		}
		
		//set the xml nodes just in case xml is requested	
		$this->pnode = 'waterpoints';
		$this->cnode = 'waterpoint';    
		 $sql = "SELECT * FROM waterpoint_summary";	
		 $this->getQueryData($sql);	//get query results	
		 
	}
	private function getWaterpoints()//basic waterpoint info apart from view
	{
	     // Cross validation if the request method is GET else it will return "Not Acceptable" status
		 if($this->get_request_method() != "GET"){
			$this->response('',406);
		 }	
		 //set the xml nodes just in case xml is requested	
		$this->pnode = 'waterpoints';
		$this->cnode = 'waterpoint';     
		 $sql = "SELECT * FROM waterpoints order by waterpoint_id";		
		 $this->getQueryData($sql);	//get query results	
	}
	
	private function getWaterpointDetails()
	{
	  	if($this->get_request_method() != "GET"){
				$this->response('',406);
		}   
		//set the xml nodes just in case xml is requested	
		$this->pnode = 'waterpoints';
		$this->cnode = 'waterpoint';        
		 $id = (int)$this->_request['id'];//request for the sanitized waterpoint id		   
		 $sql = "SELECT * FROM waterpoint_summary WHERE waterpoint_id = '".$id."'";		
		 $this->getQueryData($sql);	//get query results	
	}
	private function getIssueTypes()
	{
	  	if($this->get_request_method() != "GET"){
				$this->response('',406);
		}   
		//set the xml nodes just in case xml is requested	
		$this->pnode = 'issue_types';
		$this->cnode = 'issue_type';        
		
		 $sql = "SELECT * FROM issuetype";		
		 $this->getQueryData($sql);	//get query results	
	}
	private function getUsers()
	{
	  	if($this->get_request_method() != "GET"){
				$this->response('',406);
		}   
		//set the xml nodes just in case xml is requested	
		$this->pnode = 'users';
		$this->cnode = 'user';        
		   
		 $sql = "SELECT * FROM users";		
		 $this->getQueryData($sql);	//get query results	
	}
	private function getIssues()
	{
	   // Cross validation if the request method is GET else it will return "Not Acceptable" status
		 if($this->get_request_method() != "GET"){
			$this->response('',406);
		 }
		  //set the xml nodes just in case xml is requested	
		$this->pnode = 'issues';
		$this->cnode = 'issue';  			    
		 $sql = "SELECT issueid,waterpointid,
				(SELECT waterpoint_name FROM waterpoints WHERE waterpoint_id = waterpointid) AS   waterpoint_name, 
				(SELECT issuetypename FROM issuetype WHERE issuetype.issuetypeid=issue.issuetypeid) AS issuetype, 
				(SELECT username FROM users WHERE user_id=createdby) AS owner, status
				 FROM issue  ORDER BY  issueid";
		 $this->getQueryData($sql);	//get query results	
	}
	private function getIssueDetails()
	{
	   // Cross validation if the request method is GET else it will return "Not Acceptable" status
		 if($this->get_request_method() != "GET"){
			$this->response('',406);
		 }
		 $this->pnode = 'issues';
		$this->cnode = 'issue';  	
		 $id = (int)$this->_request['id'];//request for the sanitized issue id		   
		 $sql = "SELECT * FROM issue WHERE issueid ='".$id."'";
		 $this->getQueryData($sql);	//get query results	
		
	}
	private function getIssuesAssigned()
	{
	   // Cross validation if the request method is GET else it will return "Not Acceptable" status
		 if($this->get_request_method() != "GET"){
			$this->response('',406);
		 }
		 $this->pnode = 'issues';
		 $this->cnode = 'issue';  	
		 $id = (int)$this->_request['id'];//request for the sanitized issue id		   
		 $sql = "SELECT issueid,
				(SELECT waterpoint_name FROM waterpoints WHERE waterpoint_id = waterpointid) AS   waterpoint_name, waterpointid,
				(SELECT issuetypename FROM issuetype WHERE issuetype.issuetypeid=issue.issuetypeid) AS issuetype, date_time_created,
				(SELECT username FROM users WHERE user_id=user_assigned) AS assigned_for
				 FROM issue WHERE user_assigned ='".$id."' ORDER BY  waterpointid";
		 $this->thumburl = 'http://data.safe-water.org/images/thumb.png';// for the issue tracker xml	 
		 $this->getQueryData($sql);	//get query results	
		
	}
	private function getIssuesByWaterpointID()
	{
	   // Cross validation if the request method is GET else it will return "Not Acceptable" status
		 if($this->get_request_method() != "GET"){
			$this->response('',406);
		 }
		 $this->pnode = 'issues';
		$this->cnode = 'issue';  	
		 $id = (int)$this->_request['id'];//request for the sanitized issue id		   
		 $sql = "SELECT * FROM issue WHERE waterpointid  ='".$id."'";
		 $this->getQueryData($sql);	//get query results	
		
	}
	private function createIssue()
	{
	//first of all sanitize the inputs to prevent code injections
	 $wptid = $this->_request['wptid'];  
	 $createdby = $this->_request['createdby'];  
	 $issuetypeid = $this->_request['issuetypeid'];  
	 $createsourceid = $this->_request['createsourceid'];  
	 $userassigned = $this->_request['userassigned'];  
	 // Cross validation if the request method is POST else it will return "Not Acceptable" status
	if($this->get_request_method() != "POST"){
		$this->response('',406);
	}	   
	$sql = "INSERT INTO issue(waterpointid, date_time_created, status, user_assigned,issuetypeid, issuesourceid, createdby)
	   VALUES 
	  ('". $wptid."','".date("Y-m-d H:i:s")."', 'False', '".$userassigned."','". $issuetypeid ."','".$createsourceid."', '".$createdby."');";
	
	$this->setQueryData($sql,"Successfully created issue","Failed to create issue, query was ".$sql);	//set query results	
		 
 	}
	private function getQueryData($sql)// use central function to process all queries for gets 
	{
	    $obj = new MainFuncs(); 
	    $query_result = $obj->processReturnQuery($sql,'dsw_db');//
	    if(pg_num_rows($query_result) > 0)
		 {
			$result = array();
			while($rlt = pg_fetch_array($query_result, NULL, PGSQL_ASSOC))
			{
				$result[] = $rlt;
			}
			// If success everythig is good send header as "OK" and return list of users in JSON format
			$returnformat = 'json';
			 $format = (string)@$this->_request['format'];
			 if(!empty($format))
			 {
			   $returnformat = $format;
			 }
			if($returnformat =='json')
			{
			   $this->response($this->json($result), 200,$returnformat);
			}
			else
			{
			   //$this->response($this->genXML($query_result,'issues','issue'), 200,$returnformat);
			   $query_result =  $obj->processReturnQuery($sql,'dsw_db');//
			 //  $this->genXML($query_result);
			 $this->response($this->genXML($query_result,$this->pnode,$this->cnode), 200,$returnformat);
			 }
		  }
		  else
		  {
		      $this->response('',204);
		  }
		  pg_close($conn);
	}
	
	private function setQueryData($sql,$successmsg,$errormsg)// use central function to process all queries for posts/puts
	{
	     $obj = new MainFuncs(); 
	    $query_result = $obj->processReturnQuery($sql,'dsw_db');//
	    if($query_result)
		 {
			$success = array('status' => "Post Success", "msg" => $successmsg);
             $this->response($this->json($success),200);
		  }
		  else
		  {
		     $error = array('status' => "Post Failure", "msg" => $errormsg.$sql);
              $this->response($this->json($error), 400);
		  }
		 pg_close($conn);
	}
	private function genXML($result,$rootnode,$childnode)
	{ 
	   // Create XML document
		$doc = new DomDocument('1.0', 'UTF-8');
		
		// Create root node
		$root = $doc->createElement($rootnode);
		$root = $doc->appendChild($root);
		
		while ($row = pg_fetch_assoc($result)) {
			// add node for each row
		
			$node = $doc->createElement($childnode);
			$node = $root->appendChild($node);
		
			foreach ($row as $column => $value) {
				$columnElement = $doc->createElement($column);
				$columnElement = $node->appendChild($columnElement);
		
				$columnValue = $doc->createTextNode($value);
				$columnValue = $columnElement->appendChild($columnValue);
			}
			if(!empty($this->thumburl))// customized addition to the xml
			{
			    $columnElement = $doc->createElement('thumb_url');
				$columnElement = $node->appendChild($columnElement);
		
				$columnValue = $doc->createTextNode($this->thumburl);
				$columnValue = $columnElement->appendChild($columnValue);
			}
		
		}
	        	
		// Complete XML document
		$doc->formatOutput = true;
		$xmlContent = $doc->saveXML();
		echo $xmlContent;
	}
	/*
	 *	Encode array into JSON
	*/
	private function json($data){
		if(is_array($data)){
			return json_encode($data);
		}
	}
}
	// Initiiate Library
	
	$api = new API;
	$api->processApi();

?>

