<?php
include('connection.php');
if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{
		$lastname=$_POST["lastname"];
		$firstname=$_POST["firstname"];
		$middlename=$_POST["middlename"];
		$purok=$_POST["purok"];
		$barang=$_POST["barang"];
		$mobnum=$_POST["mobnum"];
		$bene_type=$_POST["bene_type"];
		$muni=$_POST["muni"];
		$gender=$_POST["gender"];
		$bday=$_POST["bday"];
		$province=$_POST["province"];
		$personnel=$_POST["personnel"];

		$other_id=$_POST["id_other"];
		$pagibig=$_POST["pagibig"];
		$phil=$_POST["phil"];

		$date=date('h:i:s a m/d/Y',time());
		$cdate=date('F j, Y',strtotime($date));
		$count=0;
		$count2=0;
		$count3=0;

		if($personnel!=''){
			$query3="SELECT name FROM personel";
			$statement3 = $connection->prepare($query3);
			$statement3->execute();
			$result3 = $statement3->fetchAll();
			foreach($result3 as $row3)
			{
				if(strtoupper($personnel)==strtoupper($row3["name"])){
					$count+=1;
				}
			}

			if($count==0){
				$query3="INSERT INTO personel(name) values('$personnel')";
				$statement3 = $connection->prepare($query3);
				$statement3->execute();
			}
		}
		if($bene_type!=''){
			$query2="SELECT description FROM beneficiary_type";
			$statement2 = $connection->prepare($query2);
			$statement2->execute();
			$result2 = $statement2->fetchAll();
			foreach($result2 as $row2)
			{
				if(strtoupper($bene_type)==strtoupper($row2["description"])){
					$count2+=1;
				}
			}
			if($count2==0){
				$query4="INSERT INTO beneficiary_type(description) values('$bene_type')";
				$statement4 = $connection->prepare($query4);
				$statement4->execute();
			}
		}

		if($lastname!=''&&$firstname!=''&&$middlename!=''){
			$query5="SELECT * FROM beneficiaries";
			$statement5 = $connection->prepare($query5);
			$statement5->execute();
			$result5 = $statement5->fetchAll();
			foreach($result5 as $row2)
			{
				if(strtoupper($lastname)==strtoupper($row2["lastname"])&&strtoupper($firstname)==strtoupper($row2["firstname"])){
					$count3+=1;
				}
			}
			if($count3==1){
				echo "Name are already exist in the System!!! please check the list of Beneficiaries";
			}else{
				if($other_id!='' || $pagibig!='' || $phil!=''){
					$statement = $connection->prepare("CALL beneficiary_data(@id_b,'$lastname','$firstname','$middlename','$purok','$barang','$mobnum','$bene_type','$muni','$gender','$bday','$province','$personnel','$date','$cdate','$other_id','$pagibig','$phil')");
					$result = $statement->execute();
					if(!empty($result))
					{
						echo 'Data Saved';
					}
					else{
						echo $result;
					}
				}else{
					$statement = $connection->prepare("CALL beneficiary_data(@id_b,'$lastname','$firstname','$middlename','$purok','$barang','$mobnum','$bene_type','$muni','$gender','$bday','$province','$personnel','$date','$cdate','','','')");
					$result = $statement->execute();
					if(!empty($result))
					{
						echo 'Data Saved';
					}
					else{
						echo $result;
					}
				}
				
			}

		}
		
		
	}
	
}

if(isset($_POST["coperation"]))
{
	if($_POST["coperation"] == "Save")
	{
		$lastname=$_POST["clastname"];
		$firstname=$_POST["cfirstname"];
		$middlename=$_POST["cmiddlename"];
		$purok=$_POST["cpurok"];
		$barang=$_POST["cbarang"];
		$mobnum=$_POST["cmobnum"];
		$bene_type=$_POST["cbene_type"];
		$muni=$_POST["cmuni"];
		$gender=$_POST["cgender"];
		$bday=$_POST["cbday"];
		$cprovince=$_POST["cprovince"];
		$personnel=$_POST["cpersonnel"];
		$id=$_POST["cuser_id"];
		$cid_other=$_POST["cid_other"];
		$pagibig=$_POST["cpagibig"];
		$phil=$_POST["cphil"];
		
		$statement = $connection->prepare(
			"UPDATE beneficiaries 
			SET firstname = '$firstname', lastname = '$lastname', middlename='$middlename', purok='$purok',
			barangay = '$barang',mobnum = '$mobnum',beneficiary_type='$bene_type',mucipality = '$muni',
			gender = '$gender',bday = '$bday',province = '$cprovince',personnel = '$personnel',other_id='$cid_other',pag_ibig='$pagibig',phil='$phil'
			WHERE id = '$id'
			"
		);
		$result = $statement->execute();
		if(!empty($result))
		{
			echo 'Data Updated';
		}
		else{
			echo 'Data wrong';
		}
	}
}

?>