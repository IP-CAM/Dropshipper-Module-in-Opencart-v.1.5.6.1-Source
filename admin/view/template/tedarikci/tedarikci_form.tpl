<?php echo $header; ?>  
<script type="text/javascript">
    $(document).ready(function(){
        $('#tedarikci_xml_adres').change(function(){
            var xmladdress = $(this).val();

            $('#xml_match_container').html("XML alınıyor bekleyiniz...");

            $.post('<?php echo $xml_ajax_url;?>',{address:xmladdress},function (data){
                $('#xml_match_container').html(data);
            });
        });
    });

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
                <a onclick="$('#form').submit();" class="button">Kaydet</a></div>
        </div>
        <div class="content">
            <form action="" method="post" id="form">
                <table class="form">
                    <tbody>
                        <tr>
                            <td>Tedarikçi Adı</td>
                            <td><input type="text" name="tedarikci[tedarikci_adi]"  size="80" /></td>
                        </tr> 
                        <tr>
                            <td>Tedarikçi Xml Adresi</td>
                            <td><input type="text" name="tedarikci[tedarikci_xml_adres]" id="tedarikci_xml_adres"  size="80" /></td>
                        </tr>
                        <tr>
                            <td>Kategori Eşleşmeleri</td>
                            <td><input type="text" name="fields[KATEGORILER]" id="field_kategori"  size="100" /> (Örn : 1=3,2=5)</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center" id="xml_match_container">Xml eşleştirmek için yukarıya adres giriniz.</td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
<?php echo $footer; ?>