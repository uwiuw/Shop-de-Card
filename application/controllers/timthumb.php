<?php

/*
    TimThumb script created by Tim McDaniels and Darren Hoyt with tweaks by Ben Gillbanks
    http://code.google.com/p/timthumb/

    MIT License: http://www.opensource.org/licenses/mit-license.php

    Paramters
    ---------
    w: width
    h: height
    zc: zoom crop (0 or 1)
    q: quality (default is 75 and max is 100)
    
    HTML example: <img src="/scripts/timthumb.php?src=/images/whatever.jpg&w=150&h=200&zc=1" alt="" />

This is a CI controller, simply put in your controller folder
CI example: www.domain.com/timthumb/index/800x600.jpg/300/300/1/100/0/1

currently image file must be in a folder /assets/images/
*/

class Timthumb extends CI_Controller {

	function Timthumb(){
		parent::__construct();
		define ('CACHE_SIZE', 250);
		define ('CACHE_CLEAR', 5);
		define ('VERSION', '1.14');
		define ('DIRECTORY_CACHE', APPPATH.'cache');
		define ('DIRECTORY_TEMP',  APPPATH.'cache');
	}

/*
$sizeLimits = array(
    "100x100",
    "150x150",
);

error_reporting(E_ALL);
ini_set("display_errors", 1); 
*/
	function index(){
                //echo APPPATH.'cache/';
		// check to see if GD function exist
		if(!function_exists('imagecreatetruecolor')) {
		    $this->_displayError('GD Library Error: imagecreatetruecolor does not exist - please contact your webhost and ask them to install the GD library');
		}

		$src 		= preg_replace("/[^0-9a-zA-Z.]+/", '', $this->uri->segment('3',0));
		$new_width      = preg_replace("/[^0-9]+/", '', $this->uri->segment('4',0));
		$new_height     = preg_replace("/[^0-9]+/", '', $this->uri->segment('5',0));
		$zoom_crop      = preg_replace("/[^0-9]+/", '', $this->uri->segment('6',0));
		$quality        = preg_replace("/[^0-9]+/", '', $this->uri->segment('7',0));
		$filters        = $this->uri->segment('8',0);
		$sharpen        = $this->uri->segment('9',0);

		// sort out image source
		$src = "/assets/product/" . $src;
		if($src == '' || strlen($src) <= 3) {
		    $this->_displayError ('no image specified');
		}

		$settings_hash = md5($src . $new_width . $new_height . $zoom_crop . $quality . $filters . $sharpen);

		if (function_exists('imagefilter') && defined('IMG_FILTER_NEGATE')) {
			$imageFilters = array(
				"1" => array(IMG_FILTER_NEGATE, 0),
				"2" => array(IMG_FILTER_GRAYSCALE, 0),
				"3" => array(IMG_FILTER_BRIGHTNESS, 1),
				"4" => array(IMG_FILTER_CONTRAST, 1),
				"5" => array(IMG_FILTER_COLORIZE, 4),
				"6" => array(IMG_FILTER_EDGEDETECT, 0),
				"7" => array(IMG_FILTER_EMBOSS, 0),
				"8" => array(IMG_FILTER_GAUSSIAN_BLUR, 0),
				"9" => array(IMG_FILTER_SELECTIVE_BLUR, 0),
				"10" => array(IMG_FILTER_MEAN_REMOVAL, 0),
				"11" => array(IMG_FILTER_SMOOTH, 0),
			);
		}

		// clean params before use
		$src = $this->_cleanSource($src);
		// last modified time (for caching)
		$lastModified = filemtime($src);

		if ($new_width == 0 && $new_height == 0) {
		    $new_width = 100;
		    $new_height = 100;
		}

		// get mime type of src
		$mime_type = $this->_mime_type($src);

		// check to see if this image is in the cache already
		$this->_check_cache ($mime_type,$settings_hash);

		// if not in cache then clear some space and generate a new file
		$this->_cleanCache();

		//ini_set('memory_limit', '50M');

		// make sure that the src is gif/jpg/png
		if(!$this->_valid_src_mime_type($mime_type)) {
		    $this->_displayError('Invalid src mime type: ' . $mime_type);
		}

		if(strlen($src) && file_exists($src)) {

		    // open the existing image
		    $image = $this->_open_image($mime_type, $src);
		    if($image === false) {
			$this->_displayError('Unable to open image : ' . $src);
		    }

		    // Get original width and height
		    $width = imagesx($image);
		    $height = imagesy($image);
    
		    // generate new w/h if not provided
		    if( $new_width && !$new_height ) {
			$new_height = $height * ( $new_width / $width );
		    } elseif($new_height && !$new_width) {
			$new_width = $width * ( $new_height / $height );
		    } elseif(!$new_width && !$new_height) {
			$new_width = $width;
			$new_height = $height;
		    }

		    // create a new true color image
		    $canvas = imagecreatetruecolor( $new_width, $new_height );
		    imagealphablending($canvas, false);
		    // Create a new transparent color for image
		    $color = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
		    // Completely fill the background of the new image with allocated color.
		    imagefill($canvas, 0, 0, $color);
		    // Restore transparency blending
		    imagesavealpha($canvas, true);

		    if( $zoom_crop ) {

			$src_x = $src_y = 0;
			$src_w = $width;
			$src_h = $height;

			$cmp_x = $width  / $new_width;
			$cmp_y = $height / $new_height;

			// calculate x or y coordinate and width or height of source
			if ( $cmp_x > $cmp_y ) {
			    $src_w = round( ( $width / $cmp_x * $cmp_y ) );
			    $src_x = round( ( $width - ( $width / $cmp_x * $cmp_y ) ) / 2 );
			} elseif ( $cmp_y > $cmp_x ) {
			    $src_h = round( ( $height / $cmp_y * $cmp_x ) );
			    $src_y = round( ( $height - ( $height / $cmp_y * $cmp_x ) ) / 2 );
			}
        
			imagecopyresampled( $canvas, $image, 0, 0, $src_x, $src_y, $new_width, $new_height, $src_w, $src_h );
		    } else {

			// copy and resize part of an image with resampling
			imagecopyresampled( $canvas, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
		    }
    
		    if ($filters != '' && function_exists('imagefilter') && defined('IMG_FILTER_NEGATE')) {
			// apply filters to image
			$filterList = explode("|", $filters);
			foreach($filterList as $fl) {
			    $filterSettings = explode(",", $fl);
			    if(isset($imageFilters[$filterSettings[0]])) {
            
				for($i = 0; $i < 4; $i ++) {
				    if(!isset($filterSettings[$i])) {
					$filterSettings[$i] = null;
				    }
				}
                
				switch($imageFilters[$filterSettings[0]][1]) {
                
				    case 1:
				    
					imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1]);
					break;
				    
				    case 2:
				    
					imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1], $filterSettings[2]);
					break;
				    
				    case 3:
				    
					imagefilter($canvas, $imageFilters[$filterSettings[0]][0], $filterSettings[1], $filterSettings[2], $filterSettings[3]);
					break;
				    
				    default:
				    
					imagefilter($canvas, $imageFilters[$filterSettings[0]][0]);
					break;
					
				}
			    }
			}
		    }
			
		if ($sharpen > 0 && function_exists('imageconvolution')) {
	
		$sharpenMatrix = array(
			array(-1,-1,-1),
			array(-1,16,-1),
			array(-1,-1,-1),
		);
		$divisor = 8;
		$offset = 0;

		imageconvolution($canvas, $sharpenMatrix, $divisor, $offset);
	
	}
    
    // output image to browser based on mime type
    $this->_show_image($mime_type, $canvas,$quality,$settings_hash);
    
    // remove image from memory
    imagedestroy($canvas);
    
} else {

    if (strlen($src)) {
        $this->_displayError ('image ' . $src . ' not found');
    } else {
        $this->_displayError ('no source specified');
    }
    
}

