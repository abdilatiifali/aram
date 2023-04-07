<?php
@session_start();
$user_data = $_SESSION['licence_data'];
require_once 'textPainter.php';
require_once 'ImageResize.php';

// Resize image
$image = $user_data->image != '' ? '../uploads/users_licence/'.$user_data->image : '../assets/img/user-big.png';
$image_resize = new ImageResize($image);
// Resize image to 170 X 170
$image_resize->resizeImage(60, 70, 'exact', true);
$image_resize->saveImage('user_a.jpg', 100);
// Resize image to 170 X 170
//$image_resize = new ImageResize('user.jpg');
$image_resize->resizeImage(30, 30, 'exact', true);
$image_resize->saveImage('user_b.jpg', 100);

$dest = imagecreatefrompng('Main_images/DL_Front.png');
$src = imagecreatefromjpeg('user_a.jpg');

imagealphablending($dest, false);
imagesavealpha($dest, true);

// Parameters            ( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h , int $pct )
imagecopymerge($dest, $src, 10, 80, 0, 0, 60, 70, 100); //have to play with these numbers for it to work for you, etc.

header('Content-Type: image/png');
imagepng($dest, 'licence.png');

imagedestroy($dest);
imagedestroy($src);

//
//$img = resize_image('user.jpg', 100, 100);
$dest = imagecreatefrompng('licence.png');
$src = imagecreatefromjpeg('user_b.jpg');

imagealphablending($dest, false);
imagesavealpha($dest, true);

// Parameters            ( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h , int $pct )
imagecopymerge($dest, $src, 240, 140, 0, 0, 30, 30, 100); //have to play with these numbers for it to work for you, etc.

header('Content-Type: image/png');
imagepng($dest, 'licence.png');

imagedestroy($dest);
imagedestroy($src);



$img = new textPainter('licence.png', $user_data->licence_no, 'FranklinGothic.ttf', 50);
$img->setPosition(82, 83);  // 85, 83
$img->setFontSize(6);
$img->setTextColor(69,69,69);  // 217,217,217
$img->show();

//

$img = new textPainter('up/dl_updated.png', $user_data->name, 'FranklinGothic.ttf', 50);
$img->setPosition(82, 105);
$img->setFontSize(6);
$img->setTextColor(69,69,69);  // 217,217,217
$img->show();

$img = new textPainter('up/dl_updated.png', $user_data->nationality, 'FranklinGothic.ttf', 50);
$img->setPosition(82, 127);
$img->setFontSize(6);
$img->setTextColor(69,69,69);  // 217,217,217
$img->show();

$img = new textPainter('up/dl_updated.png', date('d - m - Y', strtotime($user_data->date_birth)), 'FranklinGothic.ttf', 50);
$img->setPosition(82, 149);
$img->setFontSize(6);
$img->setTextColor(69,69,69);  // 217,217,217
$img->show();

$img = new textPainter('up/dl_updated.png', $user_data->issue_place, 'FranklinGothic.ttf', 50);
$img->setPosition(82, 171);
$img->setFontSize(6);
$img->setTextColor(69,69,69);  // 217,217,217
$img->show();


$img = new textPainter('up/dl_updated.png', str_replace(",","-",$user_data->vehicle_types), 'FranklinGothic.ttf', 50);
$img->setPosition(82, 193);
$img->setFontSize(6);
$img->setTextColor(69,69,69);  // 217,217,217
$img->show();

$img = new textPainter('up/dl_updated.png', date('d - m - Y', strtotime($user_data->issue_date)), 'FranklinGothic.ttf', 50);
$img->setPosition(215, 83);
$img->setFontSize(6);
$img->setTextColor(69,69,69);  // 217,217,217
$img->show();

$img = new textPainter('up/dl_updated.png', date('d - m - Y', strtotime($user_data->expiry_date)), 'FranklinGothic.ttf', 50);
$img->setPosition(215, 105);
$img->setFontSize(6);
$img->setTextColor(69,69,69);  // 217,217,217
$img->show();



function merge($filename_x, $filename_y, $filename_result) {

 // Get dimensions for specified images

 list($width_x, $height_x) = getimagesize($filename_x);
 list($width_y, $height_y) = getimagesize($filename_y);

 // Create new image with desired dimensions

 $image = imagecreatetruecolor($width_x + $width_y, $height_x);

 // Load images and then copy to destination image

 $image_x = imagecreatefrompng($filename_x);
 $image_y = imagecreatefrompng($filename_y);

 imagecopy($image, $image_x, 0, 0, 1, 0, $width_x, $height_x);
 imagecopy($image, $image_y, $width_x, 0, 0, 0, $width_y, $height_y);

 // Save the resulting image to disk (as JPEG)

 imagejpeg($image, $filename_result);

 // Clean up

 imagedestroy($image);
 imagedestroy($image_x);
 imagedestroy($image_y);

}

//merge('up/dl_updated.png', '', 'Licence.jpg');

// convert to jpg image
$file = "up/dl_updated.png";

$image = imagecreatefrompng($file);
$bg = imagecreatetruecolor(imagesx($image), imagesy($image));

imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
imagealphablending($bg, TRUE);
imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
imagedestroy($image);

header('Content-Type: image/jpeg');

$quality = 50;
imagejpeg($bg, 'Licence.jpg');
imagedestroy($bg);
?>
