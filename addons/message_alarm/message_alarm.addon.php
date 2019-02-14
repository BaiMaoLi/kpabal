<?php
if(!defined("__ZBXE__")) exit();

if($called_position != 'before_module_proc' || Context::getResponseMethod()!="HTML") return;
$logged_info = Context::get('logged_info');
if(!$logged_info) return;

$module = Context::get('module');
if(!$module) $module = $this->module;
if($module == 'communication' || $module == 'admin' || $module == 'member') return;
$link   = Context::getRequestUri().'?mid='.Context::get('mid').'&act=dispCommunicationMessages';
	
$aobj->receiver_srl = $logged_info->member_srl;
$aobj->readed = 'N';
$aobj->related_srl = 0;
$output = executeQueryArray('addons.message_alarm.getMessageCount', $aobj);
if(!count($output->data)) return;

if($addon_info->mode == 'layer') 
{
	$sc =  "var message = '읽지않은 쪽지가 ".count($output->data)."개 있습니다.확인하시겠습니까?';\nvar messageurl = '".$link."';";
	$text = '<script type="text/javascript">'.$sc.'</script>';
	Context::addCSSFile("./addons/message_alarm/notify.css", false);
	Context::addJsFile('./addons/message_alarm/notify.js', false ,'', null, 'body');
}
elseif($addon_info->mode == 'confirm') 
{
	$sc =  "var message = '읽지않은 쪽지가 ".count($output->data)."개 있습니다.확인하시겠습니까?';\nvar url = '".$link."';\n if(confirm(message)) location.href= url ;";
	$text = '<script type="text/javascript">'.$sc.'</script>';
}
else $text = '<script type="text/javascript">alert("읽지않은 쪽지가 '.count($output->data).'개 있습니다.")</script>';

Context::addHtmlFooter($text);
