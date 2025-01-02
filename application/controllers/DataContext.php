<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataContext extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->model('MCrewscv');
		$this->load->helper(array('form', 'url'));
	}

	function getDataByReq($slc = "",$dbNya = "",$whereNya = "",$orderNya = "",$groupNya = "",$limitNya = "")
	{
		$rsl = $this->MCrewscv->getData($slc,$dbNya,$whereNya,$orderNya,$groupNya,$limitNya);

		if(count($rsl) > 0)
		{
			return $rsl[0]->$slc;
		}else{
			return "";
		}
	}

	function getFullNameByIdPerson($idPerson = "")
	{
		$fullName = "";

		$sql = "SELECT TRIM(CONCAT(fname,' ',mname,' ' ,lname)) AS fullName
				FROM mstpersonal WHERE deletests = '0' AND idperson = '".$idPerson."' ";
		$rsl = $this->MCrewscv->getDataQuery($sql);

		if(count($rsl) > 0)
		{
			$fullName = $rsl[0]->fullName;
		}

		return $fullName;
	}

	function getMstPersonal($return = "",$whereNya = "")
	{
		$dataOut = array();

		$dataOut = $this->MCrewscv->getData("*","mstpersonal",$whereNya);

		if($return == "")
		{
			return $dataOut;
		}else{
			print json_encode($dataOut);
		}
	}

	function cekPersonOnVessel($idPerson = "")
	{
		$stPerson = "";

		$sql = "SELECT idcontract, idperson, CASE WHEN (signoffdt != '0000-00-00' AND signoffdt <= CURDATE()) THEN 'onleave' WHEN signoffdt = '0000-00-00' THEN 'onboard' END AS status
				FROM tblcontract 
				where idperson='".$idPerson."' AND deletests=0 ORDER BY idcontract DESC limit 0,1";
		$rsl = $this->MCrewscv->getDataQuery($sql);

		if(count($rsl) > 0)
		{
			$stPerson = $rsl[0]->status;
		}

		return $stPerson;
	}

	function getCityByOption($return = "",$typeVal = "")
	{
		$opt = "";

		$rsl = $this->MCrewscv->getData("*","tblkota","Deletests = '0'","NmKota ASC");

		foreach ($rsl as $key => $val)
		{
			if($typeVal == "name")
			{
				$opt .= "<option value=\"".$val->NmKota."\">".$val->NmKota."</option>";
			}
			if($typeVal == "kode")
			{
				$opt .= "<option value=\"".$val->KdKota."\">".$val->NmKota."</option>";
			}			
		}

		if($return == "")
		{
			return $opt;
		}else{
			print json_encode($opt);
		}
	}

	function getCountryByOption($return = "",$typeVal = "")
	{
		$opt = "";

		$rsl = $this->MCrewscv->getData("*","tblnegara","Deletests = '0'","NmNegara ASC");

		foreach ($rsl as $key => $val)
		{
			if($typeVal == "name")
			{
				$opt .= "<option value=\"".$val->NmNegara."\">".$val->NmNegara."</option>";
			}
			if($typeVal == "kode")
			{
				$opt .= "<option value=\"".$val->KdNegara."\">".$val->NmNegara."</option>";
			}			
		}

		if($return == "")
		{
			return $opt;
		}else{
			print json_encode($opt);
		}
	}

	function getVesselByOption($return = "",$typeVal = "",$searchNya = "")
	{
		$opt = "";

		$whereNya = "deletests = '0'";

		if($searchNya != "" AND $searchNya != "017")
		{
			$whereNya .= " AND kdcmp = '".$searchNya."' ";
		}

		$rsl = $this->MCrewscv->getData("*","mstvessel",$whereNya,"nmvsl ASC");

		foreach ($rsl as $key => $val)
		{
			if($typeVal == "name")
			{
				$opt .= "<option value=\"".$val->nmvsl."\">".$val->nmvsl."</option>";
			}
			if($typeVal == "kode")
			{
				$opt .= "<option value=\"".$val->kdvsl."\">".$val->nmvsl."</option>";
			}
		}

		if($return == "")
		{
			return $opt;
		}else{
			print json_encode($opt);
		}
	}

	function getRankByOption($return = "",$typeVal = "")
	{
		$opt = "";

		$rsl = $this->MCrewscv->getData("*","mstrank","deletests = '0'","nmrank ASC");
		foreach ($rsl as $key => $val)
		{
			if($typeVal == "name")
			{
				$opt .= "<option value=\"".$val->nmrank."\">".$val->nmrank."</option>";
			}
			if($typeVal == "kode")
			{
				$opt .= "<option value=\"".$val->kdrank."\">".$val->nmrank."</option>";
			}			
		}

		if($return == "")
		{
			return $opt;
		}else{
			print json_encode($opt);
		}
	}

	function getCompanyByOption($return = "",$typeVal = "")
	{
		$opt = "";

		$rsl = $this->MCrewscv->getData("*","mstcmprec","deletests = '0'","nmcmp ASC");

		foreach ($rsl as $key => $val)
		{
			if($typeVal == "name")
			{
				$opt .= "<option value=\"".$val->nmcmp."\">".$val->nmcmp."</option>";
			}
			if($typeVal == "kode")
			{
				$opt .= "<option value=\"".$val->kdcmp."\">".$val->nmcmp."</option>";
			}			
		}

		if($return == "")
		{
			return $opt;
		}else{
			print json_encode($opt);
		}
	}

	function getSignOffRemarkByOption($return = "",$typeVal = "")
	{
		$opt = "";

		$rsl = $this->MCrewscv->getData("*","mstremark","deletests = '0'","nmremark ASC");

		foreach ($rsl as $key => $val)
		{
			if($typeVal == "name")
			{
				$opt .= "<option value=\"".$val->nmremark."\">(".$val->nmremark.") ".$val->descremark."</option>";
			}
			if($typeVal == "kode")
			{
				$opt .= "<option value=\"".$val->kdremark."\">(".$val->nmremark.") ".$val->descremark."</option>";
			}			
		}

		if($return == "")
		{
			return $opt;
		}else{
			print json_encode($opt);
		}
	}

	function getVesselTypeByOption($return = "",$typeVal = "")
	{
		$opt = "";

		$whereNya = "Deletests = '0' AND NmType != ''";

		$rsl = $this->MCrewscv->getData("*","tbltype",$whereNya,"NmType ASC");

		foreach ($rsl as $key => $val)
		{
			if($typeVal == "name")
			{
				$opt .= "<option value=\"".$val->NmType."\">(".$val->NmType.") ".$val->DefType."</option>";
			}
			if($typeVal == "kode")
			{
				$opt .= "<option value=\"".$val->KdType."\">(".$val->NmType.") ".$val->DefType."</option>";
			}			
		}

		if($return == "")
		{
			return $opt;
		}else{
			print json_encode($opt);
		}
	}

	function getMstCertificateByOption($return = "")
	{
		$opt = "";

		$rsl = $this->MCrewscv->getData("*","mstcert","deletests = '0'","certgroup,certname ASC");
		foreach ($rsl as $key => $val)
		{
			$displayName = "(".$val->certgroup.") ".$val->certname;
			
			$opt .= "<option value=\"".$val->kdcert."\">".$displayName."</option>";
		}

		if($return == "")
		{
			return $opt;
		}else{
			print json_encode($opt);
		}
	}

	function getMstRankByOption($return = "")
	{
		$opt = "";

		$rsl = $this->MCrewscv->getData("*","mstrank","deletests = '0'","nmrank ASC");
		foreach ($rsl as $key => $val)
		{
			$opt .= "<option value=\"".$val->kdrank."\">".$val->nmrank."</option>";
		}

		if($return == "")
		{
			return $opt;
		}else{
			print json_encode($opt);
		}
	}

	function getMenuGeneralByOption($idPerson = "",$ref1 = "",$ref2 = "")
	{
		$dataOut = array();
		$opt = "";
		$opt1 = "";
		$opt2 = "";
		$opt .= "<option value=\"\">-</option>";

		$rsl = $this->MCrewscv->getData("*","tblrefcmp","deletests = '0' AND idperson = '".$idPerson."'","refcmp ASC");

		if(count($rsl) > 0)
		{
			foreach ($rsl as $key => $val)
			{
				$opt .= "<option value=\"".$val->idref."\">".$val->refcmp." (".$val->refpic.")"."</option>";
			}

			if($ref1 != "")
			{
				$opt1 .= "<option value=\"\">-</option>";
				foreach ($rsl as $key => $val)
				{
					$selNya = "";

					if($val->idref == $ref1)
					{
						$selNya = "selected=\"selected\"";
					}
					$opt1 .= "<option value=\"".$val->idref."\" ".$selNya.">".$val->refcmp." (".$val->refpic.")"."</option>";
				}
			}else{
				$opt1 = $opt;
			}

			if($ref2 != "")
			{
				$opt2 .= "<option value=\"\">-</option>";
				foreach ($rsl as $key => $val)
				{
					$selNya = "";

					if($val->idref == $ref2)
					{
						$selNya = "selected=\"selected\"";
					}
					$opt2 .= "<option value=\"".$val->idref."\" ".$selNya.">".$val->refcmp." (".$val->refpic.")"."</option>";
				}
			}else{
				$opt2 = $opt;
			}
		}

		$dataOut['ref1'] = $opt1;
		$dataOut['ref2'] = $opt2;

		return $dataOut;
	}

	function getReplacementByOption($idPerson = "",$signOnVsl = "",$return = "")
	{
		$opt = "";

		$opt .= "<option value=\"000000\"> - </option>";

		$sql = "SELECT A.idcontract,TRIM(CONCAT(B.fname,' ',B.mname,' ' ,B.lname)) AS fullName
				FROM tblcontract A
				LEFT JOIN mstpersonal B ON B.idperson = A.idperson
				AND A.idcontract IN (
					SELECT MAX(idcontract) AS idcontract
					FROM tblcontract
					WHERE deletests =0
					AND idperson = B.idperson
					)
				WHERE A.deletests=0 AND A.signoffdt = '0000-00-00' AND A.signonvsl = '".$signOnVsl."'
				GROUP BY A.idperson ORDER BY fullName ASC";

		$rsl = $this->MCrewscv->getDataQuery($sql);
		foreach ($rsl as $key => $val)
		{
			$opt .= "<option value=\"".$val->idcontract."\">".$val->fullName."</option>";
		}

		if($return == "")
		{
			return $opt;
		}else{
			print json_encode($opt);
		}
	}

	function menuTahun($thnmulai = "", $thnPilih = "")
	{
		$tahun = date("Y");
		$html="";
		$html.= "<option value=\"\"></option>";
		for($i = $tahun; $i >= $thnmulai; $i--)
		{
			$sel = "";
			if($thnPilih == $i)
			{
				$sel = "selected=\"selected\"";
			}
			$html.= "<option value=\"".$i."\" ".$sel.">".$i."</option>";	
		}
		return $html;
	}

	function getMaritalStatus($maritalstsid = "")
	{
		$opt = "";
		
		$arrayMaritalStatus = array("-", "Single", "Married", "Divorced", "Common Law Partner", "Widowed", "Separated");
		for($i = 0; $i < count($arrayMaritalStatus); $i++)
		{
			$sel = "";
			if($maritalstsid == $arrayMaritalStatus[$i])
			{
				$sel = "selected=\"selected\"";
			}
			$opt.= "<option value=\"".$arrayMaritalStatus[$i]."\" ".$sel.">".$arrayMaritalStatus[$i]."</option>";
		}
		return $opt;
	}

	function getReligion($religion = "")
	{
		$opt = "";
		
		$arrayReligion = array("-", "Buddha", "Catholic", "Christian", "Hindu", "Moeslem", "Others");
		for($i = 0; $i < count($arrayReligion); $i++)
		{
			$sel = "";
			if($religion == $arrayReligion[$i])
			{
				$sel = "selected=\"selected\"";
			}
			$opt.= "<option value=\"".$arrayReligion[$i]."\" ".$sel.">".$arrayReligion[$i]."</option>";
		}
		return $opt;
	}

	function getBloodType($golDrh = "")
	{
		$opt = "";
		
		$arrayBloodType = array("-", "A", "B", "O", "AB");
		for($i = 0; $i < count($arrayBloodType); $i++)
		{
			$sel = "";
			if($golDrh == $arrayBloodType[$i])
			{
				$sel = "selected=\"selected\"";
			}
			$opt.= "<option value=\"".$arrayBloodType[$i]."\" ".$sel.">".$arrayBloodType[$i]."</option>";
		}
		return $opt;
	}

	function getUkuran($ukuran = "")
	{
		$opt = "";
		
		$arrayUkuran = array("-", "S", "M", "L", "XL", "XXL", "XXXL", "XXXXL", "XXXXXL");
		for($i = 0; $i < count($arrayUkuran); $i++)
		{
			$sel = "";
			if($ukuran == $arrayUkuran[$i])
			{
				$sel = "selected=\"selected\"";
			}
			$opt.= "<option value=\"".$arrayUkuran[$i]."\" ".$sel.">".$arrayUkuran[$i]."</option>";
		}
		return $opt;
	}

	function getMainEngine($type = "")
	{
		$opt = "";
		
		$arrayUkuran = array("-", "Engine A", "Engine B");
		for($i = 0; $i < count($arrayUkuran); $i++)
		{
			$sel = "";
			if($type == $arrayUkuran[$i])
			{
				$sel = "selected=\"selected\"";
			}
			$opt.= "<option value=\"".$arrayUkuran[$i]."\" ".$sel.">".$arrayUkuran[$i]."</option>";
		}
		return $opt;
	}

	function getNewIdPerson($return = "")
	{
		$newIdPerson = "";

		$sql = "SELECT MAX(idperson)+1 AS idpersonmax FROM mstpersonal";
		$rsl = $this->MCrewscv->getDataQuery($sql);

		if(count($rsl) > 0)
		{
			$newIdPerson = $rsl[0]->idpersonmax;
		}

		if($return == "")
		{
			return $newIdPerson;
		}else{
			print json_encode($newIdPerson);
		}
	}

	function getVessel()
	{
		$dataOut = array();

		$dataOut = $this->MCrewscv->getData("*","mstvessel","deletests = '0' AND nmvsl != '' AND nmvsl != '-' ","nmvsl ASC");

		return $dataOut;
	}

	function getNewId($fieldId = "",$tbl = "",$whereNya = "")
	{
		$newId = "1";

		$sql = "SELECT MAX(".$fieldId.")+1 AS idNew FROM ".$tbl." ".$whereNya;
		$rsl = $this->MCrewscv->getDataQuery($sql);

		if(count($rsl) > 0)
		{
			if(!is_null($rsl[0]->idNew))
			{
				$newId = $rsl[0]->idNew;
			}
		}

		return $newId;
	}

	function uploadFile($tmpFile = "",$dir = "",$fileName = "",$newFileName = "")
	{
		$dt = explode(".", $fileName);
		$newFileName = str_replace(array(' ','/','.',',','-'), '', $newFileName).".".trim($dt[count($dt)-1]);
		move_uploaded_file($tmpFile, $dir."/".$fileName);
		rename($dir."/".$fileName, $dir."/".$newFileName);
		return $newFileName;
	}

	function hitungSelisihByHari($sDate = "",$eDate = "")
	{
		$dayNya = "";
		if($sDate != "" AND $eDate != "")
		{
			$tgl1 = new DateTime();
			$tgl2 = new DateTime($eDate);

			$dayNya = $tgl2->diff($tgl1);
			$dayNya = $dayNya->days;
		}

		return $dayNya;
	}
	
	function hitungSelisihCompleteByHari($sDate = "",$eDate = "")
	{
		$dayNya = "";

		if($sDate != "" AND $eDate != "")
		{
			$tgl1 = new DateTime($sDate);
			$tgl2 = new DateTime($eDate);

			$tempDay = $tgl2->diff($tgl1);

			if($tempDay->y > 0)
			{
				$dayNya .= $tempDay->y." Years ";
			}
			if($tempDay->m > 0)
			{
				$dayNya .= $tempDay->m." Months ";
			}
			if($tempDay->d > 0)
			{
				$dayNya .= $tempDay->d." Days ";
			}
		}

		return $dayNya;
	}

	function hitungSelisihByBulan($dateNya = "", $ttlBulan = "")
    {
    	$bulanNya = "";

    	if($dateNya != "" AND $ttlBulan != "")
    	{
	        $dates = new DateTime($dateNya);
			$timeNya = $dates->modify($ttlBulan.' month');
			
			$bulanNya = $timeNya->format('Y-m-d');
		}

        return $bulanNya;
    }

    function hitungUmur($dateNya = "")
    {
    	$umur = "";

    	if($dateNya != "" AND $dateNya != "0000-00-00")
    	{
    		$dateNya = new DateTime($dateNya);
	    	$todays = new DateTime();
	    	$hitUmur = $todays->diff($dateNya);
	    	$umur = $hitUmur->y;
	    }
	    return $umur;
    }

    function intervalBulan($tglSekarang, $month)
	{
		$sql = "SELECT DATE_ADD(".$tglSekarang.", INTERVAL ".$month." MONTH) AS hasil;";
		$rsl = $this->MCrewscv->getDataQuery($sql);
		
		return $rsl[0]->hasil;
	}

	function delFile($fileNya,$dir)
	{
		$dataDel = array();
		$dataOut = array();
		$de = explode(",",$fileNya);

		if(count($de) > 0)
		{
			for ($lan=0; $lan < count($de); $lan++)
			{
				unlink($dir."/".$de[$lan]);
				$dataDel[] = $de[$lan];
			}
		}
		if(count($dataDel) > 0)
		{
			for ($hal=0; $hal < count($dataDel) ; $hal++)
			{
				$do = explode("_", $dataDel[$hal]);
				$dl = explode(".", $do[1]);
				$dataOut[$dl[0]] = $dl[0];
			}
		}
		return $dataOut;
	}

	function convertReturnName($dateNya = "")
	{
		if($dateNya == "0000-00-00")
		{
			return "";
		}else{
			$dt = explode("-", $dateNya);
			$tgl = $dt[2];
			$bln = $dt[1];
			$thn = $dt[0];
			if($bln == "01" || $bln == "1"){ $bln = "Jan"; }
			else if($bln == "02" || $bln == "2"){ $bln = "Feb"; }
			else if($bln == "03" || $bln == "3"){ $bln = "Mar"; }
			else if($bln == "04" || $bln == "4"){ $bln = "Apr"; }
			else if($bln == "05" || $bln == "5"){ $bln = "Mei"; }
			else if($bln == "06" || $bln == "6"){ $bln = "Jun"; }
			else if($bln == "07" || $bln == "7"){ $bln = "Jul"; }
			else if($bln == "08" || $bln == "8"){ $bln = "Ags"; }
			else if($bln == "09" || $bln == "9"){ $bln = "Sep"; }
			else if($bln == "10"){ $bln = "Okt"; }
			else if($bln == "11"){ $bln = "Nov"; }
			else if($bln == "12"){ $bln = "Des"; }

			return $tgl." ".$bln." ".$thn;
		}
	}

	function convertReturnNameWithTime($dateNya = "")
	{
		$dataNya = explode(" ", $dateNya);
		$dt = explode("-", $dataNya[0]);
		$tgl = $dt[2];
		$bln = $dt[1];
		$thn = $dt[0];
		if($bln == "01" || $bln == "1"){ $bln = "Jan"; }
		else if($bln == "02" || $bln == "2"){ $bln = "Feb"; }
		else if($bln == "03" || $bln == "3"){ $bln = "Mar"; }
		else if($bln == "04" || $bln == "4"){ $bln = "Apr"; }
		else if($bln == "05" || $bln == "5"){ $bln = "Mei"; }
		else if($bln == "06" || $bln == "6"){ $bln = "Jun"; }
		else if($bln == "07" || $bln == "7"){ $bln = "Jul"; }
		else if($bln == "08" || $bln == "8"){ $bln = "Ags"; }
		else if($bln == "09" || $bln == "9"){ $bln = "Sep"; }
		else if($bln == "10"){ $bln = "Okt"; }
		else if($bln == "11"){ $bln = "Nov"; }
		else if($bln == "12"){ $bln = "Des"; }

		return $tgl." ".$bln." ".$thn." ".$dataNya[1];
	}

	function convertReturnBulanTglTahun($dateNya = "")
	{
		if($dateNya == "0000-00-00")
		{
			return "";
		}else{
			$dt = explode("-", $dateNya);
			$tgl = $dt[2];
			$bln = $dt[1];
			$thn = $dt[0];
			if($bln == "01" || $bln == "1"){ $bln = "Januari"; }
			else if($bln == "02" || $bln == "2"){ $bln = "Februari"; }
			else if($bln == "03" || $bln == "3"){ $bln = "Maret"; }
			else if($bln == "04" || $bln == "4"){ $bln = "April"; }
			else if($bln == "05" || $bln == "5"){ $bln = "Mei"; }
			else if($bln == "06" || $bln == "6"){ $bln = "Juni"; }
			else if($bln == "07" || $bln == "7"){ $bln = "Juli"; }
			else if($bln == "08" || $bln == "8"){ $bln = "Agustus"; }
			else if($bln == "09" || $bln == "9"){ $bln = "September"; }
			else if($bln == "10"){ $bln = "Oktober"; }
			else if($bln == "11"){ $bln = "November"; }
			else if($bln == "12"){ $bln = "Desember"; }

			return $bln." ".$tgl." ,".$thn;
		}
	}


}
