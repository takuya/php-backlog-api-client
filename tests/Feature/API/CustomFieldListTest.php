<?php

namespace tests\Feature\API;



use tests\Feature\TestCase\TestCaseTemporaryProject;

class CustomFieldListTest extends TestCaseTemporaryProject {
  protected $sample_cf=null;
  protected $sample_issue_type_id;
  protected $sample_priority_id;
  
  protected function setUp (): void {
    parent::setUp();
    $this->create_custom_field();
    $this->issue_type_id();
    $this->priority_id();
  }
  
  protected function tearDown (): void {
    $this->delete_custom_field();
    parent::tearDown();
  }
  protected function delete_custom_field(){
    if($this->sample_cf){
      $api = $this->api_client();
      $api->deleteCustomField($this->project_id,$this->sample_cf->id);
    }
  }
  protected function create_custom_field(){
    $api = $this->api_client();
    $ret = $api->addCustomField($this->project_id,[
      'typeId'=>6,
      'name'=>'sample-for-api',
      'description'=>'APIテスト用',
      'required'=>false,
      'items'=>['項目A','項目B','項目C'],
      'allowInput'=>true,
      'allowAddItem'=>true
    ]);
    $this->sample_cf=$ret;
    return $ret;
  }
  protected function issue_type_id(){
    $api = $this->api_client();
    $ret =$api->getIssueTypeList($this->project_id);
    $this->sample_issue_type_id = $ret[0]->id;
  }
  protected function priority_id(){
    $api = $this->api_client();
    $ret =$api->getPriorityList();
    $this->sample_priority_id = $ret[0]->id;
  }
  
  
  public function test_create_issue_with_custom_field_of_multiple_list(){
    $api = $this->api_client();
    $cf_id=$this->sample_cf->id;
    $data = [
      'projectId' =>$this->project_id,
      'summary'=>'追加テスト',
      'issueTypeId'=>$this->sample_issue_type_id,
      'priorityId'=>$this->sample_priority_id,
    ] ;
    $data['customField_'.$cf_id] = [1,2];
    $ret = $api->addIssue($data);
    $api->deleteIssue($ret->id);
    $posted_cf = array_values(array_filter($ret->customFields,fn($e)=>$e->id==$cf_id));
    $this->assertNotEmpty($posted_cf);
    $posted_cf= $posted_cf[0]->value;
    $this->assertEquals(2,sizeof($posted_cf) );
    


  }
  
}