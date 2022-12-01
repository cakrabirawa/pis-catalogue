<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado 
Apps Year: 2018
----------------------------------------------------
*/
class libCaptcha
{
    public $width  = 210;
    public $height = 70;
    public $minWordLength = 6;
    public $maxWordLength = 6;
    public $session_var = 'captcha';
    public $backgroundColor = array(255, 255, 255); //array(50, 50, 50);
    public $colors = array(
        array(100, 100, 100), // green //array(60,141,188), // blue
        array(100, 100, 100), // green //array(68,157,68), green
        array(100, 100, 100), // green //array(214,36,7),  // red
    );
    public $shadowColor = null;
    public $fonts = array(
        /*'Antykwa'  => array('spacing' => -3, 'minSize' => 27, 'maxSize' => 30, 'font' => 'AntykwaBold.ttf'),
        'Candice'  => array('spacing' =>-1.5,'minSize' => 28, 'maxSize' => 31, 'font' => 'Candice.ttf'),
        'DingDong' => array('spacing' => -2, 'minSize' => 24, 'maxSize' => 30, 'font' => 'Ding-DongDaddyO.ttf'),
        'Duality'  => array('spacing' => -2, 'minSize' => 30, 'maxSize' => 38, 'font' => 'Duality.ttf'),
        'Heineken' => array('spacing' => -2, 'minSize' => 24, 'maxSize' => 34, 'font' => 'Heineken.ttf'),
        'Jura'     => array('spacing' => -2, 'minSize' => 28, 'maxSize' => 32, 'font' => 'Jura.ttf'),
        'StayPuft' => array('spacing' =>-1.5,'minSize' => 28, 'maxSize' => 32, 'font' => 'StayPuft.ttf'),
        'Times'    => array('spacing' => -2, 'minSize' => 28, 'maxSize' => 34, 'font' => 'TimesNewRomanBold.ttf'),*/
        'VeraSans' => array('spacing' => -1, 'minSize' => 22, 'maxSize' => 42, 'font' => 'VeraSansBold.ttf'),
    );
    public $Yperiod    = 11;
    public $Yamplitude = 1;
    public $Xperiod    = 11;
    public $Xamplitude = 1;
    public $maxRotation = 1;
    public $scale = 1;
    public $blur = false;
    public $debug = false;
    public $imageFormat = 'jpeg';
    public $im;

