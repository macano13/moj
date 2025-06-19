<?php

//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

require_once('config.php');

include_once  'vendor/mantas-done/subtitles/src/Subtitles.php';
use \Done\Subtitles\Subtitles;

$user = getUserFromSession();

$userId = $user->id;
$createdby = $_GET['createdBy'];
$fil = $_GET['subtitle'];
$cnt = $_GET['cnt'];

$file = ABSPATH . '/content/uploads/' . $userId . '/' . $fil;

$subtitles = Subtitles::load($file);
                $subs = $subtitles->srtArrContent();

?>

<table cid="<?=$fil; ?>" id="trasrt_<?=$cnt ; ?>" class="table table-bordered">
                <thead class="notranslate">
                    <tr>
                        <th width="5%">Id</th>
                        <th width="10%">Start Time</th>
                        <th width="10%">End Time</th>
                        <th width="35%">Orignal Text</th>
                        <th width="45%">Translated Text</th>
                    </tr>
                </thead>
	<tbody>
<?php

foreach($subs as $sub){
	?>
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
                            <td class="translate target-sub" contenteditable="">
                                <?php

                                print_r((!mb_detect_encoding($sub['content'], 'utf-8', true)) ? utf8_encode($sub['content']) : $sub['content']);

                                ?>
                            </td>

                        </tr>

<?php


}
?>
</tbody>
</table>

