<?php
if (! is_preview()) {

    ?>
[[ 
string CodeUnique = system.Tools.GenerateGUID(); 
string li_email_MD5 = System.Tools.Hash.MD5.GetString(Contact.f_EMail);
string li_jobid = (Mailing.idBatch is not null) ? Mailing.idBatch.ToString() : Sendlog.idSendLog.ToString();
string li_suffix = "&li=" + Project.idProject.ToString() + "&e=" + li_email_MD5 + "&p=" + CodeUnique + "&stpe=default;
string li_rtb_suffix = "&e=%%emailaddr%%&p=%%jobid%%&lctg=inserthere&stpe=pixel";
]]
<?php
}
?>