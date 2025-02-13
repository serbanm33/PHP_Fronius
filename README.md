# PHP_Fronius
More information about Fronius Solar API v1:

https://www.fronius.com/en/solar-energy/installers-partners/products/all-products/system-monitoring/open-interfaces/fronius-solar-api-json-
https://www.fronius.com/~/downloads/Solar%20Energy/Operating%20Instructions/42,0410,2012.pdf

This class implements some of the functionality of Fronius Solar API v1 and allows you to get data from Fronius Symo inverters equipped with Datamanagers v2.0. For easy use I kept the naming very close to the API specification.

Not tested with GEN24 or other Fronius inverters and I have no plans to extend the code.

DISCLAIMER: I have no affiliation with Fronius, I really like their products (best inverters on the market by far) and I have done this project some time ago for my custom home automation integration. 

Hopefully they will not take my project down.

# How to use
- Save the PHP_Fronius.php to a path of your liking;
- Require/require once/import the file where you want to use the class;
- Create a new instance of the PHP_Fronius class
- Set the IP address of the datamanager
- Call the appropriate function
- For details about input parameters please check function description

# How to get the most useful information
# Inverter info
Class will return information about all Symo inverters connected to the same Solar Net

Code:
```
	$Symo = New PHP_Fronius();
	$Symo->Invertor_IP = '192.168.1.100';
	$Info = $Symo->GetInverterInfo();
```
Result:
```
Array
(
    [Body] => Array
        (
            [Data] => Array
                (
                    [1] => Array
                        (
                            [CustomName] => Symo 5
                            [DT] => 122
                            [ErrorCode] => 0
                            [PVPower] => xxxx
                            [Show] => 1
                            [StatusCode] => 7
                            [UniqueID] => xxxxx
                        )

                    [2] => Array
                        (
                            [CustomName] => Symo 6
                            [DT] => 110
                            [ErrorCode] => 0
                            [PVPower] => 7940
                            [Show] => 1
                            [StatusCode] => 7
                            [UniqueID] => xxxxxx
                        )
                )
        )
    [Head] => Array
        (
            [RequestArguments] => Array
                (
                )

            [Status] => Array
                (
                    [Code] => 0
                    [Reason] => 
                    [UserMessage] => 
                )

            [Timestamp] => 2025-02-13T16:11:25+02:00
        )
)
```
# Real time power flow
Code:
```
$PowerFlow = $Symo->GetPowerFlowRealtimeData();
```
Result:
```
Array
(
    [Body] => Array
        (
            [Data] => Array
                (
                    [Inverters] => Array
                        (
                            [1] => Array
                                (
                                    [DT] => 122
                                    [E_Day] => 13798
                                    [E_Total] => xxx
                                    [E_Year] => xxx.x
                                    [P] => 407
                                )
                            [2] => Array
                                (
                                    [DT] => 110
                                    [E_Day] => 12089
                                    [E_Total] => xxx
                                    [E_Year] => xxx.x
                                    [P] => 443
                                )
                        )
                    [Site] => Array
                        (
                            [E_Day] => 25887
                            [E_Total] => xxx
                            [E_Year] => xxx.xxx
                            [Meter_Location] => grid
                            [Mode] => meter
                            [P_Akku] => 
                            [P_Grid] => -43.09
                            [P_Load] => -806.91
                            [P_PV] => 850
                            [rel_Autonomy] => 100
                            [rel_SelfConsumption] => 94.930588235294
                        )
                    [Version] => 12
                )
        )
    [Head] => Array
        (
            [RequestArguments] => Array
                (
                )
            [Status] => Array
                (
                    [Code] => 0
                    [Reason] => 
                    [UserMessage] => 
                )
            [Timestamp] => 2025-02-13T16:17:28+02:00
        )
)
```

# Meter Data

Code:
```
	$Meter = $Symo->GetMeterRealtimeData(2,0);
 ```
Result:
```
Array
(
    [Body] => Array
        (
            [Data] => Array
                (
                    [Current_AC_Phase_1] => 2.715
                    [Current_AC_Phase_2] => 2.919
                    [Current_AC_Phase_3] => 2.534
                    [Details] => Array
                        (
                            [Manufacturer] => Fronius
                            [Model] => Smart Meter 63A
                            [Serial] => xxxxx
                        )
                    [Enable] => 1
                    [EnergyReactive_VArAC_Sum_Consumed] => 235610
                    [EnergyReactive_VArAC_Sum_Produced] => 426882190
                    [EnergyReal_WAC_Minus_Absolute] => 33332918
                    [EnergyReal_WAC_Plus_Absolute] => 33034409
                    [EnergyReal_WAC_Sum_Consumed] => 33034409
                    [EnergyReal_WAC_Sum_Produced] => 33332918
                    [Frequency_Phase_Average] => 50
                    [Meter_Location_Current] => 0
                    [PowerApparent_S_Phase_1] => 656.7585
                    [PowerApparent_S_Phase_2] => 700.8519
                    [PowerApparent_S_Phase_3] => 604.359
                    [PowerApparent_S_Sum] => 1564
                    [PowerFactor_Phase_1] => -0.05
                    [PowerFactor_Phase_2] => -0.03
                    [PowerFactor_Phase_3] => -0.07
                    [PowerFactor_Sum] => -0.05
                    [PowerReactive_Q_Phase_1] => -525.16
                    [PowerReactive_Q_Phase_2] => -570.53
                    [PowerReactive_Q_Phase_3] => -467.12
                    [PowerReactive_Q_Sum] => -1562.81
                    [PowerReal_P_Phase_1] => -27
                    [PowerReal_P_Phase_2] => -20.78
                    [PowerReal_P_Phase_3] => -35.43
                    [PowerReal_P_Sum] => -83.21
                    [TimeStamp] => 1739454155
                    [Visible] => 1
                    [Voltage_AC_PhaseToPhase_12] => 417.4
                    [Voltage_AC_PhaseToPhase_23] => 414.5
                    [Voltage_AC_PhaseToPhase_31] => 416
                    [Voltage_AC_Phase_1] => 241.9
                    [Voltage_AC_Phase_2] => 240.1
                    [Voltage_AC_Phase_3] => 238.5
                )
        )
    [Head] => Array
        (
            [RequestArguments] => Array
                (
                    [DeviceClass] => Meter
                    [DeviceId] => 0
                    [Scope] => Device
                )
            [Status] => Array
                (
                    [Code] => 0
                    [Reason] => 
                    [UserMessage] => 
                )
            [Timestamp] => 2025-02-13T15:42:35+02:00
        )
)
```