/**
 * 
 */


/**
 * 
 */

/**
 * 
 */


/**
 * clean out old files from the cache
 * you can change the number of files to store and to delete per loop in the defines at the top of the code
 */



/**
 * compare the file time of two files
 */
function filemtime_compare($a, $b) {

    return filemtime($a) - filemtime($b);
    
}


/**
 * determine the file mime type
 */



/**
 * 
 */



/**
 * 
 */



/**
 * 
 */



/**
 * 
 */



/**
 * check to if the url is valid or not
 */
function valid_extension ($ext) {

    if (preg_match("/jpg|jpeg|png|gif/i", $ext)) {
        return TRUE;
    } else {
        return FALSE;
    }
    
}


/**
 *
 */



/**
 * tidy up the image source url
 */



/**
 * 
 */



/**
 * generic error message
 */
	}

	function _displayError ($errorString = '') {
	    header('HTTP/1.1 400 Bad Request');
		echo '<pre>' . $errorString . '<br />TimThumb version : ' . VERSION . '</pre>';
	    die();
	}

function _get_request( $property, $default = 0 ) {
    
    if( isset($_REQUEST[$property]) ) {
    
        return $_REQUEST[$property];
        
    } else {
    
        return $default;
        
    }
    
}

function _cleanSource($src) {

	$host = str_replace('www.', '', $_SERVER['HTTP_HOST']);
	$regex = "/^((ht|f)tp(s|):\/\/)(www\.|)" . $host . "/i";
	
	$src = preg_replace ($regex, '', $src);
	$src = strip_tags ($src);
    $src = $this->_checkExternal ($src);
    
    // remove slash from start of string
    if (strpos($src, '/') === 0) {
        $src = substr ($src, -(strlen($src) - 1));
    }

    // don't allow users the ability to use '../' 
    // in order to gain access to files below document root
    $src = preg_replace("/\.\.+\//", "", $src);
    
    // get path to image on file system
    $src = $this->_get_document_root($src) . '/' . $src;

    return $src;

}

