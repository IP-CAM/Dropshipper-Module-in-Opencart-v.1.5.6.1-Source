<?php echo $header; ?>
<script type="text/javascript">
    function stokGuncelle(tedarikciId)
    {
        $('#span_' + tedarikciId).html('<img src="view/image/loading.gif" /> Güncelleniyor..');
        $.post('<?php echo $update_stock_link?>',{tedarikci_id:tedarikciId},function(data)
            {
                $('#span_' + tedarikciId).html('Güncellendi..');
        });
    }
</script>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
            <?php } ?>
    </div>
    <?php if ($error_warning) { ?>
        <div class="warning"><?php echo $error_warning; ?></div>
        <?php } ?>
    <?php if ($success) { ?>
        <div class="success"><?php echo $success; ?></div>
        <?php } ?>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/category.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons">
                <a href="<?php echo $yeni_tedarikci_link; ?>" class="button">Yeni Tedarikçi</a>
                <a onclick="$('#form').submit();" class="button">Sil</a></div>
        </div>
        <div class="content">
            <form action="<?php echo $tedarikci_sil_link; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="list">
                    <thead>
                        <tr>
                            <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
                            <td class="left">Tedarikçi Adı</td>
                            <td class="right">Adresi</td>
                            <td class="right">Son Güncelleme</td>
                            <td class="right">Stok Adeti</td>
                            <td class="right">İşlem</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($tedarikciler) { ?>
                            <?php foreach ($tedarikciler as $tedarikci) { ?>
                                <tr>
                                    <td style="text-align: center;">
                                    <input type="checkbox" name="selected[]" value="<?php echo $tedarikci['tedarikci_id']; ?>" />
                                    <td class="left"><?php echo $tedarikci['tedarikci_adi']; ?></td>
                                    <td class="left"><?php echo $tedarikci['tedarikci_xml_adres']; ?></td>
                                    <td class="right"><?php echo $tedarikci['tedarikci_son_guncelleme']; ?></td>
                                    <td class="right"><?php echo $tedarikci['stok_adeti']; ?></td>
                                    <td class="right"><span id="span_<?php echo $tedarikci['tedarikci_id']; ?>">[ <a href="javascript:stokGuncelle(<?php echo $tedarikci['tedarikci_id']; ?>)">Stokları Güncelle</a> ]</span> [ <a href="<?php echo $tedarikci['edit_url']; ?>">Düzenle</a> ]
                                </tr>
                                <?php } ?>
                            <?php } else { ?>
                            <tr>
                                <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
                            </tr>
                            <?php } ?>
                    </tbody>
                </table>
            </form>
            <div class="pagination"><?php echo $pagination; ?></div>
        </div>
    </div>
</div>
<?php echo $footer; ?>