    public function __construct($config = array())
    {
        $this->resourcesPath = getcwd();
        $this->wordsFile = 'application' . DIRECTORY_SEPARATOR .
            'libraries' . DIRECTORY_SEPARATOR .
            'captcha' . DIRECTORY_SEPARATOR .
            'resources' . DIRECTORY_SEPARATOR .
            'words' . DIRECTORY_SEPARATOR .
            'en.php';
    }
    public function CreateImage()
    {
        $ini = microtime(true);
        $this->ImageAllocate();
        $text = $this->GetCaptchaText();
        $fontcfg  = $this->fonts[array_rand($this->fonts)];
        $this->WriteText(trim($text), $fontcfg);
        $_SESSION[$this->session_var] = trim($text);
        $this->WaveImage();
        if ($this->blur && function_exists('imagefilter')) imagefilter($this->im, IMG_FILTER_GAUSSIAN_BLUR);
        $this->ReduceImage();
        if ($this->debug) {
            imagestring(
                $this->im,
                1,
                1,
                $this->height - 8,
                "$text {$fontcfg['font']} " . round((microtime(true) - $ini) * 1000) . "ms",
                $this->GdFgColor
            );
        }
        $this->WriteImage();
        $this->Cleanup();
    }
    protected function ImageAllocate()
    {
        if (!empty($this->im)) {
            imagedestroy($this->im);
        }
        $this->im = imagecreatetruecolor($this->width * $this->scale, $this->height * $this->scale);
        $this->GdBgColor = imagecolorallocate(
            $this->im,
            $this->backgroundColor[0],
            $this->backgroundColor[1],
            $this->backgroundColor[2]
        );
        imagefilledrectangle($this->im, 0, 0, $this->width * $this->scale, $this->height * $this->scale, $this->GdBgColor);
        $color           = $this->colors[mt_rand(0, sizeof($this->colors) - 1)];
        $this->GdFgColor = imagecolorallocate($this->im, $color[0], $color[1], $color[2]);
       if (!empty($this->shadowColor) && is_array($this->shadowColor) && sizeof($this->shadowColor) >= 3) {
            $this->GdShadowColor = imagecolorallocate(
                $this->im,
                $this->shadowColor[0],
                $this->shadowColor[1],
                $this->shadowColor[2]
            );
        }
    }
    protected function GetCaptchaText()
    {
        return $this->GetRandomCaptchaText();
    }
    protected function GetRandomCaptchaText($length = null)
    {
        $length = rand($this->minWordLength, $this->maxWordLength);
        $words  = "abcdefghijlmnopqrstvwyz";
        $vocals = "aeiou";

        $text  = "";
        $vocal = rand(0, 1);
        for ($i = 0; $i < $length; $i++) {
            if ($vocal) {
                $text .= substr($vocals, mt_rand(0, 4), 1);
            } else {
                $text .= substr($words, mt_rand(0, 22), 1);
            }
            $vocal = !$vocal;
        }
        return $text;
    }
    protected function WriteText($text, $fontcfg = array())
    {
        if (empty($fontcfg)) {
            // Select the font configuration
            $fontcfg  = $this->fonts[array_rand($this->fonts)];
        }

        // Full path of font file
        $fontfile = getcwd() . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'captcha' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'fonts' . DIRECTORY_SEPARATOR . $fontcfg['font'];


        /** Increase font-size for shortest words: 9% for each glyp missing */
        $lettersMissing = $this->maxWordLength - strlen($text);
        $fontSizefactor = 1 + ($lettersMissing * 0.09);

        // Text generation (char by char)
        $x      = 20 * $this->scale;
        $y      = round(($this->height * 27 / 40) * $this->scale);
        $length = strlen($text);
        for ($i = 0; $i < $length; $i++) {
            $degree   = rand($this->maxRotation * -1, $this->maxRotation);
            $fontsize = rand($fontcfg['minSize'], $fontcfg['maxSize']) * $this->scale * $fontSizefactor;
            $letter   = substr($text, $i, 1);

            if ($this->shadowColor) {
                $coords = imagettftext(
                    $this->im,
                    $fontsize,
                    $degree,
                    $x + $this->scale,
                    $y + $this->scale,
                    $this->GdShadowColor,
                    $fontfile,
                    $letter
                );
            }
            //print $fontfile;
            $coords = imagettftext(
                $this->im,
                $fontsize,
                $degree,
                $x,
                $y,
                $this->GdFgColor,
                $fontfile,
                $letter
            );
            $x += ($coords[2] - $x) + ($fontcfg['spacing'] * $this->scale);
        }
    }
    protected function WaveImage()
    {
        $xp = $this->scale * $this->Xperiod * rand(1, 3);
        $k = rand(0, 100);
        for ($i = 0; $i < ($this->width * $this->scale); $i++) {
            imagecopy(
                $this->im,
                $this->im,
                $i - 1,
                sin($k + $i / $xp) * ($this->scale * $this->Xamplitude),
                $i,
                0,
                1,
                $this->height * $this->scale
            );
        }

        $k = rand(0, 100);
        $yp = $this->scale * $this->Yperiod * rand(1, 2);
        for ($i = 0; $i < ($this->height * $this->scale); $i++) {
            imagecopy(
                $this->im,
                $this->im,
                sin($k + $i / $yp) * ($this->scale * $this->Yamplitude),
                $i - 1,
                0,
                $i,
                $this->width * $this->scale,
                1
            );
        }
    }
    protected function ReduceImage()
    {
        $imResampled = imagecreatetruecolor($this->width, $this->height);
        imagecopyresampled(
            $imResampled,
            $this->im,
            0,
            0,
            0,
            0,
            $this->width,
            $this->height,
            $this->width * $this->scale,
            $this->height * $this->scale
        );
        imagedestroy($this->im);
        $this->im = $imResampled;
    }
    protected function WriteImage()
    {
        if ($this->imageFormat == 'png' && function_exists('imagepng')) {
            header("Content-type: image/png");
            imagepng($this->im);
        } else {
            header("Content-type: image/jpeg");
            imagejpeg($this->im, null, 100);
        }
    }
    protected function Cleanup()
    {
        imagedestroy($this->im);
    }
}