function _mime_type($file) {

    if (stristr(PHP_OS, 'WIN')) { 
        $os = 'WIN';
    } else { 
        $os = PHP_OS;
    }

    $mime_type = '';

    if (function_exists('mime_content_type') && $os != 'WIN') {
        $mime_type = mime_content_type($file);
    }
    
	// use PECL fileinfo to determine mime type
	if (!$this->_valid_src_mime_type($mime_type)) {
		if (function_exists('finfo_open')) {
			$finfo = @finfo_open(FILEINFO_MIME);
			if ($finfo != ''){
				$mime_type = finfo_file($finfo, $file);
				finfo_close($finfo);
			}
		}
	}

    // try to determine mime type by using unix file command
    // this should not be executed on windows
    if (!$this->_valid_src_mime_type($mime_type) && $os != "WIN") {
        if (preg_match("/FreeBSD|FREEBSD|LINUX/", $os)) {
			$mime_type = trim(@shell_exec('file -bi ' . escapeshellarg($file)));
        }
    }

    // use file's extension to determine mime type
    if (!$this->_valid_src_mime_type($mime_type)) {

        // set defaults
        $mime_type = 'image/png';
        // file details
        $fileDetails = pathinfo($file);
        print_r($fileDetails);exit;
        $ext = strtolower($fileDetails["extension"]);
        // mime types
        $types = array(
             'jpg'  => 'image/jpeg',
             'jpeg' => 'image/jpeg',
             'png'  => 'image/png',
             'gif'  => 'image/gif'
         );
        
        if (strlen($ext) && strlen($types[$ext])) {
            $mime_type = $types[$ext];
        }
        
    }
    
    return $mime_type;

}

