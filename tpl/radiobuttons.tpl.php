<div class="col-sm-2 col-lg-2">
    <div class="ind-radio ind-form">
        <input class="presence presence_yes" data-id="<?php echo $this->vars['id'];?>" <?php echo $this->vars['checked1'];?> type="radio" name="presence[<?php echo $this->vars['id'];?>]" id="presence_<?php echo $this->vars['id'];?>_1" value="1" />
        <label for="presence_<?php echo $this->vars['id'];?>_1"> Yes </label>
    </div>

    <div class="ind-radio ind-form">
        <input class="presence presence_no" data-id="<?php echo $this->vars['id'];?>" <?php echo $this->vars['checked2'];?> type="radio" name="presence[<?php echo $this->vars['id'];?>]" id="presence_<?php echo $this->vars['id'];?>_2" value="2" />
        <label for="presence_<?php echo $this->vars['id'];?>_2"> No </label>
    </div>
</div>
