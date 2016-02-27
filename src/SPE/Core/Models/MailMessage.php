<?php

namespace SPE\Core\Models;

class MailMessage {

  private $containsHtml = false;
  private $body;
  private $attachments = array();
  private $subject;
  private $from;
  private $toCsv;

  public function __construct($containsHtml=false) {
    $this->containsHtml = $containsHtml;
  }

  public function addAttachment($filePath, $contentType){
    $attachment = array();
    $attachment['filepath']=$filePath;
    $attachment['contenttype']=$contentType;
    $this->attachments[] = $attachment;
  }

  public function setHtmlBody($body){
    $this->body = $body;
    $this->containsHtml = true;
  }

  public function setBody($body){
    $this->body = $body;
  }

  public function setSubject($subject){
    $this->subject = $subject;
  }

  public function setFrom($from){
    $this->from = $from;
  }

  public function addTo($to){
    if ( ! isset($this->toCsv)){
      $this->toCsv = $to;
    }else{
      $this->toCsv = $this->toCsv.','.$to;
    }
  }

  public function getBody(){
    return $this->body;
  }

  public function getTxtBody(){
    return $this->body;
  }

  public function getHtmlBody(){
    return $this->body;
  }

  public function getAttachments(){
    return $this->attachments;
  }

  public function getSubject(){
    return $this->subject;
  }

  public function getFrom(){
    return $this->from;
  }

  public function getToCsv(){
    return $this->toCsv;
  }

  public function isMessageInHtml(){
    return $this->containsHtml;
  }

}
