<?php
error_reporting(0);
session_start();

if (!emtpy($_SESSION)) {
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

if (!empty($_POST['submit'])) {
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
            if ($_SESSION['reloadB'] == '') {
                $temp = array();
                foreach($_SESSION['farm']['Bunnies'] as $k) {
                    if (in_array($k, $_SESSION['farm']['bunnies_alive'])) {
                        $_SESSION['dead_bunnies'][count($_SESSION['feed'])][] = $k;
                    } else {
                        $temp[] = $k;
                    }
                }
                $_SESSION['farm']['Bunnies'] = $temp;
                $_SESSION['farm']['bunnies_alive'] = $temp;
            }
            $_SESSION['reloadB'] = 'N'
        }

        if (empty($_SESSION['farm']['bunnies_alive'])){
            $_SESSION['farm']['reloadB'] = 'Y';
            $_SESSION['farm']['bunnies_alive'] =$_SESSION['farm']['Bunnies'];    
        }

        if (count($_SESSION['feed']) == 10 || count($_SESSION['feed']) == 20 || 
        count($_SESSION['feed']) == 30 || count($_SESSION['feed']) == 40 || 
        count($_SESSION['feed']) == 50) {
            if ($_SESSION['reloadC'] == '') {
                $temp = array();
                foreach($_SESSION['farm']['Cows'] as $k) {
                    if (in_array($k, $_SESSION['farm']['cows_alive'])) {
                        $_SESSION['dead_cows'][count($_SESSION['feed'])][] = $k;
                    } else {
                        $temp[] = $k;
                    }
                }
                $_SESSION['farm']['Cows'] = $temp;
                $_SESSION['farm']['cows_alive'] = $temp;
            }
            $_SESSION['reloadC'] = 'N';
        }

        if(empty($_SESSION['farm']['cows_alive'])){
            $_SESSION['reloadC'] = 'Y';
            $_SESSION['farm']['cows_alive'] = $_SESSION['farm']['Bunnies'];
        }

        if ($_SESSION['feed'] == 15 || $_SESSION['feed'] == 30 || $_SESSION['feed'] == 45) {
            if ($_SESSION['reloadF'] == '') {
                $temp = array();
                foreach($_SESSION['farm']['Farmer'] as $k) {
                    if (in_array($k, $_SESSION['farm']['farmer_alive'])) {
                        $_SESSION['dead_farmer'][count($_SESSION['feed'])][] = $k;
                    } else {
                        $temp[] = $k;
                    }
                }
                $_SESSION['farm']['Farmer'] = $temp;
                $_SESSION['farm']['farmer_alive'] = $temp;
            }
            $_SESSION['reloadF'] = 'N';
        }

        if (empty($_SESSION['farm']['farmer_alive'])) {
            $_SESSION['reloadF'] = 'Y';
            $_SESSION['farm']['farmer_alive'] = $_SESSION['farm']['Farmer'];
        }

    } else {
        unset($_SESSION['farm']);
        $_SESSION['submit'] = 'disabled';
        $_SESSION['reload'] = '';
    }
}

if(count($_SESSION['feed']) == 50 || empty($_SESSION['farm'])) {
    $message = '';

    if (count($_SESSION['feed']) == 50) {
        if (empty($_SESSION['farm']['Bunnies']) || empty($_SESSION['farm']['Cows']) || empty($_SESSION['farm']['Farmer'])) {
            $_SESSION['result'] = 'You Lose the Game';
        } else {
            $_SESSION['result'] = 'You Won the Game';
        }
    }
    $_SESSION['result'] = 'disabled';
    $_SESSION['reload'] = '';
}
?>

<div style="width:100%;text-align:center;" ><h2>Farm Feeding Game</h2></div>
<form name="ReqFeedForm" id="ReqFeedForm" action="" method="POST" >
    <input type="submit" name="Submit" id="frm_submit" value="Feed.." <?php echo $_SESSION['submit']; ?>/>
    <input type="submit" name="Reload" id="Reload" value="Reload New Game.." <?php echo $_SESSION['reload']; ?>/>
</form>

<div><h4>No. Of Feeds : <?php echo (count($_SESSION['feed'])); ?></h4></div>
<div><?php echo $_SESSION['result']; ?></div>
<div>
	Farmer Died: <?php echo count($_SESSION['farm']['Farmer_died']); ?>
	Cow Died: <?php echo count($_SESSION['farm']['Cow_died']); ?>
	Bunny Died: <?php echo count($_SESSION['farm']['Bunny_died']); ?>
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

    <?php
        if (!empty($_SESSION['feed'])) {
            foreach($_SESSION['feed'] as $key) {
                $current_value = $key+1;

                $F = '';
                $C1 = '';
                $C2 = '';
                $B1 = '';
                $B2 = '';
                $B3 = '';
                $B4 = '';

                if ($key == 'F') {
                    $F = 'Y';
                }
                if ($key == 'C1') {
                    $C1 = 'Y';
                }
                if ($key == 'C2') {
                    $C2 = 'Y';
                }
                if ($key == 'B1') {
                    $B1 = 'Y';
                }
                if ($key == 'B2') {
                    $B2 = 'Y';
                }
                if ($key == 'B3') {
                    $B2 = 'Y';
                }
                if ($key == 'B4') {
                    $B2 = 'Y';
                }

                foreach($_SESSION['farm']['dead_bunnies'] as $key=>$Val ){
					if($key ==$current_value){
						foreach($Val as $dead_bunny){
							if($dead_bunny == 'B1'){
								$B1 ='<font color="red"><strong> X </strong></font>';
							}if($dead_bunny == 'B2'){
								$B2 ='<font color="red"><strong> X </strong></font>';
							}if($dead_bunny == 'B3'){
								$B3 ='<font color="red"><strong> X </strong></font>';
							}if($dead_bunny ==  'B4'){
								$B4 ='<font color="red"><strong> X </strong></font>';
							}
						}					
					}
                }
                
                foreach($_SESSION['farm']['dead_cows'] as $key=>$Val ){
					if($key ==$current_value){
						foreach($Val as $dead_cow){
							if($dead_cow == 'C1'){
								$C1 ='<font color="red"><strong> X </strong></font>';
							}if($dead_cow == 'C2'){
								$C2 ='<font color="red"><strong> X </strong></font>';
							}
						}					
					}
				}
				
				foreach($_SESSION['logs']['dead_farmer'] as $key=>$Val ){
					if($key ==$current_value){
						foreach($Val as $dead_farmer){
							if($dead_farmer == 'F1'){
								$F ='<font color="red"><strong> X </strong></font>';
							}
						}					
					}
				}
				
			?>

    <tr>
        <td><?php echo $current_value; ?></td>
        <td><?php echo $F; ?></td>
        <td><?php echo $C1; ?></td>
        <td><?php echo $C2; ?> </td>
        <td><?php echo $B1; ?></td>
        <td><?php echo $B2; ?></td>
        <td><?php echo $B3; ?></td>
        <td><?php echo $B4; ?></td>				
        
    </tr>
    <?php
            }
        }
    ?>

</table>