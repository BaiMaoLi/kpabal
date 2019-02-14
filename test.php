<?php
$ip="24.39.82.68";
if(isset($_POST['ip']))$ip=$_POST['ip'];
$netmask="255.255.255.252";
if(isset($_POST['netmask']))$netmask=$_POST['netmask'];
$cidr=new CIDR;
$result=CIDR::addrandmask2cidr($ip,$netmask);
class CIDR {
	public static function addrandmask2cidr($ipinput, $netmask){
	    $mask=$netmask;
		$netmask = ip2long($netmask);
		if($netmask === false) return false;
		$neg = ((~(int)$netmask) & 0xFFFFFFFF);
		if((($neg + 1) & $neg) === 0)return self::add2cidr($ipinput,$mask);
	}
	public static function add2cidr($ipinput,$netmask){
		$alignedIP = long2ip((ip2long($ipinput)) & (ip2long($netmask)));
		$int=ip2long($netmask);//echo $int;
		$int = $int & 0xFFFFFFFF;
		$int = ( $int & 0x55555555 ) + ( ( $int >> 1 ) & 0x55555555 ); 
		$int = ( $int & 0x33333333 ) + ( ( $int >> 2 ) & 0x33333333 );
		$int = ( $int & 0x0F0F0F0F ) + ( ( $int >> 4 ) & 0x0F0F0F0F );
		$int = ( $int & 0x00FF00FF ) + ( ( $int >> 8 ) & 0x00FF00FF );
		$int = ( $int & 0x0000FFFF ) + ( ( $int >>16 ) & 0x0000FFFF );
		$int = $int & 0x0000003F;
		$return=array();
		for($i=32;$i>=0;$i--){
		    $mask= -1 << (32 - $i);
		    $subnet  = ip2long($netmask);
		    $subnet &= $mask;
		    echo long2ip((ip2long($ipinput)) & ($subnet))."/".$i."<br>";
		    array_push($return,long2ip((ip2long($ipinput)) & ($subnet))."/".$i);
		}
		return $return;
	}
}
?>