<? if (isset($messages_banner) && !empty($messages_banner)): ?>
    <div class="messages-banner">
        <? foreach ($messages_banner as $type => $message): ?>
            <div class="alert alert-info fade in text-center message-banner" data-message_type="<?=$type?>" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span
                        class="sr-only">Close</span></button>
                <?= $message ?>
            </div>
        <? endforeach ?>
    </div>
<? endif ?>