     <div id="form_delete_reponse">
     
      <form method="get" id="del_admin_cache">
       <input name="category_id" type="hidden" value="admin" /> 
       <input name="Are_you_sure" type="hidden" value="admin" /> 
       <input name="token" type="hidden" value="<?php echo $this->session->data['token']; ?>" /> 
      <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected_del\']').attr('checked', this.checked);" /></td>
              <td class="right">cat</td>
              <td class="left">reference</td>
              <td class="left">cached</td>
              <td class="left">date</td>
              
            </tr>
          </thead> 
          <tbody>
            <?php if ($cache_records) { ?>
            <?php foreach ($cache_records as $cache_record) { ?>
            <tr> 
              <td style="text-align: center;">                 
                <input type="checkbox" name="selected_del[]" value="<?php echo $cache_record['cache_id']; ?>" />
              </td>
              <td class="right"><?php echo $cache_record['cat']; ?></td>
              <td class="left"><?php echo $cache_record['name']; ?></td>
              <td class="left"><?php echo $cache_record['cached']; ?></td>
              <td class="left"><?php echo $cache_record['date']; ?></td>
              
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="5"><?php echo $text_error_no_cache; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        
      
  </form> 
     </div>