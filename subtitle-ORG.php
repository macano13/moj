<?php
include_once 'vendor/mantas-done/subtitles/src/Subtitles.php';
header('Content-Type: text/html; charset=utf-8');
require_once('config.php');

use \Done\Subtitles\Subtitles;

$fileName = '';
if (isset($_GET['srt'])) {
    $user = getUserFromSession();
    $userId = $user->id;
    $fileName = $_GET['srt'];
    if (!file_exists('uploads/' . $fileName)) {
        copy('uploads_iota/' . $fileName, 'uploads/' . $fileName);
    }
} else if (isset($_GET['subtitle'])) {
    $fileName = $_GET['subtitle'];
    $userId = $_GET['createdBy'];

    if (!file_exists("content/uploads/" . $userId . "/" . "temporary")) {
        mkdir("content/uploads/" . $userId . "/" . "temporary", 0777, true);
    }
    if (!file_exists('uploads/' . $fileName)) {
        if (!file_exists("content/uploads/" . $userId . "/temporary/" . $fileName)) {
            copy('content/uploads/' . $userId . '/' . $fileName, "content/uploads/" . $userId . "/temporary/" . $fileName);
            copy('content/uploads/' . $userId . '/' . $fileName, 'uploads/' . $fileName);
        } else {
            copy("content/uploads/" . $userId . "/temporary/" . $fileName, 'uploads/' . $fileName);
        }
    }
}
?>
<?php

// require_once(ABSPATH . '/code/post/upload-file-post.php');
require_once(ABSPATH . '/code/post/upload-translated-file.php');
include_once("code/template/header.php");

// header('Content-type: text/html; charset=UTF-8'); //chrome/
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Custom styles for this template -->

    <!-- Bootstrap core CSS -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-32" />

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>


    <script rel="preload" src="js/bootbox.min.js" as="script"></script>
    <style type="text/css">
        .loader {
            margin-left: 35% !important;
            margin-top: 10%;
            margin-bottom: 10%;

            align-content: center;
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 200px;
            height: 200px;
            -webkit-animation: spin 2s linear infinite;
            /* Safari */
            animation: spin 2s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <style type="text/css">
        #loaderModal {
            text-align: center;
            position: fixed;
            left: 50%;
            top: 65%;
            transform: translate(-50%, -50%);
        }
    </style>
    <style>
        #popup {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 99;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, .5);
            display: none;
        }

        #error-popup {
            width: 400px;
            height: 200px;
            position: fixed;
            z-index: 100;
            top: 50vh;
            left: 50%;
            background: #fff;
            transform: translate(-50%, -50%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        #error-popup>span {
            position: absolute;
            right: 8px;
            top: 5px;
            color: #ba0d0d;
            font-weight: 700;
            font-size: 20px;
        }

        #error-popup>span:hover {
            cursor: pointer;
        }

        #error-popup p {
            /*position: absolute;*/
            /*padding-left: 10px;*/
            /*padding-right: 10px;*/
            /*text-align: center;*/
            /*top: 50%;*/
            font-size: 20px;
            /*transform: translateY(-50%);*/
        }

        #error-popup p span {
            color: #ba0d0d;
            font-size: 30px;
            font-weight: 600;
        }

        .translated-sub {
            display: none;
        }

        #text-to-translate {
            visibility: hidden;
            position: absolute;
            top: 150px;
            height: calc(600px);
            overflow: scroll;
        }

        /*loader*/
        #loader {
            margin: auto;
            display: none;
            position: fixed;
            width: 100vw;
            height: 100vh;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: rgba(241, 242, 243, 0.6);
        }

        #loader h4 {
            font-size: 16px;
            letter-spacing: 10px;
            font-weight: 900;
        }

    .success-msg {
    max-width: 100%;
    border-radius: 5px;
    font-size: 15px;
    height: 40px;
    text-align: center;
    padding: 10px;
    background: green;
    color: white;
    font-weight: 600;
    display: none;
	
	animation:success-msg 0.5s 1;
    -webkit-animation:success-msg 0.5s 1;
    animation-fill-mode: forwards;
    
    animation-delay:7s;
    -webkit-animation-delay:6s; /* Safari and Chrome */
    -webkit-animation-fill-mode: forwards;
    
} 

