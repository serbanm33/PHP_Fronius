<?PHP
class PHP_Fronius
{
/**
* Description:	Get data from Fronius Symo inverters equipped with Datamanager 2.0
* 				      This class implements Fronius Solar API v1
* Author: 		  Marius Șerban
*/
	public $Invertor_IP 	= 	'192.168.250.181';
	public $API_Version 	= 	'v1';
	public $Last_URL		=	null;

	public function GetAPIVersion(				$URL = NULL)
	{
		/**
		* Description:	Returns an array with the following structure: Array ( [APIVersion] => 1 [BaseURL] => /solar_api/v1/ [CompatibilityRange] => 1.5-16 )
		* Return:		    ARRAY
		*/
		if ($URL		!= NULL) {
			$URL 		= $this->Invertor_IP.$URL;
		} else {
			$URL 		= $this->Invertor_IP.'/solar_api/GetAPIVersion.cgi';
		}
		$CURL 			= curl_init($URL);
		curl_setopt($CURL, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($CURL, CURLOPT_RETURNTRANSFER , TRUE);
		$Return			= curl_exec($CURL);
		curl_close($CURL);
		$this->Last_URL	= $URL;
		
		return (json_decode($Return,TRUE));
	}
	public function GetInverterRealtimeData(	$Scope = 1, 		$URL = NULL, 		$DeviceID = NULL, $DataCollection = NULL)
	{
		/**
		* Description:	Returns an array with inverter real time data
		* $Scope:
		* 		          1 -> System
		* 		          2 -> Device
		* $DataCollection:
		* 				      1 -> CumulationInverterData
		* 				      2 -> CommonInverterData
		* 				      3 -> 3PInverterData
		* 				      4 -> MinMaxInverterData
		* Return:		    ARRAY or FALSE
		*/
		if ($URL							!= NULL) {
			$URL 							= $this->Invertor_IP.$URL;
		} else {
			$URL 							= $this->Invertor_IP.'/solar_api/'.$this->API_Version.'/GetInverterRealtimeData.cgi';
		}
		if ($Scope 							== 	1) {
			$URL 							= $URL.'?Scope=System';
		} elseif ($Scope					==	2) {
			$URL 							= $URL.'?Scope=Device';
			if (!is_null($DeviceID) AND is_numeric($DeviceID) AND ($DeviceID >= 0 AND $DeviceID <= 99)) {
				$URL						=	$URL.'&DeviceId='.$DeviceID;
				if ($DataCollection 		== 1) {
					$URL					=	$URL.'&DataCollection=CumulationInverterData';
				} elseif ($DataCollection 	== 2) {
					$URL					=	$URL.'&DataCollection=CommonInverterData';
				} elseif ($DataCollection 	== 3) {
					$URL					=	$URL.'&DataCollection=3PInverterData';
				} elseif ($DataCollection 	== 4) {
					$URL					=	$URL.'&DataCollection=MinMaxInverterData';
				} else {
					return FALSE;
				}
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
		$CURL 								= curl_init($URL);
		curl_setopt($CURL, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($CURL, CURLOPT_RETURNTRANSFER , TRUE);
		$Return								= curl_exec($CURL);
		curl_close($CURL);
		$this->Last_URL						= $URL;
		
		return (json_decode($Return,TRUE));
	}
	public function GetSensorRealtimeData(		$Scope = 1, 		$URL = NULL, 		$DeviceID = NULL, $DataCollection = 1)
	{
		/**
		* Description:	Returns an array with inverter real time data
		* $Scope:
		* 		          1 -> System
		* 		          2 -> Device
		* $DataCollection:
		* 				      1 -> NowSensorData
		* 				      2 -> MinMaxSensorData
		* Return:		    ARRAY or FALSE
		*/
		if ($URL				!= NULL) {
			$URL 				= $this->Invertor_IP.$URL;
		} else {
			$URL 				= $this->Invertor_IP.'/solar_api/'.$this->API_Version.'/GetSensorRealtimeData.cgi';
		}
		if ($Scope 				= 1) {
			$URL 				= $URL.'?Scope=System';
		} elseif ($Scope			==	2) {
			$URL 				= $URL.'?Scope=Device';
			if ($DeviceID		!= NULL AND is_numeric($DeviceID) AND ($DeviceID >=0 AND $DeviceID <= 9)) {
				$URL			=	$URL.'&DeviceId='.$DeviceID;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
		if ($DataCollection 	== 1) {
			$URL				=	$URL.'&DataCollection=NowSensorData';
		} elseif ($DataCollection == 2) {
			$URL				=	$URL.'&DataCollection=MinMaxSensorData';
		} else {
			return FALSE;
		}
		$CURL 					= curl_init($URL);
		curl_setopt($CURL, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($CURL, CURLOPT_RETURNTRANSFER , TRUE);
		$Return					= curl_exec($CURL);
		curl_close($CURL);
		$this->Last_URL			= $URL;

		return (json_decode($Return,TRUE));
	}
	public function GetStringRealtimeData(		$Scope = 1, 		$URL = NULL, 		$DeviceID = NULL, $DataCollection = 1, 		$TimePeriod = 3)
	{
		/**
		* Description:	Returns an array with inverter real time data
		* $Scope:
		* 		          1 -> System
		* 		          2 -> Device
		* $DataCollection:
		* 				      1 -> NowStringControlData
		* 				      2 -> LastErrorStringControlData
		* 				      3 -> CurrentSumStringControlData
		* $TimePeriod:
		* 				      1 -> Day
		* 				      2 -> Year
		* 				      3 -> Total
		* Return:		    ARRAY or FALSE
		*/
		if ($URL				!= NULL) {
			$URL 				= $this->Invertor_IP.$URL;
		} else {
			$URL 				= $this->Invertor_IP.'/solar_api/'.$this->API_Version.'/GetStringRealtimeData.cgi';
		}
		if ($Scope 				= 1) {
			$URL 				= $URL.'?Scope=System';
		} elseif ($Scope			==	2) {
			$URL 				= $URL.'?Scope=Device';
			if ($DeviceID		!= NULL AND is_numeric($DeviceID) AND ($DeviceID >=0 AND $DeviceID <= 199)) {
				$URL			=	$URL.'&DeviceId='.$DeviceID;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
		if ($DataCollection 	== 1) {
			$URL				=	$URL.'&DataCollection=NowStringControlData';
		} elseif ($DataCollection == 2) {
			$URL				=	$URL.'&DataCollection=LastErrorStringControlData';
		} elseif ($DataCollection == 3) {
			$URL				=	$URL.'&DataCollection=CurrentSumStringControlData';
		} else {
			return FALSE;
		}
		if ($TimePeriod == 1) {
			$URL				=	$URL.'&TimePeriod=Day';
		} elseif ($TimePeriod == 2) {
			$URL				=	$URL.'&TimePeriod=Year';
		} elseif ($TimePeriod == 3) {
			$URL				=	$URL.'&TimePeriod=Total';
		} else {
			return FALSE;
		}
		$CURL 					= curl_init($URL);
		curl_setopt($CURL, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($CURL, CURLOPT_RETURNTRANSFER , TRUE);
		$Return					= curl_exec($CURL);
		curl_close($CURL);
		$this->Last_URL			= $URL;

		return (json_decode($Return,TRUE));
	}
	public function GetLoggerInfo(				$URL = NULL)
	{
		/**
		* Description:	Returns an array with inverter logger info
		* Return:		    ARRAY
		*/
		if ($URL		!= NULL) {
			$URL 		= $this->Invertor_IP.$URL;
		} else {
			$URL 		= $this->Invertor_IP.'/solar_api/'.$this->API_Version.'/GetLoggerInfo.cgi';
		}
		$CURL 			= curl_init($URL);
		curl_setopt($CURL, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($CURL, CURLOPT_RETURNTRANSFER , TRUE);
		$Return			= curl_exec($CURL);
		curl_close($CURL);
		$this->Last_URL	= $URL;

		return (json_decode($Return,TRUE));
	}
	public function GetLoggerLEDInfo(			$URL = NULL)
	{
		/**
		* Description:	Returns an array with inverter logger LED info
		* Return:		    ARRAY
		*/
		if ($URL		!= NULL) {
			$URL 		= $this->Invertor_IP.$URL;
		} else {
			$URL 		= $this->Invertor_IP.'/solar_api/'.$this->API_Version.'/GetLoggerLEDInfo.cgi';
		}
		$CURL 			= curl_init($URL);
		curl_setopt($CURL, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($CURL, CURLOPT_RETURNTRANSFER , TRUE);
		$Return			= curl_exec($CURL);
		curl_close($CURL);
		$this->Last_URL	= $URL;

		return (json_decode($Return,TRUE));
	}
	public function GetInverterInfo(			$URL = NULL)
	{
		/**
		* Description:	Returns an array with inverter info
		* Return:		    ARRAY
		*/
		if ($URL		!= NULL) {
			$URL 		= $this->Invertor_IP.$URL;
		} else {
			$URL 		= $this->Invertor_IP.'/solar_api/'.$this->API_Version.'/GetInverterInfo.cgi';
		}
		$CURL 			= curl_init($URL);
		curl_setopt($CURL, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($CURL, CURLOPT_RETURNTRANSFER , TRUE);
		$Return			= curl_exec($CURL);
		curl_close($CURL);
		$this->Last_URL	= $URL;

		return (json_decode($Return,TRUE));
	}
	public function GetActiveDeviceInfo(		$DeviceClass = 7, 	$URL = NULL)
	{
		/**
		* Description:	Returns an array with device data
		* $DeviceClass:
		* 				      1 -> Inverter
  	* 				      2 -> Storage
		* 				      3 -> Ohmpilot
		* 				      4 -> SensorCard
		* 				      5 -> StringControl
		* 				      6 -> Meter
		* 				      7 -> System
		* Return:		    ARRAY or FALSE
		*/
		if ($URL				!= NULL) {
			$URL 				= $this->Invertor_IP.$URL;
		} else {
			$URL 				= $this->Invertor_IP.'/solar_api/'.$this->API_Version.'/GetActiveDeviceInfo.cgi';
		}
		if ($DeviceClass 		== 1) {
			$URL				=	$URL.'?DeviceClass=Inverter';
		} elseif ($DeviceClass 	== 2) {
			$URL				=	$URL.'?DeviceClass=Storage';
		} elseif ($DeviceClass 	== 3) {
			$URL				=	$URL.'?DeviceClass=Ohmpilot';
		} elseif ($DeviceClass 	== 4) {
			$URL				=	$URL.'?DeviceClass=SensorCard';
		} elseif ($DeviceClass 	== 5) {
			$URL				=	$URL.'?DeviceClass=StringControl';
		} elseif ($DeviceClass 	== 6) {
			$URL				=	$URL.'?DeviceClass=Meter';
		} elseif ($DeviceClass 	== 7) {
			$URL				=	$URL.'?DeviceClass=System';
		} else {
			return FALSE;
		}
		$CURL 					= curl_init($URL);
		curl_setopt($CURL, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($CURL, CURLOPT_RETURNTRANSFER , TRUE);
		$Return					= curl_exec($CURL);
		curl_close($CURL);
		$this->Last_URL			= $URL;

		return (json_decode($Return,TRUE));
	}
	public function GetMeterRealtimeData(		$Scope = 1, 		$DeviceID = NULL, 	$URL = NULL)
	{
		/**
		* Description:	Returns an array with meter data
		* $Scope:
		* 		          1 -> System
		* 		          2 -> Device
		* Return:		    ARRAY or FALSE
		*/
		if ($URL			!= NULL) {
			$URL 			= $this->Invertor_IP.$URL;
		} else {
			$URL 			= $this->Invertor_IP.'/solar_api/'.$this->API_Version.'/GetMeterRealtimeData.cgi';
		}
		if ($Scope			== 1) {
			$URL 			= $URL.'?Scope=System';
		} elseif ($Scope		== 2) {
			$URL 			= $URL.'?Scope=Device';
			if (!is_null($DeviceID) AND is_numeric($DeviceID) AND ($DeviceID >=0 AND $DeviceID <= 65535)) {
				$URL		=	$URL.'&DeviceId='.$DeviceID;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
		$CURL 				= curl_init($URL);
		curl_setopt($CURL, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($CURL, CURLOPT_RETURNTRANSFER , TRUE);
		$Return				= curl_exec($CURL);
		curl_close($CURL);
		$this->Last_URL		= $URL;

		return (json_decode($Return,TRUE));
	}
	private function GetStorageRealtimeData(	$Scope = 1, 		$DeviceID = NULL, 	$URL = NULL)
	{
		/**
		* Description:	Returns an array with storage data
		* $Scope:
		* 		          1 -> System
		* 		          2 -> Device
		* Return:		    ARRAY or FALSE
		*/
		if ($URL			!= NULL) {
			$URL 			= $this->Invertor_IP.$URL;
		} else {
			$URL 			= $this->Invertor_IP.'/solar_api/'.$this->API_Version.'/GetStorageRealtimeData.cgi';
		}
		if ($Scope			== 1) {
			$URL 			= $URL.'?Scope=System';
		} elseif ($Scope		== 2) {
			$URL 			= $URL.'?Scope=Device';
			if ($DeviceID	!= NULL AND is_numeric($DeviceID) AND ($DeviceID >=0 AND $DeviceID <= 65535)) {
				$URL		=	$URL.'&DeviceId='.$DeviceID;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
		$CURL 				= curl_init($URL);
		curl_setopt($CURL, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($CURL, CURLOPT_RETURNTRANSFER , TRUE);
		$Return				= curl_exec($CURL);
		curl_close($CURL);
		$this->Last_URL		= $URL;

		return (json_decode($Return,TRUE));
	}
	public function GetOhmPilotRealtimeData(	$Scope = 1, 		$DeviceID = NULL, 	$URL = NULL)
	{
		/**
		* Description:	Returns an array with OhmPilot real time data
		* $Scope:
		* 		          1 -> System
		* 		          2 -> Device
		* Return:		    ARRAY or FALSE
		*/
		if ($URL			!= NULL) {
			$URL 			= $this->Invertor_IP.$URL;
		} else {
			$URL 			= $this->Invertor_IP.'/solar_api/'.$this->API_Version.'/GetOhmPilotRealtimeData.cgi';
		}
		if ($Scope			== 1) {
			$URL 			= $URL.'?Scope=System';
		} elseif ($Scope		== 2) {
			$URL 			= $URL.'?Scope=Device';
			if ($DeviceID	!= NULL AND is_numeric($DeviceID) AND ($DeviceID >=0 AND $DeviceID <= 65535)) {
				$URL		=	$URL.'&DeviceId='.$DeviceID;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
		$CURL 				= curl_init($URL);
		curl_setopt($CURL, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($CURL, CURLOPT_RETURNTRANSFER , TRUE);
		$Return				= curl_exec($CURL);
		curl_close($CURL);
		$this->Last_URL		= $URL;

		return (json_decode($Return,TRUE));
	}
	public function GetPowerFlowRealtimeData(	$URL = NULL)
	{
		/**
		* Description:	Returns an array with local grid energy
		* Return:		    ARRAY
		*/
		if ($URL			!= NULL) {
			$URL 			= $this->Invertor_IP.$URL;
		} else {
			$URL 			= $this->Invertor_IP.'/solar_api/'.$this->API_Version.'/GetPowerFlowRealtimeData.fcgi';
		}
		$CURL 				= curl_init($URL);
		curl_setopt($CURL, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($CURL, CURLOPT_RETURNTRANSFER , TRUE);
		$Return				= curl_exec($CURL);
		curl_close($CURL);
		$this->Last_URL		= $URL;
		
		return (json_decode($Return,TRUE));
	}
	public function GetArchiveData(				$Scope = 1,			$TS_Start,			$TS_End,			$Channel,				$DeviceClass = 1,	$DeviceID = NULL,	$SeriesType = NULL,	$HumanReadable = NULL,	$URL = NULL)
	{
		/**
		* Description:	Returns an array with archive data
		* $Scope:
		* 			        1  -> System
		* 			        2  -> Device
		* $SeriesType:
		* 			        1  -> DailySum
		* 			        2  -> Detail
		* $Channel:
		* 			        1  -> TimeSpanInSec
		* 			        2  -> EnergyReal_WAC_Sum_Produced
		* 			        3  -> EnergyReal_WAC_Sum_Consumed
		* 			        4  -> InverterEvents
		* 			        5  -> InverterErrors
		* 			        6  -> Current_DC_String_1
		* 			        7  -> Current_DC_String_2
		* 			        8  -> Voltage_DC_String_1
		* 			        9  -> Voltage_DC_String_2
		* 			        10 -> Temperature_Powerstage
		* 			        11 -> Voltage_AC_Phase_1
		* 			        12 -> Voltage_AC_Phase_2
		* 			        13 -> Voltage_AC_Phase_3
		* 			        14 -> Current_AC_Phase_1
		* 			        15 -> Current_AC_Phase_2
		* 			        16 -> Current_AC_Phase_3
		* 			        17 -> PowerReal_PAC_Sum
		* 			        18 -> EnergyReal_WAC_Minus_Absolute
		* 			        19 -> EnergyReal_WAC_Plus_Absolute
		* 			        20 -> Meter_Location_Current
		* 			        21 -> Temperature_Channel_1
		* 			        22 -> Temperature_Channel_2
		* 			        23 -> Digital_Channel_1
		* 			        24 -> Digital_Channel_2
		* 			        25 -> Radiation
		*		            Text -> Multiple selection
		* $DeviceClass:
		* 			        1  -> Inverter
		* 			        2  -> SensorCard
		* 			        3  -> StringControl
		* 			        4  -> Meter
		* 			        5  -> Storage
		* 			        6  -> OhmPilot
		* Return:		    ARRAY
		*/
		if ($URL			!= NULL) {
			$URL 			= $this->Invertor_IP.$URL;
		} else {
			$URL 			= $this->Invertor_IP.'/solar_api/'.$this->API_Version.'/GetArchiveData.cgi';
		}
		if ($Scope			== 1) {
			$URL 			= $URL.'?Scope=System';
		} elseif ($Scope		== 2) {
			$URL 			= $URL.'?Scope=Device';
		} else {
			return FALSE;
		}
		if ($SeriesType 	!= NULL AND	$SeriesType 	== 1) {
			$URL 			= $URL.'&SeriesType=DailySum';
		} elseif ($SeriesType != NULL AND	$SeriesType == 2) {
			$URL 			= $URL.'&SeriesType=Detail';
		}
		if ($HumanReadable != NULL AND $HumanReadable == TRUE) {
			$URL 			= $URL.'&HumanReadable=True';
		} elseif ($HumanReadable != NULL AND $HumanReadable == FALSE) {
			$URL 			= $URL.'&HumanReadable=False';
		}
		//$URL 				= $URL.'&StartDate='.str_replace(' ','T',date('Y-m-d H:i:s',$TS_Start));
		$URL 				= $URL.'&StartDate='.$TS_Start;
		//$URL 				= $URL.'&EndDate='.str_replace(' ','T',date('Y-m-d H:i:s',$TS_End));
		$URL 				= $URL.'&EndDate='.$TS_End;
		if (is_numeric($Channel) AND	$Channel == 1) {
			$URL 			= $URL.'&Channel=TimeSpanInSec';
		}
		if (is_numeric($Channel) AND	$Channel == 2) {
			$URL 			= $URL.'&Channel=EnergyReal_WAC_Sum_Produced';
		}
		if (is_numeric($Channel) AND	$Channel == 3) {
			$URL 			= $URL.'&Channel=EnergyReal_WAC_Sum_Consumed';
		}
		if (is_numeric($Channel) AND	$Channel == 4) {
			$URL 			= $URL.'&Channel=InverterEvents';
		}
		if (is_numeric($Channel) AND	$Channel == 5) {
			$URL 			= $URL.'&Channel=InverterErrors';
		}
		if (is_numeric($Channel) AND	$Channel == 6) {
			$URL 			= $URL.'&Channel=Current_DC_String_1';
		}
		if (is_numeric($Channel) AND	$Channel == 7) {
			$URL 			= $URL.'&Channel=Current_DC_String_2';
		}
		if (is_numeric($Channel) AND	$Channel == 8) {
			$URL 			= $URL.'&Channel=Voltage_DC_String_1';
		}
		if (is_numeric($Channel) AND	$Channel == 9) {
			$URL 			= $URL.'&Channel=Voltage_DC_String_2';
		}
		if (is_numeric($Channel) AND	$Channel == 10) {
			$URL 			= $URL.'&Channel=Temperature_Powerstage';
		}
		if (is_numeric($Channel) AND	$Channel == 11) {
			$URL 			= $URL.'&Channel=Voltage_AC_Phase_1';
		}
		if (is_numeric($Channel) AND	$Channel == 12) {
			$URL 			= $URL.'&Channel=Voltage_AC_Phase_2';
		}
		if (is_numeric($Channel) AND	$Channel == 13) {
			$URL 			= $URL.'&Channel=Voltage_AC_Phase_3';
		}
		if (is_numeric($Channel) AND	$Channel == 14) {
			$URL 			= $URL.'&Channel=Current_AC_Phase_1';
		}
		if (is_numeric($Channel) AND	$Channel == 15) {
			$URL 			= $URL.'&Channel=Current_AC_Phase_2';
		}
		if (is_numeric($Channel) AND	$Channel == 16) {
			$URL 			= $URL.'&Channel=Current_AC_Phase_3';
		}
		if (is_numeric($Channel) AND	$Channel == 17) {
			$URL 			= $URL.'&Channel=PowerReal_PAC_Sum';
		}
		if (is_numeric($Channel) AND	$Channel == 18) {
			$URL 			= $URL.'&Channel=EnergyReal_WAC_Minus_Absolute';
		}
		if (is_numeric($Channel) AND	$Channel == 19) {
			$URL 			= $URL.'&Channel=EnergyReal_WAC_Plus_Absolute';
		}
		if (is_numeric($Channel) AND	$Channel == 20) {
			$URL 			= $URL.'&Channel=Meter_Location_Current';
		}
		if (is_numeric($Channel) AND	$Channel == 21) {
			$URL 			= $URL.'&Channel=Temperature_Channel_1';
		}
		if (is_numeric($Channel) AND	$Channel == 22) {
			$URL 			= $URL.'&Channel=Temperature_Channel_2';
		}
		if (is_numeric($Channel) AND	$Channel == 23) {
			$URL 			= $URL.'&Channel=Digital_Channel_1';
		}
		if (is_numeric($Channel) AND	$Channel == 24) {
			$URL 			= $URL.'&Channel=Digital_Channel_2';
		}
		if (is_numeric($Channel) AND	$Channel == 25) {
			$URL 			= $URL.'&Channel=Radiation';
		}
		if (is_string($Channel)){
			$URL			= $URL.$Channel;
			
		}
		if ($Scope			== 2) 
		{
			if (is_numeric($DeviceClass)		AND $DeviceClass == 1)
			{
				$URL 		= $URL.'&DeviceClass=Inverter';
			}
			elseif (is_numeric($DeviceClass)	AND $DeviceClass == 2)
			{
				$URL 		= $URL.'&DeviceClass=SensorCard';
			}
			elseif (is_numeric($DeviceClass)	AND $DeviceClass == 3)
			{
				$URL 		= $URL.'&DeviceClass=StringControl';
			}
			elseif (is_numeric($DeviceClass)	AND $DeviceClass == 4)
			{
				$URL 		= $URL.'&DeviceClass=Meter';
			}
			elseif (is_numeric($DeviceClass)	AND $DeviceClass == 5)
			{
				$URL 		= $URL.'&DeviceClass=Storage';
			}
			elseif (is_numeric($DeviceClass)	AND $DeviceClass == 6)
			{
				$URL 		= $URL.'&DeviceClass=OhmPilot';
			}
			if ($DeviceID	!= NULL AND is_numeric($DeviceID) AND ($DeviceID >=0 AND $DeviceID <= 199)) {
				$URL		=	$URL.'&DeviceId='.$DeviceID;
			}
		}
		$CURL 				= curl_init($URL);
		curl_setopt($CURL, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($CURL, CURLOPT_RETURNTRANSFER , TRUE);
		$Return				= curl_exec($CURL);
		curl_close($CURL);
		$this->Last_URL		= $URL;

		return (json_decode($Return,TRUE));
	}	
}
?>