function _open_image($mime_type, $src) {

	$mime_type = strtolower($mime_type);
	
    if (stristr ($mime_type, 'gif')) {
    
        $image = imagecreatefromgif($src);
        
    } elseif (stristr($mime_type, 'jpeg')) {
    
        @ini_set ('gd.jpeg_ignore_warning', 1);
        $image = imagecreatefromjpeg($src);
        
    } elseif (stristr ($mime_type, 'png')) {
    
        $image = imagecreatefrompng($src);
        
    }
    
    return $image;

}

function _cleanCache() {

    $files = glob("cache/*", GLOB_BRACE);
    
    if (count($files) > 0) {
    
        $yesterday = time() - (24 * 60 * 60);
        
        usort($files, 'filemtime_compare');
        $i = 0;
        
        if (count($files) > CACHE_SIZE) {
            
            foreach ($files as $file) {
                
                $i ++;
                
                if ($i >= CACHE_CLEAR) {
                    return;
                }
                
                if (@filemtime($file) > $yesterday) {
                    return;
                }
                
				if (file_exists($file)) {
					unlink($file);
				}
                
            }
            
        }
        
    }

}

function _check_cache ($mime_type,$settings_hash) {

    // make sure cache dir exists
    if (!file_exists(DIRECTORY_CACHE)) {
        // give 777 permissions so that developer can overwrite
        // files created by web server user
        mkdir(DIRECTORY_CACHE);
        chmod(DIRECTORY_CACHE, 0777);
    }
    $this->_show_cache_file ($mime_type,$settings_hash);
}

function _show_cache_file ($mime_type,$settings_hash) {

    $cache_file = DIRECTORY_CACHE . '/' . $this->_get_cache_file($settings_hash);

    if (file_exists($cache_file)) {
        
        $gmdate_mod = gmdate("D, d M Y H:i:s", filemtime($cache_file));
        
        if(! strstr($gmdate_mod, "GMT")) {
            $gmdate_mod .= " GMT";
        }
        
        if (isset($_SERVER["HTTP_IF_MODIFIED_SINCE"])) {
        
            // check for updates
            $if_modified_since = preg_replace ("/;.*$/", "", $_SERVER["HTTP_IF_MODIFIED_SINCE"]);
            
            if ($if_modified_since == $gmdate_mod) {
                header("HTTP/1.1 304 Not Modified");
                die();
            }

        }
        
		clearstatcache();
        $fileSize = filesize ($cache_file);
        
        // send headers then display image
        header ('Content-Type: ' . $mime_type);
        header ('Accept-Ranges: bytes');
        header ('Last-Modified: ' . $gmdate_mod);
        header ('Content-Length: ' . $fileSize);
        header ('Cache-Control: max-age=9999, must-revalidate');
        header ('Expires: ' . $gmdate_mod);
        
        readfile ($cache_file);
        
        die();

    }
}

function _get_cache_file($settings_hash) {

    global $lastModified;
    static $cache_file;
    
    if (!$cache_file) {
        $cachename = $_SERVER['QUERY_STRING'] . VERSION . $lastModified;
        $cache_file = md5($cachename . $settings_hash) . '.png';
    }
    return $cache_file;
}

function _valid_src_mime_type($mime_type) {

    if (preg_match("/jpg|jpeg|gif|png/i", $mime_type)) {
        return true;
    }
    
    return false;

}