@keyframes success-msg{
    from {opacity :1;}
    to {opacity :0;}
}

@-webkit-keyframes success-msg{
    from {opacity :1;}
    to {opacity :0;}
}
        }
    </style>
    <style type="text/css">
        iframe.goog-te-banner-frame {
            display: none !important;
        }
    </style>
    <style type="text/css">
        body {
            position: static !important;
            top: 0px !important;
        }

.goog-te-gadget .goog-te-combo {

     border-radius: 8px!important;
}
    </style>

</head>

<body onload="loadFunction()">
    <div id="popup">
        <div id="error-popup">
            <span id="cross">X</span>
            <p>Please select the language first</p>
        </div>
    </div>

    <div id="loader">
        <div>
            <img src="loader.svg" alt="">
            <h4 class="skiptranslate">TRANSLATING</h4>
        </div>
    </div>



    <div id="hiddden">
        <div class="to_be_hidden" id="button">

            <div>
                <div id="google_translate_element"></div>
                <br>
            </div>

            <div class="d-flex justify-content-between">
                
				<div class="translate-button notranslate">
				             <button  type="button" class="button translate-button" onclick="autoScroll()">
                            Translate Subtitle
                        </button>
						</div>
						<div class="center-buttons">
                <div class="notranslate buttons">
				
                    <div>
           

                        <button  type="button" class="button button-1 buttons" onclick="check()">Download
                        </button>
                        <button  type="button" class="button buttons" onclick="saveDraft()">Save as draft
                        </button>
                        <form action="subtitle.php" method="post" style="display:inline-block">
                            <input type="hidden" name="filePathUrl" id="filePathUrl" value="filePathUrl">
                            <button  type="submit" class="btn button save-button" disabled id="btnSaveSubtitle">
                                Save Subtitle
                            </button>
                        </form>
                    </div>
                </div>
				</div>
				<h4 class="skiptranslate success-msg">Subtitle Translated!</h4>
            </div>


        </div>
        <?php
        // $file = "uploads/$fileName";
        // $subtitles = Subtitles::load($file);
        // // print_r($subtitles);
        // // die();
        // $subs = $subtitles->srtArrContent();
        // foreach ($subs as $sub) {
        //     $test[] = json_encode($sub);
        // }
        // $value = json_encode($test);
        // // var_dump(gettype($subs));
        // // echo "<pre>";
        // // print_r(json_encode($test));
        // // die();
        ?>
        <script type="text/javascript">
            function loadFunction() {
                // var test = window.location.href;
                // var ex = test.split("=");
                // var testNew = [];
                // var testNew = '';
                // let targetSub = document.querySelectorAll('.target-sub');
                // // console.log(targetSub);
                // let translatedTexts = document.querySelectorAll('.translate-p');
                // // console.log(testNew);
                // let successMsg = document.querySelector('.success-msg');
                // var ok = [];
                // testNew.forEach(element => {
                //     ok = element;
                // });
                // console.log(ok);
                // var decode = Object.values(testNew);
                // for (const key in testNew[0]) {
                //     // if (Object.hasOwnProperty.call(testNew, key)) {

                //     //     const element = testNew[key];

                //     // }
                //     console.log(testNew[key]);
                // }
                // // console.log(targetSub);
                // decode.forEach((text, i) => {
                //     console.log(text);
                //     targetSub[i].content = text.conetent;
                // });
                // successMsg.style.display = 'block';
                // loader.style.display = 'none';
                // console.log(ex[1]);
                // $.ajax({
                //     type: "POST",
                //     url: "vendor/mantas-done/subtitles/src/Subtitles.php",
                //     data: {
                //         "file": "<?= 'uploads/' . $fileName ?>",
                //         // file: php_var,
                //         // subtitle: subtitle,
                //         // language: language,
                //         // author: author,
                //     },
                //     success: function(data) {
                //         // console.log("hello");
                //         console.log(data);

                //         // $("#loaderModal").remove();
                //         // alert(data);
                //         // setTimeout(function() {
                //         //     window.location = 'browse.php';
                //         // }, 10);
                //     },
                // });

                document.getElementById('button').style.display = 'block';
                <?php
                $file_name = $fileName;
                /*
				ini_set('MAX_EXECUTION_TIME', -1);
	
				define('SRT_STATE_SUBNUMBER', 0);
				define('SRT_STATE_TIME', 1);
				define('SRT_STATE_TEXT', 2);
				define('SRT_STATE_BLANK', 3);
	
				$lines = file("uploads/" . $file_name);
	
				$subs = array();
				$state = SRT_STATE_SUBNUMBER;
				$subNum = 0;
				$subText = '';
				$subTime = '';
	
				foreach ($lines as $line) {
					switch ($state) {
						case SRT_STATE_SUBNUMBER:
						if (trim($line) != '') {
							$subNum = trim($line);
							$state = SRT_STATE_TIME;
						}else{
							break;
						}
						break;
	
						case SRT_STATE_TIME:
							$subTime = trim($line);
							$state = SRT_STATE_TEXT;
							break;
	
						case SRT_STATE_TEXT:
							if (trim($line) == '') {
								$sub = new stdClass;
								$sub->number = $subNum;
								list($sub->startTime, $sub->stopTime) = explode(' --> ', $subTime);
								$sub->text = $subText;
								$subText = '';
								$state = SRT_STATE_SUBNUMBER;
	
								$subs[] = $sub;
							} else {
								$subText .= $line;
							}
							break;
					}
				}
	
				if ($state == SRT_STATE_TEXT) {
					// if file was missing the trailing newlines, we'll be in this
					// state here.  Append the last read text and add the last sub.
					$sub->text = $subText;
					$subs[] = $sub;
				}
  			  */
                ?>

                document.getElementById('table').style.display = 'block';
            }

            /*
			$('#blank').click(function() {
				Swal.fire('please select the desired language first')
			});

			$("body").on("change", "#google_translate_element select", function (e) {
			
				//$("#blank").replaceWith("<button style='margin-top:-5%' data-toggle='modal' class='btn btn-success' data-target='#exampleModal' onclick='lang1()'>Save To Database</button>");
				console.log('language selected');
				$('html, body').animate({
					scrollTop: $("#button").offset().top
				}, 1500);
				//scrollTo($('#trasrt'), 500);
			
				autoScroll();
			});

			var language = $('.goog-te-combo').val();
			$( document ).ready(function() {
				var language = $("select.goog-te-combo option:selected").text();
				console.log("lol: "+language);
				if(language != ''){
					$("#blank").replaceWith("<button style='margin-top:-5%' data-toggle='modal' class='btn btn-success' data-target='#exampleModal' onclick='lang1()'>Save To Database</button>");
				}else{

				}
			});
		  */
            let popup = document.getElementById('popup');
            let cross = document.getElementById('cross');
            cross.addEventListener('click', () => {
                popup.style.display = 'none';
            });
            popup.addEventListener('click', () => {
                popup.style.display = 'none';
            });

            function savetodatavase() {
                let filename = "<?php echo $fileName; ?>";
                let ext = filename.split('.');
                if (ext[ext.length - 1].toLowerCase() === 'srt') {
                    var language = $('.goog-te-combo').val();
                    console.log(language);

                    if (language == '') {
                        console.log('plz select language')
                        Swal.fire('Please select your language')
                    } else {
                        console.log('show');
                        var langPath = $("select.goog-te-combo option:selected").text();
                        document.getElementById("country").value = langPath;
                        $('.langinput').attr('value', langPath);
                        $('#exampleModal').modal('show')

                    }
                } else {
                    popup.style.display = 'block';
                }
            }

            function autoScroll() {
                console.log('hello');
                var language = $('.goog-te-combo').val();
                console.log(language);

                if (language == '') {
                    popup.style.display = 'block';
                    Swal.fire('Please select your language')
                } else {
                    // console.log('else');
                    // let targetSub = document.querySelectorAll('.target-sub');
                    // let translatedTexts = document.querySelectorAll('.translate-p');
                    //
                    // // console.log(targetSub);
                    // translatedTexts.forEach((text, i) => {
                    //     targetSub[i].textContent = text.textContent;
                    // });
                    const loader = document.querySelector('#loader');
                    var height = $('#text-to-translate').get(0).scrollHeight;
                    var time = height / 10;

                    loader.style.display = 'flex';
                    $("#text-to-translate").animate({
                        scrollTop: height
                    }, time);
                    $("#text-to-translate").animate({
                        scrollTop: 0
                    }, time);
                    console.log(time * 2);
                    setTimeout(function() {
                        // $('#text-to-translate').animate({scrollTop: 0}, 18900); // 1000 is the duration of the animation
                        let targetSub = document.querySelectorAll('.target-sub');
                        // console.log(targetSub);
                        let translatedTexts = document.querySelectorAll('.translate-p');
                        // console.log(translatedTexts);
                        let successMsg = document.querySelector('.success-msg');

                        // console.log(targetSub);
                        translatedTexts.forEach((text, i) => {
                            targetSub[i].textContent = text.textContent;
                        });
                        successMsg.style.display = 'block';
                        loader.style.display = 'none';
                    
                       
                   
                            var php_var = "uploads/<?php echo $file_name; ?>";
                            var table = document.getElementById('trasrt');
                            var jsonArr = [];
                            for (var i = 1, row; row = table.rows[i]; i++) {
                                var col = row.cells;
                                var jsonObj = {
                                    id: col[0].innerText,
                                    start: col[1].innerText,
                                    end: col[2].innerText,
                                    text: col[4].innerText

                                }

                                jsonArr.push(jsonObj);

                            }
                            var trasrt = JSON.stringify(jsonArr);
                            // console.log(trasrt);
                            $.ajax({
                                type: "POST",
                                url: "generate.php",
                                data: {
                                    data: trasrt,
                                    file: php_var
                                },
                                cache: false,

                                success: function(data) {
                                    console.log(data);
                                    document.getElementById("dnl").href = data;
                                    document.getElementById("filePathUrl").value = data;
                                    document.getElementById("btnSaveSubtitle").disabled = false;
                                }
                            });
                       



                    }, (time * 2));
                }
            }

            var smooth_scroll_to = function(element, target, duration) {
                target = Math.round(target);
                duration = Math.round(duration);
                if (duration < 0) {
                    return Promise.reject("bad duration");
                }
                if (duration === 0) {
                    element.scrollTop = target;
                    return Promise.resolve();
                }

                var start_time = Date.now();
                var end_time = start_time + duration;

                var start_top = element.scrollTop;
                var distance = target - start_top;

                var smooth_step = function(start, end, point) {
                    if (point <= start) {
                        return 0;
                    }
                    if (point >= end) {
                        return 1;
                    }
                    var x = (point - start) / (end - start);
                    return x * x * (3 - 2 * x);
                }

                return new Promise(function(resolve, reject) {
                    var previous_top = element.scrollTop;

                    var scroll_frame = function() {
                        if (element.scrollTop != previous_top) {
                            reject("interrupted");
                            return;
                        }

                        var now = Date.now();
                        var point = smooth_step(start_time, end_time, now);
                        var frameTop = Math.round(start_top + (distance * point));
                        element.scrollTop = frameTop;

                        if (now >= end_time) {
                            resolve();
                            return;
                        }

                        if (element.scrollTop === previous_top &&
                            element.scrollTop !== frameTop) {
                            resolve();
                            return;
                        }
                        previous_top = element.scrollTop;
                        setTimeout(scroll_frame, 0);
                    }
                    setTimeout(scroll_frame, 0);
                });
            }

            function googleTranslateElementInit() {
                new google.translate.TranslateElement({}, 'google_translate_element');
            }
        </script>

        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" rel="noreferrer"></script>
        <div class="to_be_hidden " id="table" style="overflow-y: scroll; height:600px;width: 80%;margin-top: 2%">

            <table id="trasrt" class="table table-bordered">
                <thead class="notranslate">
                    <tr>
                        <th width="5%">Id</th>
                        <th width="10%">Start Time</th>
                        <th width="10%">End Time</th>
                        <th width="35%">Orignal Text</th>
                        <th width="45%">Translated Text</th>
                    </tr>
                </thead>
                <?php
                function cp1250_to_utf2($text)
                {
                    $dict  = array(
                        chr(225) => 'á', chr(228) =>  'ä', chr(232) => 'č', chr(239) => 'ď',
                        chr(233) => 'é', chr(236) => 'ě', chr(237) => 'í', chr(229) => 'ĺ', chr(229) => 'ľ',
                        chr(242) => 'ň', chr(244) => 'ô', chr(243) => 'ó', chr(154) => 'š', chr(248) => 'ř',
                        chr(250) => 'ú', chr(249) => 'ů', chr(157) => 'ť', chr(253) => 'ý', chr(158) => 'ž',
                        chr(193) => 'Á', chr(196) => 'Ä', chr(200) => 'Č', chr(207) => 'Ď', chr(201) => 'É',
                        chr(204) => 'Ě', chr(205) => 'Í', chr(197) => 'Ĺ', chr(188) => 'Ľ', chr(210) => 'Ň',
                        chr(212) => 'Ô', chr(211) => 'Ó', chr(138) => 'Š', chr(216) => 'Ř', chr(218) => 'Ú',
                        chr(217) => 'Ů', chr(141) => 'Ť', chr(221) => 'Ý', chr(142) => 'Ž', chr(230) => 'æ',
                        chr(150) => '-', chr(240) => 'ð', chr(198) => 'Æ'
                    );
                    return strtr($text, $dict);
                }

                $file = "uploads/$fileName";
                $subtitles = Subtitles::load($file);
                $subs = $subtitles->srtArrContent();

                foreach ($subs as $sub) {

                ?>

                    <tbody>
                        <!-- <input type="hidden" name="test[]" id="code" value=" <?php echo $sub['content']; ?>"> -->
                        <tr>
                            <td class="notranslate">
                                <?php echo $sub['sl']; ?>

                            </td>
                            <td class="notranslate">
                                <?php echo $sub['start']; ?>
                            </td>
                            <td class="notranslate">
                                <?php echo $sub['end']; ?>
                            </td>
                            <td class="notranslate">
                                <?php

                                print_r((!mb_detect_encoding($sub['content'], 'utf-8', "windows-1251")) ? utf8_encode($sub['content']) : $sub['content']);
                                // print_r(mb_convert_encoding($sub['content'], 'UTF-8'));

                                ?>
                            </td>
                            <td class="notranslate target-sub" contenteditable="">
                                <?php

                                print_r((!mb_detect_encoding($sub['content'], 'utf-8', true)) ? utf8_encode($sub['content']) : $sub['content']);

                                ?>
                            </td>

                        </tr>
                    </tbody>
                <?php
                }
                ?>
            </table>
        </div>
    </div>
    <div id="text-to-translate">
        <?php foreach ($subs as $sub) : ?>
            <p class="translate-p"><?php echo $sub['content']; ?></p>
        <?php endforeach; ?>
    </div>

    <a id="dnl" href="" download hidden>
    </a>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog notranslate" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Subtitle Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Title:</label>
                            <input type="text" class="form-control" id="subtitle" value="<?php echo pathinfo($file_name, PATHINFO_FILENAME); ?>">
                            <label for="recipient-name" class="col-form-label" id="title_err" style="visibility: hidden"></label>
                        </div>
                        <!-- <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Language:</label>
                            <input type="text" class="form-control langinput" id="country" value="" readonly>
                            <select class="form-control langselect" aria-label="Language Translate Widget" id="country" style="display: none" required="true">
                                <option value="">Select Language</option>
                                <option value="English">English</option>
                                <option value="Afrikaans">Afrikaans</option>
                                <option value="Albanian">Albanian</option>
                                <option value="Amharic">Amharic</option>
                                <option value="Arabic">Arabic</option>
                                <option value="Armenian">Armenian</option>
                                <option value="Azerbaijani">Azerbaijani</option>
                                <option value="Basque">Basque</option>
                                <option value="Belarusian">Belarusian</option>
                                <option value="Bengali">Bengali</option>
                                <option value="Bosnian">Bosnian</option>
                                <option value="Bulgarian">Bulgarian</option>
                                <option value="Catalan">Catalan</option>
                                <option value="Cebuano">Cebuano</option>
                                <option value="Chichewa">Chichewa</option>
                                <option value="Chinese (Simplified)">Chinese (Simplified)</option>
                                <option value="Chinese (Traditional)">Chinese (Traditional)</option>
                                <option value="Corsican">Corsican</option>
                                <option value="Croatian">Croatian</option>
                                <option value="Czech">Czech</option>
                                <option value="Danish">Danish</option>
                                <option value="Dutch">Dutch</option>
                                <option value="Esperanto">Esperanto</option>
                                <option value="Estonian">Estonian</option>
                                <option value="Filipino">Filipino</option>
                                <option value="Finnish">Finnish</option>
                                <option value="French">French</option>
                                <option value="Frisian">Frisian</option>
                                <option value="Galician">Galician</option>
                                <option value="Georgian">Georgian</option>
                                <option value="German">German</option>
                                <option value="Greek">Greek</option>
                                <option value="Gujarati">Gujarati</option>
                                <option value="Haitian Creole">Haitian Creole</option>
                                <option value="Hausa">Hausa</option>
                                <option value="Hawaiian">Hawaiian</option>
                                <option value="Hebrew">Hebrew</option>
                                <option value="Hindi">Hindi</option>
                                <option value="Hmong">Hmong</option>
                                <option value="Hungarian">Hungarian</option>
                                <option value="Icelandic">Icelandic</option>
                                <option value="Igbo">Igbo</option>
                                <option value="Indonesian">Indonesian</option>
                                <option value="Irish">Irish</option>
                                <option value="Italian">Italian</option>
                                <option value="Japanese">Japanese</option>
                                <option value="Javanese">Javanese</option>
                                <option value="Kannada">Kannada</option>
                                <option value="Kazakh">Kazakh</option>
                                <option value="Khmer">Khmer</option>
                                <option value="Korean">Korean</option>
                                <option value="Kurdish (Kurmanji)">Kurdish (Kurmanji)</option>
                                <option value="Kyrgyz">Kyrgyz</option>
                                <option value="Lao">Lao</option>
                                <option value="Latin">Latin</option>
                                <option value="Latvian">Latvian</option>
                                <option value="Lithuanian">Lithuanian</option>
                                <option value="Luxembourgish">Luxembourgish</option>
                                <option value="Macedonian">Macedonian</option>
                                <option value="Malagasy">Malagasy</option>
                                <option value="Malay">Malay</option>
                                <option value="Malayalam">Malayalam</option>
                                <option value="Maltese">Maltese</option>
                                <option value="Maori">Maori</option>
                                <option value="Marathi">Marathi</option>
                                <option value="Mongolian">Mongolian</option>
                                <option value="Myanmar (Burmese)">Myanmar (Burmese)</option>
                                <option value="Nepali">Nepali</option>
                                <option value="Norwegian">Norwegian</option>
                                <option value="Pashto">Pashto</option>
                                <option value="Persian">Persian</option>
                                <option value="Polish">Polish</option>
                                <option value="Portuguese">Portuguese</option>
                                <option value="Punjabi">Punjabi</option>
                                <option value="Romanian">Romanian</option>
                                <option value="Russian">Russian</option>
                                <option value="Samoan">Samoan</option>
                                <option value="Scots Gaelic">Scots Gaelic</option>
                                <option value="Serbian">Serbian</option>
                                <option value="Sesotho">Sesotho</option>
                                <option value="Shona">Shona</option>
                                <option value="Sindhi">Sindhi</option>
                                <option value="Sinhala">Sinhala</option>
                                <option value="Slovak">Slovak</option>
                                <option value="Slovenian">Slovenian</option>
                                <option value="Somali">Somali</option>
                                <option value="Spanish">Spanish</option>
                                <option value="Sundanese">Sundanese</option>
                                <option value="Swahili">Swahili</option>
                                <option value="Swedish">Swedish</option>
                                <option value="Tajik">Tajik</option>
                                <option value="Tamil">Tamil</option>
                                <option value="Telugu">Telugu</option>
                                <option value="Thai">Thai</option>
                                <option value="Turkish">Turkish</option>
                                <option value="Ukrainian">Ukrainian</option>
                                <option value="Urdu">Urdu</option>
                                <option value="Uzbek">Uzbek</option>
                                <option value="Vietnamese">Vietnamese</option>
                                <option value="Welsh">Welsh</option>
                                <option value="Xhosa">Xhosa</option>
                                <option value="Yiddish">Yiddish</option>
                                <option value="Yoruba">Yoruba</option>
                                <option value="Zulu">Zulu</option>
                            </select>
                        </div> -->
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Author:</label>
                            <input type="text" readonly class="form-control" id="author" value="anonymous">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="savedb()" id="submit_button">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
	   <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>






