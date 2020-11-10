<?php foreach ($datanya as $k => $v):
  $type  = empty($v['type'])  ? '': $v['type'];
  $icon  = empty($v['icon'])  ? 'label': $v['icon'];
  $name  = empty($v['name'])  ? '': $v['name'];
  $nama  = empty($v['nama'])  ? '': $v['nama'];
  $placeholder = empty($v['placeholder'])  ? '': $v['placeholder'];
  // $value = empty($v['value']) ? '': $v['value'];
  @$value = $v['value'];
  $class = empty($v['class']) ? '': $v['class'];
  $id    = empty($v['id'])    ? '': $v['id'];
  $html  = empty($v['html'])  ? '': $v['html'];
  $col   = empty($v['col'])   ? '': $v['col'];
  $hidden = empty($v['hidden']) ? '': $v['hidden'];
  $data_select = empty($v['data_select']) ? array() : $v['data_select'];
  $validasi = empty($v['validasi'])  ? '': $v['validasi'];
  if ($validasi==true) { $validasi = 'required'; }
  $mb = empty($v['mb'])  ? 'mb-50': $v['mb'];
  $pesan_small = empty($v['pesan_small'])  ? '': $v['pesan_small'];
  ?>

<?php if ($type=='batas'){ ?>
  <div class="col-<?= $col; ?>"></div>
<?php
}else{
  if($col!=''){ ?>
<div class="col-<?= $col; ?>"> <?php
  } ?>
  <div class="form-group" <?php if($hidden){ echo "hidden id='Hfg_$name'"; } ?>>
    <label for="Input<?= $k; ?>" id="Lbl_<?= $name; ?>"><?= $nama; ?></label>
    <?php if ($type!='radio'): ?>
    <div class="position-relative has-icon-left <?php if($type=='file'){ echo "custom-file"; } ?>">
    <?php endif; ?>
      <?php if ($type=='textarea'){ ?>
        <textarea name="<?= $name; ?>" class="form-control <?= $class; ?>" id="Input<?= $k; ?> <?= $id; ?>" placeholder="<?php if($placeholder==''){ echo $nama; }else{ echo $placeholder; } ?>" <?= $validasi; ?> <?= $html; ?>><?= $value; ?></textarea>
      <?php }elseif ($type=='radio'){ ?>
        <br>
        <?php foreach ($value as $k_data => $v_data): ?>
          <div class="custom-control custom-radio d-inline <?= $v_data['jarak']; ?>">
            <input type="<?= $type; ?>" class="custom-control-input" name="<?= $name; ?>" id="customRadio<?= $k_data; ?>" value="<?= $k_data; ?>" <?= $validasi; ?> <?= $html; ?>>
            <label class="custom-control-label" for="customRadio<?= $k_data; ?>"><?= $v_data['val']; ?></label>
          </div>
        <?php endforeach; ?>
      <?php }elseif ($type=='checked'){ ?>

      <?php }elseif ($type=='select'){ ?>
        <select name="<?= $name; ?>" class="form-control <?= $class; ?>" id="Input<?= $k; ?> <?= $id; ?>" data-placeholder="Pilih <?= $nama; ?>" <?= $validasi; ?> <?= $html; ?>>
            <option value=""> - Pilih <?= $nama; ?> - </option>
            <?php foreach ($data_select as $k_sel => $v_sel):
              if ($name=='id_wilayah') {
                $titlenya = htmlentities(strip_tags(get_data_sektornya($v_sel['id'])));
              }else {
                $titlenya = '';
              }
              ?>
              <option value="<?= $v_sel['id']; ?>" <?php echo $v_sel['sel']; ?> title="<?= $titlenya; ?>"><?= $v_sel['nama']; ?></option>
            <?php endforeach; ?>
        </select>
      <?php }elseif ($type=='switch' && $name=='status'){ ?>
        <div class="custom-control custom-switch custom-switch-glow custom-switch-warning mr-2 mb-1 float-left" style="z-index:999">
            <input type="checkbox" name="<?= $name; ?>" class="custom-control-input" id="customSwitch_<?= $name; ?>" <?php if($value==1){echo "checked";} ?>>
            <label class="custom-control-label" for="customSwitch_<?= $name; ?>">
                <span class="switch-icon-left" data-toggle="tooltip" data-placement="top" title="" data-original-title="Aktif"><i class="bx bx-check"></i></span>
                <span class="switch-icon-right" data-toggle="tooltip" data-placement="top" title="" data-original-title="Tidak Aktif"><i class="bx bx-x"></i></span>
            </label>
        </div>
      <?php }else{ ?>
        <input type="<?= $type; ?>" name="<?= $name; ?>" class="form-control <?= $class; ?> <?php if($type=='file'){ echo "custom-file-input"; } ?>" id="Input<?= $k; ?> <?= $id; ?>" value="<?= $value; ?>" placeholder="<?php if($placeholder==''){ echo $nama; }else{ echo $placeholder; } ?>" <?= $validasi; ?> <?= $html; ?>>
        <?php if ($type=='file'): ?>
          <label class="custom-file-label" for="Input<?= $k; ?>">Pilih <?= $nama; ?></label>
        <?php endif; ?>
        <?php if ($pesan_small!=''): ?>
          <small class="text-danger"> <b><?= $pesan_small; ?></b> </small>
        <?php endif; ?>
      <?php } ?>
      <?php if ($icon!=''): ?>
        <div class="form-control-position">
            <i class="bx bx-<?= $icon; ?>"></i>
        </div>
      <?php endif; ?>
    <?php if ($type!='radio'): ?>
    </div>
    <?php endif; ?>
  </div>
<?php if($col!=''){ ?>
</div>
<?php }
} ?>
<?php endforeach; ?>
