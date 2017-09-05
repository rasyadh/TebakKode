<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tebakkode_m extends CI_Model {

  function __construct(){
    parent::__construct();
    $this->load->database();
  }

  // Events Log
  function log_events($signature, $body)
  {
    $this->db->set('signature', $signature)
    ->set('events', $body)
    ->insert('eventlog');

    return $this->db->insert_id();
  }

  // Users
  function getUser($userId){
    $data = $this->db->where('user_id', $userId)->get('users')->row_array();
    if(count($data) > 0) return $data;
    return false;
  }

  function saveUser($profile){
    $this->db->set('user_id', $profile['userId'])
      ->set('display_name', $profile['displayName'])
      ->insert('users');

    return $this->db->insert_id();
  }

  // Question
  function getQuestion($questionNum){
    $data = $this->db->where('number', $questionNum)
      ->get('questions')
      ->row_array();

    if(count($data)>0) return $data;
    return false;
  }

  function isAnswerEqual($number, $answer){
    $this->db->where('number', $number)
      ->where('answer', $answer);

    if(count($this->db->get('questions')->row()) > 0)
      return true;

    return false;
  }

  function setUserProgress($user_id, $newNumber){
    $this->db->set('number', $newNumber)
      ->where('user_id', $user_id)
      ->update('users');

    return $this->db->affected_rows();
  }

  function setScore($user_id, $score){
    $this->db->set('score', $score)
      ->where('user_id', $user_id)
      ->update('users');

    return $this->db->affected_rows();
  }

}
