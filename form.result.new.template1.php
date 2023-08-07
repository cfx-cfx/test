<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>
<?=$arResult["FORM_NOTE"]?> <!-- выводит errors . . . -->
<?if ($arResult["isFormNote"] != "Y")
{
?>
<?=$arResult["FORM_HEADER"]?> <!-- выводит <form . . . -->
<table> <!-- В таблице заголовок, изображение  и  описание -->
<?
if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y")
{
?>
    <tr>
        <td><?
if ($arResult["isFormTitle"])
{
?>
    <h3><?=$arResult["FORM_TITLE"]; // Заголовок веб-формы?></h3> 
<?
} //endif ;

	// изображение страницы (если есть)
    if ($arResult["isFormImage"] == "Y")
    {
    ?>
    <a href="<?=$arResult["FORM_IMAGE"]["URL"]?>" target="_blank" alt="<?=GetMessage("FORM_ENLARGE")?>"><img src="<?=$arResult["FORM_IMAGE"]["URL"]?>" <?if($arResult["FORM_IMAGE"]["WIDTH"] > 300):?>width="300"<?elseif($arResult["FORM_IMAGE"]["HEIGHT"] > 200):?>height="200"<?else:?><?=$arResult["FORM_IMAGE"]["ATTR"]?><?endif;?> hspace="3" vscape="3" border="0" /></a>
    <?//=$arResult["FORM_IMAGE"]["HTML_CODE"]?>
    <?
    } //endif
    ?>

            <p><?=$arResult["FORM_DESCRIPTION"]?></p>
        </td>
    </tr>
    <?
} // endif
    ?>
</table><!-- В таблице заголовок, изображение  и  описание -->
<br />
<div class="form-container"> <!-- В таблице вопросы -->

    <?
    foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
    {
        if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden') // если есть инпут type=hidden
        {
            echo $arQuestion["HTML_CODE"];
        }
        else // если нет инпут type=hidden
        {
    ?>
		<div class="whole_-question">
			<div class="question">
                <?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
                <span class="error-fld" title="<?=htmlspecialcharsbx($arResult["FORM_ERRORS"][$FIELD_SID])?>"></span>
                <?endif;?>
				<!-- собственно вопрос -->
                <?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"];?><?endif;?>
                <?=$arQuestion["IS_INPUT_CAPTION_IMAGE"] == "Y" ? "<br />".$arQuestion["IMAGE"]["HTML_CODE"] : ""?>
			</div>
			<!-- Ответы -->
            <div class="answer"><?=$arQuestion["HTML_CODE"]?></div>
		</div>
    <?
        }
    } //endwhile
    ?>
	<p>
		<?=$arResult["REQUIRED_SIGN"];?> - <?=GetMessage("FORM_REQUIRED_FIELDS")?>
	</p>
<?
if($arResult["isUseCaptcha"] == "Y")
{
?>
        <tr>
            <th colspan="2"><b><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></b></th>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" /></td>
        </tr>
        <tr>
            <td><?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?></td>
            <td><input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" /></td>
        </tr>
<?
} // isUseCaptcha
?>
<div class="form-submit">
                <input <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value="<?=htmlspecialcharsbx(trim($arResult["arForm"]["BUTTON"]) == '' ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" />
                <?if ($arResult["F_RIGHT"] >= 15):?>
                &nbsp;<input type="hidden" name="web_form_apply" value="Y" /><input type="submit" name="web_form_apply" value="<?=GetMessage("FORM_APPLY")?>" />
                <?endif;?>
                &nbsp;<input type="reset" value="<?=GetMessage("FORM_RESET");?>" />
	</div>

<?=$arResult["FORM_FOOTER"]?>
</div>
<?
} //endif (isFormNote)