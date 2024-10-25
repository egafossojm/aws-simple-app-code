
<?php
if (is_preview()) {

    ?>
 <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; padding: 0px 0px 0px 0px" class="text-pad-right bigbox-cell content-ads">
	<tr>
	  <td style="padding: 0px 0px 10px 0px; text-align: center; width: 728px;" class="text-pad-right bigbox-cell content-ads">
	    <table border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
		  <tr>
		    <td colspan="2">
		      <a href="http://li.tcmedia.tc/click?s=<?php echo $li_codes['code_300_250']; ?>&amp;li={LIST_ID}&amp;e=%%emailaddr%%&amp;p=%%jobid%%" rel="nofollow"> 
		          <img src="http://li.tcmedia.tc/imp?s=<?php echo $li_codes['code_300_250']; ?>&amp;li={LIST_ID}&amp;e=%%emailaddr%%&amp;p=%%jobid%%" border="0" width="300" style="width: auto; max-width: 300px !important;">
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

<table border="0" cellpadding="0" cellspacing="0" style="width: 100%; word-break: break-word; -webkit-hyphens: auto; -moz-hyphens: auto; hyphens: auto; border-collapse: collapse !important; vertical-align: top; text-align: left; color: #222222; font-family: 'Helvetica', 'Arial', sans-serif; font-weight: normal; line-height: 19px; font-size: 14px; padding: 0px 0px 0px 0px" class="text-pad-right bigbox-cell content-ads">
	<tr>
		<td style="padding: 0px 0px 10px 0px; text-align: center; width: 728px;" class="text-pad-right bigbox-cell content-ads">
			<table border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
			<tr>
				<td colspan="2">
    				<a href="[[="https://li.tcmedia.tc/click?s=<?php echo $li_codes['code_300_250']; ?>" + li_suffix;]]" rel="nofollow" target="_blank">
    					<img src="[[="https://li.tcmedia.tc/imp?s=<?php echo $li_codes['code_300_250']; ?>" + li_suffix;]]&li_coord=desktop&collapse_width=300" border="0" width="300" style="display: block; width: 100% !important; max-width: 300px !important;"/>
                    </a>
				</td>
			</tr>
			<tr>
				<td align="left">
					<a style="display: block; max-width: 116px;  max-height: 15px;" href="[[="http://li.tcmedia.tc/click?s=<?php echo $li_codes['code_300_116']; ?>"  + li_suffix;]]" rel="nofollow">
						<img src="[[="http://li.tcmedia.tc/imp?s=<?php echo $li_codes['code_300_116']; ?>"  + li_suffix;]]" border="0"/>
					</a>
				</td>
				<td align="right">
					<a style="display: block; max-width: 19px;  max-height: 15px;" href="[[="http://li.tcmedia.tc/click?s=<?php echo $li_codes['code_300_19']; ?>"  + li_suffix;]]" rel="nofollow">
						<img src="[[="http://li.tcmedia.tc/imp?s=<?php echo $li_codes['code_300_19']; ?>"  + li_suffix;]]" border="0"/>
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