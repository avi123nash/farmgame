<?php
error_reporting(0);
session_start();

if(!emtpy($_SESSION)) {
    $_SESSION['farm']['Bunnies'] = array('B1', 'B2', 'B3', 'B4');
    $_SESSION['farm']['Cows'] = array('C1', 'C2');
    $_SESSION['farm']['Farmer'] = array('F');
    $_SESSION['farm']['bunnies_alive'] = array('B1', 'B2', 'B3', 'B4');
    $_SESSION['farm']['dead_bunnies'];
    $_SESSION['farm']['cows_alive'] = array('C1', 'C2');
    $_SESSION['farm']['dead_cows'];
    $_SESSION['farm']['farmer_alive'] = array('F');
    $_SESSION['reloadB'] = 'N';
    $_SESSION['reloadC'] = 'N';
    $_SESSION['reloadF'] = 'N';
    $_SESSION['submit'] = '';
    $_SESSION['reload'] = 'disabled';
}

if(!empty($_POST['submit'])) {
    function generate_random_feed() {
        
        $initial_array = ("F" => "F", "B" => "B", "C" => "C");

        if (empty($_SESSION['farm']['Bunnies'])) {
            unset($my_array['B']);
            $_SESSION['submit'] = 'disabled';
            $_SESSION['reload'] = '';
            $_SESSION['result'] = 'You lose the Game';
        }

        if (empty($_SESSION['farm']['Cows'])) {
            unset($my_array['C']);
            $_SESSION['submit'] = 'disabled';
            $_SESSION['reload'] = '';
            $_SESSION['result'] = 'You lose the Game';
        }

        if (empty($_SESSION['farm']['Farmer'])) {
            unset($my_array['F']);
            $_SESSION['submit'] = 'disabled';
            $_SESSION['reload'] = '';
            $_SESSOION['result'] = 'You lose the Game';
        }

        shuffle($initial_array);

        if ($initial_array[0] == 'B') {
            return array_shift($_SESSION['farm']['bunnies_alive']);
        } else if ($initial_array[0] == 'C') {
            return array_shift($_SESSION['farm']['cows_alive']);
        } else {
            return array_shift($_SESSION['farm']['farmer_alive'])
        }
    }

    if (count($_SESSION['feed']) < 50) {
        $_SESSION['feed'] = generate_random_feed();

        if (count($_SESSION['feed']) == 8 || count($_SESSION['feed']) == 16 || count($_SESSION['feed']) == 24 || 
        count($_SESSION['feed']) == 32 || count($_SESSION['feed']) == 40 || count($_SESSION['feed']) == 48) {
            if($_SESSION['reloadB'] == '') {
                $temp = array();
                foreach($_SESSION['farm']['Bunnies'] as $k) {
                    if (in_array($k, $_SESSION['farm']['bunnies_alive'])) {
                        $_SESSION['dead_bunnies'][count($_SESSION['feed'])][] = $val;
                    } else {
                        $temp[] = $val;
                    }
                }
                $_SESSION['farm']['Bunnies'] = $temp;
                $_SESSION['farm']['bunnies_alive'] = $temp;
            }
            $_SESSION['reloadB'] = 'N'
        }
    }

}

?>

<div style="width:100%;text-align:center;" ><h2>Farm Feeding Game</h2></div>
<form name="ReqFeedForm" id="ReqFeedForm" action="" method="POST" >
    <input type="submit" name="Submit" id="frm_submit" value="Feed.." <?php echo $_SESSION['submit']; ?>/>
    <input type="submit" name="Reload" id="Reload" value="Reload New Game.." <?php echo $_SESSION['reload']; ?>/>
</form>

<div><h4>No. Of Feeds</h4></div>
<div>
	Farmer Died:
	Cow Died:
	Bunny Died:
</div>

<table>
    <tr>
        <td>Farmer</td>
        <td>Cow1</td>
        <td>Cow2</td>
        <td>Bunny1</td>
        <td>Bunny2</td>
        <td>Bunny3</td>
        <td>Bunny4</td>
    </tr>

</table>