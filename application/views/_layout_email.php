<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>HASHPLANS</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <table width="100%" bgcolor="#f8f8f8" style="max-width: 600px; background: #f8f8f8; padding: 20px 70px 70px 70px;" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td style="padding-bottom: 30px;">
                    <a href="<?=site_url()?>" target="_blank" style="display: block;">
                        <img src="<?= site_url('assets/img/logo/hashplan.jpg'); ?>" width="158" heigth="30" style="display:block;" alt="Hashplans logo"/>
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    <? $this->load->view($view, $data); ?>
                </td>
            </tr>
        </table>
    </body>
</html>