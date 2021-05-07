<?php

declare(strict_types=1);

	class CallMeBot extends IPSModule
	{
		public function Create()
		{
			//Never delete this line!
			parent::Create();

			$this->RegisterPropertyString ("APIKey", "");
      $this->RegisterPropertyString ("HandyNumber","");
			$this->RegisterPropertyString ("Message","");
			$this->RegisterPropertyBoolean("MessageBoxVisible",false);

			$this->RegisterVariableString ("ReturnValue", $this->translate("Return Value"), "~HTMLBox", 0);
			
		}

		public function Destroy()
		{
			//Never delete this line!
			parent::Destroy();


		}

		public function ApplyChanges()
		{
			//Never delete this line!
			parent::ApplyChanges();

			if($this->ReadPropertyBoolean("MessageBoxVisible") === true) 
			{
				IPS_SetHidden($this->GetIDForIdent("ReturnValue"),true);
			} 
			else 
			{
				IPS_SetHidden($this->GetIDForIdent("ReturnValue"),false);
			}
		}



		public function SendToWhatsAppEx (string $PhoneNumber, string $Message, string $ApiKey) 
		{
				$return = $this->CheckUp ($PhoneNumber, $Message, $ApiKey);
				
				if($return["ErrorCode"]>=0)
				{
			    $Number = $this->ReplaceInNumber($PhoneNumber);
					$Message = $this->ConvertMessage($Message);
			    $Url = "https://api.callmebot.com/whatsapp.php?phone=".$Number."&text=".urlencode($Message)."&apikey=".$ApiKey;
			    $output = $this->SendCurl($Url);
					
					$this->SetValue("ReturnValue",$output);
					return $output;
				}
				else 
				{
					$this->SetErrorMessage($return);
					return $return;
				}
		}


		public function SendToWhatsApp ($Message) 
		{
				$PhoneNumber = $this->ReadPropertyString("HandyNumber");				
				$ApiKey = $this->ReadPropertyString("APIKey");

				$return = $this->CheckUp ($PhoneNumber, $Message, $ApiKey);

				if($return["ErrorCode"]>=0)
				{
			    $Number = $this->ReplaceInNumber($PhoneNumber);
					$Message = $this->ConvertMessage($Message);
			    $Url = "https://api.callmebot.com/whatsapp.php?phone=".$Number."&text=".urlencode($Message)."&apikey=".$ApiKey;
			    $output = $this->SendCurl($Url);
					
					$this->SetValue("ReturnValue",$output);
					return $output;
				}
				else 
				{
					$this->SetErrorMessage($return);
					return $return;
				}
		}


		public function Test_SendToWhatsApp () 
		{
				$PhoneNumber = $this->ReadPropertyString("HandyNumber");
				$Message = $this->ReadPropertyString("Message");
				$ApiKey = $this->ReadPropertyString("APIKey");

				$return = $this->CheckUp ($PhoneNumber, $Message, $ApiKey);

				if($return["ErrorCode"]>=0)
				{
					$Number = $this->ReplaceInNumber($PhoneNumber);
					$Message = $this->ConvertMessage($Message);
					$Url = "https://api.callmebot.com/whatsapp.php?phone=".$Number."&text=".urlencode($Message)."&apikey=".$ApiKey;
					$output = $this->SendCurl($Url);
					
					$this->SetValue("ReturnValue",$output);
					echo $output;
				} 
				else 
				{
					echo $return["ErrorMsg"];
					$this->SetErrorMessage ($return);
				}
		}

		private function ConvertMessage($Message)
		{
				$ConvertedMessage = strip_tags(str_replace(array("<br>"),"\n",$Message));
				return $ConvertedMessage;
		}

		private function SetErrorMessage ($return)
		{
				$error="";
				foreach($return as $Name => $Value)
				{
						$error.= $Name.": ".$Value."<br>";
				}
				$this->SetValue("ReturnValue",$error);
		}


		private function CheckUp (string $PhoneNumber, string $Message, string $ApiKey)
		{
			$rc = 0;
			$msg=[];

			if(empty($PhoneNumber)) 
			{
				$rc=-1;
				$msg=[
					"ErrorCode" => $rc, 
					"ErrorMsg" 	=> "HandyNumber is empty"
				];
			}
			if(empty($Message)) 
			{
				$rc=-2;
				$msg=[
					"ErrorCode" => $rc, 
					"ErrorMsg" 	=> "Message is empty"
				];
			}
			if(empty($ApiKey)) 
			{
				$rc=-3;
				$msg=[
					"ErrorCode" => $rc, 
					"ErrorMsg" 	=> "ApiKey is empty"
				];				
			}
				
			if($rc<0)
			{
				return $msg;
			} 
			else 
			{
				$msg=[
					"ErrorCode" => 0, 
					"ErrorMsg" 	=> "No errors"
				];
				return $msg;
			}
		}

		private function ReplaceInNumber(string $PhoneNumber) 
		{
		    // Trim spaces
		    $Number = ltrim(rtrim(str_replace(" ","",$PhoneNumber)));

		    // Replace Zero at begin
		    if(substr($Number,0,1)===strval(0))
		    {
		        $Number = "+49".substr($Number,1,20);
		    }

		    return $Number;
		}

		private function SendCurl (string $Url) 
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $Url);
			$output = curl_exec($ch);
			curl_close($ch);
	
			return $output;
		}
	}