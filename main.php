<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->
Load();
$action = 'root';
if (!$zbp->CheckRights($action)) {$zbp->ShowError(6);die();}
if (!$zbp->CheckPlugin('ajaxTemplate')) {$zbp->ShowError(48);die();}

$blogtitle = 'ajaxTemplate';
require $blogpath . 'zb_system/admin/admin_header.php';
require $blogpath . 'zb_system/admin/admin_top.php';

$selectors = array();
$callbackIng = '';
$callbackEd = '';
if (count($_POST) > 0) {
	$selectorsPost = GetVars('selector', 'POST');
	$callbackIng = GetVars('callback-ing', 'POST');
	$callbackEd = GetVars('callback-ed', 'POST');
	foreach ($selectorsPost as $key => $value) {
		$selectors[] = $value;
	}
	$zbp->Config('ajaxTemplate')->selectors = serialize($selectors);
	$zbp->Config('ajaxTemplate')->callbackIng = $callbackIng;
	$zbp->Config('ajaxTemplate')->callbackEd = $callbackEd;
	$zbp->SaveConfig('ajaxTemplate');
	$zbp->SetHint('good');
	Redirect('./main.php');
} else {
	$selectors = unserialize($zbp->Config('ajaxTemplate')->selectors);
	if (!$selectors) {
		$selectors = array();
	}
	$callbackIng = $zbp->Config('ajaxTemplate')->callbackIng;
	$callbackEd = $zbp->Config('ajaxTemplate')->callbackEd;
}
?>
<div id="divMain">
	<div class="divHeader">
		<?php echo $blogtitle;?></div>
	<div class="SubMenu"></div>
	<div id="divMain2">
		<form action="?act=save" method="post">
			<table width="100%" border="0" class="table_hover table_striped">
				<tr height="32">
					<th colspan="2" align="center">设置</th>
				</tr>
				<tr height="32">
					<td width="30%" align="left">
						<p> <b>· 指定要替换的元素的选择器 <a href="#" class="a-append">[增加]</a></b>
							<br/>
							<span class="note">&nbsp;&nbsp;被选择器选择到的元素将被替换，请确保该元素唯一。如：<br/>&nbsp;&nbsp;body<br/>&nbsp;&nbsp;title<br/>&nbsp;&nbsp;.container</span>
						</p>
					</td>
					<td class="td-selectors">
					<?php foreach ($selectors as $key => $value) {?>
						<p class="p-selector"><a href="#" class="a-remove"> - </a><input type="text" name="selector[]" value="<?php echo htmlspecialchars($value)?>" style="width:80%"/></p>
					<?php }
?>
					</td>
				</tr>
				<tr height="32">
					<td width="30%" align="left">
						<p> <b>· 切换过程回调JavaScript函数</a></b>
							<br/>
							<span class="note">&nbsp;&nbsp;参数：pageObject<br/>&nbsp;&nbsp;不需要另行包装function(){}</span>
						</p>
					</td>
					<td>
					<textarea style="width: 80%" rows="20" name="callback-ing"><?php echo htmlspecialchars($callbackIng)?></textarea>
					</td>
				</tr>
				<tr height="32">
					<td width="30%" align="left">
						<p> <b>· 切换完毕回调JavaScript函数</a></b>
							<br/>
							<span class="note">&nbsp;&nbsp;参数：pageObject、xhrData<br/>&nbsp;&nbsp;不需要另行包装function(){}</span>
						</p>
					</td>
					<td>
					<textarea style="width: 80%" rows="20" name="callback-ed"><?php echo htmlspecialchars($callbackEd)?></textarea>
					</td>
				</tr>			</table>
			<hr/>
			<p>
				<input type="submit" value="提交" class="button" />
			</p>
			<hr/>
		</form>
	</div>
</div>
<script>
$(function() {
	$("body").delegate(".a-append", "click", function() {
		$pSelector = $($(".p-selector")[0]).clone();
		if ($pSelector.length === 0) {
			$pSelector = $('<p class="p-selector"><a href="#" class="a-remove"> - </a><input type="text" name="selector[]" value="" style="width:80%"/></p>');
		}
		$pSelector.appendTo(".td-selectors");
		return false;
	}).delegate(".a-remove", "click", function() {
		$(this).parent().remove();
		return false;
	});

});
</script>

<?php
require $blogpath . 'zb_system/admin/admin_footer.php';
RunTime();
?>