function _checkExternal ($src) {

    $allowedSites = array(
        'flickr.com',
        'picasa.com',
        'blogger.com',
        'wordpress.com',
        'img.youtube.com',
    );

    if (preg_match('/http:\/\//', $src) == true) {
    
        $url_info = parse_url ($src);
        
        $isAllowedSite = false;
        foreach ($allowedSites as $site) {
			$site = '/' . addslashes($site) . '/';
            if (preg_match($site, $url_info['host']) == true) {
                $isAllowedSite = true;
            }
		}
        
		if ($isAllowedSite) {
		
			$fileDetails = pathinfo($src);
			$ext = strtolower($fileDetails['extension']);
			
			$filename = md5($src);
			$local_filepath = DIRECTORY_TEMP . '/' . $filename . '.' . $ext;
            
            if (!file_exists($local_filepath)) {
                
                if (function_exists('curl_init')) {
                
                    $fh = fopen($local_filepath, 'w');
                    $ch = curl_init($src);
                    
                    curl_setopt($ch, CURLOPT_URL, $src);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
					curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');
                    curl_setopt($ch, CURLOPT_FILE, $fh);
					
					if (curl_exec($ch) === FALSE) {
						if (file_exists($local_filepath)) {
							unlink($local_filepath);
						}
						$this->_displayError('error reading file ' . $src . ' from remote host: ' . curl_error($ch));
					}
					
					curl_close($ch);
					fclose($fh);

                } else {
            
                    if (!$img = file_get_contents($src)) {
                        $this->_displayError('remote file for ' . $src . ' can not be accessed. It is likely that the file permissions are restricted');
                    }
                    
                    if (file_put_contents($local_filepath, $img) == FALSE) {
                        $this->_displayError('error writing temporary file');
                    }
                    
                }
                
                if (!file_exists($local_filepath)) {
                    $this->_displayError('local file for ' . $src . ' can not be created');
                }
                
            }
            
            $src = $local_filepath;
            
        } else {
        
            $this->_displayError('remote host "' . $url_info['host'] . '" not allowed');
            
        }
        
    }
    
    return $src;
    
}

function _get_document_root ($src) {

    // check for unix servers
    if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $src)) {
        return $_SERVER['DOCUMENT_ROOT'];
    }

    // check from script filename (to get all directories to timthumb location)
    $parts = array_diff(explode('/', $_SERVER['SCRIPT_FILENAME']), explode('/', $_SERVER['DOCUMENT_ROOT']));
    $path = $_SERVER['DOCUMENT_ROOT'];
    foreach ($parts as $part) {
        $path .= '/' . $part;
        if (file_exists($path . '/' . $src)) {
            return $path;
        }
    }    
    
    // the relative paths below are useful if timthumb is moved outside of document root
    // specifically if installed in wordpress themes like mimbo pro:
    // /wp-content/themes/mimbopro/scripts/timthumb.php
    $paths = array(
        ".",
        "..",
        "../..",
        "../../..",
        "../../../..",
        "../../../../.."
    );
    
    foreach ($paths as $path) {
        if(file_exists($path . '/' . $src)) {
            return $path;
        }
    }
    
    // special check for microsoft servers
    if (!isset($_SERVER['DOCUMENT_ROOT'])) {
        $path = str_replace("/", "\\", $_SERVER['ORIG_PATH_INFO']);
        $path = str_replace($path, "", $_SERVER['SCRIPT_FILENAME']);
        
        if (file_exists($path . '/' . $src)) {
            return $path;
        }
    }
    
    $this->_displayError('file not found ' . $src);

}

function _show_image($mime_type, $image_resized, $quality, $settings_hash) {

    // check to see if we can write to the cache directory
    $is_writable = 0;
    $cache_file_name = DIRECTORY_CACHE . '/' . $this->_get_cache_file($settings_hash);

    if (touch($cache_file_name)) {
        
        // give 666 permissions so that the developer 
        // can overwrite web server user
        chmod ($cache_file_name, 0666);
        $is_writable = 1;
        
    } else {
        
        $cache_file_name = NULL;
        header ('Content-type: ' . $mime_type);
        
    }

    switch ($mime_type) {
    
        case 'image/jpeg':
            imagejpeg($image_resized, $cache_file_name, $quality);
            break;
        
        default :
            $quality = floor ($quality * 0.09);
            imagepng($image_resized, $cache_file_name, $quality);
            
    }
    
    if ($is_writable) {
        $this->_show_cache_file ($mime_type,$settings_hash);
    }

    imagedestroy ($image_resized);
    
    $this->_displayError ('error showing image');

}

}

/* End of file timthumb.php */
/* Location: ./system/application/controllers/timthumb.php */
