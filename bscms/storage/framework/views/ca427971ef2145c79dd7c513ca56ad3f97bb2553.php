<ol class="dd-list">
    <?php $__currentLoopData = $menu_nodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="dd-item dd3-item <?php if($row->related_id > 0): ?> post-item <?php endif; ?>" data-type="<?php echo e($row->type); ?>"
            data-related-id="<?php echo e($row->related_id); ?>" data-title="<?php echo e($row->getRelated()->name); ?>"
            data-class="<?php echo e($row->css_class); ?>" data-id="<?php echo e($row->id); ?>" data-custom-url="<?php echo e($row->url); ?>"
            data-icon-font="<?php echo e($row->icon_font); ?>" data-target="<?php echo e($row->target); ?>">
            <div class="dd-handle dd3-handle"></div>
            <div class="dd3-content">
                <span class="text float-left" data-update="title"><?php echo e($row->getRelated()->name); ?></span>
                <span class="text float-right"><?php echo e($row->type); ?></span>
                <a href="#" title="" class="show-item-details"><i class="fa fa-angle-down"></i></a>
                <div class="clearfix"></div>
            </div>
            <div class="item-details">
                <label class="pad-bot-5">
                    <span class="text pad-top-5 dis-inline-block" data-update="title"><?php echo e(trans('core.menu::menu.title')); ?></span>
                    <input type="text" name="title" value="<?php echo e($row->getRelated()->name); ?>"
                           data-old="<?php echo e($row->getRelated()->name); ?>">
                </label>
                <?php if(!$row->related_id): ?>
                    <label class="pad-bot-5 dis-inline-block">
                        <span class="text pad-top-5" data-update="custom-url"><?php echo e(trans('core.menu::menu.url')); ?></span>
                        <input type="text" name="custom-url" value="<?php echo e($row->url); ?>" data-old="<?php echo e($row->url); ?>">
                    </label>
                <?php endif; ?>
                <label class="pad-bot-5 dis-inline-block">
                    <span class="text pad-top-5" data-update="icon-font"><?php echo e(trans('core.menu::menu.icon')); ?></span>
                    <input type="text" name="icon-font" value="<?php echo e($row->icon_font); ?>" data-old="<?php echo e($row->icon_font); ?>">
                </label>
                <label class="pad-bot-10">
                    <span class="text pad-top-5 dis-inline-block"><?php echo e(trans('core.menu::menu.css_class')); ?></span>
                    <input type="text" name="class" value="<?php echo e($row->css_class); ?>" data-old="<?php echo e($row->css_class); ?>">
                </label>
                <label class="pad-bot-10">
                    <span class="text pad-top-5 dis-inline-block"><?php echo e(trans('core.menu::menu.target')); ?></span>
                    <div style="width: 228px; display: inline-block">
                        <div class="ui-select-wrapper">
                            <select name="target" class="ui-select" id="target" data-old="<?php echo e($row->target); ?>">
                                <option value="_self" <?php if($row->target == '_self'): ?> selected="selected" <?php endif; ?>><?php echo e(trans('core.menu::menu.self_open_link')); ?>

                                </option>
                                <option value="_blank" <?php if($row->target == '_blank'): ?> selected="selected" <?php endif; ?>><?php echo e(trans('core.menu::menu.blank_open_link')); ?>

                                </option>
                            </select>
                            <svg class="svg-next-icon svg-next-icon-size-16">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#select-chevron"></use>
                            </svg>
                        </div>
                    </div>
                </label>
                <div class="clearfix"></div>
                <div class="text-right" style="margin-top: 5px">
                    <a href="#" class="btn btn-danger btn-remove btn-sm"><?php echo e(trans('core.menu::menu.remove')); ?></a>
                    <a href="#" class="btn btn-primary btn-cancel btn-sm"><?php echo e(trans('core.menu::menu.cancel')); ?></a>
                </div>
            </div>
            <div class="clearfix"></div>
            <?php if($row->hasChild()): ?>
                <?php echo Menu::generateMenu([
                        'slug' => $menu->slug,
                        'view' => 'core.menu::partials.menu',
                        'parent_id' => $row->id,
                        'theme' => false,
                        'active' => false
                    ]); ?>

            <?php endif; ?>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ol>