</body>
<script type="text/javascript">
    function lang1() {
        var langPath = $("select.goog-te-combo option:selected").text();
        /*document.getElementById("country").options[document.getElementById("country").selectedIndex].text = langPath;
        document.getElementById("country").options[document.getElementById("country").selectedIndex].value = langPath;*/
        document.getElementById("country").value = langPath;
        // console.log(langPath);
        //$(".langinput").value = langPath;
        //$('input[type="text"][class="langinput"]').prop("value", "langPath");
        //$('.langinput').text(langPath);
        $('.langinput').attr('value', langPath);
        //$(".langinput").display = "inline";

    }
    /*function stoppedTyping(){
        if($('#subtitle').val().length > 1 && $('#country').val().length >0 ) {
            document.getElementById('submit_button').disabled = false;
        } else {
            document.getElementById('submit_button').disabled = true;
        }
    }
    function stoppedSelect(){
        if($('#subtitle').val().length > 1 && $('#country').val().length >0 ) {
            document.getElementById('submit_button').disabled = false;
        } else {
            document.getElementById('submit_button').disabled = true;
        }
    }*/

    function savedb() {
        $("#loaderModal").modal('show');
        var php_var = "<?php echo $file_name; ?>";
        var subtitle = document.getElementById('subtitle').value;
        var language = document.getElementById('country').value;
        var author = document.getElementById('author').value;
        var table = document.getElementById('trasrt');
        var jsonArr = [];
        for (var i = 1, row; row = table.rows[i]; i++) {
            var col = row.cells;
            var jsonObj = {
                id: col[0].innerText,
                start: col[1].innerText,
                end: col[2].innerText,
                text: col[4].innerText,

            };
            jsonArr.push(jsonObj);
        }

        var trasrt = JSON.stringify(jsonArr);
        $.ajax({
            type: "POST",
            url: "save_database.php",
            data: {
                data: trasrt,
                file: php_var,
                subtitle: subtitle,
                language: language,
                author: author,
            },
            cache: false,

            success: function(data) {
                console.log("hello");
                console.log(data);

                $("#loaderModal").remove();
                alert(data);
                setTimeout(function() {
                    window.location = 'browse.php';
                }, 10);
            },
        });
        $("#exampleModal").modal('hide');
    }

    function check() {
        var language = $('.goog-te-combo').val();
        if (language === '') {
            popup.style.display = 'block';
        } else {
            var php_var = "uploads/<?php echo $file_name; ?>";
            var table = document.getElementById('trasrt');
            var jsonArr = [];
            for (var i = 1, row; row = table.rows[i]; i++) {
                var col = row.cells;
                var jsonObj = {
                    id: col[0].innerText,
                    start: col[1].innerText,
                    end: col[2].innerText,
                    text: col[4].innerText

                }

                jsonArr.push(jsonObj);

            }
            var trasrt = JSON.stringify(jsonArr);
            // console.log(trasrt);
            $.ajax({
                type: "POST",
                url: "generate.php",
                data: {
                    data: trasrt,
                    file: php_var
                },
                cache: false,

                success: function(data) {
                    console.log(data);
                    document.getElementById("dnl").href = data;
                    document.getElementById('dnl').click();
                    document.getElementById("filePathUrl").value = data;
                    document.getElementById("btnSaveSubtitle").disabled = false;
                }
            });
        }
    }

    //saving Draft extend Functionality

    function saveFileForSaveDaft(path) {
        var fileename =  '<?php echo $fileName; ?>'
        console.log(fileename);
        $.ajax({
            type: "POST",
            url: "/save-draft-file.php",
            data: {
                filePathUrl: path,
                fileName: fileename,
            },
            cache: false,

            success: function(data) {
                alert("File is successfully saved!");
                console.log(data);
            },
            error: function(error) {
                console.log(error);
            }
            
        });
    }

    function saveDraftExtendFunc() {
        var language = $('.goog-te-combo').val();
        if (language === '') {
            popup.style.display = 'block';
        } else {
            var php_var = "uploads/<?php echo $file_name; ?>";
            var table = document.getElementById('trasrt');
            var jsonArr = [];
            for (var i = 1, row; row = table.rows[i]; i++) {
                var col = row.cells;
                var jsonObj = {
                    id: col[0].innerText,
                    start: col[1].innerText,
                    end: col[2].innerText,
                    text: col[4].innerText

                }

                jsonArr.push(jsonObj);

            }
            var trasrt = JSON.stringify(jsonArr);
            $.ajax({
                type: "POST",
                url: "generate.php",
                data: {
                    data: trasrt,
                    file: php_var
                },
                cache: false,

                success: function(data) {
                    document.getElementById("filePathUrl").value = data;
                    saveFileForSaveDaft(data)
                    document.getElementById("btnSaveSubtitle").disabled = false;
                }
            });
        }
    }
    // Saving file in user temporary folder
    function saveDraft() {
        var table = document.getElementById('trasrt');
        var jsonArr = [];
        for (var i = 1, row; row = table.rows[i]; i++) {
            var col = row.cells;
            var jsonObj = {
                id: col[0].innerText,
                start: col[1].innerText,
                end: col[2].innerText,
                text: col[4].innerText,

            };
            jsonArr.push(jsonObj);
        }

        var trasrt = JSON.stringify(jsonArr);

        // "content/uploads/".$userId."/temporary/".$fileName
        var fileName = '<?php echo "content/uploads/" . $userId . "/temporary/" . $fileName; ?>'
        $.ajax({
            type: "POST",
            url: "saveasdraft.php",
            data: {
                data: trasrt,
                file: fileName
            },
            cache: false,
            success: function(data) {
                let res = JSON.parse(data)
                if (res.status == 'success') {
                    saveDraftExtendFunc();
                } else {
                    alert("Something went wrong");
                }
            },
            error: function(error) {
                alert("Something went wrong");
            }
        });
    }
</script>
<script type="text/javascript">
    function new_file() {
        document.getElementsByClassName('to_be_hidden')[0].style.visibility = 'hidden';
        document.getElementsByClassName('to_be_hidden')[1].style.visibility = 'hidden';
        document.getElementById('to_be_shown').style.display = 'block';

    }
</script>
<script type="text/javascript">
    Dropzone.options.uploadWidget = {
        accept: function(file, done) {
            done();
            // var extension = file.name.split(".").slice(-1)[0];
            // if (extension == "srt") {
            //     done();
            // } else {
            //     done("Only  srt files are supported");
            // }
        },
        paramName: 'file',
        acceptedFiles: '.srt,.ass,.vtt,.stl,.sub,.sbv',
        maxFiles: 1,
        init: function() {
            this.on('success', function(file, resp) {
                window.location.href = '/uploads/subtitle.php?srt=' + file.name;


            });
        }
    };
</script>

</html>

<!-- /.content -->
<?php
include_once("code/template/footer.php");
?>