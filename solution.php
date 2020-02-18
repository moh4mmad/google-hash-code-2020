<?php

$pizza = new Pizza;
$fileNames = array("a_example", "b_small", "c_medium", "d_quite_big", "e_also_big");
foreach ($fileNames as $fileName)
{
	$pizza->Process($fileName);
}

class Pizza
{

	public function Solve($max, $inputList) {

        $solutionList = [];

   		$fullsize = count($inputList);
        $i = 0;
        $j = 0;
        $maxscore = 0;

        for ($j = $fullsize - 1; $j >= 0; $j--) {

            $size = $j;
            $sum = 0;
            $currentList = [];
			
            for ($i = $size; $i >= 0; $i--) {

                $currentValue = $inputList[$i];

                $tempSum = $sum + $currentValue;

                if ($tempSum == $max) {
                    $sum = $tempSum;
					array_push($currentList, $i);
                    break;
				} else if ($tempSum > $max) {
                    continue;
				} else if ($tempSum < $max) {
                    $sum = $tempSum;
					array_push($currentList, $i);
                    continue;
                }
            }

            if ($maxscore < $sum) {
                $maxscore = $sum;
                $solutionList = $currentList;
            }
        }

		echo 'Score = '.$maxscore."<br>";

        return $solutionList;
    }
	
	public function Process($fileName){

        echo("-----------------------<br>");
        echo($fileName);
        echo("<br>-----------------------<br>");
		$inputList = [];
        $fr = fopen('input/'.$fileName.'.in', "r");
		
        $line = "";
		$firstLine = fgets($fr);

        $vars = preg_split('/\s+/', $firstLine);

        $max = $vars[0];
        $num = $vars[1];

        while (($line = fgets($fr)) != null) {
            $letters = preg_split('/\s+/', $line);
            foreach ($letters as $letter) {
				if($letter == "") continue;
                array_push($inputList, $letter);
            }
        }

        fclose($fr);

        echo("INPUT : ");
        echo($max. " " .$num);
		echo("<br>");
		foreach ($inputList as $input) {
			echo($input. " ");
        }
		echo("<br>");
        $outputList = self::Solve($max, $inputList); 
		
		array_reverse($outputList);

        echo("Output : ");
		$outputfile = fopen('output/'.$fileName.'.out', "w") or die("Unable to open file!");
		$size = sizeof($outputList);
		echo $size."<br>";
		fwrite($outputfile, $size);
		fwrite($outputfile, "\n");
		foreach ($outputList as $output) {
			echo $output." ";
			fwrite($outputfile, $output." ");
        }
		fclose($outputfile);
		echo("<br>");
    }
	
}