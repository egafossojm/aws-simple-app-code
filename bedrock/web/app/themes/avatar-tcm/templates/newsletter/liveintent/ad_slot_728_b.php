
<?php
if (is_preview()) {

    ?>
<table border="0" cellpadding="0" cellspacing="0" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;position:relative;background:#c9c9c9;padding:0px;" bgcolor="#c9c9c9" class="row header advert" >
<tr>
  <td style="text-align: center; padding: 8px 0;">
    <table border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td colspan="2" style="text-align: center;">
      <a href="http://li.tcmedia.tc/click?s=<?php echo $li_codes['code_728_90_b']; ?>&amp;li={LIST_ID}&amp;e=%%emailaddr%%&amp;p=%%jobid%%" rel="nofollow"> 
          <img src="http://li.tcmedia.tc/imp?s=<?php echo $li_codes['code_728_90_b']; ?>&amp;li={LIST_ID}&amp;e=%%emailaddr%%&amp;p=%%jobid%%" border="0" width="728" style="width: auto; max-width: 728px !important;">
      </a>
    </td>
  </tr>
  </table>
</td>
  </tr>
  </table>  
  <?php
} else {
    ?>

<table border="0" cellpadding="0" cellspacing="0" style="border-spacing:0;border-collapse:collapse;vertical-align:top;text-align:left;width:100%;position:relative;background:#c9c9c9;padding:0px;" bgcolor="#c9c9c9" class="row header advert" >
<tr>
	<td style="text-align: center; padding: 8px 0;">
		<table border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td colspan="2" style="text-align: center;">
					<a href="[[="http://li.tcmedia.tc/click?s=<?php echo $li_codes['code_728_90_b']; ?>" + li_suffix;]]" rel="nofollow" target="_blank">
						<img src="[[="https://li.tcmedia.tc/imp?s=<?php echo $li_codes['code_728_90_b']; ?>" + li_suffix;]]&li_coord=desktop&collapse_width=728" border="0" width="728" style="display: block; width: 100% !important; max-width: 728px !important;"/>
					</a>
				</td>
			</tr>
			<tr>
				<td align="left">
					<a style="display: block; max-width: 116px;  max-height: 15px;" href="[[="http://li.tcmedia.tc/click?s=<?php echo $li_codes['code_728_116_b']; ?>" + li_suffix;]]" rel="nofollow">
						<img src="[[="http://li.tcmedia.tc/imp?s=<?php echo $li_codes['code_728_116_b']; ?>" + li_suffix;]]" border="0"/>
					</a>
				</td>
				<td align="right">
					<a style="display: block; max-width: 19px;  max-height: 15px;" href="[[="http://li.tcmedia.tc/click?s=<?php echo $li_codes['code_728_19_b']; ?>" + li_suffix;]]" rel="nofollow">
						<img src="[[="http://li.tcmedia.tc/imp?s=<?php echo $li_codes['code_728_19_b']; ?>" + li_suffix;]]" border="0"/>
					</a>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>

<?php
}
?>