<?php defined('C5_EXECUTE') or die("Access Denied.");?>
<select class="form-control" name="<?=$this->field('value')?>">
    <option><?=t('Select a Group')?></option>
    <?php foreach($group_list->getResults() as $group): ?>
        <option value="<?=$group->getGroupID()?>" <?php if($group->getGroupID()==$value)echo 'selected'?>><?=$group->getGroupPath()?></option>
    <?php endforeach; ?>
</select>