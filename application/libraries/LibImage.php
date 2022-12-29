<?php
/*
	Resource From: http:///www.white-hat-web-design.co.uk/blog/resizing-image-with-php
*/
class libImage {
 
   var $image;
   var $image_type;
 
   function gfLoad($filename) {
 
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
 
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
 
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
 
         $this->image = imagecreatefrompng($filename);
      }
   }
   function gfSave($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
 
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
 
         imagegif($this->image,$filename);
      } elseif( $image_type == IMAGETYPE_PNG ) {
 
         imagepng($this->image,$filename);
      }
      if( $permissions != null) {
 
         chmod($filename,$permissions);
      }
   }
   function gfOutput($image_type=IMAGETYPE_JPEG) {
 
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
 
         imagegif($this->image);
      } elseif( $image_type == IMAGETYPE_PNG ) {
 
         imagepng($this->image);
      }
   }
   function gfGetWidth() {
 
      return imagesx($this->image);
   }
   function gfGetHeight() {
 
      return imagesy($this->image);
   }
   function gfResizeToHeight($height) {
 
      $ratio = $height / $this->gfGetHeight();
      $width = $this->gfGetWidth() * $ratio;
      $this->gfResize($width,$height);
   }
 
   function gfResizeToWidth($width) {
      $ratio = $width / $this->gfGetWidth();
      $height = $this->gfGetHeight() * $ratio;
      $this->gfResize($width,$height);
   }
 
   function gfScale($scale) {
      $width = $this->gfGetWidth() * $scale/100;
      $height = $this->gfGetHeight() * $scale/100;
      $this->gfResize($width,$height);
   }
 
   function gfResize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->gfGetWidth(), $this->gfGetHeight());
      $this->image = $new_image;
   }       
}
